<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Formatters\Resources;
use Illuminate\Http\Request;
use App\Formatters\Resource;
use App\Formats\CustomError;
use App\Mail\EmailUpdated;
use App\Mail\ConfirmMail;
use App\Formats\Error;
use Validator;
use App\User;
use JWTAuth;
use DB;

class UserController extends Controller
{
    public function __construct () {
        $this->middleware('auth:api')->except('create', 'login');
    }

    /**
     * Creates a new user in the database
     *
     * @param Request $request
     * @return json
     */
    public function create (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'usuario' => 'required|string|min:6|max:255|unique:usuario,usuario',
            'correo' => 'required|string|email|max:255|unique:usuario,correo',
            'clave' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(CustomError::format('Los campos no se llenaron correctamente', 400, $validator->errors()), 400);
        }

        try {

            DB::beginTransaction();

            $user = new User;
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->usuario = $request->usuario;
            $user->correo = $request->correo;
            $user->clave = bcrypt($request->clave);
            $user->estado_id = 1;
            $user->role_id = 1;
            $user->save();

            Mail::to($user->correo)->send(new ConfirmMail($user));

            DB::commit();

            return response()->json(Resource::format($user, 'App\User'), 201);

        } catch (\Exception $e) {

            DB::rollback();
            
            return response()->json(Error::format($e, '5xx'), 500);
        }
    }

    /**
     * Retrieves the authenticated user
     *
     * @param Request $request
     * @return json
     */
    public function read (Request $request) {
        
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(CustomError::format('User no encontrado', 404), 404);
        }

        try {

            $resource = User::select('id', 'nombre', 'apellido', 'usuario', 'correo', 'role_id', 'estado_id')
            ->where('id', $user->id)
            ->with(['role', 'status'])
            ->first();                

            return response()->json(Resource::format($resource, 'App\User'), 200);

        } catch (\Exception $e) {

            return response()->json(Error::format($e, '5xx'), 500);
        }
    }

    /**
     * Updates the authenticated user
     *
     * @param Request $request
     * @return json
     */
    public function update(Request $request){
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'correo' => 'required|email',
            'usuario' => 'required|string',
            'clave' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(CustomError::format('Los campos no se llenaron correctamente', 400, $validator->errors()), 400);
        }

        if (! $user = JWTAuth::parseToken()->authenticate() ) {
            return response()->json(CustomError::format('Usuario no encontrado', 404), 404);
        }

        $isEmailDifferent = false;
        $isUsernameDifferent = false;
        $message = 'Datos actualizados correctamente, por favor inicie sesión para confirmarlos.';

        if($request->correo != $user->correo) {
            $validator = Validator::make($request->all(), ['correo' => 'unique:usuario']);

            if ($validator->fails()) {
                return response()->json(CustomError::format('Los campos no se llenaron correctamente', 400, [
                    'correo' => ['El correo elegido ya está en uso'],
                ]), 400);
            }

            $isEmailDifferent = true;
        }
       
        if($request->usuario != $user->usuario) {
            $validator = Validator::make($request->all(), ['usuario' => 'unique:usuario']);

            if ($validator->fails()) {
                return response()->json(CustomError::format('Los campos no se llenaron correctamente', 400, [
                    'correo' => ['El usuario elegido ya está en uso'],
                ]), 400);
            }

            $isUsernameDifferent = true;
        }

        try {

            DB::beginTransaction();

            $usuario = User::where('id', $user->id)->first();

            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->usuario = mb_strtolower($request->usuario);
            $usuario->clave = bcrypt($request->clave);

            if($isEmailDifferent) {
                $usuario->verifyme_token = str_random(40);          
                $message = 'Hemos enviado un correo de confirmación a '.$request->correo.', mientras podrá seguir utilizando el antiguo.';
                Mail::to($request->correo)->send(new EmailUpdated($usuario, $request->correo));
            }

            $usuario->save();

            DB::commit();

            return response()->json(Resource::format($usuario, 'App\User'));
        
        } catch (\Exception $e) {

            return response()->json(Error::format($e, '5xx'), 500);
        }
    }

    /**
     * Deletes the authenticated user
     *
     * @param Request $request
     * @return json
     */
    public function delete (Request $request) {

        if (! $user = JWTAuth::parseToken()->authenticate() ) {
            return response()->json(CustomError::format('Usuario no encontrado', 404), 404, 404);
        }

        try {

            DB::beginTransaction();
            
            $usuario = User::find($user->id);
            $usuario->estado_id = 4;
            $usuario->save();
            $usuario->delete();

            DB::commit();

            return response()->json(Resource::format($usuario, 'App\User'), 200);

        } catch (\Exception $e) {
            
           return response()->json(Error::format($e, '5xx'), 500);
        }
    }

    public function login (Request $request) {
        
        $credentials = $request->only('usuario', 'password');  

        $user = User::select('id', 'usuario', 'estado_id', 'role_id')
            ->where('usuario', $request->usuario)
            ->first();

        if ($user == null) {
            return response()->json(CustomError::format('Los datos enviados no son correctos', 400, [
                'usuario' => [
                    'Estas credenciales no coinciden con nuestros registros'
                ]
            ]), 401);
        }

        try {

            if (!$token = JWTAuth::claims(['role' => $user->role_id])->attempt($credentials)) {                
                return response()->json(CustomError::format('Los datos enviados no son correctos', 400, [
                'usuario' => [
                    'Estas credenciales no coinciden con nuestros registros'
                ]
            ]), 401);

            } else {               

                if ($user->estado_id == 1) {
                    return response()->json(CustomError::format('Los datos enviados no son correctos', 400, [
                        'usuario' => [
                            'Estas credenciales no coinciden con nuestros registros'
                        ]
                    ]), 401);

                } else if ($user->estado_id == 3) {
                    return response()->json(CustomError::format('El usuario ha sido baneado de la plataforma', 403, []), 403);
                }
            }

        } catch (JWTException $e) {

            return response()->json(Error::format($e, '5xx'), 500);
        }

        return response()->json([
            'data' => [
                'type' => 'token',
                'id' => $user->id,
                'attributes' => [
                    'type' => 'Bearer',
                    'token' => $token,
                    'expires_in' => env('JWT_TTL', 60)
                ],
            ],
        ], 200);
    }

    public function logout () {

        auth()->logout();

        return response()->json([
            'data' => [
                'type' => 'response',
                'attributes' => [
                    'status' => 'success',
                    'code' => 200,
                ]
            ]
        ], 200);
    }
}

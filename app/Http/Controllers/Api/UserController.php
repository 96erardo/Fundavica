<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ConfirmMail;
use App\User;
use JWTAuth;
use DB;

class UserController extends Controller
{
    public function __construct () {
        $this->middleware('jwt.auth')->only('read');
    }


    public function create (Request $request) {
        $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'usuario' => 'required|string|min:6|max:255|unique:usuario,usuario',
            'correo' => 'required|string|email|max:255|unique:usuario,correo',
            'clave' => 'required|string|min:6|confirmed',
        ]);

        try {

            DB::beginTransaction();

            $user = new User;
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->usuario = $request->usuario;
            $user->correo = $request->correo;
            $user->clave = bcrypt($request->clave);
            $user->estado_id = 1;
            $user->save();

            Mail::to($user->correo)->send(new ConfirmMail($user));

            DB::commit();

            return response()->json([
                'status' => 'success'
            ], 201);

        } catch (\Exception $e) {

            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo[2]
            ], 500);
        }
    }

    public function read (Request $request) {
        if (! $user = JWTAuth::parseToken()->authenticate() ) {
            return response()->json(['user_not_found'], 401);
        }

        User::select('id', 'nombre', 'apellido', 'usuario', 'correo', 'role_id')
            ->where('id', $user->id)
            ->with(['estado', 'role', 'status'])
            ->first();
            

        return response()->json([
            $user,
        ], 200);
    }

    public function update(Request $request){
        
        $this->validate($request, [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'correo' => 'required|email',
            'usuario' => 'required|string',
            'clave' => 'required|min:6|confirmed'
        ]);

        if (! $user = JWTAuth::parseToken()->authenticate() ) {
            return response()->json(['user_not_found'], 404);
        }

        $isEmailDifferent = false;
        $isUsernameDifferent = false;
        $message = 'Datos actualizados correctamente, por favor inicie sesión para confirmarlos.';

        if($request->correo != $user->correo) {
            $this->validate($request, ['correo' => 'unique:usuario']);
            $isEmailDifferent = true;
        }
       
        if($request->usuario != $user->usuario) {
            $this->validate($request, ['usuario' => 'unique:usuario']);
            $isUsernameDifferent = true;
        }

        try {

            DB::beginTransaction();

            $usuario = User::find('id', $user->id);

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

            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete (Request $request) {

        if (! $user = JWTAuth::parseToken()->authenticate() ) {
            return response()->json(['user_not_found'], 404);
        }

        try {

            DB::beginTransaction();
            
            $usuario = User::find($user->id);
            $usuario->estado_id = 4;
            $usuario->save();
            $usuario->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
            ], 200);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login (Request $request) {
        
        $credentials = $request->only('usuario', 'password');  

        try {
            if ( ! $token = JWTAuth::attempt($credentials) ) {                
                return response()->json([
                    'usuario' => [
                        'Estas credenciales no coinciden con nuestros registros'
                    ]
                ], 401);

            } else {                

                $user = User::select('id', 'usuario', 'estado_id', 'role_id')
                    ->where('usuario', $request->usuario)
                    ->first();

                if ($user->estado_id == 1) {
                    return response()->json([
                        'usuario' => [
                            'Estas credenciales no coinciden con nuestros registros'
                        ]
                    ], 401);

                } else if ($user->estado == 3) {
                    return response()->json([
                        'error' => [
                            'El usuario ' . $user->usuario . ' se encuentra actualmente bloqueado, contacte con nosotros para solicitar un desbloqueo'
                        ]
                    ], 403);
                }
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => [
                    'Error al autenticar al usuario, intentelo de nuevo',
                ]
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ], 200);
    }
}

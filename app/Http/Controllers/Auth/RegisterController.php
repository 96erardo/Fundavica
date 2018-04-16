<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'usuario' => 'required|string|min:6|max:255|unique:usuario',
            'correo' => 'required|string|email|max:255|unique:usuario',
            'clave' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nombre' => $data['nombre'],
            'apellido'=> $data['apellido'],
            'usuario' => $data['usuario'],
            'correo' => $data['correo'],
            'clave' => bcrypt($data['clave']),
            'role_id' => 1, 
            'estado_id' => 1
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        Mail::to($user->correo)->send(new ConfirmMail($user));

        return redirect('login')->with('status', 'Confirme su cuenta de correo con el email que le hemos enviado.');
    }

    /**
     * Handle a email confirmation request for the applicacion.
     * 
     * @param string $token
     * @return \Iluminate\Http\Response
     */
    public function confirmEmail($token) {
        User::where('verifyme_token', $token)->firstOrFail()->hasVerified();

        return redirect('login')->with('status', 'Cuenta de correo confirmada, por favor inicia sesión.');
    }
}

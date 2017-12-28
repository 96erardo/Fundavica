<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangePassword;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    public function resetView(Request $request, $token) {

        $exist = User::where('token', $token)->count();

        if($exist == 0)
            return redirect('/');
        
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function requestReset(Request $request) {

        $this->validate($request, [
            'correo' => 'required|email|exists:usuario,correo'
        ]);

        $user = User::where('correo', $request->correo)->first();
        $user->token = str_random(40);

        $user->save();
       
        Mail::to($user->correo)->send(new ChangePassword($user));

        return redirect('login')->with('status', 'Ingrese a su correo, le hemos enviado un correo para restaurar su contraseña');
    }

    public function resetPassword(Request $request) {

        $this->validate($request, [
            'clave' => 'required|string|min:6|confirmed',
            'token' => 'required|string|min:40'
        ]);

        $user = User::where('token', $request->token)->first();
        $user->clave = bcrypt($request->clave);
        $user->token = null;
        $user->save();

        return redirect('login')->with('status', 'Contraseña reestablecida');
    }
}

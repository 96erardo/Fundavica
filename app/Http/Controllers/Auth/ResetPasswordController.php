<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangePassword;
use App\Models\PasswordResets;
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

        $exist = PasswordResets::where('token', $token)->count();

        if($exist == 0)
            return redirect('/');
        
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function requestReset(Request $request) {

        $this->validate($request, [
            'correo' => 'required|email|exists:usuario,correo'
        ]);

        $user = User::where('correo', $request->correo)->first();
        $pr = PasswordResets::where('correo', $request->correo);

        if($pr->count() > 0) {            
            $password_resets = $pr->first();
            $password_resets->token = str_random(40);
            $password_resets->created_at = date('Y-m-d H:i:s');
            $password_resets->save();
        
        } else {
            $password_resets = new PasswordResets();
            $password_resets->correo = $request->correo;
            $password_resets->token = str_random(40);
            $password_resets->created_at = date('Y-m-d H:i:s');
            $password_resets->save();
        }
       
        Mail::to($user->correo)->send(new ChangePassword($user, $password_resets->token));

        return redirect('login')->with('status', 'Ingrese a su correo, le hemos enviado un correo para restaurar su contraseña');
    }

    public function resetPassword(Request $request) {

        $this->validate($request, [
            'clave' => 'required|string|min:6|confirmed',
            'token' => 'required|string|min:40'
        ]);
        
        $pasword_resets = PasswordResets::where('token', $request->token)->first();
        $user = User::where('correo', $pasword_resets->correo)->first();
        $user->clave = bcrypt($request->clave);
        $user->save();
        $pasword_resets->delete();

        return redirect('login')->with('status', 'Contraseña reestablecida');
    }
}

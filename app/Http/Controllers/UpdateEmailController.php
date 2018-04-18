<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailUpdated;
use App\User;

class UpdateEmailController extends Controller
{
    public function update(Request $request){
        $this->validate($request, [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'correo' => 'required|email',
            'usuario' => 'required|string',
            'clave' => 'required|min:6|confirmed'
        ]);

        $user = $request->user();
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

        $usuario = User::where('id', $request->user()->id)->first();

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

        Auth::logout();

        return redirect('login')->with('status', $message);
    }

    public function validateEmail(Request $request, $email, $token) {

        $user = User::where('verifyme_token', $token)->first();
        
        if(!$user)
            return redirect('/');

        $user->correo = $email;
        $user->verifyme_token = null;
        $user->save();

        Auth::logout();

        return redirect('login')->with('status', 'Correo electrónico confirmado, puede iniciar sesión');
    }
}

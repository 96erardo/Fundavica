<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;

class UserController extends Controller
{

    //USER DATA
    public function profile(Request $request){

        $user = $request->user();
        return view('user.profile', ['usuario' => $user]);
    }

    public function edit(Request $request){
        
        $user = $request->user();
        return view('auth.update', ['usuario' => $user]);
    }

    public function delete(Request $request){

        $user = $request->user();
        $usuario = User::where('usuario', $user->usuario)->first();
        $usuario->delete();

        return redirect('/logout');
    }

    public function admin($id) {

        $usuario = User::where('id', $id)->first();
        $usuario->role_id = 4;
        $usuario->save();

        return redirect("user/manage")->with('status', $usuario->usuario.' es ahora un administrador en Fundavica');;       
    }

    public function writer(Request $request, $id) {

        $usuario = User::where('id', $id)->first();
        $usuario->role_id = 3;
        $usuario->save();

        if($usuario->usuario == $request->user()->usuario) {
            return redirect('logout');
        }

        return redirect("user/manage")->with('status', $usuario->usuario.' es ahora un redactor en Fundavica');       
    }

    public function normal(Request $request, $id) {

        $usuario = User::where('id', $id)->first();
        $usuario->role_id = 1;
        $usuario->save();

        if($usuario->usuario == $request->user()->usuario) {
            return redirect('logout');
        }

        return redirect("user/manage")->with('status', $usuario->usuario.' es ahora un usuario estandar en Fundavica');       
    }

    public function block($id) {

        $usuario = User::where('id', $id)->first();
        $usuario->estado_id = 3;
        $usuario->save();

        return redirect("user/manage")->with('status', $usuario->usuario.' ha sido baneado correctamente');       
    }

    public function unblock($id) {

        $usuario = User::where('id', $id)->first();
        $usuario->estado_id = 2;
        $usuario->save();

        return redirect("user/manage")->with('status', $usuario->usuario.' ha sido desbloqueado correctamente');       
    }

    public function manage(){

        $users = User::select('id','nombre', 'apellido', 'usuario', 'correo', 'role_id', 'estado_id')
            ->where('estado_id', '>=', '2')
            ->where('estado_id', '<=', '3')
            ->with(['role', 'status'])
            ->get();

        return view('auth.manage', ['users' => $users]);
    }
}

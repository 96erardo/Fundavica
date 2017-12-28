<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{
    //
    public function manage() {

    	$resultados = Account::all();

    	return view('manage.accounts', ['accounts' => $resultados]);
    }

    public function add(Request $request) {

    	$this->validate($request, [
    			'medio' => 'required',
    			'nro' => 'required'
    		]);

    	$cuenta = new Account;

    	$cuenta->banco = $request->medio;
    	$cuenta->nro_cuenta = $request->nro;
    	$cuenta->estado = 1;
    	$cuenta->save();

        $msg = "Cuenta agregada correctamente";

    	return redirect('account/manage')->with('status', 'Cuenta bancaria agregada correctamente');
    }

    public function hide($id) {

        $cuenta = Account::where('id', $id)->first();
        $cuenta->estado = 0;
        $cuenta->save();

        return redirect('account/manage')->with('status', 'Cuenta bancaria ocultada');
    }

    public function show($id) {

        $cuenta = Account::where('id', $id)->first();
        $cuenta->estado = 1;
        $cuenta->save();

        return redirect('account/manage')->with('status', 'Cuenta bancaria publicada');
    }

    public function delete($id) {

        $cuenta = Account::where('id', $id)->first();
        $cuenta->delete();

        return redirect('account/manage')->with('status', 'Cuenta bancaria eliminada');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donations;
use App\Account;

class DonationController extends Controller
{
    //

    public function manage($page = 0){

        $donations = Donations::count();

        $pages = ceil($donations/15);

        if($page > $pages || $page < 0){
            return redirect('donation/manage/0');
        }

        $offset = $page * 15;

        $results = 
        Donations::offset($offset)
            ->limit(15)
            ->get();

        return view('manage.donations', ['donations' => $results, 'page' => $page, 'pages' => $pages ]);
    }

    public function add(Request $request){

    	$this->validate($request, [
    			'nombre' => 'required',
    			'apellido' => 'required',
    			'cedula' => 'required|numeric',
    			'correo' => 'required|email',
    			'monto' => 'required|numeric',
    			'fecha' => 'required|date'
    		]);

        $donacion = new Donations;

        $donacion->nombre = $request->nombre;
        $donacion->apellido = $request->apellido;
        $donacion->cedula = $request->cedula;
        $donacion->correo = $request->correo;
        $donacion->medio = $request->medio;
        $donacion->operacion = $request->operacion;
        $donacion->monto = $request->monto;
        $donacion->moneda = $request->moneda;
        $donacion->codigo = $request->codigo;
        $donacion->fecha = $request->fecha;
        $donacion->estado = 0;

        $donacion->save();

        return redirect()->back()->with('status', 'Donación registrada, muchas gracias por ayudarnos en nuestra misión !');
    }

    public function valid($id) {

        $donacion = Donations::where('id', $id)->first();
        $donacion->estado = 1;
        $donacion->save();

        return redirect('donation/manage/0')->with('status', 'Donación validada');
    }

    public function reject($id) {

        $donacion = Donations::where('id', $id)->first();
        $donacion->estado = 0;
        $donacion->save();

        return redirect('donation/manage/0')->with('status', 'Donación rechazada');
    }

    public function delete($id) {

        $donacion = Donations::where('id', $id)->first();
        $donacion->delete();

        return redirect('donation/manage/0')->with('status', 'Donación eliminada');
    }

    public function search(Request $request) {

        $this->validate($request, [
                'busqueda' => 'required'
            ]);

        $busqueda = $request->busqueda;

        $donations = 
        Donations::where('nombre', 'like', '%'.$busqueda.'%')
            ->orwhere('apellido', 'like', '%'.$busqueda.'%')
            ->orwhere('cedula', 'like', '%'.$busqueda.'%')
            ->orwhere('medio', 'like', '%'.$busqueda.'%')
            ->orwhere('codigo', 'like', '%'.$busqueda.'%')
            ->get();

        return view('manage.search.donations', ['donations' => $donations, 'search' => $busqueda]);
    }
}

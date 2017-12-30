<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Account;
use App\People;
use App\Album;
use App\Donations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpinionMail;

class FundavicaController extends Controller
{
        //
  public function home() {
    return redirect('/posts/0');
  }

  public function post($page = 0){

    $posts = Post::count();

    $pages = ceil($posts/16);

    if($page > $pages || $page < 0){

      return redirect('/posts/0');
    }

    $offset = $page * 16;

    $results = Post::select('id','titulo', 'imagen', 'fecha', 'categoria_id', 'usuario_id', 'estado')
    ->where('estado', 1)
    ->offset($offset)
    ->limit(16)
    ->orderBy('id', 'desc')
    ->with([
      'category' => function($query) {
        $query->select('id', 'nombre', 'color');
    }, 
      'user' => function($query) {
        $query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
    }
    ])->get();

    return view('index.posts', ['posts' => $results, 'page' => $page, 'pages' => $pages ]);
  }

  public function search(Request $request) {

    $this->validate($request, [
      'busqueda' => 'required'
    ]);

    $busqueda = $request->busqueda;

    $posts = 
    Post::select('id','titulo', 'imagen', 'fecha', 'usuario_id', 'categoria_id', 'estado')
    ->where('titulo', 'like', '%'.$busqueda.'%')
    ->where('estado', '1')
    ->orderBy('id', 'desc')
    ->with([
      'user' => function($query) {
        $query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
      },
      'category' => function($query) {
        $query->select('id', 'nombre', 'color');
      }
    ])->get();

    return view('index.search', ['posts' => $posts, 'search' => $busqueda]);
  }

  public function album(){

    return view('index.gallery');
  }

  public function contact() {

    return view('index.contact'); 
  }

  public function opinion(Request $request) {
    
    $this->validate($request, [
      'mensaje' => 'required|string|max:255'
    ]);

    $message = $request->mensaje;

    Mail::to('fundavica.online@gmail.com')->send(new OpinionMail($message));

    return redirect()->back()->with('status', 'Mensaje enviado al correo de fundavica, gracias por ayudarnos a mejorar');
  }

  public function donations(){

   $accounts = Account::where('estado', 1)->get();
   
   $donations = 
    Donations::select('nombre', 'apellido', 'cedula', 'fecha')
      ->where('estado', '1')
      ->get();

   return view('index.donations', ['accounts' => $accounts, 'donations' => $donations]);
 }

 public function comingSoon(){

   return view('layouts.coming-soon');
 }

 public function notFoundPost(){

   return view('page.not-found-post');
 }
}

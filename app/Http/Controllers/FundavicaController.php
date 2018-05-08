<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Account;
use App\Models\People;
use App\Models\Album;
use App\Models\Donations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpinionMail;
use Carbon\Carbon;

class FundavicaController extends Controller
{
  public function home() {
    return redirect('/posts/0');
  }

  public function post(Request $request, $page = 0) {

    $posts = Post::count();

    $pages = ceil($posts/16);

    if($page > $pages || $page < 0){

      return redirect('/posts/0');
    }

    $offset = $page * 16;

    $results = Post::where('estado_id', 2)
    ->offset($offset)
    ->limit(16)
    ->orderBy('created_at', 'desc')
    ->with([
      'category' => function($query) {
        $query->select('id', 'nombre', 'color');
    }, 
      'user' => function($query) {
        $query->withTrashed()->select('id', 'nombre', 'apellido', 'correo', 'usuario');
    },
      'status'
    ])->get();

    foreach($results as $post) {
      $date = strtotime($post->created_at);
      $post->fecha = date('d-m-Y', $date);
    }

    return view('post.index', ['posts' => $results, 'page' => $page, 'pages' => $pages ]);
  }

  public function search(Request $request) {

    $this->validate($request, [
      'busqueda' => 'required'
    ]);

    $search = $request->busqueda;

    $posts = Post::select('id','titulo', 'imagen', 'created_at', 'usuario_id', 'categoria_id', 'estado_id')
      ->where('titulo', 'like', '%'.$search.'%')
      ->where('estado_id', '2')
      ->orderBy('id', 'desc')
      ->with([
        'user' => function($query) {
          $query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
        },
        'category' => function($query) {
          $query->select('id', 'nombre', 'color');
        }
      ])->get();

    foreach($posts as $post) {
      $date = strtotime($post->created_at);
      $post->fecha = date('d-m-Y', $date);
    }

    return view('post.search', ['posts' => $posts, 'search' => $search]);
  }

  public function album(){

    return view('gallery.index');
  }

  public function contact() {

    return view('contact.index'); 
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
   
   $donations = Donations::select('nombre', 'apellido', 'cedula', 'fecha')
      ->where('estado', '1')
      ->get();

    foreach($donations as $donation) {
      $date = strtotime($donation->fecha);
      $donation->fecha = date('d-m-Y', $date);
    }

   return view('donation.index', ['accounts' => $accounts, 'donations' => $donations]);
 }

 public function comingSoon(){

   return view('layouts.coming-soon');
 }

 public function notFoundPost(){

   return view('page.not-found-post');
 }
}

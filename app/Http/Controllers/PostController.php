<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;

class PostController extends Controller
{
	public function post($id){

		$result = Post::where('id', $id)
		->with([
			'category' => function($query) {
				$query->select('id', 'nombre', 'color');
			},
			'user' => function($query){
				$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
			},
			'comments' => function($query) {
				$query->with([
					'user' => function($query) {
						$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
					} 
					]);
			}
		])->first();

		$date = strtotime($result->created_at);
		$result->fecha = date('d-m-Y', $date);
		
		return view('page.article', ['pub' => $result]);
	}

	public function manage($page = 0){
		
		$posts = Post::select('id','titulo', 'created_at', 'usuario_id', 'estado_id')
			->orderBy('created_at', 'desc')
			->with([
				'user' => function($query) {
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				},
				'status'
			])->get();
		
		foreach($posts as $post) {
			$date = strtotime($post->created_at);
			$post->fecha = date('d-m-Y', $date);
		}

		return view('manage.posts', ['posts' => $posts]);
	}

	public function add(){

		$categories = Category::all();

		return view('page.create-article', ['categories' => $categories]);
	}

	public function added(Request $request) {

		$this->validate($request, [
			'titulo' => 'required|string',
			'imagen' => 'required|string',
			'contenido' => 'required|string'
			]);

		$usuario = $request->user();
		$publicacion = new Post;
		$publicacion->titulo = $request->titulo;
		$publicacion->imagen = $request->imagen;
		$publicacion->contenido = $request->contenido;
		$publicacion->fecha = date("Y-m-d");
		$publicacion->usuario_id = $usuario->id;
		$publicacion->categoria_id = $request->categoria;
		$publicacion->estado_id = 1;
		$publicacion->save();

		return redirect('/');
	}

	public function edit(Post $post){
		
		$categories = Category::all();

		return view('page.edit-article', ['categories' => $categories, 'post' => $post]);
	}

	public function edited(Request $request, Post $post) {

		$this->validate($request, [
			'titulo' => 'required',
			'imagen' => 'required',
			'contenido' => 'required',
			]);

		$publicacion = Post::where('id', $request->post->id)->first();
		$publicacion->titulo = $request->titulo;
		$publicacion->imagen = $request->imagen;
		$publicacion->categoria_id = $request->categoria;
		$publicacion->contenido = $request->contenido;
		$publicacion->fecha = date("Y-m-d");
		$publicacion->save();
		
		return redirect('post/'.$request->post->id);
	}

	public function hide($id) {

		$publicacion = Post::where('id', $id)->first();
		$publicacion->estado = 0;
		$publicacion->save();

		return redirect('post/manage')->with('status', 'Publicación "'. $publicacion->titulo .'" ocultada.');
	}

	public function show($id) {

		$publicacion = Post::where('id', $id)->first();
		$publicacion->estado = 1;
		$publicacion->save();

		return redirect('post/manage')->with('status', 'Publicación "'. $publicacion->titulo .'" visible.');
	}

	public function delete(Post $post) {

		$publicacion = $post->titulo;
		$post->delete();

		return redirect('post/manage')->with('status', 'Publicación "'. $publicacion .'" eliminada.');
	}

	//COMMENTS
	public function comment(Request $request, $post) {

		$this->validate($request, [
			'contenido' => 'required'
			]);

		$usuario = $request->user();

		$comentario = new Comment;
		$comentario->usuario_id = $usuario->id;
		$comentario->publicacion_id = $post;
		$comentario->contenido = $request->contenido;
		$comentario->fecha = date("Y-m-d");
		$comentario->estado = 1;
		$comentario->save();

		return redirect('post/'.$post)->with('status', '!Comentario agregado correctamente!');
	}

	public function editComment(Request $request, $post, Comment $comment) {

		$this->validate($request, [
			'comentario' => 'required'
			]);

		$comment->contenido = $request->comentario;
		$comment->fecha = date("Y-m-d");
		$comment->save();

		return redirect('post/'.$post)->with('status', '¡Comentario editado correctamente!');
	}

	public function hideComment($post, $comment) {

		$comentario = Comment::where('id', $comment)->first();

		$comentario->estado = 0;
		$comentario->save();

		return redirect('post/'.$post)->with('status', '¡Comentario ocultado correctamente!');
	}

	public function showComment($post, $comment) {

		$comentario = Comment::where('id', $comment)->first();

		$comentario->estado = 1;
		$comentario->save();

		return redirect('post/'.$post)->with('status', '¡Comentario visible!');
	}  

	public function deleteComment(Post $post, Comment $comment) {

		$comment->delete();

		return redirect('post/'.$post->id)->with('status', '¡Comentario eliminado correctamente!');
	}

	public function writer(Request $request, $page = 0){
		
		$user = $request->user();
		
		$posts = Post::select('id','titulo', 'created_at', 'usuario_id', 'estado_id')
			->where('usuario_id', $user->id)
			->orderBy('id', 'desc')
			->with([
				'user' => function($query) {
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				},
				'status'
			])->get();
		
		foreach($posts as $post) {
			$date = strtotime($post->created_at);
			$post->fecha = date('d-m-Y', $date);
		}

		return view('manage.writer', ['posts' => $posts]);
	} 
}

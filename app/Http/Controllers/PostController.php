<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\HiddenPost;
use App\Events\ShowPost;
use App\Events\UpdatedPost;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\UserModPost;
use App\User;

class PostController extends Controller
{
	public function post($id){

		$post = Post::where('id', $id)
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

		$history = UserModPost::where('publicacion_id', $id)
			->orderBy('created_at', 'desc')
			->limit(10)
			->with([
				'user' => function ($query) {
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				},
				'post' => function ($query) {
					$query->select('id', 'titulo');
				},
				'operation'
			])->get();
		
		$date = strtotime($post->created_at);
		$post->fecha = date('d-m-Y H:i:s', $date);

		foreach ($post->comments as $comment) {
			$date = strtotime($comment->created_at);
			$comment->fecha = date('d-m-Y', $date);
		}


		foreach ($history as $operation) {
			$date = strtotime($operation->created_at);
			$operation->created_at = date('d-m-Y H:i:s', $date);
		}
		
		return view('post.read', [
			'pub' => $post,
			'history' => $history,
		]);
	}

	public function manage() {
		
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

		return view('post.manage', ['posts' => $posts]);
	}

	public function add(){

		$categories = Category::all();

		return view('post.create', ['categories' => $categories]);
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
		$publicacion->usuario_id = $usuario->id;
		$publicacion->categoria_id = $request->categoria;
		$publicacion->estado_id = 2;
		$publicacion->save();

		return redirect('/');
	}

	public function edit(Post $post){
		
		$categories = Category::all();

		return view('post.update', ['categories' => $categories, 'post' => $post]);
	}

	public function edited(Request $request, Post $post) {

		$this->validate($request, [
			'titulo' => 'required',
			'imagen' => 'required',
			'contenido' => 'required',
			]);

		$post = Post::where('id', $request->post->id)->first();
		$post->titulo = $request->titulo;
		$post->imagen = $request->imagen;
		$post->categoria_id = $request->categoria;
		$post->contenido = $request->contenido;
		$post->save();

		event(new UpdatedPost($post));
		
		return redirect('post/'.$request->post->id);
	}

	public function hide($id) {

		$post = Post::where('id', $id)->first();
		$post->hide();
		$post->save();

		event(new HiddenPost($post));

		return redirect('post/manage')->with('status', 'Publicación "'. $post->titulo .'" ocultada.');
	}

	public function show($id) {

		$post = Post::where('id', $id)->first();
		$post->show();
		$post->save();

		event(new ShowPost($post));

		return redirect('post/manage')->with('status', 'Publicación "'. $post->titulo .'" visible.');
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
		$comentario->show();
		$comentario->save();

		return redirect('post/'.$post)->with('status', '!Comentario agregado correctamente!');
	}

	public function editComment(Request $request, $post, Comment $comment) {

		$this->validate($request, [
			'comentario' => 'required'
			]);

		$comment->contenido = $request->comentario;
		$comment->save();

		return redirect('post/'.$post)->with('status', '¡Comentario editado correctamente!');
	}

	public function hideComment($post, $comment) {

		$comentario = Comment::where('id', $comment)->first();

		$comentario->hide();
		$comentario->save();

		return redirect('post/'.$post)->with('status', '¡Comentario ocultado correctamente!');
	}

	public function showComment($post, $comment) {

		$comentario = Comment::where('id', $comment)->first();

		$comentario->show();
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

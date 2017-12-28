<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Category;
use App\User;
use App\Comment;
use App\Tag;

class PostController extends Controller
{
	public function post($id){

		$resultado = Post::where('id', $id)
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

		$others = DB::select("SELECT id, titulo, imagen FROM mydb.publicacion ORDER BY RAND() LIMIT 5");		
		
		return view('page.article', ['pub' => $resultado , 'others' => $others]);
	}

	public function manage($page = 0){

		$posts = Post::count();

		$pages = ceil($posts/16);

		if($page > $pages || $page < 0){
			return redirect('post/manage/0');
		}

		$offset = $page * 15;

		$results = Post::select('id','titulo', 'fecha', 'usuario_id', 'estado')
		->offset($offset)
		->limit(15)
		->orderBy('id', 'desc')
		->with([
			'user' => function($query) {
				$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
			}
			])->get();

		return view('manage.posts', ['posts' => $results, 'page' => $page, 'pages' => $pages ]);
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
		$publicacion->estado = 1;
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

		return redirect('post/manage/0')->with('status', 'Publicación "'. $publicacion->titulo .'" ocultada.');
	}

	public function show($id) {

		$publicacion = Post::where('id', $id)->first();
		$publicacion->estado = 1;
		$publicacion->save();

		return redirect('post/manage/0')->with('status', 'Publicación "'. $publicacion->titulo .'" visible.');
	}

	public function search(Request $request) {

		$this->validate($request, [
				'busqueda' => 'required'
			]);

		$busqueda = $request->busqueda;

		$posts = 
		Post::select('id','titulo', 'imagen', 'fecha', 'categoria_id', 'usuario_id', 'estado')
			->where('titulo', 'like', '%'.$busqueda.'%')
			->with([
				'category' => function($query) {
					$query->select('id', 'nombre', 'color');
				}, 
				'user' => function($query) {
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				}
				])->get();

		return view('manage.search.posts', ['posts' => $posts, 'search' => $busqueda]);
	}

	public function delete(Post $post) {

		$publicacion = $post->titulo;
		$post->delete();

		return redirect('post/manage/0')->with('status', 'Publicación "'. $publicacion .'" eliminada.');
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

		$posts = Post::count();

		$pages = ceil($posts/15);

		if($page > $pages || $page < 0){
			return redirect('post/manage/0');
		}

		$usuario = $request->user();
		$offset = $page * 15;

		$results = Post::select('id','titulo', 'fecha', 'usuario_id', 'estado')
		->where('usuario_id', $usuario->id)
		->offset($offset)
		->limit(15)
		->orderBy('id', 'desc')
		->with([
			'user' => function($query) {
				$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
			}
			])->get();

		return view('manage.writer', ['posts' => $results, 'page' => $page, 'pages' => $pages ]);
	} 

	public function writersearch(Request $request) {

		$this->validate($request, [
			'busqueda' => 'required'
		]);

		$busqueda = $request->busqueda;
		$usuario = $request->user();

		$posts = 
		Post::select('id','titulo', 'imagen', 'fecha', 'usuario_id', 'estado')
			->where('usuario_id', $usuario->id)
			->where('titulo', 'like', '%'.$busqueda.'%')
			->with([
				'user' => function($query) {
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				}
			])->get();

		return view('manage.search.writer', ['posts' => $posts, 'search' => $busqueda]);
	}
}

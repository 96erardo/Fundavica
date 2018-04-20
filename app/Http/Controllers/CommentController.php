<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Request $request, $post) {

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
    
    public function read($id) {
        return $id;
    }

	public function update(Request $request, $post, Comment $comment) {

		$this->validate($request, [
			'comentario' => 'required'
			]);

		$comment->contenido = $request->comentario;
		$comment->save();

		return redirect('post/'.$post)->with('status', '¡Comentario editado correctamente!');
    }
    
    public function delete(Post $post, Comment $comment) {

		$comment->delete();

		return redirect('post/'.$post->id)->with('status', '¡Comentario eliminado correctamente!');
	}

	public function hide($post, $comment) {

		$comentario = Comment::where('id', $comment)->first();
		$comentario->hide();
		$comentario->save();

		return redirect('post/'.$post)->with('status', '¡Comentario ocultado correctamente!');
	}

	public function show($post, $comment) {

		$comentario = Comment::where('id', $comment)->first();
		$comentario->show();
		$comentario->save();

		return redirect('post/'.$post)->with('status', '¡Comentario visible!');
	}  
}

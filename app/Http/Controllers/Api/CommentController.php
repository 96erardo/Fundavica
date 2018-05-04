<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use JWTAuth;
use DB;

class CommentController extends Controller
{
    public function construct () {
		$this-middleware('jwt.auth')->only('create');
    }

    public function get ($post) {
        
        $comments = Comment::where('publicacion_id', $post)
            ->where('respuesta_id', null)
            ->orderBy('created_at', 'asc')
            ->with([
				'user' => function($query) {
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				},
				'responses' => function($query) {
					$query->where('estado_id', 2)
						->with([
							'user' => function($query) {
								$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
							}
						]);
				}
			])
            ->get();

        return $comments;
	}
	
	public function create (Request $request, $post, $response = null) {

		$this->validate($request, [
			'contenido' => 'required'
		]);

		try {
			
			if (! $user = JWTAuth::parseToken()->authenticate() ) {
                return response()->json(['user_not_found'], 404);
			}

			DB::beginTransaction();

			$comentario = new Comment;
			$comentario->usuario_id = $user->id;
			$comentario->publicacion_id = $post;
			$comentario->contenido = $request->contenido;
			$comentario->respuesta_id = $response;
			$comentario->show();
			$comentario->save();

			DB::commit();

			return response()->json([
				'status' => 'success'
			], 201);
			
		} catch (\Exception $e) {
			
			DB::rollback();
            
            return response()->json([
				'status' => 'error',
				'message' => $e->getMessage(),
            ], 500);
		}
    }

    public function read ($post, $comment) {

        $comment = Comment::where('publicacion_id', $post)
            ->where('id', $comment)
            ->with([
                'user' => function($query) {
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				},
				'responses' => function($query) {
					$query->where('estado_id', 2)
						->with([
							'user' => function($query) {
								$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
							}
						]);
				}
            ])
            ->first();

        return $comment;
    }
}

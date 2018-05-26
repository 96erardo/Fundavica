<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\QueryFilters\FiltersComment;
use App\Formatters\Resources;
use App\Formatters\Resource;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Formats\Error;
use JWTAuth;
use DB;

class CommentController extends Controller
{
    public function construct () {

		$this->middleware('jwt.auth')->only('create');
		$this->middleware('api.comment.update')->only('update');
		$this->middleware('api.comment.delete')->only('delete');
		
    }

    public function get (FiltersComment $filters, $post) {
		try {
        
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

			return response()->json(Resources::format($comments, 'App\Models\Comment'), 200);

		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
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

			$commentary = new Comment;
			$commentary->usuario_id = $user->id;
			$commentary->publicacion_id = $post;
			$commentary->contenido = $request->contenido;
			$commentary->respuesta_id = $response;
			$commentary->show();
			$commentary->save();

			DB::commit();

			return response()->json(Resource::format($commentary, 'App\Models\Comment'), 201);
			
		} catch (\Exception $e) {
			
			DB::rollback();
            
            return response()->json(Error::format($e, '5xx'), 500);
		}
    }

    public function read ($post, $comment) {

		try {

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
		
			return response()->json(Resource::format($comment, 'App\Models\Comment'), 200);
		
		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}

	}
	
	public function update ($post, $comment) {
		$this->validate($request, [
			'comentario' => 'required|string'
		]);

		try {

			DB::beginTransaction();

			$commentary = Comment::find($comment);
			$commentary->contenido = $request->comentario;
			$commentary->save();

			DB::commit();

			return response()->json(Resource::format($comment, 'App\Models\Comment'), 200);

		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
	}

	public function delete ($post, $comment) {
		try {

			DB::beginTransaction();

			$commentary = Comment::find($comment);
			$commentary->delete();

			DB::commit();

			return response()->json(Resource::format($comment, 'App\Models\Comment'), 200);

		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
	}
}

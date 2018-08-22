<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\QueryFilters\FiltersComment;
use App\Formatters\Resources;
use App\Formats\CustomError;
use App\Formatters\Resource;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Formats\Error;
use JWTAuth, Validator, DB;

class CommentController extends Controller
{
    public function __construct () {

		$this->middleware('auth:api')->except('read', 'get', 'responses');
		$this->middleware('api.comment.update')->only('update');
		$this->middleware('api.comment.delete')->only('delete');
		
    }

    public function get (FiltersComment $filters, Request $request, $post) {

		$validator = Validator::make($request->all() + ['post' => $post], [
            'post' => 'exists:publicacion,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(CustomError::format('La publicación no existe', 404, $validator->errors()), 404);
		}

		try {
        
			$comments = Comment::where('publicacion_id', $post)
				->where('respuesta_id', null)
				->orderBy('created_at', 'asc')
				->filterBy($filters)
				->get();

			return response()->json(Resources::format($comments, 'App\Models\Comment'), 200);

		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
	}
	
	public function create (Request $request, $post, $response = null) {
		$validator = Validator::make($request->all() + ['post' => $post], [
			'post' => 'required|exists:publicacion,id',
			'contenido' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json(CustomError::format('La información enviada es incorrecta', 400, $validator->errors()), 400);
		}

		try {
			
			if (! $user = JWTAuth::parseToken()->authenticate() ) {
                return response()->json(CustomError::format('User no encontrado', 404), 404);
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

    public function read (Request $request, FiltersComment $filters, $post, $comment) {
		$validator = Validator::make($request->all() + ['post' => $post, 'comment' => $comment], [
			'post' => 'required|exists:publicacion,id',
			'comment' => 'required|exists:comentario,id',
		]);

		if ($validator->fails()) {
			return response()->json(CustomError::format('La información enviada es incorrecta', 400, $validator->errors()), 400);
		}

		try {

			$comment = Comment::where('publicacion_id', $post)
				->where('id', $comment)
				->filterBy($filters)
				->first();
		
			return response()->json(Resource::format($comment, 'App\Models\Comment'), 200);
		
		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
	}

	public function responses (Request $request, $post, $comment) {
		$validator = Validator::make($request->all() + ['post' => $post, 'comment' => $comment], [
			'post' => 'required|exists:publicacion,id',
			'comment' => 'required|exists:comentario,id',
		]);

		if ($validator->fails()) {
			return response()->json(CustomError::format('La información enviada es incorrecta', 400, $validator->errors()), 400);
		}

		try {

			$comment = Comment::where('publicacion_id', $post)
				->where('respuesta_id', $comment)
				->with([
					'user' => function($query) {
						$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario', 'correo', 'role_id', 'estado_id');
					},
					// 'responses' => function($query) {
					// 	$query->where('estado_id', 2)
					// 		->with([
					// 			'user' => function($query) {
					// 				$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
					// 			}
					// 		]);
					// }
				])
				->get();
		
			return response()->json(Resources::format($comment, 'App\Models\Comment'), 200);
		
		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
	}
	
	public function update (Request $request, $post, $comment) {		
		$validator = Validator::make($request->all() + ['post' => $post, 'comment' => $comment], [
			'post' => 'required|exists:publicacion,id',
			'comment' => 'required|exists:comentario,id',
			'contenido' => 'required|string'
		]);

		if ($validator->fails()) {
			return response()->json(CustomError::format('La información enviada es incorrecta', 400, $validator->errors()), 400);
		}

		try {

			DB::beginTransaction();

			$commentary = Comment::find($comment);
			$commentary->contenido = $request->contenido;
			$commentary->save();

			DB::commit();

			return response()->json(Resource::format($commentary, 'App\Models\Comment'), 200);

		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
	}

	public function delete ($post, $comment) {
		$validator = Validator::make(['post' => $post, 'comment' => $comment], [
			'post' => 'required|exists:publicacion,id',
			'comment' => 'required|exists:comentario,id',
		]);

		if ($validator->fails()) {
			return response()->json(CustomError::format('La información enviada es incorrecta', 400, $validator->errors()), 400);
		}

		try {

			DB::beginTransaction();

			$commentary = Comment::find($comment);
			$commentary->delete();

			DB::commit();

			return response()->json(Resource::format($commentary, 'App\Models\Comment'), 200);

		} catch (\Exception $e) {

			return response()->json(Error::format($e, '5xx'), 500);
		}
	}
}

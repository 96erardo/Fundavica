<?php

namespace App\Http\Controllers\Api;

use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Serializer\JsonApiSerializer;
use App\Transformers\PostTransformer;
use App\Http\Controllers\Controller;
use App\QueryFilters\FiltersPost;
use League\Fractal\Resource\Item;
use App\Formatters\Resources;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use App\Models\Post;
use JWTAuth;
use DB;

class PostController extends Controller
{
    public function __construct () {

        $this->middleware('jwt.auth')->except('get', 'read');

        $this->middleware('api.post.create')->only('create');
        $this->middleware('api.post.update')->only('update');
        $this->middleware('api.post.delete')->only('delete');
    }    

    public function get (FiltersPost $filters) {
        
        try {
            
            $posts = Post::orderBy('created_at', 'desc')->filterBy($filters)->get();

            return Resources::format($posts, 'App\Models\Post');
            
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function create (Request $request) {

        $this->validate($request, [
            'titulo' => 'required|string',
			'imagen' => 'required|string',
            'contenido' => 'required|string',
            'categoria' => 'required',
        ]);

        try {

            if (! $user = JWTAuth::parseToken()->authenticate() ) {
                return response()->json(['user_not_found'], 404);
            }

            DB::beginTransaction();

            $post = new Post;
            $post->titulo = $request->titulo;
            $post->imagen = $request->imagen;
            $post->contenido = $request->contenido;
            $post->usuario_id = $user->id;
            $post->categoria_id = $request->categoria;
            $post->estado_id = 2;
            $post->save();

            DB::commit();

            return response()->json([
                'status' => 'success'
            ], 201);

        } catch(\Exception $e) {
            
            DB::rollback();
            
            return response()->json([
                'status' => 'error'
            ], 500);
        }
    }

    public function read (Request $request, $id) {
        
        $post = Post::where('id', $id)
			->with([
				'category' => function($query) {
					$query->select('id', 'nombre', 'color');
				},
				'user' => function($query){
					$query->withTrashed()->select('id', 'nombre', 'apellido', 'usuario');
				},
				'comments' => function($query) {
					$query->select('id', 'contenido', 'created_at', 'usuario_id', 'publicacion_id', 'estado_id')
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
						]);
				},
            ])->first();

        return $post->touches('category') ? 'true':'false';
            
        return $post;
    }

    public function update (Request $request, $id) {
        
        $this->validate($request, [
            'titulo' => 'required|string',
			'imagen' => 'required|string',
            'contenido' => 'required|string',
            'categoria' => 'required',
        ]);

        try {

            if (! $user = JWTAuth::parseToken()->authenticate() ) {
                return response()->json(['user_not_found'], 404);
            }

            DB::beginTransaction();

            $post = Post::find($id);
            $post->titulo = $request->titulo;
            $post->imagen = $request->imagen;
            $post->contenido = $request->contenido;
            $post->usuario_id = $user->id;
            $post->categoria_id = $request->categoria;
            $post->save();

            DB::commit();

            return response()->json([
                'status' => 'success'
            ], 200);

        } catch(\Exception $e) {
            
            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete (Request $request, $id) {
        try {

            DB::beginTransaction();

            $post = Post::find($id);
            $post->delete();

            DB::commit();

            return response()->json([
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {

            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

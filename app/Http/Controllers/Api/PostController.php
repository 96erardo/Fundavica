<?php

namespace App\Http\Controllers\Api;

use App\Transformers\PostTransformer;
use App\Http\Controllers\Controller;
use App\QueryFilters\FiltersPost;
use App\Formatters\Resources;
use Illuminate\Http\Request;
use App\Formatters\Resource;
use App\Formats\CustomError;
use App\Formats\Error;
use App\Models\Post;
use JWTAuth, Validator, DB;

class PostController extends Controller
{
    public function __construct () {

        $this->middleware('auth:api')->except('get', 'read');

        $this->middleware('api.post.create')->only('create');
        $this->middleware('api.post.update')->only('update');
        $this->middleware('api.post.delete')->only('delete');
    }    

    public function get (Request $request, FiltersPost $filters) {
        
        try {            
            
            $query = Post::select('id', 'titulo', 'imagen', 'created_at', 'updated_at', 'usuario_id', 'categoria_id', 'estado_id')
                ->orderBy('created_at', 'desc')
                ->filterBy($filters);

            if (!$request->has('page')) {
                $query->offset($this->offset(0, 16))->limit(10);
            }

            $posts = $query->get();

            return Resources::format($posts, 'App\Models\Post');
            
        } catch (\Exception $e) {

            return response()->json(Error::format($e, '5xx'), 500);
        }
    }

    public function create (Request $request) {

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string',
			'imagen' => 'required|string',
            'contenido' => 'required|string',
            'categoria' => 'required|exists:categoria,id',
        ]);

        if ($validator->fails()) {
            return response()->json(CustomError::format('Los campos no se llenaron correctamente', 400, $validator->errors()), 400);
        }

        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(CustomError::format('User no encontrado', 404), 404);
        }

        try {

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

            return response()->json(Resource::format($post, 'App\Models\Post'), 201);

        } catch(\Exception $e) {
            
            DB::rollback();
            
            return response()->json(Error::format($e, '5xx'), 500);
        }
    }

    public function read (FiltersPost $filters, $id) {

        try {
        
        $post = Post::select('id', 'titulo', 'imagen', 'created_at', 'updated_at', 'usuario_id', 'categoria_id', 'estado_id')
            ->where('id', $id)
            ->filterBy($filters)
            ->first();
        
            return Resource::format($post, 'App\Models\Post');

        } catch (\Exception $e) {

            return response()->json(Error::format($e, '5xx'), 500);
        } 
    }

    public function update (Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string',
			'imagen' => 'required|string',
            'contenido' => 'required|string',
            'categoria' => 'required|exists:categoria,id',
        ]);

        if ($validator->fails()) {
            return response()->json(CustomError::format('Los campos no se llenaron correctamente', 400, $validator->errors()), 400);
        }
        
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(CustomError::format('User no encontrado', 404), 404);
        }

        try {

            DB::beginTransaction();

            $post = Post::find($id);
            $post->titulo = $request->titulo;
            $post->imagen = $request->imagen;
            $post->contenido = $request->contenido;
            $post->categoria_id = $request->categoria;
            $post->save();

            DB::commit();

            return response()->json(Resource::format($post, 'App\Models\Post'), 200);

        } catch(\Exception $e) {
            
            DB::rollback();
            
            return  response()->json(Error::format($e, '5xx'), 500);
        }
    }

    public function delete (Request $request, $id) {
        try {

            $validator = Validator::make($request->all(), [
                'titulo' => 'required|string',
                'imagen' => 'required|string',
                'contenido' => 'required|string',
                'categoria' => 'required|exists:categoria,id',
            ]);

            DB::beginTransaction();

            $post = Post::find($id);
            $post->delete();

            DB::commit();

            return response()->json(Resource::format($post, 'App\Models\Post'), 200);

        } catch (\Exception $e) {

            DB::rollback();
            
            return  response()->json(Error::format($e, '5xx'), 500);
        }
    }

    private function offset ($page, $elements) {
        
        $posts = Post::count();
        $pages = ceil( $posts/$elements );
            
        if ($page > $pages || $page < 0) {
            $offset = 0;
        } else {
            $offset = $page * $elements;
        }
    
        return $offset;
    }
}

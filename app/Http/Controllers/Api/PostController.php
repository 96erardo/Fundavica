<?php

namespace App\Http\Controllers\Api;

use App\Transformers\PostTransformer;
use App\Http\Controllers\Controller;
use App\QueryFilters\FiltersPost;
use App\Formatters\Resources;
use App\Formatters\Resource;
use App\Formats\Error;
use Illuminate\Http\Request;
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
            
            $posts = Post::select('id', 'titulo', 'imagen', 'created_at', 'updated_at', 'usuario_id', 'categoria_id', 'estado_id')
                ->orderBy('created_at', 'desc')
                ->filterBy($filters)
                ->get();

            return Resources::format($posts, 'App\Models\Post');
            
        } catch (\Exception $e) {

            return response()->json(Error::format($e, '5xx'), 500);
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
        
        $this->validate($request, [
            'titulo' => 'required|string',
			'imagen' => 'required|string',
            'contenido' => 'required|string',
            'categoria' => 'required',
        ]);

        try {

            DB::beginTransaction();

            $post = Post::find($id);
            $post->titulo = $request->titulo;
            $post->imagen = $request->imagen;
            $post->contenido = $request->contenido;
            $post->usuario_id = $user->id;
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
}

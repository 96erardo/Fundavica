<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QueryFilters\FiltersPost;
use App\Models\Post;
use DB;

class PostController extends Controller
{
    public function get(FiltersPost $filters) {
        return Post::orderBy('created_at', 'desc')->filterBy($filters)->get();
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
            $post->usuario_id = 1;
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

    public function update (Request $request) {
        
        $this->validate($request, [
            'titulo' => 'required|string',
			'imagen' => 'required|string',
            'contenido' => 'required|string',
            'categoria' => 'required',
        ]);
    }
}

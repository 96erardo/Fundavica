<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QueryFilters\FiltersPost;
use App\Models\Post;
use DB;

class PostController extends Controller
{
    public function __construct () {

        $this->middleware('jwt.auth')->except('get');
    }    

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
            $post->usuario_id = $request->usuario_id;
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
        return $id;
    }

    public function update (Request $request) {
        
        $this->validate($request, [
            'titulo' => 'required|string',
			'imagen' => 'required|string',
            'contenido' => 'required|string',
            'categoria' => 'required',
        ]);
    }

    // eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdXNlcnMvbG9naW4iLCJpYXQiOjE1MjUzODM2NjUsImV4cCI6MTUyNTM4NzI2NSwibmJmIjoxNTI1MzgzNjY1LCJqdGkiOiJyWFRMWnJNcVFvNkJ2T2FDIn0.zttsjYlzzRPRZHROgV1XxOphGfF3MiyCH10vFmI6bwo
}

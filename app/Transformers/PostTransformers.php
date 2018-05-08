<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

class PostTransformer extends TransformerAbstract {
    
    public function transform (Post $post) {
        return [
            'id' => (int) $post->id,
            'titulo' => $post->titulo,
            'imagen' => $post->imagen,
            'contenido' => $post->contenido,
            'fecha_creacion' => Carbon::parse($post->created_at)->format('d/m/Y'),
            'timestamps' => $post->created_at,
        ];
    }
}
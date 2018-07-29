<?php

namespace App\Http\Middleware\Api\Posts;

use App\Formats\CustomError;
use App\Models\Post;
use App\Models\Token;
use Closure, JWTAuth;

class Delete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $auth_header = $request->header('Authorization');
        $token_string = explode(' ', $auth_header)[1];
        
        $token = new Token($token_string);
        $post = Post::find($request->id);

        if ($post == null) {
            return response()->json(CustomError::format('Recurso no encontrado', 404), 404);
        }        

        if ( $token->get('sub') != $post->usuario_id ) {
            return response()->json(CustomError::format('El usuario no está autorizado para realizar estas acciones', 403), 403);
        }

        return $next($request);
    }
}

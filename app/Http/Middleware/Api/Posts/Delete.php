<?php

namespace App\Http\Middleware\Api\Posts;

use App\Models\Post;
use Closure;
use JWTAuth;

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
        if ( $user = JWTAuth::parseToken()->authenticate() ) {

            $post = Post::find($request->id);

            if ( $user->id != $post->usuario_id ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized Action'
                ], 403);
            }
        } else {

            return response()->json(['user_not_found'], 404);
        }

        return $next($request);
    }
}

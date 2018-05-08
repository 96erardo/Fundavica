<?php

namespace App\Http\Middleware\Api\Comment;

use App\Models\Comment;
use App\Models\Token;
use Closure;
use JWTAuth;

class Update
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
        $comment = Comment::find($request->comment);
            
        if ( $token->get('sub') != $comment->usuario_id ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized Action'
            ], 403);
        }

        return $next($request);
    }
}

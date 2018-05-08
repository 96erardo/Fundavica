<?php

namespace App\Http\Middleware\Api\Posts;

use Closure;
use JWTAuth;

class Create
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
            if ( $user->role_id < 3 ) {
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

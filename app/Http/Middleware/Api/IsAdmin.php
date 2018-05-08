<?php

namespace App\Http\Middleware\Api;

use Closure;

class IsAdmin
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
        
        if($token->get('role') != 4) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized Action'
            ], 403);
        };

        return $next($request);
    }
}

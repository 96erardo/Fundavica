<?php

namespace App\Http\Middleware;

use Closure;
use App\Post;

class IsPost
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
        $count = Post::where('id', $request->id)->count();
        
        if($count == 0){
            return redirect('/404');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CanWrite
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
        if(!Session::has('usuario')){
            return redirect()->back();            
        }else{
            $tipo = Session::get('tipo');            
            if($tipo != 1 && $tipo != 2){
                return redirect('/');
            }
        }

        return $next($request);
    }
}

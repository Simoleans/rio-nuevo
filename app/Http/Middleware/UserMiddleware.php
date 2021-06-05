<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->status == 0)
        {
            return redirect()->route('loginView')->withErrors('No puedes entrar, tu usuario esta deshabilitado.');

        }else{
            return $next($request);
        }
    }
}

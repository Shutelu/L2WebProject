<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsGestionnaire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //est gestionnaire ou admin
        if($request->user()->isGestionnaire()){
            return $next($request);
        }

        //si fail
        abort(403,'Erreur : Vous n\'etes pas le gestionnaire');
    }
}

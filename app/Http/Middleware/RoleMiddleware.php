<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if(!auth()->check()) return redirect()->route('home')->with('error','Please log in to access this page.');
        if(!in_array(auth()->user()->role,$roles)){
            abort(403,'Unauthorized access. You do not have the correct permissions.');
        }

        return $next($request);
    }
}

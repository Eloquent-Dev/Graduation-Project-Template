<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequiredCompleteProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()){
            if(is_null(auth()->user()->national_no) || is_null(auth()->user()->phone)){
                return redirect()->route('home')->with('warning', 'Please complete your account details before submitting a complaint!');
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsInstructor
{
    /**
     * Summary of handle
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return void
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->is_instructor == false)
        {
            abort(403,'Area restrita para instrutores');
        }

        return $next($request);
    }
}

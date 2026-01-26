<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('age') || $request->is('save-age')) {
            return $next($request);
        }

        $age = session('age');

        if (!$age || $age < 18) {
            return redirect('/age');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTimeAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $now = now();
        $startTime = Carbon::parse('07:00:00');
        $endTime = Carbon::parse('10:00:00');

        if ($now->between($startTime, $endTime)) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Access Denied.',
            'time' => $now->format('H:i:s'),
        ], 403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class TimeRestrictedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentTime = Carbon::now()->format('H:i');

        $startTime = '00:00';
        $endTime = '23:15';

        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            return $next($request); // Allow access
        }else{
            return response()->json(['message' => 'Time restricted access. Please try again.'.$currentTime], 403);
        }
    }
}

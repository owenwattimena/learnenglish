<?php

namespace App\Http\Middleware;

use App\Helpers\JsonFormatter;
use Closure;
use Illuminate\Http\Request;

class IsPeriod
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
        $user = $request->user();
        if(!$user->period->status)
        {
            return JsonFormatter::error("Your Periode is not active.", code: 422);
        }
        return $next($request);
    }
}

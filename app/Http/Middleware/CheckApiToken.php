<?php

namespace App\Http\Middleware;

use App\Helpers\JsonFormatter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;

class CheckApiToken extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$request->bearerToken()) {
            return JsonFormatter::error("Unauthorized. Token missing or empty.", code: 401);
        }
        else if($request->bearerToken())
        {
            $user = auth('sanctum')->user();
            if($user == null)
            {
                return JsonFormatter::error("Unauthorized. Token error or not correct.", code: 401);
            }
        }

        return $next($request);
    }
}

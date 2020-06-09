<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate //extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->expectsJson()) {
            if (strpos($request->url(), "api") > 0) {
                if (empty($request->header('Authorization'))) {
                    return responseUnAuthorize();
                } else {
                    if (auth('api')->user()) {
                        return $next($request);
                    } else {
                        return responseUnAuthenticated();
                    }
                }
            } else {
                return route('login');
            }
        }
    }


    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }
}
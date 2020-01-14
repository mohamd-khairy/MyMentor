<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorize = $request->header('Authorization');
            $this->checkIn($authorize);
        $split = explode(" " , $authorize);
            $this->checkIn($split);
        $token = end($split);
            $this->checkIn($token);
        
        return $next($request);
    }

    public function checkIn($input)
    {
        if(empty($input)){
            return responseUnAuthorize();
        }
    }

}

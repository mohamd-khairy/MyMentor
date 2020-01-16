<?php

namespace App\Http\Middleware;

use Closure;

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
        if(empty($authorize)){
            return responseUnAuthorize();
        }

        $split = explode(" " , $authorize);
        if(empty($split)){
            return responseUnAuthorize();
        }        
        
        $token = end($split);
        if(empty($token)){
            return responseUnAuthorize();
        }      

        return $next($request);
    }

}

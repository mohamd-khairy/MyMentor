<?php

namespace App\Http\Middleware;

use Closure;

class PermissionFor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $permission = null)
    {
        $allPermissions = explode("|" , $permission);
        if(in_array(auth('api')->user()->user_type->user_type_name,$allPermissions)){
            return $next($request);
        }
        return responseUnAuthorize("you don't have a permission for this .");
    }
}

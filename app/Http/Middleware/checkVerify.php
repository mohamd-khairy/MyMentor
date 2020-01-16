<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class checkVerify
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
        $user = User::where('email' , $request->email)->first();
        if($user){
            if(! $user->verified){
                return \responseFail('You need to confirm your account. We have sent you Verification Mail, please check your email.');
            }
            return $next($request);
        }
        return \responseFail('There is no user with this email !');
    }
}

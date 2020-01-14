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
        
        // return $this->postGuzzleRequest($token);

        return $next($request);
    }

    public function checkIn($input)
    {
        if(empty($input)){
            return responseUnAuthorize();
        }
    }

    
    public function postGuzzleRequest($token)
    {
        return $token;
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8000/api/auth/me";//URL::to('api/auth/me');
        $data = [];

        $request = $client->post($url,[
            'body' => $data,
            'headers' => [
                'Authorization'=> $token,
                'Content-Type' => 'application/json',
            ]
        ]);

        $response = $request->send();
        $response = $response->getBody();

        return $response;
    }
}

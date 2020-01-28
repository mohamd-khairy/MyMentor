<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Sessions;

class SessionController extends Controller
{
    const MODEL = Sessions::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
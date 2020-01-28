<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;

class UserController extends Controller
{
    const MODEL = User::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
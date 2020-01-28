<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Rate;

class RateController extends Controller
{
    const MODEL = Rate::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
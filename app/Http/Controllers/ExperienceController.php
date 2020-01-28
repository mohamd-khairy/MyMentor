<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\ExperienceDetails;

class ExperienceController extends Controller
{
    const MODEL = ExperienceDetails::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\JobDetails;

class JobDetailsController extends Controller
{
    const MODEL = JobDetails::class;
    const FILTERS = ['user_id' ];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
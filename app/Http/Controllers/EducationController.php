<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\EducationDetails;

class EducationController extends Controller
{
    const MODEL = EducationDetails::class;
    const FILTERS = ['user_id' ];

        const WITH = [];
use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

}
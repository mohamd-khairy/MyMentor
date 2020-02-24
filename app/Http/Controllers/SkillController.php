<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\SkillDetails;

class SkillController extends Controller
{
    const MODEL = SkillDetails::class;
    const FILTERS = ['user_id','skill_name'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
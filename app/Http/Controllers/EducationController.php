<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\EducationDetails;
use App\Models\User;

class EducationController extends Controller
{
    const MODEL = EducationDetails::class;
    const FILTERS = ['user_id' ];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show($id)
    {
        $current_id = auth('api')->user()->id;
        $data = User::find($id);

        if($current_id != $data->id && $data->user_type->user_type_name != 'mentor'){
            return responseFail("this id not belong to you !");
        }
        

        return $this->find($id);

    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Http\Controllers\Traits\UserTrait;
use App\Models\Rate;

class RateController extends Controller
{
    const MODEL = Rate::class;
    const FILTERS = ['user_id' , 'user_rated_id'];

    use RestApi , UserTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id']= $data->user_rated_id;
        $data['user_rated_id'] = auth('api')->user()->id;
        $data = Rate::firstOrCreate($data);
        $this->set_rate($data->user_rated_id);
        if (empty($data)) {
            return responseSuccess([],"data is empty");
        }
        return responseSuccess($data , "data added successfully");
    }
}

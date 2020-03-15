<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Http\Controllers\Traits\UserTrait;
use App\Models\Rate;

class RateController extends Controller
{
    const MODEL = Rate::class;
    const FILTERS = ['user_id' , 'user_add_rate_id'];

    use RestApi , UserTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $data = Rate::firstOrCreate($request->all());
        $this->set_rate($data->user_add_rate_id);
        if (empty($data)) {
            return responseSuccess([],"data is empty");
        }
        return responseSuccess($data , "data added successfully");
    }
}

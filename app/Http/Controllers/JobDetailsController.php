<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Http\Controllers\Traits\UserTrait;
use App\Models\JobDetails;

class JobDetailsController extends Controller
{
    const MODEL = JobDetails::class;
    const FILTERS = ['user_id' ];

    use RestApi , UserTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index(Request $request)
    {
        $conditions = $this->filter($request);

        if(is_array($conditions)){
            $data = JobDetails::where($conditions)->first();
            return responseSuccess($data , "data returned successfully"); 
        }else{
            return $this->filter($request);
        }
    }

    public function store(Request $request)
    {
        $old = JobDetails::where('user_id' , auth('api')->user()->id)->first();
        if($old){
            $data = $old->update($request->all());
        }else{
            $data = JobDetails::create($request->all());
        }

        $this->set_complete_profile_rate();

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data , "data added successfully");
    }
}
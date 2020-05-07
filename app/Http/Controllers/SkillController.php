<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\SkillDetails;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    const MODEL = SkillDetails::class;
    const FILTERS = ['user_id','skill_name'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "skill_name" => "required|string"
        ]);
         
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $skills = explode(',' , $request->skill_name);

        $data = Collect($skills)->map(function($item){
            return SkillDetails::create($item);
        });

        if($data){
            return responseSuccess($data , 'data saved successfully');
        }
        return responseFail('some thing wrong');
    }
    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Http\Controllers\Traits\UserTrait;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    const MODEL = Profile::class;
    const FILTERS = ['user_id' ];

    use RestApi , UserTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show($id)
    {
        $current_id = auth('api')->user()->id;
        $data = User::find($id);

        if($current_id != $data->id){
            return responseFail("this id not belong to you !");
        }
        

        return $this->find($id);

    }

    public function show_mentor_profile($id)
    {
        $data = User::with('profile','topics')->find($id);

        if($data->user_type->id != 1 || (string) $data->user_type->user_type_name != "mentor"){
            return responseFail("this id not belong to mentor !");
        }

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data , "data returned successfully");

    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "photo" => "nullable|image|mimes:jpeg,jpg,png|max:512",
            'phone_number' => 'required|unique:profiles,id,'.auth('api')->user()->id.'|min:10',
            'mobile' => 'required|unique:profiles,id,'.auth('api')->user()->id.'|min:10'
        ]);
         
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $current_id = auth('api')->user()->id;
        $res = $this->putBy($request , ['user_id' => $current_id]);
        $this->set_complete_profile_rate();
        return $res;

    }

}

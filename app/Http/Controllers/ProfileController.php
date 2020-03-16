<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Http\Controllers\Traits\UserTrait;
use App\Models\Profile;
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

    public function show_my_profile()
    {
        $current_id = auth('api')->user()->id;
        return $this->findBy(['user_id' => $current_id]);
    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "photo" => "nullable|image|mimes:jpeg,jpg,png|max:512",
            'phone_number' => 'required|unique:profiles,id|min:10',
            'mobile' => 'required|unique:profiles,id|min:10'
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

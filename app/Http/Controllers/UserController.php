<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use App\Http\Controllers\Traits\RestApi;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    const MODEL = User::class;
    const FILTERS = ['user_type_id'];

    use RestApi , UserTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function most_popular_mentor()
    {
      $data = User::with('profile','topics')->where(['user_type_id' => 1])->orderBy('complete_profile_rate' , 'desc')->take(5)->get() ?? [];

      return responseSuccess($data , 'data returned successfully');
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|max:50',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
      ]);
      
      if ($validator->fails()) {    
          return response()->json($validator->messages(), 400);
      }

      return $this->add($request);        

    }

}

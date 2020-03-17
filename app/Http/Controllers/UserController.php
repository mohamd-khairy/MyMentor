<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use App\Http\Controllers\Traits\RestApi;
use App\Mail\EmailVerify;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

      /** convert request data to array */
      $data = $request->all();
      /** assign fisrt and last name to name field */
      $data['name'] = $request->first_name . " " . $request->last_name;
      $data['remember_token'] = Str::random(20);
      /** start transaction */
      DB::beginTransaction();
      /** create user */
      $user = User::create($data);

      if ($user) {
          $data['user_id'] = $user->id;
          /** create profile for this user */
          $profile = Profile::create($data);
      }

      if ($profile) {
          /** send verify email to new user */
          Mail::to($user->email)->send(new EmailVerify($user));

           /** commit database action */
           DB::commit();

          /** return json response with user data */
          return responseSuccess($user , 'Your Account Created successfully , and verified email has been sent.');
      }
      /** rollback the database action */
      DB::rollback();
      /** return json response with unauthorize message */
      return responseUnAuthorize();
  
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use App\Http\Controllers\Traits\RestApi;
use App\Mail\EmailVerify;
use App\Models\Profile;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    const MODEL = User::class;
    const FILTERS = ['user_type_id'];
    const WITH = [];

    use RestApi , UserTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function most_popular_mentor()
    {
      $data = User::with('profile','topics','skills' , 'experienceDetail' , 'job')->where( 'complete_profile_rate' ,'>=', 90)->where(['user_type_id' => UserType::where('user_type_name' , 'mentor')->first()->id])->orderBy('complete_profile_rate' , 'desc')->take(5)->get() ?? [];

      return responseSuccess($data , 'data returned successfully');
    }

}

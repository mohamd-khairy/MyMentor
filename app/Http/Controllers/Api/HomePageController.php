<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserType;

class HomePageController extends Controller
{

  public function most_popular_mentor()
  {
    $data = User::with('profile', 'topics', 'skills', 'experienceDetail', 'job')->where('complete_profile_rate', '>=', 90)->where(['user_type_id' => UserType::where('user_type_name', 'mentor')->first()->id])->orderBy('complete_profile_rate', 'desc')->take(5)->get() ?? [];

    return responseSuccess($data, 'data returned successfully');
  }
}
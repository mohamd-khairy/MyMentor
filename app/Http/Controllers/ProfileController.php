<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Http\Controllers\Traits\UserTrait;
use App\Models\Profile;

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
        return $this->findBy(['user_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $res = $this->putBy($request , ['user_id' => $id]);
        $this->set_complete_profile_rate();
        return $res;

    }

}

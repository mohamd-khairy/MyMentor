<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Profile;

class ProfileController extends Controller
{
    const MODEL = Profile::class;

    use RestApi;

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
        return $this->putBy($request , ['user_id' => $id]);
    }
    
}
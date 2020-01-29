<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Sessions;

class SessionController extends Controller
{
    const MODEL = Sessions::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function store(Request $request)
    {
        /** check type of give user type */
        $user = getUser(['id' => $request->user_give_id]);
        if($user && $user->user_type->user_type_name != 'mentor'){
            return responseFail('user give id must be mentor type');
        }

        /** check type of recieve user type */
        $user = getUser(['id' => $request->user_recieve_id]);
        if($user && $user->user_type->user_type_name != 'user'){
            return responseFail('user receive id must be user type');
        }

        return $this->add($request);  

    }
}
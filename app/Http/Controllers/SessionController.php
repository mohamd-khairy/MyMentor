<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Sessions;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller
{
    const MODEL = Sessions::class;
    const FILTERS = ['user_give_id' ,'user_recieve_id','topic_id','day_id' , 'status' , 'session_type'];

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

    public function acceptOrReject(Request $request , $session_id)
    {

        //must be mentor
        
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);
        
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $session = Sessions::find($session_id);

        $accept = (int) $request->accept == 1 ||  (string) $request->accept == "true"? 1: 0;

        if($session){

            $session->update(['accept' => (boolean) $accept]);

            return responseSuccess($session , 'session changed successfully');

        }
            return responseFail('this session not found');

    }
}
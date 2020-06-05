<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Chat;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    const MODEL = Chat::class;
    const FILTERS = ['user_id' , 'mentor_id'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if(auth('api')->user()->user_type->user_type_name == 'mentor'){

            $data['mentor_id'] = auth('api')->user()->id;
            /**  user_id is required_if:logged in user is mentor */
            $validator = Validator::make($request->all(), [
                'user_id' => 'required'
            ]);

        }else{

            $data['user_id'] = auth('api')->user()->id;
            /**  mentor_id is required_if:logged in user is user */
            $validator = Validator::make($request->all(), [
                'mentor_id' => 'required'
            ]);
        }
        
        
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }
        return $row = Chat::where('mentor_id' , $request->mentor_id)->first();
        if(empty($row)){
            $row = Chat::create($data);
        }

        return responseSuccess($row , "data added successfully");

    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    const MODEL = Chat::class;
    const FILTERS = ['user_id', 'mentor_id'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if (auth('api')->user()->user_type->user_type_name == 'mentor') {

            $data['mentor_id'] = auth('api')->user()->id;
            /**  user_id is required_if:logged in user is mentor */
            $validator = Validator::make($request->all(), [
                'user_id' => 'required'
            ]);
        } else {

            $data['user_id'] = auth('api')->user()->id;
            /**  mentor_id is required_if:logged in user is user */
            $validator = Validator::make($request->all(), [
                'mentor_id' => 'required'
            ]);
        }


        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $row = Chat::firstOrCreate($data);

        return responseSuccess($row, "data added successfully");
    }

    public function show($id)
    {
        // $this->set_all_chat_messages_read($id);
        return $this->find($id);
    }

    // public function set_all_chat_messages_read($chat_id)
    // {
    //     $chat = Chat::find($chat_id);
    //     if ($chat->user_id == auth('api')->user()->id) {
    //         $mentor_id = $chat->mentor_id;
    //         Message::where('read', 0)
    //             ->where('chat_id', $chat_id)
    //             ->where('user_id', $chat->mentor_id)
    //             ->update(['read' => 1]);
    //     } else {
    //         $user_id = $chat->user_id;
    //         Message::where('read', 0)
    //             ->where('chat_id', $chat_id)
    //             ->where('user_id', $chat->user_id)
    //             ->update(['read' => 1]);
    //     }
    // }
}
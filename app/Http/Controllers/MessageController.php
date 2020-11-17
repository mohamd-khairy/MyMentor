<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Chat;
use App\Models\Message;

class MessageController extends Controller
{
    const MODEL = Message::class;
    const FILTERS = ['chat_id', 'read'];

        const WITH = [];
use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // public function get_un_read_messages(Request $request)
    // {
    //     // $conditions = $this->filter($request);
    //     // if(!is_array($conditions)){
    //     //     return  $this->filter($request);
    //     // }

    //     // $messages = Message::join('chats' , function($join) use($conditions){
    //     //     $join->on('chats.id' , 'messages.chat_id')->where($conditions);
    //     // })->where('read',0)->get();

    //     // return responseSuccess($messages , 'data returned successfully');


    //     $messages = Message::join('chats', function ($join) {
    //         $join->on('chats.id', 'messages.chat_id')->where('chats.user_id', auth('api')->user()->id);
    //     })->where('read', 0)->get();

    //     return responseSuccess($messages, 'data returned successfully');
    // }


    public function store(Request $request)
    {
        $data = $this->add($request);
        // $chat = Chat::find($request->chat_id);
        // if ($chat->user_id == auth('api')->user()->id) {
        //     $mentor_id = $chat->mentor_id;
        //     Message::where('read', 0)
        //         ->where('chat_id', $request->chat_id)
        //         ->where('user_id', $chat->mentor_id)
        //         ->update(['read' => 1]);
        // } else {
        //     $user_id = $chat->user_id;
        //     Message::where('read', 0)
        //         ->where('chat_id', $request->chat_id)
        //         ->where('user_id', $chat->user_id)
        //         ->update(['read' => 1]);
        // }

        return $data;
    }
}
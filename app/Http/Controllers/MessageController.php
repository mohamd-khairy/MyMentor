<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Message;

class MessageController extends Controller
{
    const MODEL = Message::class;
    const FILTERS = ['chat_id'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

}
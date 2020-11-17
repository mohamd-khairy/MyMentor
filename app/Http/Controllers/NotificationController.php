<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Notification;

class NotificationController extends Controller
{
    const MODEL = Notification::class;
    const FILTERS = ['user_id'];

        const WITH = [];
use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $conditions = $this->filter($request);
        if (is_array($conditions)) {
            $conditions['readed'] = false;
            if (auth('api')->user()->id == $request->user_id) {
                return $this->get($conditions);
            } else {
                return responseUnAuthorize();
            }
        } else {
            return $this->filter($request);
        }
    }

    public function readed($user_id)
    {
        $noti = Notification::where('user_id', $user_id)->update(['readed' => true]);
        return responseSuccess($noti, 'readed successfully');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message', 'user_id', 'chat_id'];

    protected $with = ['user'];

    /** attach loged in user id with profile data */
    public static function boot()
    {
        parent::boot();

        try {
            static::creating(function ($data) {
                if (empty($data->user_id) && auth('api')->user()) {
                    $data->user_id = auth('api')->user()->id;

                    $chat = Chat::find($data->chat_id);
                    if ($chat) {
                        if ($chat->user_id == $data->user_id) {
                            $to = $chat->mentor_id;
                            $from = $chat->user_id;
                            $name = $chat->user->name;
                            $image = $chat->user->profile->photo;
                        } else {
                            $to = $chat->user_id;
                            $from = $chat->mentor_id;
                            $name = $chat->mentor->name;
                            $image = $chat->mentor->profile->photo;
                        }
                    }

                    $noti = [
                        'title'   => $name . ' send message to you',
                        'body'    => $data->message,
                        'image'   => $image,
                        'user_id' => $to,
                        'from_user_id' => $from,
                        'type'    => 'chat'
                    ];
                    Notification::create($noti);
                }
            });
        } catch (\Throwable $th) {
            return $th;
        }
    }


    /** relations */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with('profile');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message' , 'user_id' ,'chat_id'];

    protected $with = ['user' , 'chat'];

    /** attach loged in user id with profile data */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            $data->user_id = auth('api')->user()->id;
        });
    }

    /** relations */

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class , 'chat_id');
    }

}

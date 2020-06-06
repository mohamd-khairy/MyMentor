<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message' , 'user_id' ,'chat_id'];

    protected $with = ['user'];

    /** attach loged in user id with profile data */
    public static function boot()
    {
        parent::boot();

        try {
            static::creating(function ($data) {
                if(empty($data->user_id) && auth('api')->user()){
                    $data->user_id = auth('api')->user()->id;
                }
            });
        } catch (\Throwable $th) {
            return $th;
        }
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

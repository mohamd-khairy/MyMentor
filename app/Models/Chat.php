<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['mentor_id' , 'user_id'];

    protected $with = ['messages' , 'user' , 'mentor'];

    /** attach loged in user id with chat data */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if(auth('api')->user()->user_type->user_type_name == 'mentor'){
                $data->mentor_id = auth('api')->user()->id;
            }else{
                $data->user_id = auth('api')->user()->id;
            }
        });
    }

    /** relations */

    public function mentor()
    {
        return $this->belongsTo(User::class , 'mentor_id')->with('profile');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id')->with('profile');
    }

    public function messages()
    {
        return $this->hasMany(Message::class , 'chat_id' ,'id');
    }
}

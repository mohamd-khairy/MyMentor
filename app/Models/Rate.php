<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['rate' , 'comment' , 'user_add_rate_id' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user' , 'user_add_rate'];
    
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

    public function user_add_rate()
    {
        return $this->belongsTo(User::class , 'user_add_rate_id');
    }
}

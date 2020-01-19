<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['rate' , 'comment' , 'user_add_rate_id' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user'];
    
    /** attach loged in user id with profile data */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = auth('api')->user()->id ?? '';
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

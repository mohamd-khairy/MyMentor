<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['rate' , 'comment' , 'user_add_rate_id' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

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

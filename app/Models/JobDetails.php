<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class JobDetails extends Model
{
    protected $fillable = ['available_days' , 'available_langs' , 'session_price' ,
        'session_duration' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}

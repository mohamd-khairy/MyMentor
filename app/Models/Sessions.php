<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $fillable = [ 'details' , 'duration' , 'day_id' , 'user_give_id' , 'user_recieve_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user_give' , 'user_recieve'];

        
    /** relations */

    public function day()
    {
        return $this->belongsTo(WeekDays::class , 'day_id');
    }

    public function user_give()
    {
        return $this->belongsTo(User::class , 'user_give_id');
    }

    public function user_recieve()
    {
        return $this->belongsTo(User::class , 'user_recieve_id');
    }
}

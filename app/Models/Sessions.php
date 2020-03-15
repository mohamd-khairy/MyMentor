<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $fillable = [ 'details' , 'duration' , 'day_id' , 'user_give_id' , 'user_recieve_id' ,'topic_id','accept','session_type'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user_give' , 'user_recieve' , 'topic'];

    protected $appends = ['day'];

    protected $casts = [ "accept" => "boolean"];

    /** mutators */

    public function getDayAttribute()
    {
        return  $this->day_id? WeekDays::find($this->day_id)->day : null;
    }
    
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

    public function topic()
    {
        return $this->belongsTo(Topics::class , 'topic_id');
    }
}

<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Sessions extends Model
{
    protected $fillable = ['title' , 'day_ids' , 'details' , 'duration' , 'day_id' , 'repository_url' ,
     'user_give_id' , 'user_recieve_id' ,'topic_id','accept','session_type'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user_give' , 'user_recieve' , 'topic'];

    protected $appends = ['day'];

    protected $casts = [ "accept" => "boolean"];

    /** mutators */

    public function setDayIdsAttribute($input)
    {
        $this->attributes['day_ids'] =  json_encode($input);
    }

    public function getDayIdsAttribute($value) {
        $days = json_decode($value, true);

        $days_names = [];

        if(!empty($days)){

            $collection = new Collection($days);
            
            $days_names = $collection->map(function($item, $key) {
                return WeekDays::where('id' , $item)->first()->day;
            });
        }

        return $days_names;
    }

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
        return $this->belongsTo(User::class , 'user_recieve_id')->with('profile');
    }

    public function topic()
    {
        return $this->belongsTo(Topics::class , 'topic_id');
    }
}

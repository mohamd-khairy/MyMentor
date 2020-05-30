<?php

namespace App\Models;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;

class SessionDays extends Model
{
    protected $fillable= ['date_time' , 'session_id' , 'week_days_id'];

    protected $appends = ['day'];

    public function getDayAttribute()
    {
        return  $this->week_days_id? WeekDays::find($this->week_days_id)->day : null;
    }


    /** relations */
    public function session()
    {
        return $this->belongsTo(Sessions::class);
    }

}

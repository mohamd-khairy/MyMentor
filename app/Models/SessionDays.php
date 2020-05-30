<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;

class SessionDays extends Model
{
    protected $fillable= ['date_time' , 'session_id' , 'week_days_id'];

    protected $appends = ['day'];

    protected $hidden = [ 'created_at' ,'updated_at'];

    // protected $dates = [
    //     'date_time'
    // ];

    public function getDayAttribute()
    {
        return  $this->week_days_id? WeekDays::find($this->week_days_id)->day : null;
    }


    // public function getDateTimeAttribute()
    // {
    //     return $this->attributes['date_time'] ?  Carbon::parse($this->attributes['date_time'])->diffForHumans() : null ;

    //     // return $this->attributes['date_time'] ? date('d M, Y h:i A' , strtotime($this->attributes['date_time'])) : null;
    // }

    /** relations */
    public function session()
    {
        return $this->belongsTo(Sessions::class);
    }

}

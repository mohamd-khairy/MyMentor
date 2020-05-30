<?php

namespace App\Models;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;

class SessionDays extends Model
{
    protected $fillable= ['date_time' , 'session_id' , 'week_days_id'];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

}

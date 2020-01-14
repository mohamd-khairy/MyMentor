<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    protected $fillable = ['day'];

    protected $hidden = ['created_at' , 'updated_at'];

}

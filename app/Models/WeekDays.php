<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    protected $fillable = ['day'];

    protected $hidden = ['created_at' , 'updated_at'];

    const days = ['saturday'=> 1, 'sunday' => 2 , 'monday' => 3 ,'tuesday' => 4 ,'wednesday' => 5 , 'thursday' => 6 , 'friday' => 7];

}

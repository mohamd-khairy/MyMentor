<?php

use App\Models\User;
use App\Models\WeekDays;
use Intervention\Image\ImageManagerStatic as Image;

function getUser($condition)
{
    return User::where($condition)->first();
}

function getDay($condition)
{
    return WeekDays::where($condition)->first();
}

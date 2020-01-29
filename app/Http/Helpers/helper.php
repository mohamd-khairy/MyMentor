<?php

use App\Models\User;
use App\Models\WeekDays;

function getUser($condition)
{
    return User::where($condition)->first();
}

function getDay($condition)
{
    return WeekDays::where($condition)->first();
}
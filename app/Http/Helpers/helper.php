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

function resize_image($image)
{
    $image_resize = Image::make($image);
    return  $image_resize->resize(300, 300);
}
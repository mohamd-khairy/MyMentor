<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = ['user_type_name'];

    protected $hidden = ['created_at' , 'updated_at'];

}

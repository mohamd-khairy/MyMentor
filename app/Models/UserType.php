<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class UserType extends Model
{
    use Translatable;
    protected $translatable = ['user_type_name'];

    protected $fillable = ['user_type_name'];

    protected $hidden = ['created_at' , 'updated_at'];

    public $timestamps = false;
}

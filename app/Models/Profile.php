<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['first_name' , 'middle_name' , 'last_name' ,'photo' , 'address' ,
        'postal_code' , 'city' , 'country' , 'phone_number' , 'mobile' , 'date_of_birth' ,
        'gender' , 'marital_status' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user'];
    
    /** attach loged in user id with profile data */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            $data->user_id = auth('api')->user()->id;
        });
    }

    /** attach loged in user id with profile data */
    public function setDateOfBirthAttribute($input)
    {
        $this->attributes['date_of_birth'] = date("Y-m-d",strtotime($input));
    }


    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}

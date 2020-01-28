<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type_id' , 'is_active' , 'verified','remember_token'
    ];

    protected $hidden = [
        'is_active', 'verified', 'password', 'remember_token', 'created_at' , 'updated_at' 
        , 'email_verified_at' , 'resetPasswordCode' , 'resetPasswordCodeCreationdate'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['user_type'];

    
    /** hash password when create user */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            $data->user_id = auth('api')->user()->id;
        });
    }

    /** email to lower case when create user */
    public function setEmailAttribute($input)
    {
        $this->attributes['email'] = strtolower($input);
    }

    
    /** relations */

    public function user_type()
    {
        return $this->belongsTo(UserType::class , 'user_type_id');
    }

   
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

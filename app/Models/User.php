<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use TCG\Voyager\Models\User as VUSER;

class User extends VUSER implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type_id' , 'is_active' , 'verified','remember_token', 'complete_profile_rate' , 'rate'
    ];

    protected $hidden = [
        'is_active', 'verified', 'password', 'remember_token', 'created_at' , 'updated_at'
        , 'email_verified_at' , 'resetPasswordCode' , 'resetPasswordCodeCreationdate'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['user_type'];

    protected $appends = ['count'];


    public function getCountAttribute()
    {
        
        return $this->rates() ? $this->rates()->count() : 0;
    }



    public function setPasswordAttribute($input)
    {
        $this->attributes['password'] = Hash::make($input);
    }

    /** email to lower case when create user */
    public function setEmailAttribute($input)
    {
        $this->attributes['email'] = strtolower($input);
    }


    /** relations */

    public function profile()
    {
        return $this->hasOne(Profile::class , 'user_id');
    }

    public function user_type()
    {
        return $this->belongsTo(UserType::class , 'user_type_id');
    }

    public function mentor()
    {
        return $this->belongsTo(UserType::class , 'user_type_id')->where('user_type_name' , 'mentor');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class , 'user_rated_id');
    }

    public function job()
    {
        return $this->hasOne(JobDetails::class , 'user_id')->latest();
    }

    public function jobs()
    {
        return $this->hasMany(JobDetails::class , 'user_id');
    }

    public function skills()
    {
        return $this->hasMany(SkillDetails::class , 'user_id');
    }

    public function topics()
    {
        return $this->hasOne(Topics::class , 'user_id')->latest();
    }

    public function topicss()
    {
        return $this->hasMany(Topics::class , 'user_id');
    }

    public function experienceDetail()
    {
        return $this->hasOne(ExperienceDetails::class , 'user_id')->latest();
    }
    
    public function experienceDetails()
    {
        return $this->hasMany(ExperienceDetails::class , 'user_id');
    }

    public function classDetail()
    {
        return $this->hasOne(ClassDetails::class , 'user_id')->latest();
    }
    
    public function classDetails()
    {
        return $this->hasMany(ClassDetails::class , 'user_id');
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

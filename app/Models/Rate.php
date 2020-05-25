<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['rate' , 'comment' , 'user_rated_id' , 'user_id'];

    protected $hidden = ['updated_at'];

    protected $with = ['user' , 'user_rated'];
    
    protected $dates = [
        'created_at',
        'updated_at',
        // your other new column
    ];
    
    /** attach loged in user id with profile data */
    public static function boot()
    {
        parent::boot();

        try {
            static::creating(function ($data) {
                if(empty($data->user_id) && auth('api')->user()){
                    $data->user_id = auth('api')->user()->id;
                }
            });
        } catch (\Throwable $th) {
            return $th;
        }

    }
    
    /** relations */
    
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id')->with('profile');
    }

    public function user_rated()
    {
        return $this->belongsTo(User::class , 'user_rated_id')->with('profile');
    }

    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] ?   date('Y-m-d h:i:s A' , strtotime($this->attributes['created_at']))->diffForHumans() : null ;
        // date('d M Y' , strtotime($this->attributes['created_at'])) : null;

       
    }
}

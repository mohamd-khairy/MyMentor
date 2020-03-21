<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class JobDetails extends Model
{
    protected $fillable = ['available_days' , 'available_langs' , 'session_price' ,
        'session_duration' , 'user_id' , 'topic_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user','topic'];
    
    protected $appends = ['photo'];

    public function setAvailableLangsAttribute($input)
    {
        $this->attributes['available_langs'] = json_encode($input);
    }

    public function setAvailableDaysAttribute($input)
    {
        $this->attributes['available_days'] =  json_encode($input);
    }

    public function getAvailableLangsAttribute($value) {

        $langs = json_decode($value, true);

        $language_names = [];

        if(!empty($langs)){

            $collection = new Collection($langs);
            
            $language_names = $collection->map(function($item, $key) {
                return Language::where('id' , $item)->first()->name_1;
            });
        }

        return $language_names;
    }

    public function getAvailableDaysAttribute($value) {
        $days = json_decode($value, true);

        $days_names = [];

        if(!empty($days)){

            $collection = new Collection($days);
            
            $days_names = $collection->map(function($item, $key) {
                return WeekDays::where('id' , $item)->first()->day;
            });
        }

        return $days_names;
    }

    public function getPhotoAttribute()
    {

        return $this->user->profile;

    }

    /** attach loged in user id with profile data */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            $data->user_id = auth('api')->user()->id;
        });
    }
    
    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topics::class , 'topic_id');
    }
}

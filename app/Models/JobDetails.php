<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class JobDetails extends Model
{
    protected $fillable = ['available_days' , 'available_langs' , 'session_price' , 'session_duration_type',
    'session_duration' , 'current_job' , 'current_company', 'brief' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

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
          return $this->belongsTo(User::class , 'user_id');
      }

}

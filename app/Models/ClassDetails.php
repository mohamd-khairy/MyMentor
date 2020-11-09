<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class ClassDetails extends Model
{
    protected $fillable = [
        'available_days', 'available_langs', 'session_price', 'session_duration_type',
        'session_duration', 'user_id', 'topic_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $with = ['user', 'topic'];

    protected $appends = ['photo'];

    public function setAvailableLangsAttribute($input)
    {
        $this->attributes['available_langs'] = $input ? json_encode($input) : null;
    }

    public function setAvailableDaysAttribute($input)
    {
        $this->attributes['available_days'] =   $input ? json_encode($input) : null;
    }

    public function getAvailableDaysAttribute($value)
    {
        $days = $value ? json_decode($value, true) : null;

        if (!empty($days)) {

            $days_names = [];

            if (!is_array($days)) {
                $collection = new Collection(json_decode($days, true));
            } else {
                $collection = new Collection($days);
            }

            $days_names = $collection->map(function ($item, $key) {
                if (request()->segment(1) == 'admin') {
                    return WeekDays::where('id', $item)->first()->id;
                }
                return WeekDays::where('id', $item)->first()->day;
            });

            return $days_names;
        }

        return  null;
    }

    public function getAvailableLangsAttribute($value)
    {
        $langs = $value ? json_decode($value, true) : null;

        if (!empty($langs)) {

            $language_names = [];

            if (!is_array($langs)) {
                $collection = new Collection(json_decode($langs, true));
            } else {
                $collection = new Collection($langs);
            }

            $language_names = $collection->map(function ($item, $key) {
                if (request()->segment(1) == 'admin') {
                    return Language::where('id', $item)->first()->id;
                }
                return Language::where('id', $item)->first()->name;
            });

            return $language_names;
            return $langs;
        }

        return null;
    }



    public function getPhotoAttribute()
    {

        return $this->user->profile->photo ?? null;
    }

    /** attach loged in user id with profile data */
    public static function boot()
    {
        parent::boot();

        try {
            static::creating(function ($data) {
                if (empty($data->user_id) && auth('api')->user()) {
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topics::class, 'topic_id');
    }

}

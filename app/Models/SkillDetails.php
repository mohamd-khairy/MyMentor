<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillDetails extends Model
{
    protected $table = 'skill_details';

    protected $fillable = ['skill_name', 'user_id', 'experience_years', 'details', 'photo'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $with = ['user'];

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



    public function getPhotoAttribute()
    {
        $url = ($_SERVER['HTTP_HOST'] == 'localhost:8000' || $_SERVER['HTTP_HOST'] == '127.0.0.1:8000') ? 'http://localhost:8000' : config('app.host_url');
        $file = $url . '/' . $this->attributes['photo'];

        if (isset($this->attributes['photo']) && file_exists($this->attributes['photo'])) {
            return $file;
        } else {
            return "https://img.freepik.com/free-vector/businessman-profile-cartoon_18591-58479.jpg?size=338&ext=jpg";
        }
    }
}

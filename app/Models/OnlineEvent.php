<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineEvent extends Model
{
    public $guarded= [];

    public function getPhotoAttribute()
    {
        $url = ($_SERVER['HTTP_HOST'] == 'localhost:8000' || $_SERVER['HTTP_HOST'] == '127.0.0.1:8000') ? 'http://localhost:8000' : config('app.host_url');
        $file = $url.'/'.$this->attributes['photo'];

        if(isset($this->attributes['photo']) && file_exists($this->attributes['photo'])){
            return $file;//$this->attributes['photo'];
        }else{
          return "https://img.freepik.com/free-vector/businessman-profile-cartoon_18591-58479.jpg?size=338&ext=jpg";
        }

    }

    public function getBannerAttribute()
    {
        $url = ($_SERVER['HTTP_HOST'] == 'localhost:8000' || $_SERVER['HTTP_HOST'] == '127.0.0.1:8000') ? 'http://localhost:8000' : config('app.host_url');
        $file = $url.'/'.$this->attributes['banner'];

        if(isset($this->attributes['banner']) && file_exists($this->attributes['banner'])){
            return $file;//$this->attributes['photo'];
        }else{
          return "https://img.freepik.com/free-vector/businessman-profile-cartoon_18591-58479.jpg?size=338&ext=jpg";
        }

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

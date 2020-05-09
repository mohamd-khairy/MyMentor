<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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

    public function getAllAttributes()
    {
        $columns = $this->getFillable();
        // Another option is to get all columns for the table like so:
        // return  $columns = \Schema::getColumnListing('profiles');
        // but it's safer to just get the fillable fields

        $attributes = $this->getAttributes();

        $i = 0;
        foreach ($columns as $column)
        {
            if (!array_key_exists($column, $attributes))
            {
                $attributes[$column] = null;
            }

            if(!empty($attributes[$column])){
              $i = $i + 1;
            }
        }
        return [
          'all_attributes' => $attributes,
          'count_not_empty' => $i ?? 1,
          'count_all' => count($columns) ?? 1,
        ];
    }

    public function setDateOfBirthAttribute($input)
    {
        $this->attributes['date_of_birth'] = date("Y-m-d",strtotime($input));
    }


    public function getPhotoAttribute()
    {
        $url = $_SERVER['HTTP_HOST'] == 'localhost:8000' ? 'http://localhost:8000' : config('app.host_url');
        $file = $url.'/'.$this->attributes['photo'];

        if(isset($this->attributes['photo']) && file_exists($this->attributes['photo'])){
            return $file;//$this->attributes['photo'];
        }else{
          return "https://img.freepik.com/free-vector/businessman-profile-cartoon_18591-58479.jpg?size=338&ext=jpg";
        }

    }

    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    
    public function getDateOfBirthAttribute()
    {
        return $this->attributes['date_of_birth'] ?  date('Y-m-d' , strtotime($this->attributes['date_of_birth'])) : null;
    }

}

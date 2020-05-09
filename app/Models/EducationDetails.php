<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EducationDetails extends Model
{
    protected $fillable = ['education_name' , 'department' , 'degree' , 'university' , 'faculty', 
     'present' , 'details' , 'start_date' , 'end_date' , 'user_id'];

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
    
    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    
    public function getStartDateAttribute()
    {
        return $this->attributes['start_date'] ?  date('Y-m-d' , strtotime($this->attributes['start_date'])) : null;
    }

    public function getEndDateAttribute()
    {
        return $this->attributes['end_date'] ? date('Y-m-d' , strtotime($this->attributes['end_date'])) : null;
    }
}

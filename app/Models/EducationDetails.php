<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EducationDetails extends Model
{
    protected $fillable = ['education_name' , 'department' , 'degree' ,
     'present' , 'details' , 'start_date' , 'end_date' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user'];
    
    /** attach loged in user id with profile data */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = auth('api')->user()->id ?? '';
    }
    
    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillDetails extends Model
{
    protected $fillable = ['skill_name' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user'];
    
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
}

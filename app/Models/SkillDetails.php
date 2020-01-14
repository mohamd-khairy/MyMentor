<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillDetails extends Model
{
    protected $fillable = ['skill_name' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}

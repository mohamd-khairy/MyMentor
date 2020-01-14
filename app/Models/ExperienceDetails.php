<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ExperienceDetails extends Model
{
    protected $fillable = ['company_name' , 'job_title' , 'present' ,
        'details' , 'start_date' , 'end_date' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $fillable = ['details' , 'subject', 'topic' , 'language_id' , 'category_id' , 'user_id'];

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

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class , 'language_id');
    }
}

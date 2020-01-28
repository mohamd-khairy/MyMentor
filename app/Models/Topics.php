<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Topics extends Model
{
    use SearchableTrait;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'topics.subject' => 2,
            'topics.topic' => 1,
            'topics.details' => 3,
            'categories.id' => 4,
            'categories.name' => 5,
            'languages.id' => 6,
            'languages.lang' => 7,
            'languages.name' => 8,
        ],
        'joins' => [
            'categories' => ['topics.category_id','categories.id'],
            'languages' => ['topics.language_id','languages.id'],
        ],
    ];

    protected $fillable = ['details' , 'subject', 'topic' , 'language_id' , 'category_id' , 'user_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    protected $with = ['user' , 'category' , 'language'];
    

    // public static function scopeSearch($query, $q)
    // {
    //     return $query->where('topic', 'like', '%' .$q. '%')
    //                 ->orWhere('subject', 'like', '%' .$q. '%')
    //                 ->orWhere('details', 'like', '%' .$q. '%');
    // }

  
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

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class , 'language_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'body', 'image', 'type', 'user_id', 'from_user_id', 'readed'];

    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] ? 'at ' . date('d M, Y - h:i A', strtotime($this->attributes['created_at'])) : null;
    }
}
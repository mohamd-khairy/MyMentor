<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payment_method' , 'total_price' , 'user_recieve_id' , 'user_pay_id'];

    protected $hidden = ['created_at' , 'updated_at'];

    /** relations */
    
    public function user_recieve()
    {
        return $this->belongsTo(User::class , 'user_recieve_id');
    }

    public function user_pay()
    {
        return $this->belongsTo(User::class , 'user_pay_id');
    }
}

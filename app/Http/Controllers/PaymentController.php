<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Payment;

class PaymentController extends Controller
{
    const MODEL = Payment::class;
    const FILTERS = ['user_pay_id' , 'user_recieve_id'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
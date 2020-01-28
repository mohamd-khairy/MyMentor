<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Payment;

class PaymentController extends Controller
{
    const MODEL = Payment::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}
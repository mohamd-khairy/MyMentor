<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\WeekDays;

class WeekDayController extends Controller
{
    const MODEL = WeekDays::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index()
    {

        return $this->get();
    }

    public function show($id)
    {
        return $this->find($id);
    }

}

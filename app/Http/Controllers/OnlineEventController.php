<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\OnlineEvent;

class OnlineEventController extends Controller
{
    const MODEL = OnlineEvent::class;
    const FILTERS = [];

    use RestApi;
}

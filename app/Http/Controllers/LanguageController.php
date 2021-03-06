<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Language;

class LanguageController extends Controller
{
    const MODEL = Language::class;
    const FILTERS = ['chat_id'];

        const WITH = [];
use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

}

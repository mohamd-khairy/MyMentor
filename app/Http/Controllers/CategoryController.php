<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Category;

class CategoryController extends Controller
{
    const MODEL = Category::class;
    const FILTERS = [];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
}

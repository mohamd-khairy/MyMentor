<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Topics;

class TopicsController extends Controller
{
    const MODEL = Topics::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function search(Request $request)
    {
        $searchText = $request->q;

        $result = Topics::search($searchText)->paginate(20);
        // return Topics::whereLike(['topic', 'subject', 'category.name', 'language.name'], $searchText)->get();

        // $result = Topics::search($searchText)->get();
        return \responseSuccess($result);
    }
}
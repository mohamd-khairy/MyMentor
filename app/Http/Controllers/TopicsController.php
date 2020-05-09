<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Topics;
use App\Models\User;

class TopicsController extends Controller
{
    const MODEL = Topics::class;
    const FILTERS = ['user_id' ,'language_id' ,'category_id' ];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function search(Request $request)
    {
        $searchText = $request->q;


        $result = User::whereHas('skills', function ($query) use ($searchText) {
            $query->where('skill_name', 'like', $searchText);
        })->get();

        // $result = Topics::search($searchText)->paginate(20);
        // return Topics::whereLike(['topic', 'subject', 'category.name', 'language.name'], $searchText)->get();

        // $result = Topics::orderby('id' , 'desc')->scopeSearch($searchText)->get();
        return \responseSuccess($result);
    }
}
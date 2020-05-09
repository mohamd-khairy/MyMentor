<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Topics;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

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


        $result = User::select('user.*' , 'skills.skill_name')->leftJoin('skills', 'skills.user_id', '=', 'user.id')
        ->where('skills.skill_name', $searchText)
        ->get();

        // $result = Topics::search($searchText)->paginate(20);
        // return Topics::whereLike(['topic', 'subject', 'category.name', 'language.name'], $searchText)->get();

        // $result = Topics::orderby('id' , 'desc')->scopeSearch($searchText)->get();
        return \responseSuccess($result);
    }
}
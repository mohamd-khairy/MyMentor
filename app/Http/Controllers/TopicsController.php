<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Http\Requests\SearchRequest;
use App\Models\Topics;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class TopicsController extends Controller
{
    const MODEL = Topics::class;
    const FILTERS = ['user_id' ,'language_id' ,'category_id' ];

        const WITH = [];
use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function search(SearchRequest $request)
    {
        
        $searchText = $request->q;

        $result = User::setEagerLoads([])->with('mentor','profile','job' ,'skills')->select('users.*' , 'skill_details.user_id')
                    ->join('skill_details', 'skill_details.user_id', '=', 'users.id')
                    ->where('skill_details.skill_name', 'like', '%'.$searchText.'%')
                    ->groupBy('users.id','skill_details.user_id')
                    ->paginate(1);

        // $result = Topics::search($searchText)->paginate(20);

        return \responseSuccess($result);
    }
}
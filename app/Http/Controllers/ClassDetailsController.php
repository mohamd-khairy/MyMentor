<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\ClassDetails;

class ClassDetailsController extends Controller
{
    const MODEL = ClassDetails::class;
    const FILTERS = ['user_id'];
    const WITH = [];
    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $data = ClassDetails::create($request->all());

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data, "data added successfully");
    }
}

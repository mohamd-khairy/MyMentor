<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Profile;

class ProfileController extends Controller
{
    const MODEL = Profile::class;

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index()
    {

        return $this->get();
    }

    public function store(Request $request)
    {
        return $this->add($request);        
    }

    public function show($id)
    {
        return $this->find($id);
    }

    public function update(Request $request, $id)
    {
        return $this->put($request , $id);
    }
    
    public function destroy($id)
    {
        return $this->remove($id);
    }
}
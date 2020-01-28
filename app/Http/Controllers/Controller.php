<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $conditions = $this->filter($request);
        if(is_array($conditions))
            return $this->get($conditions);
        else
            return $this->filter($request);
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

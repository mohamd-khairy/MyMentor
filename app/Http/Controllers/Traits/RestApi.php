<?php
namespace App\Http\Controllers\Traits;
use Illuminate\Http\Request;

trait RestApi
{

    public function get()
    {
        $model = self::MODEL;
        $data = $model::get();

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data);
    }

    public function find($id)
    {
        $model = self::MODEL;
        $data = $model::find($id);

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data);
    }

    public function put($request, $id)
    {
        $model = self::MODEL;
        $data = $model::find($id);

        if (empty($data)) {
            return responseFail("data is empty");
        }
        $request = $request->all();
        $request['user_id'] = auth('api')->user()->id;

        $data->update($request);

        return responseSuccess($data);
    }

    public function add($request)
    {
        $model = self::MODEL;
        
        
        $data = $model::firstOrCreate($data);

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data);
    }

    public function remove($id)
    {
        $model = self::MODEL;
        $data = $model::find($id);

        if (empty($data)) {
            return responseFail("data is empty");
        }

        $data->delete();
        
        return responseSuccess($data);
    }

    public function getBy($condition)
    {
        $model = self::MODEL;
        $data = $model::where($condition)->get();

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data);
    }

    public function findBy($condition)
    {
        $model = self::MODEL;
        $data = $model::where($condition)->first();

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data);
    }

    public function putBy($request, $condition)
    {
        $model = self::MODEL;
        $data = $model::where($condition)->first();

        if (empty($data)) {
            return responseFail("data is empty");
        }

        $data->update($request->all());

        return responseSuccess($data);
    }

    
    public function getByConditions(Request $request)
    {
        $availableFilter = ['user_id' , 'id'];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $availableFilter)) {
                $conditions[$key] = $value;
            }
        }
        return $this->getBy($conditions);
    }
}
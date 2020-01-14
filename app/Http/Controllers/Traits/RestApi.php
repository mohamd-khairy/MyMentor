<?php
namespace App\Http\Controllers\Traits;
use Illuminate\Http\Request;

trait RestApi
{

    public function get()
    {
        $model = self::MODEL;
        $data = $model->get();

        if (empty($data)) {
            return responseFail();
        }
        return responseSuccess($data);
    }

    public function find($id)
    {
        $model = self::MODEL;
        $data = $model->find($id);

        if (empty($data)) {
            return responseFail();
        }
        return responseSuccess($data);
    }

    public function put($request, $id)
    {
        $model = self::MODEL;
        $data = $model->find($id);

        if (empty($data)) {
            return responseFail();
        }

        $data->update($request->all());

        return responseSuccess($data);
    }

    public function add($request)
    {
        $model = self::MODEL;
        $data = $model::create($request->all());

        if (empty($data)) {
            return responseFail();
        }
        return responseSuccess($data);
    }

    public function remove($id)
    {
        $model = self::MODEL;
        $data = $model->find($id);

        if (empty($data)) {
            return responseFail();
        }

        $data->delete();
        
        return responseSuccess($data);
    }

}
<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait RestApi
{

    public function get($conditions = null)
    {
        $model = self::MODEL;
        $with = self::WITH;
        $data = $model::where($conditions)->orderBy('id', 'desc');
        if ($with) {
            $data = $data->with($with);
        }
        $data = $data->get();

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data, "data returned successfully");
    }

    public function find($id)
    {
        $model = self::MODEL;
        $data = $model::find($id);

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data, "data returned successfully");
    }

    public function put($request, $id)
    {
        $model = self::MODEL;
        $row = $model::find($id);

        if (empty($row)) {
            return responseFail("data is empty");
        }
        $data = $request->all();

        if ($request->photo) {
            if ((string) $model == 'Profile') {
                $file = 'images/users/profile';
            } else {
                $file = 'images';
            }
            $imageName = time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->move(public_path($file), $imageName);
            $data['photo'] = $file . '/' . $imageName;
        }

        if ($request->banner) {
            if ((string) $model == 'Profile') {
                $file = 'images/users/profile';
            } else {
                $file = 'images';
            }
            $imageName = time() . '.' . $request->banner->getClientOriginalExtension();
            $request->banner->move(public_path($file), $imageName);
            $data['banner'] = $file . '/' . $imageName;
        }

        $row->update($data);

        return responseSuccess($row, "data updated successfully");
    }

    public function add($request)
    {
        $model = self::MODEL;
        $data = $request->all();

        if ($request->photo) {
            if ((string) $model == 'Profile') {
                $file = 'images/users/profile';
            } else {
                $file = 'images';
            }
            $imageName = time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->move(public_path($file), $imageName);
            $data['photo'] = $file . '/' . $imageName;
        }
        if ($request->banner) {
            if ((string) $model == 'Profile') {
                $file = 'images/users/profile';
            } else {
                $file = 'images';
            }
            $imageName = time() . '.' . $request->banner->getClientOriginalExtension();
            $request->banner->move(public_path($file), $imageName);
            $data['banner'] = $file . '/' . $imageName;
        }

        $data = $model::create($data); //firstOrCreate

        return responseSuccess($data, "data added successfully");
    }

    public function remove($id)
    {
        $model = self::MODEL;
        $data = $model::find($id);

        if (empty($data)) {
            return responseFail("data is empty");
        }

        $data->delete();

        return responseSuccess($data, "data removed successfully");
    }

    public function getBy($condition)
    {
        $model = self::MODEL;
        $data = $model::where($condition)->get();

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data, "data returned successfully");
    }

    public function findBy($condition)
    {
        $model = self::MODEL;
        $data = $model::where($condition)->first();

        if (empty($data)) {
            return responseFail("data is empty");
        }
        return responseSuccess($data, "data returned successfully");
    }

    public function putBy($request, $condition)
    {
        $model = self::MODEL;
        $data = $model::where($condition)->first();

        if (empty($data)) {
            return responseFail("data is empty");
        }

        $all_data = $request->all();

        if ($request->photo) {
            if ((string) $model == 'Profile') {
                $file = 'images/users/profile';
            } else {
                $file = 'images';
            }
            // Storage::delete($data->photo);
            // $all_data['photo'] = $request->photo->store('/users/profile');
            $imageName = time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->move(public_path($file), $imageName);
            $all_data['photo'] = $file . '/' . $imageName;
        }

        if ($request->banner) {
            if ((string) $model == 'Profile') {
                $file = 'images/users/profile';
            } else {
                $file = 'images';
            }
            // Storage::delete($data->banner);
            // $all_data['banner'] = $request->banner->store('/users/profile');
            $imageName = time() . '.' . $request->banner->getClientOriginalExtension();
            $request->banner->move(public_path($file), $imageName);
            $all_data['banner'] = $file . '/' . $imageName;
        }

        $data->update($all_data);

        return responseSuccess($data, "data updated successfully");
    }

    public function filter($request)
    {
        $availableFilter = (array) self::FILTERS;

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $availableFilter)) {
                $conditions[$key] = $value;
            } else {
                return responseFail("this filter not allowed");
            }
        }
        return $conditions ?? [];
    }
}

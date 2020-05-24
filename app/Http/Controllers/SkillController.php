<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\SkillDetails;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    const MODEL = SkillDetails::class;
    const FILTERS = ['user_id','skill_name'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function update_skill(Request $request, $id)
    {
        $row = SkillDetails::find($id);

        if (empty($row)) {
            return responseFail("data is empty");
        }
        $data = $request->all();

        if($request->photo){
            $file = 'images'; 
            $imageName = time().'.'. $request->photo->getClientOriginalExtension();
            $request->photo->move(public_path($file), $imageName);
            $data['photo'] = $file.'/'.$imageName;
        }

        $row->update($data);

        return responseSuccess($row , "data updated successfully");
    }
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         "skill_name" => "required|string"
    //     ]);
         
    //     if ($validator->fails()) {    
    //         return response()->json($validator->messages(), 400);
    //     }

        // $skills = explode(',' , $request->skill_name);

        // $data = Collect($skills)->map(function($item) use($request){
        //     return SkillDetails::updateOrCreate([
        //         'user_id' => auth('api')->user()->id ,
        //         'skill_name' => $item,
        //         'experience_years' => $request->experience_years,
        //         'details' => $request->details
        //     ]);
        // });
        // return $data = $this->add($request);

    // }
    
}
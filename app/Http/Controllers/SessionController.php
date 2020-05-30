<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\SessionDays;
use App\Models\Sessions;
use App\Models\WeekDays;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller
{
    const MODEL = Sessions::class;
    const FILTERS = ['user_give_id' ,'user_recieve_id','topic_id','day_id' , 'status' , 'session_type' , 'codeReview_status'];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index(Request $request)
    {
        $conditions = $this->filter($request);
        if(is_array($conditions)){
            $data = Sessions::where($conditions)->where('session_type' , '!=' , 'code review')->orderBy('id' ,'desc')->get();

            return responseSuccess($data , "data returned successfully");
        }else
            return $this->filter($request);
    }

    public function get_codeReview_session(Request $request)
    {
        $conditions = $this->filter($request);
        if(is_array($conditions)){
            $data = Sessions::where($conditions)->where('session_type' , 'code review')->orderBy('id' ,'desc')->get();

            return responseSuccess($data , "data returned successfully");
        }else
            return $this->filter($request);
    }


    public function store(Request $request)
    {
        /** check type of give user type */
        $user = getUser(['id' => $request->user_give_id]);
        if($user && $user->user_type->user_type_name != 'mentor'){
            return responseFail('user give id must be mentor type');
        }

        /** check type of recieve user type */
        $user = getUser(['id' => $request->user_recieve_id]);
        if($user && $user->user_type->user_type_name != 'user'){
            return responseFail('user receive id must be user type');
        }

        $data = $request->all();

        if($request->session_type == 'code review'){
            $data['codeReview_status'] = 'pending';
        }

        $data = Sessions::create($data);//firstOrCreate

        foreach($request->dateTime as $day => $item){

            SessionDays::create([
                'session_id' => $data->id,
                'week_days_id' => WeekDays::days[$day] ,
                'date_time' => $item ,
            ]);

        }

        return responseSuccess($data , "data added successfully");
    }

    public function acceptOrReject(Request $request , $session_id)
    {

        //must be mentor
        
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);
        
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $session = Sessions::find($session_id);

        if($session){

            if($session->session_type == 'code review'){
                if($request->status == 'accept'){
                    $codeReview_status = 'inProgress';
                }else if($request->status == 'reject'){
                    $codeReview_status = 'canceled'; 
                }else{
                    $codeReview_status = 'null'; 
                }
                
                $session->update(['status' => $request->status , 'codeReview_status' => $codeReview_status]);

            }else{
                $session->update(['status' => $request->status]);

            }

            return responseSuccess($session , 'session changed successfully');

        }
            return responseFail('this session not found');

    }

    public function schedule_sessions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:upcoming,past'
        ]);
        
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }


        $id = auth('api')->user()->id;
        $type = auth('api')->user()->user_type->user_type_name;
        $colum = $type == 'mentor'? 'user_give_id' : 'user_recieve_id';
        $sign = $request->status == 'upcoming' ? '>=' : '<';

        $data = SessionDays::with('session')->whereHas('session' , function($q) use ($id , $colum , $sign){
            $q->where($colum , $id)->where('session_type' , '!=' , 'code review');
        })->whereDate('date_time' , $sign , Carbon::now())->get();

        return responseSuccess($data , 'data returned successfully');
    }


    // public function schedule_codereview_sessions(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'status' => 'required|in:upcoming,past'
    //     ]);
        
    //     if ($validator->fails()) {    
    //         return response()->json($validator->messages(), 400);
    //     }


    //     $id = auth('api')->user()->id;
    //     $type = auth('api')->user()->user_type->user_type_name;
    //     $colum = $type == 'mentor'? 'user_give_id' : 'user_recieve_id';
    //     $sign = $request->status == 'upcoming' ? '>=' : '<';

    //     $data = SessionDays::with('session')->whereHas('session' , function($q) use ($id , $colum , $sign){
    //         $q->where($colum , $id)->where('session_type' , '!=' , 'code review');
    //     })->whereDate('date_time' , $sign , Carbon::now())->get();

    //     return responseSuccess($data , 'data returned successfully');
    // }
}
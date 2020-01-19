<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Profile;
use App\Mail\EmailVerify;
use App\Mail\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $userObj;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','verify' ,'forgetPassword' ,'resetPassword']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return responseUnAuthorize();
        }

        /** update user data to be active */
        auth('api')->user()->update(['is_active' => 1]);

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        /** convert request data to array */
        $data = $request->all();
        /** assign fisrt and last name to name field */
        $data['name'] = $request->first_name . " " . $request->last_name;
        $data['remember_token'] = Str::random(20);
        /** start transaction */
        DB::beginTransaction();
        /** create user */
        $user = User::create($data);

        if ($user) {
            $data['user_id'] = $user->id;
            /** create profile for this user */
            $profile = Profile::create($data);
        }

        if ($profile) {
            /** send verify email to new user */
            Mail::to($user->email)->send(new EmailVerify($user));

             /** commit database action */
             DB::commit();

            /** return json response with user data */
            return responseSuccess($user , 'Your Account Created successfully , and verified email has been sent.');
        }
        /** rollback the database action */
        DB::rollback();
        /** return json response with unauthorize message */
        return responseUnAuthorize();
    }

     /**
     * Verify Email.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:100',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $remember_token = $request->token;
        $user = User::where('remember_token' , $remember_token)->first();
        if($user){
            if($user->verified){
                return responseFail("Your e-mail is already verified. You can now login.");
            }else{
                $user->remember_token = null;
                $user->verified = true;
                $user->save();
                return responseSuccess('email verified successfully');
            }
        }

        return responseFail('Sorry, this link is expired.');
    }
    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return responseSuccess(auth('api')->user());

    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        /** update user data to be un active */
        auth('api')->user()->update(['is_active' => 0]);

        auth('api')->logout();

        return responseSuccess([] , 'Successfully logged out' );

    }

    /**
     * forget Password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $email = strtolower($request->email);
        $user = User::where("email", $email)->first();
        if (!empty($user)) {
            if (!empty($user->resetPasswordCode)) {
                switch (substr($user->resetPasswordCode, -3, 1)) {
                    case '1':
                        $code = Str::random(15) . "2" . rand(10, 20);
                        break;
                    case '2':
                        $code = Str::random(15) . "3" . rand(10, 20);
                        break;
                    case '3':
                        $now  = Carbon::now();
                        $end  = $user->resetPasswordCodeCreationdate;
                        $hour = $now->diffInHours($end);
                        if ($hour >= 6) {
                            $user->resetPasswordCode = null;
                            $user->resetPasswordCodeCreationdate = null;
                            $user->save();
                            $code = Str::random(15) . "1" . rand(10, 20);
                        } else {
                            return \responseFail("Sorry , try again after 6 hours !");
                        }
                        break;
                    default:
                        return \responseFail("some thing wrong !");
                        break;
                }
            } else {
                $code = Str::random(15)  . "1" . rand(10, 20);
            }
            $user->resetPasswordCode = $code;
            $user->resetPasswordCodeCreationdate = Carbon::now();
            if ($user->save()) {
                Mail::to($user->email)->send(new ResetPassword($user));
                return \responseSuccess('check your email to reset your password .');
            }
        } else {
            return \responseFail("Not Found User With this Email !");
        }
    }


    /**
     * reset Password.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'   => 'required|min:8|max:100',
            'newPassword'   => 'required|min:8|max:100'
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
       
        $user = User::where("resetPasswordCode", $request->code)->first();
        if (empty($user)) {
            return responseFail('not fount this user');
        }
        $now = Carbon::now();
        $days = $now->diffInDays($user->resetPasswordCodeCreationdate);
        if ($days < 1) { //
            $user->password = $request->newPassword;
            $user->resetPasswordCode = null;
            $user->resetPasswordCodeCreationdate = null;
            $user->save();
            return responseSuccess('password reset successfully');
        } else {
            $user->resetPasswordCode = null;
            $user->resetPasswordCodeCreationdate = null;
            $user->save();
            return responseFail('this code is expired , try again');
        }
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ],200);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}

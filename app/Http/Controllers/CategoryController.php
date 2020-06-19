<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Category;
use App\Models\SessionDays;
use Exception;
use GuzzleHttp\Client;
use \Firebase\JWT\JWT;

class CategoryController extends Controller
{
    const MODEL = Category::class;
    const FILTERS = [];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create_meeting(Request $request)
    {

        $id = $request->id;

        $client = new Client(['base_uri' => 'https://api.zoom.us']);

        try {
            $response = $client->request('POST', '/v2/users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer " . $this->generateJWTKey(),
                    'content-type'  => 'application/json'
                ],
                'json' => [
                    "topic" => "Let's learn",
                    "start_time" => "2020-06-19T20:30:00",
                    "duration" => "30",
                    "password" => "123456"
                ],
            ]);

            $data = json_decode($response->getBody());

            $session = SessionDays::find($id);
            $session->update(['join_url' => $data->join_url]);
            return responseSuccess([
                'meeting_id' => $data->id,
                'topic' => $data->topic,
                'join_url' => $data->join_url,
                'meeting_password' => $data->password,
                'start_time' => $data->start_time,
                'duration' => $data->duration
            ], 'meeting created successfully');
        } catch (Exception $e) {
            return responseFail('some thing wrong when create the meeting!');
        }
    }

    private function generateJWTKey()
    {
        $key = "Y4--nsCwQi-1w1wFqeNd-w";
        $secret = "naaLrscMCfcFQZILEmGvkGCFZHAmkwGMlCdu";
        $token = array(
            "iss" => $key,
            "exp" => time() + 3600 //60 seconds as suggested
        );
        return JWT::encode($token, $secret);
    }
}
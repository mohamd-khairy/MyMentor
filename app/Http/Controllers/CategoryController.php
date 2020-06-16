<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestApi;
use App\Models\Category;
use Exception;
use GuzzleHttp\Client;

class CategoryController extends Controller
{
    const MODEL = Category::class;
    const FILTERS = [];

    use RestApi;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create_meeting()
    {
        $client = new Client(['base_uri' => 'https://api.zoom.us']);

        try {
            $response = $client->request('POST', '/v2/users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ilk0LS1uc0N3UWktMXcxd0ZxZU5kLXciLCJleHAiOjE1OTIzNDQyMjAsImlhdCI6MTU5MjMzODgyMH0.nxELdNFdGi9l-F3rXpjlwPntgRo4rAfIyWWRDKFf8jk"
                ],
                'json' => [
                    "topic" => "Let's learn",
                    "start_time" => "2020-06-25T20:30:00",
                    "duration" => "30 min", // 30 mins
                    "password" => "123456"
                ],
            ]);

            $data = json_decode($response->getBody());
            // dd($data);
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
}
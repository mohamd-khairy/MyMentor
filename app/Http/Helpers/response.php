<?php



function responseSuccess($data = [] , $msg = null)
{
    return response()->json( [
        "status" => "success",
        "message" => $msg,
        "data" => $data
    ] , 200);
}

function responseFail($msg = null)
{
    return response()->json( [
        "status" => "fail",
        "message" => $msg,
        "data" => []
    ] , 400);
}

function responseUnAuthorize($msg = null)
{
    return response()->json([
        "status" => "fail",
        "message" => "UnAuthorize , " . $msg,
        "data" => []
    ] , 401);
}

function responseUnAuthenticated($msg = null)
{
    return response()->json([
        "status" => "fail",
        "message" => "UnAuthenticated , " . $msg,
        "data" => []
    ] , 403);
}
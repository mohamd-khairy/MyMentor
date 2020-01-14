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

function responseUnAuthorize()
{
    return response()->json([
        "status" => "fail",
        "message" => "UnAuthorize",
        "data" => []
    ] , 401);
}
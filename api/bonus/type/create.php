<?php

include_once '../../../database/DBConnection.php';
include_once '../../../models/Type.php';
$config = include_once '../../../config.php';

//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$db = DBConnection::make($config);
$bonus_type = new Type($db);
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->type) &&
    !empty($data->saved_minutes) 
){
    $bonus_type->type = $data->type;
    $bonus_type->saved_minutes = $data->saved_minutes;

    if($bonus_type->create()){
        http_response_code(201);
        $response = ["status_code" => 201, "message"=>"Bonus type created successfully!" ];
        echo json_encode($response);
    }
    else{
        //503 servizio non disponibile
        http_response_code(503);
        $response = ["status_code" => 503, "message"=>"Unable to create bonus type" ];
        echo json_encode($response);
    }
}
else{
    //400 bad request
    http_response_code(400);
    $response = ["status_code" => 400, "message"=>"Bad Request: incomplete data" ];
    echo json_encode($response);
}

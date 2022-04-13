<?php

include_once '../../database/DBConnection.php';
include_once '../../models/Bonus.php';
$config = include_once '../../config.php';

//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$db = DBConnection::make($config);
$bonus = new Bonus($db);
$data = json_decode(file_get_contents("php://input"));



if(!empty($data->id) && !empty($data->type_id) && !empty($data->quantity) && !empty($data->sold_at)){

    $bonus->id = $data->id;
    $bonus->name = $data->name;
    $bonus->type_id = $data->type_id;
    $bonus->quantity = $data->quantity;
    $bonus->sold_at = $data->sold_at;
   
    if($bonus->update()){
        http_response_code(200);
        $response = ["status_code" => 200, "message"=>"Bonus updated successfully!" ];
        echo json_encode($response);
    }else{
          //503 servizio non disponibile
          http_response_code(503);
          $response = ["status_code" => 503, "message"=>"Unable to update bonus" ];
          echo json_encode($response);
    }

}else{
    http_response_code(400);
    $response = ["status_code" => 400, "message"=>"Bad Request: incomplete data" ];
    echo json_encode($response);
}



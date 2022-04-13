<?php

include_once '../../database/DBConnection.php';
include_once '../../models/Bonus.php';
$config = include_once '../../config.php';

//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$db = DBConnection::make($config);
$bonus = new Bonus($db);
$data = json_decode(file_get_contents("php://input"));


if(!empty($data->id)){
    $bonus->id = $data->id;
    if($bonus->delete()){
        http_response_code(200);
        $response = ["status_code" => 200, "message"=>"Bonus deleted successfully!" ];
        echo json_encode($response);
    }else{
          //503 servizio non disponibile
          http_response_code(503);
          $response = ["status_code" => 503, "message"=>"Unable to delete bonus" ];
          echo json_encode($response);
    }

}else{
     http_response_code(400);
     $response = ["status_code" => 400, "message"=>"Bad Request: missing 'id' parameter" ];
     echo json_encode($response);

};



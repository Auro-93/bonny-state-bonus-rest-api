
<?php
include_once '../../../../../database/DBConnection.php';
include_once '../../../../../models/Type.php';
$config = include_once '../../../../../config.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");



$db = DBConnection::make($config);
$bonus_type = new Type($db);


$stmt = $bonus_type->read_max_saved_min();
$num = $stmt->rowCount();

if($num>0){
    http_response_code(200);
    // array di libri
    $bonus_type_arr = array();
    $bonus_type_arr["status_code"] = 200;
    $bonus_type_arr["result"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $bonus_type_item = array(
            "id" => $id,
            "type" => $type,
            "saved minutes" => $saved_minutes
        );
        array_push($bonus_type_arr["result"], $bonus_type_item);
    }
    echo json_encode($bonus_type_arr);
}else{
   
        http_response_code(200);
        $response = [
            "records" => null,
            "count" => 0
        ];
        print json_encode($response);
}



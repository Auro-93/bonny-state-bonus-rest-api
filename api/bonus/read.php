
<?php
include_once '../../database/DBConnection.php';
include_once '../../models/Bonus.php';
$config = include_once '../../config.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");



$db = DBConnection::make($config);
$bonus = new Bonus($db);


$category = isset($_GET['category']) ?  $_GET['category'] : "";
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : "";
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : "";

$params = ["category" => $category, "from_date" => $from_date, "to_date"=> $to_date ];

$stmt = $bonus->read($params);
$num = $stmt->rowCount();

if($num>0){
    http_response_code(200);
    // array di libri
    $bonus_arr = array();
    $bonus_arr["status_code"] = 200;
    $bonus_arr["records"] = array();
    $bonus_arr["count"] = $num;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $bonus_item = array(
            "id" => $id,
            "name" => $name,
            "type" => $type,
            "quantity" => $quantity,
            "sold_at" => $sold_at
        );
        array_push($bonus_arr["records"], $bonus_item);
    }
    echo json_encode($bonus_arr);
}else{
   
        http_response_code(200);
        $response = [
            "records" => null,
            "count" => 0
        ];
        print json_encode($response);
}





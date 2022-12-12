<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../Config/database.php';
include_once '../Objects/Stock.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$Stock = new Stock($db);

$Stock->stockserviceId = $data->stockserviceId;
$Stock->stockcustomerId = $data->stockcustomerId;
$Stock->stockvendorId = $data->stockvendorId;
$Stock->duration = $data->duration;
$Stock->starttime = $data->starttime;
$Stock->endtime = $data->endtime;
$Stock->amount = $data->amount;
$Stock->status = $data->status;
$Stock->stockIsActive = $data->stockIsActive;
$Stock->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$Stock->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));


$result = $Stock->InsertStocking();

if($result){
 echo json_encode($Stock); //converting the output data into JSON
}else{
  echo json_encode($Stock); //converting the output data into JSON
}

?>
		
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
include_once '../Objects/Logistics.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetLogisticsConnection();

$Logistics1 = new Logistics($db);

//$customerProduct->customerProductId = $data->customerProductId;
$Logistics1->id = $data->id;
$Logistics1->sessionId = $data->sessionId;
// $customerProduct->phoneNumber = $data->phoneNumber;
// $customerProduct->name = $data->name;
// $customerProduct->capacity = $data->capacity;
// $customerProduct->imageUrl = $data->imageUrl;
// $customerProduct->notes = $data->notes;
// $customerProduct->productName = $data->productName;
// $customerProduct->model = $data->model;
// $customerProduct->brand = $data->brand;
// $customerProduct->manDate = $data->manDate;
// $customerProduct->status = $data->status;
$Logistics1->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));


$result = $Logistics1->UpdatesessionIdBylogisticsid();

if($result){
  echo json_encode($Logistics1); //converting the output data into JSON
}else{
  echo json_encode($Logistics1); //converting the output data into JSON
}

?>
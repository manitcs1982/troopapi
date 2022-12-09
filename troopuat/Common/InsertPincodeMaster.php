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
include_once '../Config/config.php';
include_once '../Objects/PincodeMaster.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetPincodeMasterConnection();
$Pincode = new Pincode($db);
			
$Pincode->pincodeName = $data->pincodeName;
$Pincode->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$Pincode->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$Pincode->location = $data->location;
$Pincode->latitude = $data->latitude;
$Pincode->longitude = $data->longitude;
$Pincode->status = $data->status;

$result = $Pincode->InsertPincodeMaster();

if($result){
  echo json_encode($Pincode); //converting the output data into JSON
}else{
  echo json_encode($Pincode); //converting the output data into JSON
}

?>
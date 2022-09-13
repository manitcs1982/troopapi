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

$logistics = new Logistics($db);

$logistics->id = $data->id;
$logistics->phoneNumber = $data->phoneNumber;
$logistics->name = $data->name;
$logistics->email = $data->email;
$logistics->latitude = $data->latitude;
$logistics->longitude = $data->longitude;
$logistics->vehicleType = $data->vehicleType;
$logistics->status = $data->status;
$logistics->accountNumber = $data->accountNumber;
$logistics->ifscCode = $data->ifscCode;
$logistics->bankName = $data->bankName;
$logistics->branch = $data->branch;
$logistics->upiId = $data->upiId;
$logistics->panNumber = $data->panNumber;
$logistics->aadharNumber = $data->aadharNumber;
$logistics->vehicleNumber = $data->vehicleNumber;
$logistics->licenseNumber = $data->licenseNumber;
$logistics->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $logistics->UpdateLogistics();

if($result){
  echo json_encode($logistics); //converting the output data into JSON
}else{
  echo json_encode($logistics); //converting the output data into JSON
}

?>

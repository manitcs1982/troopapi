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
include_once '../Objects/VendorAvailability.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetVendorConnection();
$vendorAvailability = new VendorAvailability($db);

$vendorAvailability->vendorId    = $data->vendorId;
$vendorAvailability->vendorAvailabilityDay01 = $data->vendorAvailabilityDay01;
$vendorAvailability->vendorAvailabilityDay02 = $data->vendorAvailabilityDay02;
$vendorAvailability->vendorAvailabilityDay03 = $data->vendorAvailabilityDay03;
$vendorAvailability->vendorAvailabilityDay04 = $data->vendorAvailabilityDay04;
$vendorAvailability->vendorAvailabilityDay05 = $data->vendorAvailabilityDay05;
$vendorAvailability->vendorAvailabilityDay06 = $data->vendorAvailabilityDay06;
$vendorAvailability->vendorAvailabilityDay07 = $data->vendorAvailabilityDay07;
$vendorAvailability->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$vendorAvailability->startDate = $data->startDate;
$vendorAvailability->endDate = $data->endDate;
$result = $vendorAvailability->InsertVendorAvailability();

if($result){
 echo json_encode($vendorAvailability); //converting the output data into JSON
}else{
  echo json_encode($vendorAvailability); //converting the output data into JSON
}

?>
		
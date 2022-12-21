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
include_once '../Objects/Service.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$service = new Service($db);

$service->serviceId = $data->serviceId;
$service->vendorId = $data->vendorId;
$service->logisticsId = $data->logisticsId;
$service->logisticsName =$data->logisticsName;
$service->logisticsPhoneNumber =$data->logisticsPhoneNumber;
$service->vendorBusinessOwnerName = $data->vendorBusinessOwnerName;	
$service->vendorBusinessName = $data->vendorBusinessName;	
$service->vendorPhoneNumber = $data->vendorPhoneNumber;

/*
$service->customerId = $data->customerId;
$service->customerProductId = $data->customerProductId;
$service->productId = $data->productId;
$service->customerAddressId = $data->customerAddressId;
$service->serviceCharge = $data->serviceCharge;
$service->otp = $data->otp;
$service->randomNumber = $data->randomNumber;
$service->status = $data->status;
$service->customerTotal = $data->customerTotal;
$service->vendorTotal = $data->vendorTotal;
$service->pickUpDate = $data->pickUpDate;
$service->pickUpSlot = $data->pickUpSlot;
$service->dropDate = $data->dropDate;
$service->dropSlot = $data->dropSlot;
$service->notes = $data->notes;
*/
$service->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $service->UpdateServiceDetails();


if($result){	
  echo json_encode($service); //converting the output data into JSON
}else{
  echo json_encode($service); //converting the output data into JSON
}


?>
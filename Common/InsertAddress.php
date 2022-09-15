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
include_once '../Objects/Address.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetAddressConnection();
$address = new Address($db);

if (isset($data->potentialVendorId)) {	
	$address->potentialVendorId = $data->potentialVendorId;	
}else{	
	$address->potentialVendorId = 0;	
}
if (isset($data->vendorId)) {	
	$address->vendorId = $data->vendorId;	
}else{	
	$address->vendorId = 0;	
}
if (isset($data->addressId)) {
	$address->id = $data->addressId;
} else {
	$address->id = "";
}
$address->customerId = $data->customerId;
$address->addressLabel = $data->addressLabel;
$address->addressLine1 = $data->addressLine1;
$address->phoneNumber = $data->phoneNumber;
$address->addressLine2 = $data->addressLine2;
$address->city = $data->city;
$address->state = $data->state;
$address->zipcode = $data->zipcode;
$address->status = $data->status;
$address->latitude = $data->latitude;
$address->longitude = $data->longitude;
$address->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));


$result = $address->InsertAddress();

if($result){
  echo json_encode($address); //converting the output data into JSON
}else{
  echo json_encode($address); //converting the output data into JSON
}

?>

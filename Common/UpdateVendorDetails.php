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
include_once '../Objects/Vendor.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetVendorConnection();

$vendor = new Vendor($db);

$vendor->vendorId = $data->vendorId;
$vendor->geoLocationLat = $data->geoLocationLat;
$vendor->geoLocationLong = $data->geoLocationLong;
$vendor->businessName = $data->businessName;
$vendor->phone = $data->phone;
$vendor->businessOwnerName = $data->businessOwnerName;
$vendor->alternatePhoneNo1 = $data->alternatePhoneNo1;
$vendor->alternatePhoneNo2 = $data->alternatePhoneNo2;
$vendor->alternatePhoneNo3 = $data->alternatePhoneNo3;
$vendor->itemMasterId = $data->itemMasterId;
$vendor->interested = $data->interested;
$vendor->currentVolume = $data->currentVolume;
$vendor->notes = $data->notes;
$vendor->status = $data->status;
$vendor->bankAccountNumber = $data->bankAccountNumber;
$vendor->ifscCode = $data->ifscCode;
$vendor->upiId = $data->upiId;
$vendor->panNumber = $data->panNumber;
$vendor->bankBranch = $data->bankBranch;
$vendor->bankName = $data->bankName;
$vendor->aadharNumber = $data->aadharNumber;
$vendor->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $vendor->UpdateVendorDetails();

if($result){
  echo json_encode($vendor); //converting the output data into JSON
}else{
  echo json_encode($vendor); //converting the output data into JSON
}

?>


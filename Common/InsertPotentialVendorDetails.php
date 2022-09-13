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
include_once '../Objects/PotentialVendor.php';

$database = new Database(); //Declaring object for database class

$db = $database->GetVendorConnection();
$potentialVendor = new PotentialVendor($db);

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$potentialVendor->geoLocationLat = $data->geoLocationLat;
$potentialVendor->geoLocationLong = $data->geoLocationLong;
$potentialVendor->businessName = $data->businessName;
$potentialVendor->phone = $data->phone;
$potentialVendor->businessOwnerName = $data->businessOwnerName;
$potentialVendor->alternatePhoneNo1 = $data->alternatePhoneNo1;
$potentialVendor->alternatePhoneNo2 = $data->alternatePhoneNo2;
$potentialVendor->alternatePhoneNo3 = $data->alternatePhoneNo3;
$potentialVendor->itemMasterId = $data->itemMasterId;
$potentialVendor->interested = $data->interested;
$potentialVendor->currentVolume = $data->currentVolume;
$potentialVendor->notes = $data->notes;
$potentialVendor->status = $data->status;
$potentialVendor->productList = $data->productList;

$potentialVendor->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $potentialVendor->InsertPotentialVendorDetails();

if($result){
  echo json_encode($potentialVendor); //converting the output data into JSON
}else{
  echo json_encode($potentialVendor); //converting the output data into JSON
}

?>

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

$vendorproduct = new Vendor($db);

//$customerProduct->customerProductId = $data->customerProductId;
$vendorproduct->vendorId = $data->vendorId;
$vendorproduct->sessionId = $data->sessionId;
$vendorproduct->tokenId = $data->tokenId;
$vendorproduct->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $vendorproduct->UpdateSessionTokenIdByVendorId();

if($result){
  echo json_encode($vendorproduct); //converting the output data into JSON
}else{
  echo json_encode($vendorproduct); //converting the output data into JSON
}

?>
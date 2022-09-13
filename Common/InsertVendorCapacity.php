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
include_once '../Objects/VendorCapacity.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetVendorConnection();
$vendorCapacity = new VendorCapacity($db);

$vendorCapacity->productId    = $data->productId;
$vendorCapacity->capacity = $data->capacity;
$vendorCapacity->model = $data->model;
$vendorCapacity->brand = $data->brand;
$vendorCapacity->vendorId = $data->vendorId;
$vendorCapacity->status = $data->status;
$vendorCapacity->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$vendorCapacity->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $vendorCapacity->InsertVendorCapacity();

if($result){
 echo json_encode($vendorCapacity); //converting the output data into JSON
}else{
  echo json_encode($vendorCapacity); //converting the output data into JSON
}

?>
		
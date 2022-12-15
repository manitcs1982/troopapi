<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/config.php';
include_once '../Config/database.php';
include_once '../Objects/non_serviceable_details.php';
$database = new Database(); //Declaring object for database class
$data = json_decode(file_get_contents("php://input")); //Recieving input data
$db = $database->GetServiceConnection();
$nonService = new nonServiceable($db);

$nonService->customerId = $data->customerId;
$nonService->productId = $data->productId;
$nonService->notes = $data->notes;
$nonService->isActive = $data->isActive;
$nonService->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$nonService->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$result = $nonService->InsertNonServiceableDetails();
if($result){
    echo json_encode($nonService);
}else{
  echo json_encode($nonService); //converting the output data into JSON
}
?>
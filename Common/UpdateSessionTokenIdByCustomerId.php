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
include_once '../Objects/Customer.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetCustomerConnection();

$customerProduct = new Customer($db);

//$customerProduct->customerProductId = $data->customerProductId;
$customerProduct->id = $data->id;
$customerProduct->sessionId = $data->sessionId;
$customerProduct->tokenId = $data->tokenId;
$customerProduct->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));


$result = $customerProduct->UpdatesessionTokenIdByCustomerId();

if($result){
  echo json_encode($customerProduct); //converting the output data into JSON
}else{
  echo json_encode($customerProduct); //converting the output data into JSON
}

?>
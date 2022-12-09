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
include_once '../Objects/Customer.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetCustomerConnection();
$customer = new Customer($db);

$customer->name = $data->name;
$customer->phoneNumber = $data->phoneNumber;
$customer->email = $data->email;
$customer->tokenId = $data->tokenId;
$customer->status =1;// $data->status;
$customer->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$customer->LanguageId = $data->LanguageId;
$customer->APKVersion = $data->APKVersion;
$customer->DeviceVersion = $data->DeviceVersion;
$customer->DeviceType = $data->DeviceType;
$customer->IMEI = $data->IMEI;
$result = $customer->InsertCustomerDetails();

if($result){
		$url = $apiRootPath.'InsertAddress.php';
		$data = array("customerId" => $customer->id, "addressLabel" => $data->addressLabel, "addressLine1" => $data->addressLine1, "phoneNumber" => $data->phoneNumber, "addressLine2" => $data->addressLine2, "city" => $data->city, "state" => $data->state, "zipcode" => $data->zipcode,"latitude"=>$data->latitude ,"longitude"=>$data->longitude, "status" => $customer->status,"vendorId" => 0);		
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => json_encode($data), 
		    ),
		);			
		$context  = stream_context_create($options);
		$result2 = file_get_contents($url, false, $context);		
		$customer->Address = json_decode($result2);	
		echo json_encode($customer);
		
}else{
  echo json_encode($customer); //converting the output data into JSON
}

?>

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

$result = $service->GetServiceByServiceId();


if($result){
	$num = $result->rowCount();

	  // check if more than 0 record found
	  if($num>0){  	  	  	  
	      while ($row = $result->fetch(PDO::FETCH_ASSOC))
	      {	      	  
	          extract($row);          
	          $service->otp = $SVC_otp;			 
	      }	      
	  }
	  
  	if($service->otp === $data->otp){
		$service->isOtpMatch = true;
	}else{
		$service->isOtpMatch = false;
	}
  echo json_encode($service); //converting the output data into JSON
}else{
  echo json_encode($service); //converting the output data into JSON
}


?>

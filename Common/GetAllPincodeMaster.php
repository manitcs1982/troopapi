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
include_once '../Objects/PincodeMaster.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetPincodeMasterConnection();


$Pincode = new Pincode($db);

$result = $Pincode->GetAllPincodeMaster();

$PincodeArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
	  
	//Fetching the result data from result object
	  
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  $Pincode = new Pincode($db);
         
		  extract($row);  
		  
		  
$Pincode->pincodeId = $PIN_GPK;
$Pincode->pincodeName = $PIN_pincode;
$Pincode->createdOn = $PIN_createdOn; 
$Pincode->modifiedOn =$PIN_modifiedOn;
$Pincode->location = $PIN_location;
$Pincode->latitude = $PIN_latitude;
$Pincode->longitude = $PIN_longitude;
$Pincode->status = $PIN_status;
		  
	  array_push($PincodeArray,$Pincode);
	  }			
			
      echo json_encode($PincodeArray); //converting the output data into JSON
}else{
	$Pincode->error = "No records found";
	array_push($PincodeArray,$Pincode);
	echo json_encode($PincodeArray); //converting the output data into JSON
  }
}else{
	array_push($PincodeArray,$Pincode);
  echo json_encode($PincodeArray); //converting the output data into JSON
  
}

?>
	
  
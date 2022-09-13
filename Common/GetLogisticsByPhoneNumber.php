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
include_once '../Objects/Logistics.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetLogisticsConnection();


$logistics = new Logistics($db);

$logistics->phoneNumber = $_GET['phoneNumber'];

if (isset($_GET['tokenId'])) {
	$logistics->tokenId = $_GET['tokenId'];
	$logistics->APKVersion = $_GET['APKVersion'];
	$logistics->DeviceVersion = $_GET['DeviceVersion'];
	$logistics->DeviceType = $_GET['DeviceType'];
	$logistics->IMEI = $_GET['IMEI'];
	$logistics->UpdateTokenIdByPhoneNumber();
	$logistics->sessionId = 1;
	$logistics->UpdateSessionIdByPhoneNumber();
}

$result = $logistics->GetLogisticsByPhoneNumber();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();
//echo $result;
  // check if more than 0 record found
  if($num>0){
    
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  
          extract($row); 
         
		  $logistics->id = $LGT_GPK;
          $logistics->phoneNumber = $LGT_phoneNumber;
		  $logistics->name = $LGT_name;
          $logistics->email = $LGT_email;
		  $logistics->latitude = $LGT_lat;
		  $logistics->longitude =$LGT_long;
		  $logistics->tokenId = $LGT_tokenId;
		  $logistics->vehicleType = $LGT_vehicleType;
		  $logistics->status = $LGT_status;
          $logistics->createdOn = $LGT_createdOn;	
		  $logistics->modifiedOn = $LGT_modifiedOn;
		  $logistics->LanguageId = $LGT_LanguageId;
          $logistics->APKVersion = $LGT_APKVersion;
          $logistics->DeviceVersion = $LGT_DeviceVersion;
          $logistics->DeviceType = $LGT_DeviceType;
          $logistics->IMEI = $LGT_IMEI;		  
		  		  
      }
    
      echo json_encode($logistics); 
	  //converting the output data into JSON
  }else{ 
  	  $logistics->error = "No records found";
      echo json_encode($logistics); //converting the output data into JSON
  }
}else{
  echo json_encode($logistics); //converting the output data into JSON
}

?>
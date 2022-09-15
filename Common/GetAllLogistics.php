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

$result = $logistics->GetAllLogistics();
$database->CloseConnection();
$logisticsArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){  	  
  	  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
      	  $logistics = new Logistics($db);
          extract($row);          
          $logistics->id = $LGT_GPK;       		
		  $logistics->phoneNumber = $LGT_phoneNumber;
		  $logistics->name = $LGT_name;
		  $logistics->email = $LGT_email;
		  $logistics->latitude = $LGT_lat;
		  $logistics->longitude = $LGT_long;
		  $logistics->vehicleType = $LGT_vehicleType;
		  $logistics->tokenId = $LGT_tokenId;
		  $logistics->bankName = $LGT_bankName;
		  $logistics->status = $LGT_status;
		  $logistics->accountNumber = $LGT_accountNumber;
		  $logistics->ifscCode = $LGT_ifscCode;
		  $logistics->panNumber = $LGT_panNumber;
		  $logistics->aadharNumber = $LGT_aadharNumber;
		  $logistics->vehicleNumber = $LGT_vehicleNumber;
		  $logistics->licenseNumber = $LGT_licenseNumber;
		  $logistics->branch = $LGT_branch;
		  $logistics->upiId = $LGT_upiId;
		  $logistics->sessionId = $LGT_sessionId;
		  $logistics->createdOn = $LGT_createdOn;
		  $logistics->modifiedOn = $LGT_modifiedOn;	
		  $logistics->LanguageId = $LGT_LanguageId;
          $logistics->APKVersion = $LGT_APKVersion;
          $logistics->DeviceVersion = $LGT_DeviceVersion;
          $logistics->DeviceType = $LGT_DeviceType;
          $logistics->IMEI = $LGT_IMEI;
		  
		  array_push($logisticsArray, $logistics);		  
      }
      echo json_encode($logisticsArray); //converting the output data into JSON
  }else{
  	  $logistics->error = "No records found";
  	  array_push($logisticsArray, $logistics);		  
      echo json_encode($logisticsArray); //converting the output data into JSON
  }
}else{
	array_push($logisticsArray, $logistics);		  
  echo json_encode($logisticsArray); //converting the output data into JSON
}

?>
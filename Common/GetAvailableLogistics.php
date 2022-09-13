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
include_once '../Config/config.php';
include_once '../Objects/Logistics.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetLogisticsConnection();


$logistics = new Logistics($db);

$logistics->date = $_GET['date'];


$result = $logistics->GetAvailableLogistics();
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
		  $logistics->longitude = $LGT_long;
		  $logistics->vehicleType = $LGT_vehicleType;
		  $logistics->tokenId = $LGT_tokenId;
		  $logistics->status = $LGT_status;
		  $logistics->createdOn = $LGT_createdOn;
		  $logistics->modifiedOn = $LGT_modifiedOn;
		  /*	
          $logistics->logisticsAvailabilityId = $LGA_GPK;
          $logistics->logisticsId = $LGA_LGT_GFK;
		  $logistics->logisticsAvailabilityDay01 = $LGA_day01;	
		  $logistics->logisticsAvailabilityDay02 = $LGA_day02;
          $logistics->logisticsAvailabilityDay03 = $LGA_day03;	
          $logistics->logisticsAvailabilityDay04 = $LGA_day04;	
          $logistics->logisticsAvailabilityDay05 = $LGA_day05;	
          $logistics->logisticsAvailabilityDay06 = $LGA_day06;	
          $logistics->logisticsAvailabilityDay07 = $LGA_day07;
		  $logistics->startDate = $LGA_startDate;		  
		  $logistics->endDate = $LGA_endDate;		  
          $logistics->createdOn = $LGA_createdOn;		  
          $logistics->modifiedOn = $LGA_modifiedOn;
          */
		  		  
      }
	  
	  echo json_encode($logistics); //converting the output data into JSON
	  //converting the output data into JSON
  }else{
  	  $logistics->error = "No records found";
      echo json_encode($logistics); //converting the output data into JSON
  }
}else{
  echo json_encode($logistics); //converting the output data into JSON
}

?>
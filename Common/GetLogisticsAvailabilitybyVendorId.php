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
include_once '../Objects/LogisticsAvailability.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetLogisticsConnection();


$logistics = new LogisticsAvailability($db);

$logistics->logisticsId = $_GET['logisticsId'];


$result = $logistics->GetLogisticsAvailabilityByLogisticsId();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();
//echo $result;
  // check if more than 0 record found
  if($num>0){
      $logisticsAvailabilityArray = array();
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  
          extract($row); 
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
		  
		  array_push($logisticsAvailabilityArray,$logistics);
      }
	  
	  $logisticsAvailabilityResultArray = array();
      foreach($logisticsAvailabilityArray as $array){   
      		$url = $apiRootPath.'GetLogisticsById.php?logisticsId='.$array->logisticsId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->logisticsDetails = json_decode($result);
			
			array_push($logisticsAvailabilityResultArray,$array);
	  }
    
       echo json_encode($logisticsAvailabilityResultArray); //converting the output data into JSON
	  //converting the output data into JSON
  }else{
  	  $logistics->error = "No records found";
      echo json_encode($logistics); //converting the output data into JSON
  }
}else{
  echo json_encode($logistics); //converting the output data into JSON
}

?>
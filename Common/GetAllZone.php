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
include_once '../Objects/Zone.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetZoneConnection();

$zone = new Zone($db);

$result = $zone->GetAllZone();
$database->CloseConnection();
$zoneArray = array();

if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){  	  
  	  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
      	  $zone = new Zone($db);
          extract($row);          
          $zone->zoneId = $ZNM_GPK;
		  $zone->name = $ZNM_name;
		  $zone->zipCode = $ZNM_zipcode;
		  $zone->status = $ZNM_status;
		  $zone->createdOn = $ZNM_createdOn;
		  $zone->modifiedOn = $ZNM_modifiedOn;	
		  
		  array_push($zoneArray, $zone);		  
      }
      echo json_encode($zoneArray); //converting the output data into JSON
  }else{
  	  $zone->error = "No records found";
  	  array_push($zoneArray, $zone);		  
      echo json_encode($zoneArray); //converting the output data into JSON
  }
}else{
	array_push($zoneArray, $zone);		  
  echo json_encode($zoneArray); //converting the output data into JSON
}

?>
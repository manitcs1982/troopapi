<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/database.php';
include_once '../Config/config.php';
include_once '../Objects/TempServiceItems.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();


$tempServiceItem = new TempServiceItems($db);
$tempServiceItem->tempServiceId = $_GET['tempServiceId'];

$result = $tempServiceItem ->GetTempServiceItemsByTempServiceId();
$database->CloseConnection();
if($result){
	$tempServiceItemArray = array();
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){  		
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    
          
		  $tempServiceItem = new TempServiceItems($db);	
		  
          $tempServiceItem->tempServicItemId = $TSI_GPK;
		  $tempServiceItem->tempServiceId = $TSI_TPS_GFK;
		  $tempServiceItem->itemId = $TSI_ITM_GFK;		  
          $tempServiceItem->name = $TSI_name;
          $tempServiceItem->type = $TSI_type;
          $tempServiceItem->optionAnswer = $TSI_optionAnswer;
		  $tempServiceItem->isActive = $TSI_isActive;
          $tempServiceItem->createdOn = $TSI_createdOn;
          $tempServiceItem->modifiedOn = $TSI_modifiedOn;	
          $tempServiceItem->nativeName  = $TSI_nativeName ;	  
          $tempServiceItem->nativeOptionAnswer  = $TSI_nativeOptionAnswer;	  
		  
		 array_push($tempServiceItemArray,$tempServiceItem);
      }    
      
	  

	  echo json_encode($tempServiceItemArray); //converting the output data into JSON  					    	  
  }else{
  	  
  	  $tempServiceItem ->error = "No records found";
  	  array_push($tempServiceItemArray,$tempServiceItem);
      echo json_encode($tempServiceItemArray ); //converting the output data into JSON
  }
}else{
	array_push($tempServiceItemArray,$tempServiceItem);
  echo json_encode($tempServiceItemArray ); //converting the output data into JSON
}

?>
	  
	  
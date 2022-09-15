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
include_once '../Objects/ServiceItems.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();


$serviceItem = new ServiceItems($db);
$serviceItem ->serviceId = $_GET['serviceId'];

$result = $serviceItem ->GetServiceItemsByServiceId();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		$serviceItemArray = array();
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    
          
		  $serviceItem = new ServiceItems($db);	
		  
          $serviceItem->servicItemId = $SRI_GPK;
		  $serviceItem->serviceId = $SRI_SVC_GFK;
		  $serviceItem->itemId = $SRI_ITM_GFK;		  
          $serviceItem->name = $SRI_name;
          $serviceItem->type = $SRI_type;
          $serviceItem->optionAnswer = $SRI_optionAnswer;
		  $serviceItem->isActive = $SRI_isActive;
          $serviceItem->createdOn = $SRI_createdOn;
          $serviceItem->modifiedOn = $SRI_modifiedOn;	
          $serviceItem->nativeName  = $SRI_nativeName ;	  
		  
		 array_push($serviceItemArray,$serviceItem);
      }    
      
	  

	  echo json_encode($serviceItemArray); //converting the output data into JSON  					    	  
  }else{
  	  $serviceItem ->error = "No records found";
      echo json_encode($serviceItem ); //converting the output data into JSON
  }
}else{
  echo json_encode($serviceItem ); //converting the output data into JSON
}

?>
	  
	  
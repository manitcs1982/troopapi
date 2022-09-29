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
include_once '../Objects/ServiceDefects.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();


$serviceDefects = new ServiceDefects($db);

$serviceDefects->serviceId = $_GET['serviceId'];

$result = $serviceDefects->GetAllServiceDefectsByServiceId();
$database->CloseConnection();
$serviceDefectsArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);  
          
          $serviceDefects = new ServiceDefects($db);  
	
          
          $serviceDefects->serviceDefectId = $SVD_GPK;
          $serviceDefects->serviceId = $SVD_SVC_GFK;
          $serviceDefects->productId = $SVD_PDM_GFK;
          $serviceDefects->vendorPrice = $SVD_vendorPrice;       		
		  $serviceDefects->customerPrice = $SVD_customerPrice;
		  $serviceDefects->status = $SVD_status;      
		  $serviceDefects->quantity = $SVD_quantity;	
		  if($SVD_imageUrl!=''){	  		  	  
		  		$serviceDefects->imageUrl = $defectImageDBPath.$SVD_imageUrl;
		  }else{
				$serviceDefects->imageUrl = $SVD_imageUrl;
		  }
		  $serviceDefects->imageDescription = $SVD_imageDescription;		  
		  $serviceDefects->nativeImageDescription = $SVD_nativeImageDescription;	
		  $serviceDefects->GSTPercentage = $SVD_GSTPercentage;	
		  $serviceDefects->customerDisplayPrice = $SVD_customerDisplayPrice;	
		  $serviceDefects->createdOn = $SVD_createdOn;
		  $serviceDefects->modifiedOn = $SVD_modifiedOn;
		  
		  array_push($serviceDefectsArray,$serviceDefects);		  
      }      
      				
      echo json_encode($serviceDefectsArray); //converting the output data into JSON
  }else{
  	  $serviceDefects->error = "No records found";
  	  array_push($serviceDefectsArray,$serviceDefects);
      echo json_encode($serviceDefectsArray); //converting the output data into JSON
  }
}else{
	array_push($serviceDefectsArray,$serviceDefects);
  echo json_encode($serviceDefectsArray); //converting the output data into JSON
}

?> 
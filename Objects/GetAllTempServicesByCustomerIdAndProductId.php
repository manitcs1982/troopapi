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
include_once '../Objects/TemporaryService.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();


$tempService = new TemporaryService($db);

$tempService->customerId = $_GET['customerId'];
$tempService->productId = $_GET['productId'];

$result = $tempService->GetAllTempServicesByCustomerIdAndProductId();
$database->CloseConnection();
$tempServiceArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		$tempServiceArray = array();
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    
          
		  $tempService = new TemporaryService($db);	
		  
          $tempService->tempServiceId = $TPS_GPK;
          $tempService->customerId = $TPS_CST_GFK;          
          $tempService->customerAddressId = $TPS_ADR_GFK;	
		  $tempService->customerProductId = $TPS_CSP_GFK;
		  $tempService->productId = $TPS_PDM_GFK;		  
		  $tempService->status = $TPS_status;		  
		  $tempService->stage = $TPS_stage;		  
		  $tempService->pickUpDate = $TPS_pickUpDate;
		  $tempService->pickUpSlot = $TPS_pickUpSlot;		  
		  $tempService->notes = $TPS_notes; $tempService->isTurnOn = $TPS_isTurnOn;
		  $tempService->createdOn = $TPS_createdOn;		  
		  $tempService->modifiedOn = $TPS_modifiedOn; 
		  
		  
		  array_push($tempServiceArray,$tempService);
      }    
      
      $tempServiceResultArray = array();
      foreach($tempServiceArray as $array){   
      
      		$url = $apiRootPath.'GetCustomerDetailsById.php?id='.$array->customerId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->customerDetails = json_decode($result);
      
      		$url = $apiRootPath.'GetAddressByAddressId.php?addressId='.$array->customerAddressId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->customerAddress = json_decode($result);
			
			
			$url = $apiRootPath.'GetProductByProductId.php?productId='.$array->productId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->productDetails = json_decode($result);
			
			$url = $apiRootPath.'GetTempServiceItemsByTempServiceId.php?tempServiceId='.$array->tempServiceId;
			  $options = array(
			  'http' => array(
			  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			  'method'  => 'GET',
			  ),
		  	);
		    $context  = stream_context_create($options);
		    $result = file_get_contents($url, false, $context);

		    $array->serviceItems = json_decode($result);
			
			
			$url = $apiRootPath.'GetCustomerProductByCustomerProductId.php?customerProductId='.$array->customerProductId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);		
			$array->customerProductDetails = json_decode($result);			
						
			array_push($tempServiceResultArray,$array);					
			
	  }	
				
      echo json_encode($tempServiceResultArray); //converting the output data into JSON  					    
  }else{
  	  $tempService->error = "No records found";
  	  array_push($tempServiceArray,$tempService);
      echo json_encode($tempServiceArray); //converting the output data into JSON
  }
}else{
	array_push($tempServiceArray,$tempService);
  echo json_encode($tempServiceArray); //converting the output data into JSON
}

?>







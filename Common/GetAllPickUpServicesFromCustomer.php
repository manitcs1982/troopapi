<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/database.php';
include_once '../Config/config.php';
include_once '../Objects/Service.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();

$service = new Service($db);
$serviceArray = array();

function my_error_handler($errorNo, $errorMsg, $fileName, $lineNo)
{
	$database = new Database(); //Declaring object for database class
	$db = $database->GetServiceConnection();
	$serviceArray = array();
	$service = new Service($db);
    $service->error ="Error No: ".$errorNo." Error Msg: ".$errorMsg." in line no ".$lineNo." in ".$fileName;
  	array_push($serviceArray,$service);
  	echo json_encode($serviceArray);  	
  	die;
}

set_error_handler("my_error_handler");

$service->status = $srCreated;
$service->pickUpDate = date('Y-m-d', time());

if(date('H:i', time())>=date($startTimeMorning) && date('H:i', time())<=date($endTimeMorning)){
	$service->pickUpSlot = 'Morning';
}else if(date('H:i', time())>=date($startTimeEvening) && date('H:i', time())<=date($endTimeEvening)){
	$service->pickUpSlot = 'Evening';
}else{	
	/*
	$serviceArray = array();
	$service->error = "Rest time";
  	array_push($serviceArray,$service);
  	echo json_encode($serviceArray);
  	die;
  	*/
}

$service->pickUpDate = $testScheduleDate; //hardcode
$service->pickUpSlot = $testScheduleSlot; //hardcode
//$service->zoneId = $_GET['zoneId']; //in future
$service->logisticsLatitude = $_GET['logisticsLatitude']; //13.001177';
$service->logisticsLongitude= $_GET['logisticsLongitude']; //'80.256493';
$service->logisticsId= $_GET['logisticsId']; //'80.256493';
$result = $service->GetAllPickUpServicesFromCustomer();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		
	//Fetching the result data from result object
      while ($row  = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    
          
		  $service = new Service($db);	
		  
          $service->serviceId = $SVC_GPK;
          $service->customerId = $SVC_CST_GFK;
          $service->vendorId = $SVC_VDR_GFK;  
		  $service->referenceId = $SVC_referenceId; 
          $service->customerAddressId = $SVC_ADR_GFK;    		
		  $service->customerProductId = $SVC_CSP_GFK;
		  $service->productId = $SVC_PDM_GFK;
		  $service->serviceCharge = $SVC_serviceCharge;
		  $service->otp = $SVC_otp;
		  $service->randomNumber = $SVC_randomNumber;
		  $service->status = $SVC_status;
		  $service->customerTotal = $SVC_customerTotal;
		  $service->vendorTotal = $SVC_vendorTotal;
		  $service->pickUpDate = $SVC_pickUpDate;
		  $service->pickUpSlot = $SVC_pickUpSlot;
		  $service->dropDate = $SVC_dropDate;
		  $service->dropSlot = $SVC_dropSlot;
		  $service->notes = $SVC_notes;
		  $service->createdOn = $SVC_createdOn;		  
		  $service->modifiedOn = $SVC_modifiedOn; $service->isReopened = $SVC_isReopened; $service->reopenSRId = $SVC_reopenSRId; $service->reopenReferenceId = $SVC_reopenReferenceId; $service->reopenReason = $SVC_reopenReason;		  
		  $service->vendorAddressId = $vendorAddressId;
		  $service->isCancelled = $SVC_isCancelled;
		  
		  array_push($serviceArray,$service);
      }    
      
      $serviceResultArray = array();
      
      foreach($serviceArray as $array){   
      
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
			
			$url = $apiRootPath.'GetServiceItemsByServiceId.php?serviceId='.$array->serviceId;
			  $options = array(
			  'http' => array(
			  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			  'method'  => 'GET',
			  ),
		  	);
		    $context  = stream_context_create($options);
		    $result = file_get_contents($url, false, $context);

		    $array->serviceItems = json_decode($result);
      
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
			
			$url = $apiRootPath.'GetAddressByAddressId.php?addressId='.$array->vendorAddressId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->vendorAddress = json_decode($result);
					
			
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
			
			$url = $apiRootPath.'GetVendorDetailsById.php?vendorId='.$array->vendorId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);		
			$array->vendorDetails = json_decode($result);
						
			array_push($serviceResultArray,$array);
						
	  }	
				
      //echo json_encode($serviceResultArray); //converting the output data into JSON  	
				
      echo json_encode($serviceArray); //converting the output data into JSON
  }else{
  	  $service->error = "No records found";
  	  array_push($serviceArray,$service);
      echo json_encode($serviceArray); //converting the output data into JSON
  }
}else{
	array_push($serviceArray,$service);
  echo json_encode($serviceArray); //converting the output data into JSON
}
?>
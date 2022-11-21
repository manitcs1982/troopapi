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
include_once '../Objects/Service.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();

$service = new Service($db);
$service->status = "fixed,awaiting_for_confirmation";

$result = $service->GetAllServicesByStatus();
$database->CloseConnection();
$serviceArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		$serviceArray = array();
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    
          
		  $service = new Service($db);	
		  
          $service->serviceId = $SVC_GPK;
		  $service->logisticsId = $SVC_LGT_GFK;
		  $service->referenceId = $SVC_referenceId;
          $service->customerId = $SVC_CST_GFK;
		  $service->customerAddressId = $SVC_ADR_GFK;		  
          $service->vendorId = $SVC_VDR_GFK;       		
		  $service->logisticsId = $SVC_LGT_GFK; 
		  $service->customerProductId = $SVC_CSP_GFK;
		  $service->productId = $SVC_PDM_GFK;
		  $service->serviceCharge = $SVC_serviceCharge;
		  $service->otp = $SVC_otp;
		  $service->randomNumber = $SVC_randomNumber;
		  $service->status = $SVC_status;
		  $service->customerTotal = $SVC_customerTotal;
		  $service->vendorTotal = $SVC_vendorTotal;
		  $service->customerDisplayTotal = $SVC_customerDisplayTotal;
		  $service->deliveryFee = $SVC_deliveryFee;
		  $service->GSTAmount = $SVC_GSTAmount;
		  $service->customerGrandTotal = $SVC_customerGrandTotal;
		  $service->vendorGrandTotal = $SVC_vendorGrandTotal;
		  $service->cancelledBy = $SVC_cancelledBy;
		  $service->cancelledStatus = $SVC_cancelledStatus;
		  $service->pickUpDate = $SVC_pickUpDate;
		  $service->pickUpSlot = $SVC_pickUpSlot;
		  $service->dropDate = $SVC_dropDate;
		  $service->dropSlot = $SVC_dropSlot;
		  $service->notes = $SVC_notes; $service->isTurnOn = $SVC_isTurnOn;
		  $service->createdOn = $SVC_createdOn;		  
		  $service->modifiedOn = $SVC_modifiedOn; $service->isReopened = $SVC_isReopened; $service->reopenSRId = $SVC_reopenSRId; $service->reopenReferenceId = $SVC_reopenReferenceId; $service->reopenReason = $SVC_reopenReason;	  		  	
		  $service->isCancelled = $SVC_isCancelled;	 
		  $service->vendorBusinessOwnerName = $SVC_vendorBusinessOwnerName;	 
		  $service->vendorBusinessName = $SVC_vendorBusinessName;	 
		  $service->logisticsName = $SVC_logisticsName;	 
		  $service->vendorPhoneNumber = $SVC_vendorPhoneNumber;	 
		  $service->logisticsPhoneNumber = $SVC_logisticsPhoneNumber;
		  $service->fixedVideoPath = $fixedVideoDBPath.$SVC_fixedVideoPath;
		  $service->defectAudioPath = $defectAudioDBPath.$SVC_defectAudioPath;
		  
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
			
			$url = $apiRootPath.'GetCustomerReminderNotificationHistoryBySRId.php?serviceId='.$array->serviceId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->ReminderNotificationDetails = json_decode($result);
    				
			array_push($serviceResultArray,$array);
			
	  }	
				
      echo json_encode($serviceResultArray); //converting the output data into JSON  	
				     
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







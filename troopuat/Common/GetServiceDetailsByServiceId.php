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
//print_r($_GET);
$service->serviceId = $_GET['serviceId'];

$result = $service->GetServiceByServiceId();
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
		  
          $service->customerId = $SVC_CST_GFK;
          $service->referenceId = $SVC_referenceId;
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
		  $service->notes = $SVC_notes; $service->isTurnOn = $SVC_isTurnOn;
		  $service->createdOn = $SVC_createdOn;		
		  $service->isCancelled = $SVC_isCancelled;  
		  $service->vendorBusinessOwnerName = $SVC_vendorBusinessOwnerName;	 
		  $service->vendorBusinessName = $SVC_vendorBusinessName;	 
		  $service->logisticsName = $SVC_logisticsName;	 
		  $service->vendorPhoneNumber = $SVC_vendorPhoneNumber;	 
		  $service->logisticsPhoneNumber = $SVC_logisticsPhoneNumber;
		  $service->discountAmount = $SVC_discountAmount;
		  if($SVC_defectAudioPath!=''){	 
		 		 $service->defectAudioPath = $defectAudioDBPath.$SVC_defectAudioPath;
			}else{
				$service->defectAudioPath = '';
			}
		if($SVC_fixedVideoPath!=''){	 
	 		 $service->fixedVideoPath = $fixedVideoDBPath.$SVC_fixedVideoPath; 
		}else{
			$service->fixedVideoPath = '';
		}
		  
		  $service->modifiedOn = $SVC_modifiedOn; $service->isReopened = $SVC_isReopened; $service->reopenSRId = $SVC_reopenSRId; $service->reopenReferenceId = $SVC_reopenReferenceId; $service->reopenReason = $SVC_reopenReason;		
		  
		array_push($serviceArray,$service);
      }    
      
	  $serviceResultArray = array();
	  foreach ($serviceArray as $array) {

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
		  
		  $url = $apiRootPath.'GetAllCustomerProductInfoByCustomerProductId.php?customerProductId='.$array->customerProductId;		
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'GET',		        
		    ),
		);			
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);		
		$array->customerProductDetails = json_decode($result);


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
		  
		  $url = $apiRootPath.'GetLogisticsById.php?id='.$array->logisticsId; //.$array->vendorId;
			$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'GET',
			),
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			$array->logisticsDetails = json_decode($result);

		  $url = $apiRootPath.'GetAllServicesDefectsByServiceId.php?serviceId='.$array->serviceId;
		  $options = array(
		  'http' => array(
		  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		  'method'  => 'GET',
		  ),
		  );
		  $context  = stream_context_create($options);
		  $result = file_get_contents($url, false, $context);

		  $array->DefectsList = json_decode($result);
		  
		  $url = $apiRootPath.'GetAllServicesStatusByServiceId.php?serviceId='.$array->serviceId; //.$array->vendorId;
			$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'GET',
			),
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			$array->statusList = json_decode($result);
		  
		  $url = $apiRootPath.'GetReportsByServiceId.php?serviceId='.$array->serviceId; //.$array->vendorId;
			$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'GET',
			),
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			$array->reportList = json_decode($result);
			
			$url = $apiRootPath.'GetAllPaymentDetailsByServiceId.php?serviceId='.$array->serviceId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->PaymentDetails = json_decode($result);
			
			$url = $apiRootPath.'GetServiceDiscountDetailsbyServiceId.php?serviceId='.$array->serviceId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->DiscountDetails = json_decode($result);
				
			array_push($serviceResultArray,$array);


	  }

	  echo json_encode($serviceResultArray); //converting the output data into JSON  					    	  
  }else{
  	  $service->error = "No records found";
      echo json_encode($service); //converting the output data into JSON
  }
}else{
  echo json_encode($service); //converting the output data into JSON
}

?>
	  
	  
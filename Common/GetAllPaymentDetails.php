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
include_once '../Objects/Payment.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();

$payment = new Payment($db);

$result = $payment->GetAllPaymentDetails();
$database->CloseConnection();
$paymentArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);  
          
          $payment = new Payment($db);  
	
          $payment->paymentId = $PMT_GPK;
          $payment->serviceId = $PMT_SVC_GFK;
          $payment->customerId = $PMT_CSR_GFK;
          $payment->vendorId = $PMT_VDR_GFK;       		
		  $payment->logisticsId = $PMT_LGT_GFK;
		  $payment->referenceNumber = $PMT_referenceNumber;      
		  $payment->customerTotal = $PMT_customerTotal;		  		  	  
		  $payment->paymentIdValue = $PMT_paymentIdValue;
		  $payment->paymentStatus = $PMT_paymentStatus;		  
		  $payment->paymentMethod = $PMT_paymentMethod;	
		  $payment->isActive = $PMT_isActive;			
		  $payment->createdOn = $PMT_createdOn;
		  $payment->modifiedOn = $PMT_modifiedOn;
		  
		  array_push($paymentArray,$payment);		  
      }
              $paymentResultArray = array();
      foreach($paymentArray as $array){   
	  
      		$url = $apiRootPath.'GetServiceDetailsByServiceId.php?serviceId='.$array->serviceId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->serviceDetails = json_decode($result);
			
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
				
			
			array_push($paymentResultArray,$array);
	  }      
      				
      echo json_encode($paymentResultArray); //converting the output data into JSON
  }else{
  	  $payment->error = "No records found";
  	  array_push($paymentArray,$payment);
      echo json_encode($paymentArray); //converting the output data into JSON
  }
}else{
	array_push($paymentArray,$payment);
  echo json_encode($paymentArray); //converting the output data into JSON
}

?> 
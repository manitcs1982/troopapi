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
include_once '../Objects/NotificationHistory.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetNotificationMasterConnection();


$vendorCapacity = new NotificationHistory($db);

$vendorCapacity->vendorId = $_GET['vendorId'];

$result = $vendorCapacity->GetNotificationHistoryByVendorId();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  $vendorCapacityArray = array();
  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);          
		  $vendorCapacity = new NotificationHistory($db);		
          $vendorCapacity->notificationHistoryId= $NFH_GPK;
          $vendorCapacity->customerId = $NFH_CSR_GPK; 
		  $vendorCapacity->vendorId = $NFH_VDR_GPK; 		           		
		  $vendorCapacity->logisticsId = $NFH_LGT_GPK;
		  $vendorCapacity->title = $NFH_title;
		  $vendorCapacity->message = $NFH_message;
		  $vendorCapacity->nativeTitle = $NFH_nativeTitle;
		  $vendorCapacity->nativeMessage = $NFH_nativeMessage;
		  $vendorCapacity->isActive = $NFH_isActive;
		  $vendorCapacity->createdOn = $NFH_createdOn;
		  $vendorCapacity->modifiedOn = $NFH_modifiedOn;
		 	  
		  array_push($vendorCapacityArray, $vendorCapacity);		  
      }
	  
	  
	  $vendorCapacityResultArray = array();
	  foreach ($vendorCapacityArray as $array) {

		  $url = $apiRootPath.'GetNotificationHistoryByVendorId.php?vendorId='.$array->vendorId;
		  $options = array(
		  'http' => array(
		  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		  'method'  => 'GET',
		  ),
		  );
		  $context  = stream_context_create($options);
		  $result = file_get_contents($url, false, $context);

		//   $array->productDetails = json_decode($result);

		  array_push($vendorCapacityResultArray,$array);

	  }

	  echo json_encode($vendorCapacityResultArray); //converting the output data into JSON
	  
  }else{  
  	  $vendorCapacity->error = "No records found";
      echo json_encode($vendorCapacity); //converting the output data into JSON
  }
}else{
  echo json_encode($vendorCapacity); //converting the output data into JSON
}

?>
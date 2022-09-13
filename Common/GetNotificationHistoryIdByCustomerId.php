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
include_once '../Objects/NotificationHistory.php';

$database = new Database(); //Declaring object for database class
$db = $database-> GetNotificationMasterConnection();


$productInfo = new NotificationHistory($db);

$productInfo->customerId = $_GET['customerId'];


$result = $productInfo->GetNotificationHistoryByCustomerId();
$database->CloseConnection();
$productInfoArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {		  
          extract($row); 
          //print_r($row);           
          $productInfo = new NotificationHistory($db);
		  $productInfo->notificationHistoryId= $NFH_GPK;
		  $productInfo->customerId = $NFH_CSR_GPK;
          $productInfo->vendorId = $NFH_VDR_GPK;
          $productInfo->serviceId = $NFH_SVC_GFK;
		  $productInfo->logisticsId = $NFH_LGT_GPK;
          $productInfo->title = $NFH_title;
          $productInfo->message = $NFH_message;
          $productInfo->nativeTitle = $NFH_nativeTitle;
          $productInfo->nativeMessage = $NFH_nativeMessage; 
          $productInfo->isActive = $NFH_isActive;
          $productInfo->createdOn = $NFH_createdOn;		  
          $productInfo->modifiedOn = $NFH_modifiedOn;
	
          array_push($productInfoArray,$productInfo);		
      }    
      
      echo json_encode($productInfoArray); 
	  
  }else{
  	$productInfo = new NotificationHistory($db);
  	  $productInfo->error = "No records found";
  	  array_push($productInfoArray, $productInfo);
      echo json_encode($productInfoArray); //converting the output data into JSON
  }
}else{
  echo json_encode($productInfo); //converting the output data into JSON
}

?>
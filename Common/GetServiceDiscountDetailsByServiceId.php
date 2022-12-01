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
include_once '../Objects/service_discount.php';
$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();
$discount = new Discount($db);
$discount->serviceId = $_GET['serviceId'];
$result = $discount->GetServiceDiscountDetailsbyServiceId();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();
  // check if more than 0 record found
  $discountArray = array();
  if($num>0){
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  $discount = new Discount($db);
          extract($row);
		  $discount->serviceId = $SDC_SVC_GFK;
          $discount->serviceDiscountId = $SDC_GPK;	
          $discount->discountMasterId = $SDC_DSM_GFK;
          $discount->name = $SDC_name;
          $discount->description = $SDC_description;
          $discount->notes = $SDC_notes;
          $discount->amount = $SDC_amount;
          $discount->isActive = $SDC_isActive;
          $discount->createdOn = $SDC_createdOn;
          $discount->modifiedOn = $SDC_modifiedOn;
          $discount->isDiscountAvailable = 1;
     
		  array_push($discountArray, $discount);		  
      }
    
      echo json_encode($discountArray); //converting the output data into JSON
  }else{
  	  $discount->error = "No records found";
  	  array_push($discountArray, $discount);		  
      echo json_encode($discountArray); //converting the output data into JSON
  }
}else{
	array_push($discountArray, $discount);		  
  echo json_encode($discountArray); //converting the output data into JSON
}

?>
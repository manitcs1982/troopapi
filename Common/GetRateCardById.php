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
include_once '../Objects/RateCard.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetRateCardConnection();


$rateCard = new RateCard($db);

$rateCard->id = $_GET['id'];

$result = $rateCard->GetRateCardById();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);          		
          $rateCard->imageUrl = $RCM_imageUrl;
          $rateCard->id = $RCM_GPK;          		
		  $rateCard->imageDescription = $RCM_imageDescription;
		  $rateCard->userDescription = $RCM_userDescription;
		  $rateCard->vendorPrice = $RCM_vendorPrice;
		  $rateCard->customerPrice = $RCM_customerPrice;
		  $rateCard->status = $RCM_status;
		  $rateCard->quantity = $RCM_quantity;
		  $rateCard->nativeImageDescription = $RCM_nativeImageDescription;
		  $rateCard->nativeUserDescription = $RCM_nativeUserDescription;
		  $rateCard->createdOn = $RCM_createdOn;
		  $rateCard->modifiedOn = $RCM_modifiedOn;		  
      }
      echo json_encode($rateCard); //converting the output data into JSON
  }else{
  	  $rateCard->error = "No records found";
      echo json_encode($rateCard); //converting the output data into JSON
  }
}else{
  echo json_encode($rateCard); //converting the output data into JSON
}

?>
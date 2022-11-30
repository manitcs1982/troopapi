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
include_once '../Objects/DiscountMaster.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();

$Discount = new discountmaster($db);

$Discount->discountName = $_GET['discountName'];


$result = $Discount->GetDiscountMasterByName();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();
//echo $result;
  // check if more than 0 record found
  if($num>0){
    
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  
          extract($row); 
         
		  		  
$Discount->discountMasterId = $DSM_GPK;
$Discount->discountName = $DSM_name;
$Discount->discountReason = $DSM_reason; 
$Discount->discountDescription =$DSM_description;
$Discount->discountPercentage = $DSM_percentage;
$Discount->discountAmount = $DSM_amount;
$Discount->discountIsActive = $DSM_isActive;

		  		  
      }
    
      echo json_encode($Discount); 
	  //converting the output data into JSON
  }else{
  	  $Pincode->error = "No records found";
      echo json_encode($Discount); //converting the output data into JSON
  }
}else{
  echo json_encode($Discount); //converting the output data into JSON
}

?>
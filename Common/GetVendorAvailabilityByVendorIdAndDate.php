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
include_once '../Objects/VendorAvailability.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetVendorConnection();


$vendor = new VendorAvailability($db);

$vendor->vendorId = $_GET['vendorId'];
$vendor->startDate = $_GET['startDate'];
$vendor->endDate = $_GET['endDate'];


$result = $vendor->GetVendorAvailabilityByVendorIdAndDate();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();
//echo $result;
  // check if more than 0 record found
  if($num>0){
      $vendorAvailabilityArray = array();
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  $vendor = new VendorAvailability($db);
          extract($row); 
          $vendor->vendorAvailabilityId = $VDA_GPK;
          $vendor->vendorId = $VDA_VDR_GFK;
		  $vendor->availability = $availability;			 
		  $vendor->startDate = $VDA_startDate;		  
		  $vendor->endDate = $VDA_endDate;		  
          $vendor->actualDate = $actualDate;		            
		  
		  array_push($vendorAvailabilityArray,$vendor);
      }

       echo json_encode($vendorAvailabilityArray); //converting the output data into JSON
	  //converting the output data into JSON
  }else{
  	  $vendor->error = "No records found";
      echo json_encode($vendor); //converting the output data into JSON
  }
}else{
  echo json_encode($vendor); //converting the output data into JSON
}

?>
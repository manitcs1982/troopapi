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

$result = $vendor->GetAllVendorAvailability();
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
		  $vendor->vendoravailabilityday01 = $VDA_day01;	
		  $vendor->vendoravailabilityday02 = $VDA_day02;
          $vendor->vendoravailabilityday03 = $VDA_day03;	
          $vendor->vendoravailabilityday04 = $VDA_day04;	
          $vendor->vendoravailabilityday05 = $VDA_day05;	
          $vendor->vendoravailabilityday06 = $VDA_day06;	
          $vendor->vendoravailabilityday07 = $VDA_day07;
		  $vendor->startDate = $VDA_startDate;		  
		  $vendor->endDate = $VDA_endDate;		
          $vendor->createdOn = $VDA_createdOn;		  
          $vendor->modifiedOn = $VDA_modifiedOn;
		  
		  array_push($vendorAvailabilityArray,$vendor);
      }
	  
	  $vendorAvailabilityResultArray = array();
      foreach($vendorAvailabilityArray as $array){   
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
			
			array_push($vendorAvailabilityResultArray,$array);
	  }
    
       echo json_encode($vendorAvailabilityResultArray); //converting the output data into JSON
  }else{
  	  $vendor->error = "No records found";
      echo json_encode($vendor); //converting the output data into JSON
  }
}else{
  echo json_encode($vendor); //converting the output data into JSON
}

?>
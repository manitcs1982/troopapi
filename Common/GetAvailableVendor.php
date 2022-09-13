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
include_once '../Objects/Vendor.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetVendorConnection();
$vendor = new Vendor($db);

$vendor->zoneId = $_GET['zoneId'];
$vendor->productId = $_GET['productId'];
$vendor->date = $_GET['date']; //$_GET['dayId'];

$result = $vendor->GetAvailableVendor();
$database->CloseConnection();
$vendorArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    
			  		
		  $vendor = new Vendor($db);
		    
          $vendor->vendorId = $VDR_GPK;
          $vendor->zoneId = $VDR_ZNM_GFK;
          $vendor->geoLocationLat = $VDR_geoLocationLat;          		
		  $vendor->geoLocationLong = $VDR_geoLocationLong;
		  $vendor->businessName = $VDR_businessName;
		  $vendor->phone = $VDR_phone;
		  $vendor->businessOwnerName = $VDR_businessOwnerName;
		  $vendor->alternatePhoneNo1 = $VDR_alternatePhoneNo1;
		  $vendor->alternatePhoneNo2 = $VDR_alternatePhoneNo2;
		  $vendor->alternatePhoneNo3 = $VDR_alternatePhoneNo3;
		  $vendor->itemMasterId = $VDR_itemMasterId;
		  $vendor->VDR_interested = $VDR_interested;
		  $vendor->currentVolume = $VDR_currentVolume;
		  $vendor->notes = $VDR_notes;
		  $vendor->status = $VDR_status;
		  $vendor->createdOn = $VDR_createdOn;
		  $vendor->modifiedOn = $VDR_modifiedOn;
		  $vendor->capacity = $VDC_capacity;
		  $vendor->productId = $VDC_PDM_GFK;
		  array_push($vendorArray, $vendor);				
      }
      
      $vendorFound = 0;
      foreach($vendorArray as $array){	  	
		$url = $apiRootPath.'GetPendingServiceCountByVendorIdAndProductId.php?vendorId='.$array->vendorId.'&productId='.$array->productId;	
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'GET',		        
		    ),
		);			
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		$pendingService = json_decode($result);
		//echo "vendor = ".$array->vendorId."capacity = ".$array->capacity.' pending = '.$pendingService->pendingServiceCount.' / ';
		if($pendingService->pendingServiceCount < $array->capacity){
			echo json_encode($array); //converting the output data into JSON
			die;
		}
	  }
	  if($vendorFound==0){
	  	$vendor = new Vendor($db);
	  	$vendor->error = "No records found";
      	echo json_encode($vendor); //converting the output data into JSON
	  }
				
      //echo json_encode($vendorArray); //converting the output data into JSON
  }else{
  	  $vendor->error = "No records found";
      echo json_encode($vendor); //converting the output data into JSON
  }
}else{
  echo json_encode($vendor); //converting the output data into JSON
}

?>
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
include_once '../Objects/PotentialVendor.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetVendorConnection();


$potentialVendor = new PotentialVendor($db);

$potentialVendor->vendorId = $_GET['vendorId'];

$result = $potentialVendor->GetPotentialVendorIdDetailsByVendorId();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    		  
          $potentialVendor->vendorId = $PVD_GPK;
          $potentialVendor->zoneId = $PVD_ZNM_GFK;
          $potentialVendor->geoLocationLat = $PVD_geoLocationLat;          		
		  $potentialVendor->geoLocationLong = $PVD_geoLocationLong;
		  $potentialVendor->businessName = $PVD_businessName;
		  $potentialVendor->phone = $PVD_phone;
		  $potentialVendor->businessOwnerName = $PVD_businessOwnerName;
		  $potentialVendor->alternatePhoneNo1 = $PVD_alternatePhoneNo1;
		  $potentialVendor->alternatePhoneNo2 = $PVD_alternatePhoneNo2;
		  $potentialVendor->alternatePhoneNo3 = $PVD_alternatePhoneNo3;
		  $potentialVendor->itemMasterId = $PVD_itemMasterId;
		  $potentialVendor->PVD_interested = $PVD_interested;
		  $potentialVendor->currentVolume = $PVD_currentVolume;
		  $potentialVendor->notes = $PVD_notes;
		  $potentialVendor->status = $PVD_status;
		  $potentialVendor->productList = $PVD_productList;
		  $potentialVendor->createdOn = $PVD_createdOn;
		  $potentialVendor->modifiedOn = $PVD_modifiedOn;				
      }
      /*
      	$url = $apiRootPath.'GetAddressByVendorId.php?vendorId='.$potentialVendor->vendorId;		
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'GET',		        
		    ),
		);			
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		$potentialVendor->address = json_decode($result);	
		*/	
				
      echo json_encode($potentialVendor); //converting the output data into JSON
  }else{
  	  $potentialVendor->error = "No records found";
      echo json_encode($potentialVendor); //converting the output data into JSON
  }
}else{
  echo json_encode($potentialVendor); //converting the output data into JSON
}

?>
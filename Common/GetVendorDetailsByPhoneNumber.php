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
//$vendor->phone = $data->phone = '9879';
$vendor->phone = $_GET['phone'];

if (isset($_GET['tokenId'])) {
	$vendor->tokenId = $_GET['tokenId'];
	$vendor->APKVersion = $_GET['APKVersion'];
	$vendor->DeviceVersion = $_GET['DeviceVersion'];
	$vendor->DeviceType = $_GET['DeviceType'];
	$vendor->IMEI = $_GET['IMEI'];
	$vendor->UpdateTokenIdByPhoneNumber();
	$vendor->sessionId = 1;
	$vendor->UpdateSessionIdByPhoneNumber();
}

$result = $vendor->GetVendorDetailsByPhoneNumber();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);
		  $vendor->vendorId = $VDR_GPK;
		  $vendor->geoLocationLat = $VDR_geoLocationLat;
		  $vendor->geoLocationLong = $VDR_geoLocationLong;
          $vendor->businessName = $VDR_businessName;
          $vendor->phone = $VDR_phone;  
          $vendor->businessOwnerName = $VDR_businessOwnerName;
          $vendor->alternatePhoneNo1 = $VDR_alternatePhoneNo1;
          $vendor->alternatePhoneNo2 = $VDR_alternatePhoneNo2;
		  $vendor->alternatePhoneNo3 = $VDR_alternatePhoneNo3;
		  $vendor->itemMasterId = $VDR_itemMasterId;
		  $vendor->interested = $VDR_interested;
		  $vendor->currentVolume = $VDR_currentVolume;
		  $vendor->notes = $VDR_notes;
		  $vendor->tokenId = $VDR_tokenId;
		  $vendor->status = $VDR_status;		  
		  $vendor->bankAccountNumber = $VDR_bankAccountNumber;
		  $vendor->ifscCode = $VDR_ifscCode;
		  $vendor->upiId = $VDR_upiId;
		  $vendor->panNumbers = $VDR_panNumber;
		  $vendor->bankBranch = $VDR_bankBranch;
		  $vendor->bankName = $VDR_bankName;
		  $vendor->aadharNumber = $VDR_aadharNumber;
		  $vendor->createdOn = $VDR_createdOn;
		  $vendor->modifiedOn = $VDR_modifiedOn;
		   $vendor->LanguageId = $VDR_LanguageId;
          $vendor->APKVersion = $VDR_APKVersion;
          $vendor->DeviceVersion = $VDR_DeviceVersion;
          $vendor->DeviceType = $VDR_DeviceType;
          $vendor->IMEI = $VDR_IMEI;
	  
      }
      
      
      echo json_encode($vendor); //converting the output data into JSON
  }else{
  	  $vendor->error = "No records found";
      echo json_encode($vendor); //converting the output data into JSON
  }
}else{
  echo json_encode($vendor); //converting the output data into JSON
}

?>
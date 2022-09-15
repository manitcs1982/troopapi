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
include_once '../Objects/Address.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetAddressConnection();


$address = new Address($db);

$address->customerId = $_GET['customerId'];
$address->addressLabel = $_GET['addressLabel'];

$result = $address->GetAddressByCustomerIdAndAddressLabel();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);          		          
          $address->id = $ADR_GPK;          		
		  $address->customerId = $ADR_CSR_GFK;
		  $address->vendorId = $ADR_VDR_GFK;
		  $address->phoneNumber = $ADR_phoneNumber;
		  $address->addressLabel = $ADR_addressLabel;
		  $address->addressLine1 = $ADR_addressLine1;
		  $address->addressLine2 = $ADR_addressLine2;
		  $address->city = $ADR_city;
		  $address->state = $ADR_state;
		  $address->zipcode = $ADR_zipcode;
		  $address->status = $ADR_status;
		  $address->createdOn = $ADR_createdOn;
		  $address->modifiedOn = $ADR_modifiedOn;
		  $address->latitude = $ADR_lat;
		  $address->longitude = $ADR_long;
		  
      }
      echo json_encode($address); //converting the output data into JSON
  }else{
  	  $address->error = "No records found";
      echo json_encode($address); //converting the output data into JSON
  }
}else{
  echo json_encode($address); //converting the output data into JSON
}

?>
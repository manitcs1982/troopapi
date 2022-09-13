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
include_once '../Objects/Customer.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetCustomerConnection();

$customer = new Customer($db);

$customer->id = $_GET['id'];

$result = $customer->GetCustomerDetailsById();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);
          $customer->phoneNumber = $CSR_phoneNumber;
          $customer->id = $CSR_GPK;          		
		  $customer->name = $CSR_name;
		  $customer->email = $CSR_email;		  
		  $customer->status = $CSR_status;
		  $customer->tokenId = $CSR_tokenId;
		  $customer->createdOn = $CSR_createdOn;
		  $customer->modifiedOn = $CSR_modifiedOn;	
		  $customer->isAdmin = $CSR_isAdmin;     
           $customer->LanguageId = $CSR_LanguageId;
          $customer->APKVersion = $CSR_APKVersion;
          $customer->DeviceVersion = $CSR_DeviceVersion;
          $customer->DeviceType = $CSR_DeviceType;
          $customer->IMEI = $CSR_IMEI;		  
      }
      
      echo json_encode($customer); //converting the output data into JSON
  }else{
  	  $customer->error = "No records found";
      echo json_encode($customer); //converting the output data into JSON
  }
}else{
  echo json_encode($customer); //converting the output data into JSON
}

?>
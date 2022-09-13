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
include_once '../Objects/Reports.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();

$Reports = new Reports($db);

$Reports->vendorId = $_GET['vendorId'];

$result = $Reports->GetReportsByVendorId();
$database->CloseConnection();
$ReportsArray = array();  
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
    	
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {          		          
          $Reports = new Reports($db);
          extract($row); 
          $Reports->Id = $RPT_GPK;
	      $Reports->serviceId = $RPT_SVC_GFK;
          $Reports->referenceNumber = $RPT_referenceNumber;
          $Reports->customerId = $RPT_CSR_GFK;
          $Reports->vendorId = $RPT_VDR_GFK;
          $Reports->logisticsId = $RPT_LGT_GFK;
          $Reports->productId = $RPT_PDM_GFK;
          $Reports->reportMessage = $RPT_reportMessage;
          $Reports->createdOn = $RPT_createdOn;
          $Reports->modifiedOn = $RPT_modifiedOn;
		  array_push($ReportsArray, $Reports);		  
      }
    
      echo json_encode($ReportsArray); //converting the output data into JSON
  }else{
  	  $Reports->error = "No records found";
  	  array_push($ReportsArray, $Reports);		  
      echo json_encode($ReportsArray); //converting the output data into JSON
  }
}else{
	array_push($ReportsArray, $Reports);		  
  echo json_encode($ReportsArray); //converting the output data into JSON
}

?>
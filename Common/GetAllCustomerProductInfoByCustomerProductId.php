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
include_once '../Objects/CustomerProductInfo.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetCustomerProductConnection();

$customerProductInfo = new CustomerProductInfo($db);

$customerProductInfo->customerProductId = $_GET['customerProductId'];

$result = $customerProductInfo->GetAllCustomerProductInfoByCustomerProductId();
$database->CloseConnection();
$customerProductInfoArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){

	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
      	  extract($row);
      	  $customerProductInfo = new CustomerProductInfo($db);

          $customerProductInfo->customerProductInfoId = $CPI_GPK;
          $customerProductInfo->productId = $CPI_PDM_GFK;
          $customerProductInfo->customerId = $CPI_CSR_GFK;
          $customerProductInfo->customerProductId = $CPI_CSP_GFK;
          $customerProductInfo->productInfoId = $CPI_PIN_GFK;     
		if($CPI_isImage==1){
			$customerProductInfo->answer = $customerProductDBPath.$CPI_answer;
		}else{
			$customerProductInfo->answer = $CPI_answer;
		}
		  		 
		  $customerProductInfo->createdOn = $CPI_createdOn;
		  $customerProductInfo->modifiedOn = $CPI_modifiedOn;
		  
		  array_push($customerProductInfoArray,$customerProductInfo);
      }      	
		
	 $customerProductResultArray = array();

      foreach($customerProductInfoArray as $array){   
      
      		$url = $apiRootPath.'GetProductInfoByProductInfoId.php?productInfoId='.$array->productInfoId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);			
			$array->questionDetails = json_decode($result);
			array_push($customerProductResultArray,$array);				
	  } 	
	  		
      echo json_encode($customerProductResultArray); //converting the output data into JSON
  }else{
  	  $customerProductInfo->error = "No records found";
  	  array_push($customerProductInfoArray,$customerProductInfo);
      echo json_encode($customerProductInfoArray); //converting the output data into JSON
  }
}else{
	array_push($customerProductInfoArray,$customerProductInfo);
  echo json_encode($customerProductInfoArray); //converting the output data into JSON
}

?>







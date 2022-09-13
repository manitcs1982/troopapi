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
include_once '../Objects/CustomerProduct.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetCustomerProductConnection();


$customerProduct = new CustomerProduct($db);

$customerProduct->consumerId = $_GET['consumerId'];
$customerProduct->productId = $_GET['productId'];

$result = $customerProduct->GetAllCustomerProductByCustomerIdAndProductId();

$database->CloseConnection();

$customerProductArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){

	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);    
		  $customerProduct = new CustomerProduct($db);
          $customerProduct->customerProductId = $CSP_GPK;
          $customerProduct->consumerId = $CSP_CSR_GFK;
          $customerProduct->productId = $CSP_PDM_GFK;       		
		  $customerProduct->phoneNumber = $CSP_phoneNumber;
		  $customerProduct->name = $CSP_name;
		  $customerProduct->capacity = $CSP_capacity;
		  $customerProduct->imageUrl = $customerProductDBPath.$CSP_imageUrl;
		  $customerProduct->model = $CSP_model;
		  $customerProduct->brand = $CSP_brand;
		  $customerProduct->manDate = $CSP_manDate;
		  $customerProduct->notes = $CSP_notes;
		  $customerProduct->status = $CSP_status;
		  $customerProduct->createdOn = $CSP_createdOn;
		  $customerProduct->modifiedOn = $CSP_modifiedOn;
		  
		  array_push($customerProductArray,$customerProduct);
      }      		 
	  $customerProductResultArray = array();
      foreach($customerProductArray as $array){   
	      
	      		$url = $apiRootPath.'GetAllCustomerProductInfoByCustomerProductId.php?customerProductId='.$array->customerProductId;		
				$options = array(
				    'http' => array(
				        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				        'method'  => 'GET',		        
				    ),
				);			
				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);	
					
				$array->productDetails = json_decode($result);
				
				$url = $apiRootPath.'GetProductByProductId.php?productId='.$array->productId;		
				$options = array(
				    'http' => array(
				        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				        'method'  => 'GET',		        
				    ),
				);			
				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);	
					
				$array->productMasterDetails = json_decode($result);
				
				array_push($customerProductResultArray,$array);	
				//print_r($customerProductResultArray)			;
		  } 
				
      echo json_encode($customerProductResultArray); //converting the output data into JSON.
  }else{
  	  $customerProduct->error = "No records found";
  	  array_push($customerProductArray,$customerProduct);
      echo json_encode($customerProductArray); //converting the output data into JSON
  }
}else{
	array_push($customerProductArray,$customerProduct);
  echo json_encode($customerProductArray); //converting the output data into JSON
}

?>







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

$customerProduct->customerProductId = $_GET['customerProductId'];

$result = $customerProduct->GetCustomerProductByCustomerProductId();
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
	
          $customerProduct->customerProductId = $CSP_GPK;
          $customerProduct->consumerId = $CSP_CSR_GFK;
          $customerProduct->customerId = $CSP_CSR_GFK;
          $customerProduct->productId = $CSP_PDM_GFK;       		
          $customerProduct->name = $CSP_name;
		  $customerProduct->capacity = $CSP_capacity;
		  $customerProduct->imageUrl = $customerProductDBPath.$CSP_imageUrl;
   		  $customerProduct->notes = $CSP_notes;  
		  $customerProduct->phoneNumber = $CSP_phoneNumber;
		  $customerProduct->model = $CSP_model;
		  $customerProduct->brand = $CSP_brand;
		  $customerProduct->manDate = $CSP_manDate;
		  $customerProduct->notes = $CSP_status;
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
		} 
				
      echo json_encode($customerProductResultArray); //converting the output data into JSON
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







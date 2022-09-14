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

$customerProduct->customerId = $_GET['customerId'];

$result = $customerProduct->GetCustomerProductByCustomerProductIdTest();
$database->CloseConnection();
$customerProductArray = array();

if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
      	  $customerProduct = new CustomerProduct($db);
      	  
          extract($row);    
	
          $customerProduct->customerProductId = $CSP_GPK;
          $customerProduct->consumerId = $CSP_CSR_GFK;
          $customerProduct->productId = $CSP_PDM_GFK;   
          $customerProduct->name = $CSP_name;
		  $customerProduct->capacity = $CSP_capacity;
		  $customerProduct->imageUrl = $customerProductDBPath.$CSP_imageUrl;
   		  $customerProduct->notes = $CSP_notes;    		
		  $customerProduct->phoneNumber = $CSP_phoneNumber;
		  $customerProduct->model = $CSP_model;
		  $customerProduct->brand = $CSP_brand;
		  $customerProduct->manDate = $CSP_manDate;
		  $customerProduct->status = $CSP_status;
		  $customerProduct->createdOn = $CSP_createdOn;
		  $customerProduct->modifiedOn = $CSP_modifiedOn;
		  
		  $customerProduct->customerProductInfoId = $CPI_GPK;
          $customerProduct->productId = $CPI_PDM_GFK;
          $customerProduct->customerId = $CPI_CSR_GFK;
          $customerProduct->productInfoId = $CPI_PIN_GFK;  
                    
		  $customerProduct->productInfoId = $PIN_GPK;
		  $customerProduct->productId = $PIN_PDM_GFK;
          $customerProduct->question = $PIN_question;
		  $customerProduct->type = $PIN_type;
          $customerProduct->answer = $PIN_answer;
          $customerProduct->status = $PIN_status;
          $customerProduct->minLength = $PIN_minLength;
          $customerProduct->maxLength = $PIN_maxLength;
          $customerProduct->isFloat = $PIN_isFloat;
          $customerProduct->createdOn = $PIN_createdOn;		  
          $customerProduct->modifiedOn = $PIN_modifiedOn;
		  $customerProduct->IsMandatory = $PIN_IsMandatory;
      	  $customerProduct->nativeQuestion = $PIN_nativeQuestion;
      	  $customerProduct->nativeAnswer = $PIN_nativeAnswer;
		  $customerProduct->placeHolder = $PIN_placeHolder;
      	  $customerProduct->nativePlaceHolder = $PIN_nativePlaceHolder;
      	  
      	  $customerProduct->productId = $PDM_GPK;
          $customerProduct->name = $PDM_name;
		  $customerProduct->description = $PDM_description;
          $customerProduct->imageUrl = $customerProductDBPath.$PDM_imageUrl;
          $customerProduct->isTurnOnRequired = $PDM_isTurnOnRequired;
          $customerProduct->status = $PDM_status;
          $customerProduct->gstValue = $PDM_GSTValue;
          $customerProduct->note = $PDM_note;
          $customerProduct->createdOn = $PDM_createdOn;		  
          $customerProduct->modifiedOn = $PDM_modifiedOn;
          $customerProduct->nativeName = $PDM_nativeName;
          $customerProduct->nativeDescription = $PDM_nativeDescription;
          $customerProduct->nativeNote = $PDM_nativeNote;
		  
		  array_push($customerProductArray,$customerProduct);
      }      	
  
				
      echo json_encode($customerProductArray); //converting the output data into JSON
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







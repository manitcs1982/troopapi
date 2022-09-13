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
include_once '../Objects/ProductInfo.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetProductConnection();


$productInfo = new ProductInfo($db);

$productInfo->productId = $_GET['productId'];


$result = $productInfo->GetProductInfoByProductId();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  $productInfoArray = array();
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {		  
          extract($row); 
          $productInfo = new ProductInfo($db);
		  $productInfo->productInfoId = $PIN_GPK;
		  $productInfo->productId = $PIN_PDM_GFK;
          $productInfo->question = $PIN_question;
		  $productInfo->type = $PIN_type;
          $productInfo->answer = $PIN_answer;
          $productInfo->status = $PIN_status;
          $productInfo->minLength = $PIN_minLength;
          $productInfo->maxLength = $PIN_maxLength;
          $productInfo->isFloat = $PIN_isFloat;
          $productInfo->createdOn = $PIN_createdOn;		  
          $productInfo->modifiedOn = $PIN_modifiedOn;
		  $productInfo->IsMandatory = $PIN_IsMandatory;
      	  $productInfo->nativeQuestion = $PIN_nativeQuestion;
      	  $productInfo->nativeAnswer = $PIN_nativeAnswer;
		  $productInfo->placeHolder = $PIN_placeHolder;
      	  $productInfo->nativePlaceHolder = $PIN_nativePlaceHolder;
          
          array_push($productInfoArray,$productInfo);		
      }    
      
      echo json_encode($productInfoArray); 
	  
  }else{
  	  $productInfo->error = "No records found";
      echo json_encode($productInfo); //converting the output data into JSON
  }
}else{
  echo json_encode($productInfo); //converting the output data into JSON
}

?>
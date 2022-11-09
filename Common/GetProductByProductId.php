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
include_once '../Objects/Product.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetProductConnection();


$product = new Product($db);

$product->productId = $_GET['productId'];


$result = $product->GetProductByProductId();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();
//echo $result;
  // check if more than 0 record found
  if($num>0){
    
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  
          extract($row); 
         
		  $product->productId = $PDM_GPK;
          $product->name = $PDM_name;
		  $product->description = $PDM_description;
          $product->imageUrl = $ProductDBPath.$PDM_imageUrl;
          $product->nativeImageUrl = $ProductDBPath.$PDM_nativeImageUrl;          		
          $product->isTurnOnRequired = $PDM_isTurnOnRequired;
          $product->status = $PDM_status;
          $product->gstValue = $PDM_GSTValue;
          $product->note = $PDM_note;
          $product->createdOn = $PDM_createdOn;		  
          $product->modifiedOn = $PDM_modifiedOn;
          $product->nativeName = $PDM_nativeName;
          $product->nativeDescription = $PDM_nativeDescription;
          $product->nativeNote = $PDM_nativeNote;
		  		  
      }
    
      echo json_encode($product); 
	  //converting the output data into JSON
  }else{
  	  $product->error = "No records found";
      echo json_encode($product); //converting the output data into JSON
  }
}else{
  echo json_encode($product); //converting the output data into JSON
}

?>
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
include_once '../Objects/ItemMaster.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetProductConnection();

$Item = new ItemMaster($db);

$Item->productId = $_GET['productId'];

$result = $Item->GetItemsByProductId();
$database->CloseConnection();
$ItemArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {		  
          extract($row); 
          $Item = new ItemMaster($db);
	      $Item->itemId = $ITM_GPK;
	      $Item->productId = $ITM_PDM_GFK;
          $Item->name = $ITM_name;
	      $Item->isActive = $ITM_isActive;
	      $Item->type = $ITM_type;
	      $Item->options = $ITM_options;
          $Item->createdOn = $ITM_createdOn;
          $Item->modifiedOn = $ITM_modifiedOn;
          $Item->nativeName = $ITM_nativeName;
          $Item->nativeOptions = $ITM_nativeOptions;
          $Item->isAll = $ITM_isAll;
          $Item->refererItemId = $ITM_refererItemId;
          $Item->refItemId = $ITM_refItemId;
          $Item->refOption = $ITM_refOption;
          $Item->isMandatory = $ITM_isMandatory;
          $Item->refTamilOption = $ITM_refTamilOption;
          $Item->error = '';
          array_push($ItemArray,$Item);		
      }    
      
      echo json_encode($ItemArray); 
	  
  }else{
  	  $Item->error = "No records found";
  	  array_push($ItemArray,$Item);	
      echo json_encode($ItemArray); //converting the output data into JSON
  }
}else{
  echo json_encode($ItemArray); //converting the output data into JSON
}

?>
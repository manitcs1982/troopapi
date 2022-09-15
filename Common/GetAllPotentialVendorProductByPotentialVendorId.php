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
include_once '../Objects/PotentialVendorProduct.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetVendorConnection();


$potentialVendorProduct = new PotentialVendorProduct($db);

$potentialVendorProduct->vendorId = $_GET['vendorId'];

$result = $potentialVendorProduct->GetAllPotentialVendorProductByPotentialVendorId();
$database->CloseConnection();
$potentialVendorProductArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
      	  $potentialVendorProduct = new PotentialVendorProduct($db);
      	  
          extract($row);          		
          
          $potentialVendorProduct->id = $PVP_GPK;          		
		  $potentialVendorProduct->vendorId = $PVP_PVD_GFK;
		  $potentialVendorProduct->productId = $PVP_PDM_GFK;
		  $potentialVendorProduct->status = $PVP_Status;
		  $potentialVendorProduct->createdOn = $PVP_createdOn;
		  $potentialVendorProduct->modifiedOn = $PVP_modifiedOn;	
		  array_push($potentialVendorProductArray,$potentialVendorProduct);
      
      }
      
      $potentialVendorProductResultArray = array();
      foreach($potentialVendorProductArray as $array){
	  		 $url = $apiRootPath.'GetProductByProductId.php?productId='.$array->productId;		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			$array->productDetails = json_decode($result);		
			array_push($potentialVendorProductResultArray,$array);
	  }
      	
				
      echo json_encode($potentialVendorProductResultArray); //converting the output data into JSON
  }else{
  	  $potentialVendorProduct->error = "No records found";
  	  array_push($potentialVendorProductArray,$potentialVendorProduct);
      echo json_encode($potentialVendorProductArray); //converting the output data into JSON
  }
}else{  
  array_push($potentialVendorProductArray,$potentialVendorProduct);
  echo json_encode($potentialVendorProductArray); //converting the output data into JSON
}

?>
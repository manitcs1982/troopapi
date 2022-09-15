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
include_once '../Objects/ConstantValues.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetConstantValuesConnection();


$ConstantValues = new ConstantValues($db);

$ConstantValues->type = $_GET['type'];


$result = $ConstantValues->GetAllConstantValuesByType();
$database->CloseConnection();
$ConstantValuesArray = array();  
if($result){
  $num = $result->rowCount();
//echo $result;
  // check if more than 0 record found
  if($num>0){
    
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
		  $ConstantValues = new ConstantValues($db);
          extract($row); 
         
		      $ConstantValues->constvalueId = $CNV_GPK;
          $ConstantValues->type = $CNV_type;
		      $ConstantValues->value = $CNV_value;
          $ConstantValues->title = $CNV_title;
          if($CNV_isMedia==1)
		 {
			 $ConstantValues->value = $ConstantValuesDBPath.$CNV_value;
		 }
          else{
			  $ConstantValues->value = $CNV_value;
		  }
          $ConstantValues->isActive = $CNV_isActive;
		  $ConstantValues->isMedia = $CNV_isMedia;
          $ConstantValues->createdOn = $CNV_createdOn;
          $ConstantValues->modifiedOn = $CNV_modifiedOn;
          array_push($ConstantValuesArray, $ConstantValues);
      }
    
      echo json_encode($ConstantValuesArray); 
	  //converting the output data into JSON
  }else{
  	  $ConstantValues->error = "No records found";
      array_push($ConstantValuesArray, $ConstantValues);
      echo json_encode($ConstantValuesArray); //converting the output data into JSON
  }
}else{
  array_push($ConstantValuesArray, $ConstantValues);	
  echo json_encode($ConstantValuesArray); //converting the output data into JSON
}

?>

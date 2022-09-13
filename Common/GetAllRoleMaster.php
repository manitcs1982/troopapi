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
include_once '../Objects/RoleMaster.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetRoleMasterConnection();


$logistics = new RoleMaster($db);

$result = $logistics->GetAllRoleMaster();
$database->CloseConnection();
$logisticsArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){  	  
  	  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
      	  $logistics = new RoleMaster($db);
          extract($row);          
          $logistics->id = $RLM_GPK;       		
		  $logistics->name = $RLM_name;
		  $logistics->type = $RLM_type;
		  $logistics->email = $RLM_email;
		  $logistics->password = $RLM_password;
		  $logistics->username = $RLM_username;
		  $logistics->phoneNumber = $RLM_phoneNumber;
		  $logistics->status = $RLM_status;
		  $logistics->createdOn = $RLM_createdOn;
		  $logistics->modifiedOn = $RLM_modifiedOn;	
		  
		  array_push($logisticsArray, $logistics);		  
      }
      echo json_encode($logisticsArray); //converting the output data into JSON
  }else{
  	  $logistics->error = "No records found";
  	  array_push($logisticsArray, $logistics);		  
      echo json_encode($logisticsArray); //converting the output data into JSON
  }
}else{
	array_push($logisticsArray, $logistics);		  
  echo json_encode($logisticsArray); //converting the output data into JSON
}

?>
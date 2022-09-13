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

$role = new RoleMaster($db);

$role->username = $_GET['username'];

$result = $role->GetRoleByUsername();
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
					  		  
			$role->roleMasterId = $RLM_GPK;
			$role->name = $RLM_name;
			$role->createdOn = $RLM_createdOn; 
			$role->modifiedOn =$RLM_modifiedOn;
			$role->type = $RLM_type;
			$role->password = $RLM_password;
			$role->username = $RLM_username;
			$role->status = $RLM_status;					  		
			$role->email = $RLM_email;					  		
			$role->phoneNumber = $RLM_phoneNumber;					  		
      }
    
      echo json_encode($role); 
	  //converting the output data into JSON
  }else{
  	  $role->error = "No records found";
      echo json_encode($role); //converting the output data into JSON
  }
}else{
  echo json_encode($role); //converting the output data into JSON
}

?>
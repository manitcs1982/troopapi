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
include_once '../Objects/Service.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();

$service = new Service($db);

$service->customerId = $_GET['customerId'];

$result = $service->GetAllServiceCountByCustomerId();
$database->CloseConnection();
$serviceArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);  
                    
          $service = new Service($db);  
	
          $service->SRCount = $SRCount;		  		
      }              
 		
      echo json_encode($service); //converting the output data into JSON
  }else{
  	  echo "0";
  }
}else{
	echo "0";
}

?>







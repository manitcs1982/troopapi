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
include_once '../Objects/ServiceStatus.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();


$serviceStatus = new ServiceStatus($db);

$serviceStatus->serviceId = $_GET['serviceId'];

$result = $serviceStatus->GetAllServiceStatussByServiceId();
$database->CloseConnection();
$serviceStatusResultArray = array();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  		
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);  
          
          $serviceStatus = new ServiceStatus($db);  

          $serviceStatus->serviceStatusId = $SVS_GPK;
          $serviceStatus->serviceId = $SVS_SVC_GFK;        
		  $serviceStatus->status = $SVS_status;
		  $serviceStatus->date = $SVS_date;
		  $serviceStatus->logisticsId = $SVS_LGT_GFK;      
		  	  	
		  array_push($serviceStatusResultArray,$serviceStatus);		  
      }      
      
	
      echo json_encode($serviceStatusResultArray); //converting the output data into JSON
  }else{
  	  $serviceStatus->error = "No records found";
  	  array_push($serviceStatusResultArray,$serviceStatus);
      echo json_encode($serviceStatusResultArray); //converting the output data into JSON
  }
}else{
	array_push($serviceStatusResultArray,$serviceStatus);
  echo json_encode($serviceStatusResultArray); //converting the output data into JSON
}

?>







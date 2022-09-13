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
include_once '../Objects/LogisticsAvailability.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetLogisticsConnection();
$logisticsAvailability = new LogisticsAvailability($db);

$logisticsAvailability->logisticsAvailabilityId    = $data->logisticsAvailabilityId;
$logisticsAvailability->logisticsId    = $data->logisticsId;
$logisticsAvailability->logisticsAvailabilityDay01 = $data->logisticsAvailabilityDay01;
$logisticsAvailability->logisticsAvailabilityDay02 = $data->logisticsAvailabilityDay02;
$logisticsAvailability->logisticsAvailabilityDay03 = $data->logisticsAvailabilityDay03;
$logisticsAvailability->logisticsAvailabilityDay04 = $data->logisticsAvailabilityDay04;
$logisticsAvailability->logisticsAvailabilityDay05 = $data->logisticsAvailabilityDay05;
$logisticsAvailability->logisticsAvailabilityDay06 = $data->logisticsAvailabilityDay06;
$logisticsAvailability->logisticsAvailabilityDay07 = $data->logisticsAvailabilityDay07;
$logisticsAvailability->startDate = $data->startDate;
$logisticsAvailability->endDate = $data->endDate;
$logisticsAvailability->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$result = $logisticsAvailability->UpdateLogisticsAvailability();

if($result){
 echo json_encode($logisticsAvailability); //converting the output data into JSON
}else{
  echo json_encode($logisticsAvailability); //converting the output data into JSON
}

?>
		
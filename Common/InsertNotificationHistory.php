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
include_once '../Objects/NotificationHistory.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetNotificationMasterConnection();
$NotificationHistory = new NotificationHistory($db);

$NotificationHistory->customerId = $data->customerId;
$NotificationHistory->vendorId = $data->vendorId;
$NotificationHistory->logisticsId = $data->logisticsId;
$NotificationHistory->serviceId = $data->serviceId;
$NotificationHistory->title = $data->title;
$NotificationHistory->message = $data->message;
$NotificationHistory->nativeTitle = $data->nativeTitle;
$NotificationHistory->nativeMessage = $data->nativeMessage;
$NotificationHistory->isActive = $data->isActive;
$NotificationHistory->type = $data->type;
$NotificationHistory->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$NotificationHistory->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));



$result = $NotificationHistory->InsertNotificationHistory();

if($result){
 echo json_encode($NotificationHistory); //converting the output data into JSON
}else{
  echo json_encode($NotificationHistory); //converting the output data into JSON
}

?>

		
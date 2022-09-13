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
include_once '../Objects/NotificationMaster.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetNotificationMasterConnection();

$notification = new NotificationMaster($db);

$notification->type = $_GET['type'];


$result = $notification->GetNotificationByType();
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
         
		  $notification->notificationId = $NFM_GPK;
		  $notification->type = $NFM_type;
		  $notification->title = $NFM_title;
		  $notification->message = $NFM_message;
		  $notification->nativeTitle = $NFM_nativeTitle;
		  $notification->nativeMessage = $NFM_nativeMessage;
		  $notification->notificationPerson = $NFM_notificationPerson;
		  $notification->status = $NFM_status;
		  $notification->createdOn = $NFM_createdOn;		  
		  $notification->modifiedOn = $NFM_modifiedOn;
		  		  
      }
    
      echo json_encode($notification); 
	  //converting the output data into JSON
  }else{
  	  $notification->error = "No records found";
      echo json_encode($notification); //converting the output data into JSON
  }
}else{
  echo json_encode($notification); //converting the output data into JSON
}

?>
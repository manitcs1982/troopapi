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
include_once '../Objects/Chat.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetChatConnection();

$Chat = new Chat($db);

$Chat->customerId = $_GET['customerId'];

$result = $Chat->GetLastChatByCustomerId();
$database->CloseConnection();
$ChatArray = array();  
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
    	
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {          		          
          $Chat = new Chat($db);
          extract($row); 
          $Chat->chatId = $CHT_GPK;
	      $Chat->roleId = $CHT_RLM_GFK;
          $Chat->senderType = $CHT_senderType;
          $Chat->customerId = $CHT_CST_GFK;
          $Chat->vendorId = $CHT_VDR_GFK;
          $Chat->logisticsId = $CHT_LGT_GFK;
          $Chat->receiverType = $CHT_receiverType;
          $Chat->customerTokenId = $CHT_customerTokenId;
          $Chat->roleTokenId = $CHT_roleTokenId;
          $Chat->message = $Chat->decrypt($CHT_message);
          $Chat->media = $CHT_media;
          $Chat->isMedia = $CHT_isMedia;
          $Chat->mediaType = $CHT_mediaType;
          $Chat->isRead = $CHT_isRead;
          $Chat->status = $CHT_status;
          $Chat->createdOn = $CHT_createdOn;
          $Chat->modifiedOn = $CHT_modifiedOn;
		  array_push($ChatArray, $Chat);	
      }
    
      echo json_encode($ChatArray); //converting the output data into JSON
  }else{
  	  $Chat->error = "No records found";
  	  array_push($ChatArray, $Chat);		  
      echo json_encode($ChatArray); //converting the output data into JSON
  }
}else{
	array_push($ChatArray, $Chat);		  
  echo json_encode($ChatArray); //converting the output data into JSON
}

?>
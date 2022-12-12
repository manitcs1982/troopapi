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
include_once '../Objects/Schedule.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetScheduleConnection();


$schedule = new Schedule($db);

$schedule->time = $_GET['time'];
//$schedule->vendorId = $_GET['vendorId'];

$result = $schedule->GetScheduleDetailsByTime();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
	//Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);          		
          $schedule->scheduleId = $SCM_GPK;
          $schedule->pickupSlot1 = $SCM_pickupSlot1;          		
		  $schedule->pickupSlot2 = $SCM_pickupSlot2;
		  $schedule->dropSlot1 = $SCM_dropSlot1;
		  $schedule->dropSlot2 = $SCM_dropSlot2;
		  $schedule->pickupCutOff1 = $SCM_pickupCutOff1;
		  $schedule->pickupCutOff2 = $SCM_pickupCutOff2;
		  $schedule->dropCutOff1 = $SCM_dropCutOff1;
		  $schedule->dropCutOff2 = $SCM_dropCutOff2;
		  $schedule->holiday = $SCM_holiday;
		  $schedule->status = $SCM_status;		 
		  $schedule->createdOn = $SCM_createdOn;
		  $schedule->modifiedOn = $SCM_modifiedOn;	
		  		  
		  $date1 = date("Y-m-d");
		  $date2 = date("Y-m-d", strtotime("+1 day", strtotime($date1)));
		  //$date3 = date("Y-m-d", strtotime("+1 day", strtotime($date2)));
		  
		  
		  
		  if(strtotime($_GET['time']) < strtotime($schedule->pickupCutOff1)){ //12AM - 3PM				  
			$schedule->scheduledSlot1 = $date1.",".$schedule->pickupSlot2;
			$schedule->scheduledSlot2 = $date2.",".$schedule->pickupSlot1;
		  	//$schedule->scheduledSlots[$date1] = $schedule->pickupSlot1.",".$schedule->pickupSlot2;
		  	//$schedule->scheduledSlots[$date2] = $schedule->pickupSlot1.",".$schedule->pickupSlot2;
		  }else if(strtotime($_GET['time']) >= strtotime($schedule->pickupCutOff2)){ //9pm - 12AM
		  	$schedule->scheduledSlot1 = $date2.",".$schedule->pickupSlot1;
			$schedule->scheduledSlot2 = $date2.",".$schedule->pickupSlot2;
		  	//$schedule->scheduledSlots[$date2] = $schedule->pickupSlot1.",".$schedule->pickupSlot2;
		  	//$schedule->scheduledSlots[$date3] = $schedule->pickupSlot1.",".$schedule->pickupSlot2;
		  }else if(strtotime($_GET['time']) >= strtotime($schedule->pickupCutOff1) && strtotime($_GET['time']) < strtotime($schedule->pickupCutOff2)){
		  	$schedule->scheduledSlot1 = $date2.",".$schedule->pickupSlot1;
			$schedule->scheduledSlot2 = $date2.",".$schedule->pickupSlot2;		  	
		  	//$schedule->scheduledSlots[$date1] = $schedule->pickupSlot2;
		  	//$schedule->scheduledSlots[$date2] = $schedule->pickupSlot1; //.",".$schedule->pickupSlot2;
		  	//$schedule->scheduledSlots[$date3] = $schedule->pickupSlot1;
		  }
		  
		  
		  
      }
      echo json_encode($schedule); //converting the output data into JSON
  }else{
  	  $schedule->error = "No records found";
      echo json_encode($schedule); //converting the output data into JSON
  }
}else{
  echo json_encode($schedule); //converting the output data into JSON
}

?>
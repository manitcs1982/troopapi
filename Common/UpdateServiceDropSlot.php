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

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$service = new Service($db);

$service->serviceId = $data->serviceId;
$service->dropDate = $data->dropDate;
$service->dropSlot = $data->dropSlot;
$service->status = $data->status;
$service->logisticsId = $data->logisticsId;
$service->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$service->referenceNumber = $data->referenceNumber;
$service->appliance = urlencode($data->appliance);

$result = $service->UpdateServiceDropSlot();

if($result){
  $url = $apiRootPath.'InsertServiceStatus.php';
	
	$data = array("serviceId" => $service->serviceId, "status" => $service->status, "logisticsId" => "");		
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => json_encode($data), 
	    ),
	);			
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);	
	
	if ($service->status=='scheduled_for_drop') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=scheduled_for_drop&logisticsId='.$service->logisticsId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
		$options = array(
		'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'GET',
		),
		);
		$context  = stream_context_create($options);
		$result = json_decode(file_get_contents($url, false, $context));
		
		//InsertNotificationHistory
		$url = $apiRootPath.'InsertNotificationHistory.php';
		$data = array("serviceId" => $service->serviceId, "status" => $service->status, "customerId" =>0, "title" => $result->title,"vendorId"=>0,"message" => $result->notificationMessage,"logisticsId"=>$service->logisticsId,"type"=>"scheduled_for_drop","isActive"=>1,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage);		
		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
			'content' => json_encode($data), 
			),
		);			
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	}
		
  echo json_encode($service); //converting the output data into JSON
}else{
  echo json_encode($service); //converting the output data into JSON
}

?>
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
include_once '../Objects/Service.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$service = new Service($db);
$service->serviceId = $data->serviceId;
$service->logisticsId = $data->logisticsId;
$service->status = $data->status;
$service->customerId = $data->customerId;
$service->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
$service->referenceNumber = $data->referenceNumber;
$service->appliance = urlencode($data->appliance);
$service->logisticsNumber = $data->logisticsNumber;
$service->logisticsName = urlencode($data->logisticsName);

$url = $apiRootPath.'GetServiceDescriptionByStatus.php?status='.$service->status;
$options = array(
'http' => array(
'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
'method'  => 'GET',
),);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$SRDescription = json_decode($result);

$service->statusDescription = ''; $service->statusNativeDescription='';
if ($SRDescription->error != "No records found") {
	$service->statusDescription = $SRDescription->description;	
	$service->statusNativeDescription = $SRDescription->nativeDescription;	
}


$result = $service->AssignServiceToLogistics();

if($result){
	$url = $apiRootPath.'InsertServiceStatus.php';
	
		$data = array("serviceId" => $service->serviceId, "status" => $service->status, "logisticsId" => $service->logisticsId);		
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => json_encode($data), 
		    ),
		);			
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		if ($service->status=='picked_from_vendor') {

			$customerArray = array();
			$customerArray = explode(",",$service->customerId);
			$applianceArray = array();
			$applianceArray = explode("%2C",$service->appliance);
			$referenceNumberArray = array();
			$referenceNumberArray = explode(",",$service->referenceNumber);
			$serviceIdArray = array();
			$serviceIdArray = explode(",",$service->serviceId);
			
			foreach ($customerArray as $key=>$customerId){							
				//Firebase Notification				
				$url = $apiRootPath.'PassPushNotification.php?type=picked_from_vendor&customerId='.$customerId.'&referenceNumber='.$referenceNumberArray[$key].'&appliance='.$applianceArray[$key]."&logisticsNumber=".$service->logisticsNumber."&logisticsName=".$service->logisticsName;
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
				$data = array("serviceId" => $serviceIdArray[$key], "status" => $service->status, "customerId" => $customerId, "title" => $result->title,"vendorId"=>0,"message" => $result->notificationMessage,"logisticsId"=>0,"type"=>"picked_from_vendor","isActive"=>1,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage);
						
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
		}
		
  echo json_encode($service); //converting the output data into JSON
}else{
  echo json_encode($service); //converting the output data into JSON
}

?>

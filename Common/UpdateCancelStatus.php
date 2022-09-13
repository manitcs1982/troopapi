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


//This API not in use



$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$service = new Service($db);
$service->serviceId = $data->serviceId;
$service->status = $data->status;
$service->logisticsId = $data->logisticsId;
$service->customerId = $data->customerId;
$service->vendorId = $data->vendorId;
if(strtoupper($data->status)==strtoupper('cancelled')){
	$service->isCancelled = 1;	
}
$service->cancelledBy = $data->cancelledBy;
$service->cancelledStatus = $data->cancelledStatus;

$service->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$service->referenceNumber = $data->referenceNumber;
$service->appliance = urlencode($data->appliance);
$result = $service->UpdateCancelStatus();

if ($result) {
	
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
	
	if ($service->status=='picked_from_customer') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=picked_from_customer&customerId='.$service->customerId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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
	
		$data = array("serviceId" => $service->serviceId, "status" => $service->status, "customerId" => $service->customerId, "title" => $result->title,"vendorId"=>0,"message" => $result->notificationMessage,"logisticsId"=>0,"type"=>"picked_from_customer","isActive"=>1);		
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
	else if ($service->status=='under_inspection') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=under_inspection_vendor&vendorId='.$service->vendorId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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
	
		$data = array("serviceId" => $service->serviceId, "status" => $service->status,"type"=>"under_inspection_vendor" ,"vendorId" => $service->vendorId, "title" => $result->title,"message" => $result->notificationMessage,"logisticsId"=>0,"customerId" =>0,"isActive"=>1);		
		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => json_encode($data), 
			),
		);			
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		
		$customerArray = array();
		$customerArray = explode(",",$service->customerId);
		foreach ($customerArray as $customerId) {

			$url = $apiRootPath.'PassPushNotification.php?type=under_inspection_customer&customerId='.$customerId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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
	
			$data = array("serviceId" => $service->serviceId, "status" => $service->status, "customerId" => $service->customerId,"vendorId"=>0,"logistics"=>0,"type"=>"under_inspection_customer", "title" => $result->title,"message" => $result->notificationMessage,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage,"isActive"=>1);		
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
	else if ($service->status=='awaiting_for_confirmation') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=awaiting_for_confirmation&customerId='.$service->customerId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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
	
			$data = array("serviceId" => $service->serviceId, "status" => $service->status, "type"=>"awaiting_for_confirmation","customerId" => $service->customerId,"vendorId"=>0,"logistics"=>0, "title" => $result->title,"message" => $result->notificationMessage,"isActive"=>1);		
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
	else if ($service->status=='ready_to_fixed') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=ready_to_fixed&vendorId='.$service->vendorId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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

		$data = array("serviceId" => $service->serviceId, "status" => $service->status, "vendorId" => $service->vendorId,"logisticsId"=>0,"customerId"=>0,"type"=>"ready_to_fixed", "title" => $result->title,"message" => $result->notificationMessage,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage,"isActive"=>1);		
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
	else if ($service->status=='cancelled') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=cancel&vendorId='.$service->vendorId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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

		$data = array("serviceId" => $service->serviceId, "status" => $service->status, "vendorId" => $service->vendorId,"type"=>"cancel","logisticsId"=>0,"customerId"=>0, "title" => $result->title,"message" => $result->notificationMessage,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage,"isActive"=>1);		
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
	else if ($service->status=='fixed') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=fixed&customerId='.$service->customerId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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

		$data = array("serviceId" => $service->serviceId, "status" => $service->status, "customerId" => $service->customerId,"type"=>"fixed","vendorId"=>0,"logisticsId"=>0,"title" => $result->title,"message" => $result->notificationMessage,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage,"isActive"=>1);		
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
	else if ($service->status=='delivered') {
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=delivered&customerId='.$service->customerId.'&referenceNumber='.$service->referenceNumber.'&appliance='.$service->appliance;
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
	
		$data = array("serviceId" => $service->serviceId, "status" => $service->status, "customerId" => $service->customerId,"vendorId"=>0,"title" => $result->title,"message" => $result->notificationMessage,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage,"logisticsId"=>0,"type"=>"delivered","isActive"=>1);		
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

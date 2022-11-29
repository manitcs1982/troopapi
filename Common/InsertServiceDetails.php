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

$service->customerId = $data->customerId;
$service->customerProductId = $data->customerProductId;
$service->productId = $data->productId;
$service->addressId = $data->addressId;
$service->serviceCharge = $data->serviceCharge;
$service->otp = $data->otp;
$service->randomNumber = $data->randomNumber;
$service->status = $data->status;
$service->customerTotal = $data->customerTotal;
$service->vendorTotal = $data->vendorTotal;
$service->pickUpDate = $data->pickUpDate;
$service->pickUpSlot = $data->pickUpSlot;
$service->notes = $data->notes;
//$service->serviceCount = $data->serviceCount;
$service->appliance = urlencode($data->appliance);


if(isset($data->isTurnOn)){
	$service->isTurnOn = $data->isTurnOn;	
}else{
	$service->isTurnOn = "0";	
}
if(isset($data->tempServiceId)){
	$service->tempServiceId = $data->tempServiceId;
}else{
	$service->tempServiceId = 0;
}
$service->zoneId = $data->zoneId = 1;
//$service->logisticsId = 7 

$service->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

//To check the address is active and eligible in zone level
$url = $apiRootPath.'IsAddressEligible.php?addressId='.$service->addressId;
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET',		        
    ),
);		
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$isAddressEligible = json_decode($result);

if($isAddressEligible==1){

$service->isAddressEligible	=1;

if($data->isReopen==1){
	$service->vendorId = $data->vendorId;
}
else{
	$url = $apiRootPath.'GetAvailableVendor.php?zoneId='.$service->zoneId.'&productId='.$service->productId.'&date='.$service->pickUpDate;	
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'GET',		        
	    ),
	);		
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$availableVendor = json_decode($result);
	
	if($availableVendor->error != "No records found"){
		$service->vendorId = $availableVendor->vendorId;	
		$service->vendorBusinessOwnerName = $availableVendor->businessOwnerName;	
		$service->vendorBusinessName = $availableVendor->businessName;	
		$service->vendorPhoneNumber = $availableVendor->phone;	
	}else{
		//$service->error = "No available vendor";
		$service->vendorId = 0;	
		$service->vendorBusinessOwnerName = "";	
		$service->vendorBusinessName = "";	
		$service->vendorPhoneNumber = "";	
		//echo json_encode($service); //converting the output data into JSON
		//die;
	}
}


$url = $apiRootPath.'GetAvailableLogistics.php?date='.$service->pickUpDate;
$options = array(
'http' => array(
'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
'method'  => 'GET',
),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$availableLogistics = json_decode($result);

if ($availableLogistics->error != "No records found") {
	$service->logisticsId =$availableLogistics->id;
	$service->logisticsName =$availableLogistics->name;
	$service->logisticsPhoneNumber =$availableLogistics->phoneNumber;
} else {
	//$service->error = "No available logistics";
	$service->logisticsId = 0;
	$service->logisticsName = "";
	$service->logisticsPhoneNumber = "";
	//echo json_encode($service); //converting the output data into JSON
	//die;
}
	
//$service->vendorId = 97;	
//$service->logisticsId = 1;

$url = $apiRootPath.'GetServiceDescriptionByStatus.php?status='.$service->status;
$options = array(
'http' => array(
'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
'method'  => 'GET',
),);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$SRDescription = json_decode($result);

$service->statusDescription = '';
if ($SRDescription->error != "No records found") {
	$service->statusDescription = $SRDescription->description;	
	$service->statusNativeDescription = $SRDescription->nativeDescription;	
}

$result = $service->InsertServiceDetails();

$month=date('m');
$day=date('d');
//$acronym = preg_split("/\s+/", $service->appliance);

$words = explode(" ", urldecode($service->appliance));
$acronym = "";
foreach ($words as $w) {
	$acronym .= $w[0];
}

$service->referenceId="OF".$acronym.$day.$month.$service->serviceId;

$service->UpdatereferenceIdByServiceId();

if($result){
	
			$url = $apiRootPath.'UpdateAddressServiceCount.php';	
			$addressData = array("addressId" => $service->addressId);
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => json_encode($addressData), 
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
	
	    if($service->tempServiceId!=0){
	    	$url = $apiRootPath.'DeleteTempService.php';
	
			$tempSRData = array("tempServiceId" => $service->tempServiceId);		
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => json_encode($tempSRData), 
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);	
	    }
		//$itemDetails = explode(",", urldecode($data->serviceItems));		
		foreach($data->itemDetails as $item){			
			$url = $apiRootPath.'InsertServiceItem.php';
	
			$data = array("serviceId" => $service->serviceId, "productId" => $service->productId, "itemId" => $item->itemId,"isActive" => 1, "type"=>$item->type,"nativeName" => $item->nativeName,"name" => $item->name,"optionAnswer"=>$item->optionAnswer,"nativeOptionAnswer"=>$item->nativeOptionAnswer);	
						
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
		
		//Firebase Notification
		$url = $apiRootPath.'PassPushNotification.php?type=SRCreated&logisticsId='.$service->logisticsId.'&referenceNumber='.$service->referenceId.'&appliance='.$service->appliance;
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
		$data = array("serviceId" => $service->serviceId, "title" => $result->title, "status" => $service->status, "logisticsId" => $service->logisticsId,"vendorId"=>0,"message" => $result->notificationMessage,"customerId"=>0,"type"=>"SRcreated","isActive"=>1,"nativeTitle" => $result->nativeTitle,"nativeMessage" => $result->notificationNativeMessage);
		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => json_encode($data), 
			),
		);			
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		//print_r($result);
		
 		echo json_encode($service); //converting the output data into JSON
}else{
  echo json_encode($service); //converting the output data into JSON
}

}else{
	$service->isAddressEligible=0;
	$service->error = "Location is not serviceable, Please choose another location.";
	echo json_encode($service);
}
?>
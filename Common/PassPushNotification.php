<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/config.php';


$notificationDetails = json_decode(file_get_contents($apiRootPath.'GetNotificationByType.php?type='.$_GET['type']));
$data = json_decode(file_get_contents("php://input")); //Recieving input data

if(isset($data)){	    	
	$additionalJson = json_encode($data,true);	
}else{
	$additionalJson = '';
}


$notificationMessage = $notificationDetails->message;
$notificationNativeMessage = $notificationDetails->nativeMessage;
if (isset($_GET['referenceNumber'])) {
	$notificationMessage = str_replace("<No>",$_GET['referenceNumber'],$notificationMessage);
	$notificationNativeMessage = str_replace("<No>",$_GET['referenceNumber'],$notificationNativeMessage);
}
if (isset($_GET['appliance'])) {
	$notificationMessage = str_replace("<Appliance>",$_GET['appliance'],$notificationMessage);
	$notificationNativeMessage = str_replace("<Appliance>",$_GET['appliance'],$notificationNativeMessage);
}
if (isset($_GET['logisticsName'])) {
	$notificationMessage = str_replace("<logistics name>",$_GET['logisticsName'],$notificationMessage);
	$notificationNativeMessage = str_replace("<logistics name>",$_GET['logisticsName'],$notificationNativeMessage);
}
if (isset($_GET['logisticsNumber'])) {
	$notificationMessage = str_replace("<logistics ph no.>",$_GET['logisticsNumber'],$notificationMessage);
	$notificationNativeMessage = str_replace("<logistics ph no.>",$_GET['logisticsNumber'],$notificationNativeMessage);
}

$notificationDetails->notificationMessage = $notificationMessage;
$notificationDetails->notificationNativeMessage = $notificationNativeMessage;
$result= '';

if (strpos($notificationDetails->notificationPerson, 'L') !== false) {
	$apiKey = $logisticsApiKey; //from config
	//Get logistic details
	$logisticsDetails = json_decode(file_get_contents($apiRootPath.'GetLogisticsById.php?id='.$_GET['logisticsId']));
	
	$url = $apiRootPath.'SendPushNotification.php';
	$data = array("nativeTitle" => $notificationDetails->nativeTitle, "nativeMessage" => $notificationNativeMessage,"title" => $notificationDetails->title, "message" => $notificationMessage,"apiKey"=>$apiKey,"pushType"=>"individual","key"=>$logisticsDetails->tokenId,"language"=>$logisticsDetails->LanguageId,"deviceType"=>$logisticsDetails->DeviceType,"notificationType" => $notificationDetails->type,"additionalJson" => $additionalJson);
	$options = array(
				'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => json_encode($data),
						),
				);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);		
	
}else if (strpos($notificationDetails->notificationPerson, 'C') !== false) {
	$apiKey = $customerApiKey; //from config
	//Get logistic details
	$customerDetails = json_decode(file_get_contents($apiRootPath.'GetCustomerDetailsById.php?id='.$_GET['customerId']));	
	$url = $apiRootPath.'SendPushNotification.php';
	
	$data = array("nativeTitle" => $notificationDetails->nativeTitle, "nativeMessage" => $notificationNativeMessage,"title" => $notificationDetails->title, "message" => $notificationMessage,"apiKey"=>$apiKey,"pushType"=>"individual","key"=>$customerDetails->tokenId,"language"=>$customerDetails->LanguageId,"deviceType"=>$customerDetails->DeviceType,"notificationType" => $notificationDetails->type,"additionalJson" => $additionalJson);
	$options = array(
	'http' => array(
	'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	'method'  => 'POST',
	'content' => json_encode($data),
	),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);		
	
	
} else if (strpos($notificationDetails->notificationPerson, 'V') !== false) {
	$apiKey = $vendorApiKey; //from config
	//Get logistic details
	$vendorDetails = json_decode(file_get_contents($apiRootPath.'GetVendorDetailsById.php?vendorId='.$_GET['vendorId']));
		
	$url = $apiRootPath.'SendPushNotification.php';
	$data = array("nativeTitle" => $notificationDetails->nativeTitle, "nativeMessage" => $notificationNativeMessage,"title" => $notificationDetails->title, "message" => $notificationMessage,"apiKey"=>$apiKey,"pushType"=>"individual","key"=>$vendorDetails->tokenId,"language"=>$vendorDetails->LanguageId,"deviceType"=>$vendorDetails->DeviceType,"notificationType" => $notificationDetails->type,"additionalJson" => $additionalJson);
		
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

echo json_encode($notificationDetails);

?>

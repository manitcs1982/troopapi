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
include_once '../Objects/TemporaryService.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$tempService = new TemporaryService($db);

$tempService->customerId = $data->customerId;
$tempService->customerProductId = $data->customerProductId;
$tempService->productId = $data->productId;
$tempService->addressId = $data->addressId;
$tempService->status = $data->status;
$tempService->stage = $data->stage;
$tempService->pickUpDate = $data->pickUpDate;
$tempService->pickUpSlot = $data->pickUpSlot;
$tempService->notes = $data->notes;
$tempService->appliance = urlencode($data->appliance);

if(isset($data->isTurnOn)){
	$tempService->isTurnOn = $data->isTurnOn;	
}else{
	$tempService->isTurnOn = "0";	
}
$tempService->zoneId = $data->zoneId = 1;
//$tempService->logisticsId = 7 

$tempService->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

//only one Temp SR is eligible to create for particular Customer and product
$isEligibleResult = $tempService->IsTempServiceEligible();
if($row = $isEligibleResult->fetch(PDO::FETCH_ASSOC)){	
	extract($row);
	if($TempSRCount>=1){
		/* $tempService->error = "You can create only one draft SR for this product.";
		echo json_encode($tempService);
		die;
		*/
		$tempService->notes = $data->notes;
		$url = $apiRootPath.'UpdateTemporaryServiceDetails.php';
	
		//$data = array("tempServiceId" => $tempService->tempServiceId, "productId" => $tempService->productId, "itemId" => $item->itemId,"isActive" => 1, "type"=>$item->type,"name" => $item->name,"optionAnswer"=>$item->optionAnswer,"nativeName" => $item->nativeName,"nativeoptionAnswer"=>$item->nativeOptionAnswer);		
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => json_encode($data), 
		    ),
		);		
		echo json_encode($tempService);	
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);	
		die;
	}
}

$result = $tempService->InsertTempServiceDetails();

if($result){
		//$itemDetails = explode(",", urldecode($data->serviceItems));		
		foreach($data->itemDetails as $item){				
			$url = $apiRootPath.'InsertTempServiceItem.php';
	
			$data = array("tempServiceId" => $tempService->tempServiceId, "productId" => $tempService->productId, "itemId" => $item->itemId,"isActive" => 1, "type"=>$item->type,"name" => $item->name,"optionAnswer"=>$item->optionAnswer,"nativeName" => $item->nativeName,"nativeoptionAnswer"=>$item->nativeOptionAnswer);		
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
		
 		echo json_encode($tempService); //converting the output data into JSON
}else{
  echo json_encode($tempService); //converting the output data into JSON
}


?>
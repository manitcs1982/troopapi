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

$url = $apiRootPath.'GetServiceDetailsByServiceId.php?serviceId='.$data->serviceId;		
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET',		        
    ),
);			
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$serviceDetails = json_decode($result);

$serviceItemArray = array();
$serviceItems = new stdClass();

foreach($serviceDetails[0]->serviceItems as $item){
	$serviceItems->itemId = $item->itemId;
	$serviceItems->name = $item->name;
	$serviceItems->optionAnswer = $item->optionAnswer;
	$serviceItems->nativeName = $item->nativeName;
	$serviceItems->nativeOptionAnswer = $item->nativeOptionAnswer;
	$serviceItems->type = $item->type;
	array_push($serviceItemArray,$serviceItems);
}

$url = $apiRootPath.'InsertServiceDetails.php';
	
$data = array("addressId"=> $serviceDetails[0]->customerAddressId,"appliance"=> strtoupper($serviceDetails[0]->productDetails->name), "customerId"=> $serviceDetails[0]->customerId,"customerProductId"=> $serviceDetails[0]->customerProductId,"customerTotal"=> $serviceDetails[0]->customerTotal,"isTurnon"=> $serviceDetails[0]->isTurnOn,"itemDetails"=> $serviceItemArray,"notes"=> $serviceDetails[0]->notes,"otp"=> $data->otp,"pickUpDate"=> $data->pickUpDate,"pickUpSlot"=> $data->pickUpSlot,"productId"=> $serviceDetails[0]->productId,"randomNumber"=> $data->randomNumber,"serviceCharge"=> $serviceDetails[0]->serviceCharge,"status"=> "sr_created","vendorId"=> $serviceDetails[0]->vendorId,"vendorTotal"=> $serviceDetails[0]->vendorTotal,"isReopen"=> "1");		

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => json_encode($data), 
    ),
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$srResult = json_decode($result);

if($srResult->error == ''){
	$db = $database->GetServiceConnection();
	$service = new Service($db);
	$service->serviceId = $srResult->serviceId;
	$service->isReopened = 1;
	$service->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

	$result = $service->UpdateServiceReopen();	
	if ($result) {  
	  echo json_encode($srResult); //converting the output data into JSON
	}else{
	  echo json_encode($srResult); //converting the output data into JSON
	}
}else{
	echo json_encode($srResult);
}

?>

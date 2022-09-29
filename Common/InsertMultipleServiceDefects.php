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
include_once '../Objects/ServiceDefects.php';
include_once '../Objects/Service.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetServiceConnection();

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$loopCount = 0;
$serviceDefectsArray = array();

$vendorPrice = 0;
$customerPrice = 0;
$vendorDisplayPrice = 0;
$customerDisplayPrice = 0;
foreach($data as $defects){	
	$serviceDefects = new ServiceDefects($db);

	$serviceDefects->serviceId = $defects->serviceId;
	$serviceDefects->productId = $defects->productId;
	$serviceDefects->vendorPrice = $defects->quantity*$defects->vendorPrice;
	$serviceDefects->customerPrice = $defects->quantity*$defects->customerPrice;
	$serviceDefects->status = $defects->status;
	$serviceDefects->quantity = $defects->quantity;
	if($defects->imageUrl!=''){
		$name = pathinfo(parse_url($url)['path'], $defects->imageUrl);
		$ext = pathinfo(parse_url($url)['path'], $defects->imageUrl);
		$serviceDefects->imageUrl = $name.'.'.$ext;
	}else{
		$serviceDefects->imageUrl = '';
	}
	
	$serviceDefects->imageDescription = $defects->imageDescription;
	$serviceDefects->GSTPercentage = $defects->GSTPercentage;
	$serviceDefects->customerDisplayPrice = $defects->quantity*$defects->customerDisplayPrice;
	$serviceDefects->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
	$vendorPrice= $vendorPrice + $serviceDefects->vendorPrice;
	$customerPrice = $customerPrice + $serviceDefects->customerPrice;	
	$customerDisplayPrice = $customerDisplayPrice + $serviceDefects->customerDisplayPrice;
	$result = $serviceDefects->InsertServiceDefects();	
	
	if($result){
	  $loopCount++;	
	  array_push($serviceDefectsArray,$serviceDefects);	  
	}else{
	  $serviceDefects->error = $serviceDefects->error . " Error";
	  array_push($serviceDefectsArray,$serviceDefects);
	}		
}


if(count($data)===$loopCount){
	

	$db = $database->GetServiceConnection();
	$service = new Service($db);  
	$service->serviceId = $data[0]->serviceId;	
	$service->customerTotal = $customerPrice;
	$service->vendorTotal = $vendorPrice;
	$service->customerDisplayPrice = $customerDisplayPrice;	
	$service->deliveryFee = 70.8;
	$service->serviceCharge = 0;	
	$service->GSTAmount = 0;	//already added
	$service->customerGrandTotal = $customerDisplayPrice + $service->deliveryFee;	
	$service->customerDisplayTotal = $customerDisplayPrice;
	$service->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
	
	$result = $service->UpdateServiceAmount();
	
  echo json_encode($serviceDefectsArray); //converting the output data into JSON
}else{
  echo json_encode($serviceDefectsArray); //converting the output data into JSON
}

?>
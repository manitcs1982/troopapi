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

$db = $database->GetServiceConnection();
$service = new Service($db);
$service->serviceId = $_GET['serviceId'];
	
$FinalDiscountList = array();

 $url = $apiRootPath.'GetEarlyBirdDiscount.php?serviceId='.$service->serviceId;

			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'GET',		        
			    ),
			);	
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$t = json_decode($result, true);
//echo $t;
if ($t != "" && $t != null) {
	if ($t['isDiscountAvailable'] == 1) {
		array_push($FinalDiscountList, $t);
	}
}

$url = $apiRootPath.'GetServiceDiscountDetailsbyServiceId.php?serviceId='.$service->serviceId;

		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'GET',		        
		    ),
		);
$emptyArray = [];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);	
	//echo $result;
$AllSRDiscount = json_decode($result, true);


if($AllSRDiscount[0]['error'] != "No records found"){
	array_push($FinalDiscountList,$AllSRDiscount[0]);	
	echo json_encode($FinalDiscountList);	
}
else{
	echo json_encode($FinalDiscountList);
}








?>
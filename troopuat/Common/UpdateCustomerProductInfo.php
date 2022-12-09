<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/database.php'; include_once '../Config/config.php';
include_once '../Objects/CustomerProductInfo.php';
include_once '../Common/ImageUploadToDisk.php';

$database = new Database(); //Declaring object for database class

$dataset = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetCustomerProductConnection();

$outputArray = array();
foreach($dataset as $data){
		
	$customerProductInfo = new CustomerProductInfo($db);

	$customerProductInfo->customerProductInfoId = $data->customerProductInfoId;
	$customerProductInfo->productId = $data->productId;
	$customerProductInfo->customerId = $data->customerId;
	$customerProductInfo->productInfoId = $data->productInfoId;
	$customerProductInfo->answer = $data->answer;
	$customerProductInfo->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
		
	if ($data->isImage) {
		$fileName = $customerProductInfo->customerProductInfoId.'_CPIImage';
		$imgUpload = imageUploadToDisk($data->answer,$customerProductPath,$fileName);		
		if ($imgUpload) {
			$customerProductInfo->answer = $imgUpload;			
		}
	}

	$result = $customerProductInfo->UpdateCustomerProductInfo();
	if ($data->isImage) {
		$customerProductInfo->answer = $customerProductDBPath.$imgUpload;
	}
	if($result){
	  array_push($outputArray,$customerProductInfo); //converting the output data into JSON
	}else{
	  array_push($outputArray,$customerProductInfo); //converting the output data into JSON
	}
}

echo json_encode($outputArray);
?>
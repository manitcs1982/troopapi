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

$dataSet = json_decode(file_get_contents("php://input")); //Recieving input data

$outputArray = array();

$url = $apiRootPath.'InsertCustomerProduct.php';
$data = array("customerId" => $dataSet[0]->customerId, "productId" => $dataSet[0]->productId, "status" => "1");		
$options = array(
 "ssl"=>array(
	        "verify_peer"=>false,
	        "verify_peer_name"=>false,
	     ),
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
       
        'content' => json_encode($data), 
    ),
);	
		
$context  = stream_context_create($options);
$result2 = file_get_contents($url, false, $context);	
print_r($result2);
$customerProductId = json_decode($result2)->customerProductId;

foreach ($dataSet as $data) {
	$answer = '';
	if ($data->isImage) {
		$answer = '';
	} else {
		$answer = $data->answer;
	}

	$db = $database->GetCustomerProductConnection();
	$customerProductInfo = new CustomerProductInfo($db);

	$customerProductInfo->productId = $data->productId;
	$customerProductInfo->customerId = $data->customerId;
	$customerProductInfo->customerProductId = $customerProductId;
	$customerProductInfo->productInfoId = $data->productInfoId;
	$customerProductInfo->isImage = $data->isImage;
	$customerProductInfo->answer = $answer;
	$customerProductInfo->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
	$customerProductInfo->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

	$result = $customerProductInfo->InsertCustomerProductInfo();
	
	if ($data->isImage) {
		$fileName = $customerProductInfo->customerProductInfoId.'_CPIImage';
		$imgUpload = imageUploadToDisk($data->answer,$customerProductPath,$fileName);
		if ($imgUpload) {			
			$customerProductInfo->answer = $imgUpload;
			$customerProductInfo->UpdateCustomerProductInfo();
		}
	}
	

	if ($result) {
		array_push($outputArray,$customerProductInfo); //converting the output data into JSON
	} else {
		array_push($outputArray,$customerProductInfo); //converting the output data into JSON
	}

}
echo json_encode($outputArray);
?>

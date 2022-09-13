<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/database.php';
include_once '../Objects/ProductInfo.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetProductConnection();


function my_error_handler($errorNo, $errorMsg, $fileName, $lineNo)
{
	$database = new Database(); //Declaring object for database class
	$db = $database->GetProductConnection();
	$productInfo = new ProductInfo($db);
    $productInfo->error ="Error No: ".$errorNo." Error Msg: ".$errorMsg." in line no ".$lineNo." in ".$fileName;	  
    echo json_encode($productInfo); 	
  	die;
}
set_error_handler("my_error_handler");

$productInfo = new ProductInfo($db);
$productInfo->productInfoId = $data->productInfoId;
$productInfo->productId    = $data->productId;
$customerProductInfo->customerId = $data->customerId;
$productInfo->question = $data->question;
$productInfo->type = $data->type;
$productInfo->answer = $data->answer;
$productInfo->status = $data->status;
$productInfo->minLength = $data->minLength;
$productInfo->maxLength = $data->maxLength;
$productInfo->isFloat = $data->isFloat;
$productInfo->nativeQuestion = $data->nativeQuestion;
$productInfo->nativeAnswer = $data->nativeAnswer;
$productInfo->placeHolder = $data->placeHolder;
$productInfo->nativePlaceHolder = $data->nativePlaceHolder;
$productInfo->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $productInfo->UpdateProductInfo();

if($result){
  echo json_encode($productInfo); //converting the output data into JSON
}else{
  echo json_encode($productInfo); //converting the output data into JSON
}

?>

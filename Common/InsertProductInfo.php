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
include_once '../Objects/ProductInfo.php';
include_once '../Common/UploadImage.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetProductConnection();
$productInfo = new ProductInfo($db);
				
$productInfo->productId    = $data->productId;
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
$productInfo->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $productInfo->InsertProductInfo();

if($result){
 echo json_encode($productInfo); //converting the output data into JSON
}else{
  echo json_encode($productInfo); //converting the output data into JSON
}
?>
		
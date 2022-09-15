<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/database.php';
include_once '../Objects/Product.php';
include_once '../Common/UploadImage.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetProductConnection();


function my_error_handler($errorNo, $errorMsg, $fileName, $lineNo)
{
	$database = new Database(); //Declaring object for database class
	$db = $database->GetProductConnection();
	$product = new Product($db);
    $product->error ="Error No: ".$errorNo." Error Msg: ".$errorMsg." in line no ".$lineNo." in ".$fileName;	  
    echo json_encode($product); 	
  	die;
}
set_error_handler("my_error_handler");

$product = new Product($db);
$product->productId = $_GET['productId'];
$product->name = $_GET['name'];
echo $product->imageUrl = $_GET['imageUrl'];
$product->description = $_GET['description'];
$product->status = $_GET['status'];
$product->nativeName = $_GET['nativeName'];
$product->nativeDescription = $_GET['nativeDescription'];
$product->nativeNote =  $_GET['nativeNote'];
$product->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $product->UpdateProduct();

if (isset($_FILES['file'])) {
	echo "**";
	$file_name = $_FILES['file']['name'];
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	
	$currentDirectory = getcwd();
	$imageDirectory = str_replace("Common","Images/Product/",$currentDirectory);
	
	//$imageDirectory = "http://13.233.85.98/Troop/Images//Product/";
	$imageDirectory = $imageDirectory.$product->productId."_product.".$extension;
	//$imageUrl = $imageDirectory.".".$extension;
	$isUploaded = UploadImage($_FILES['file'],$imageDirectory);
	if($isUploaded==1) {
		$product->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
		$product->imageUrl = "http://13.233.85.98/Troop/Images/Product/".$product->productId."_product.".$extension;
		$result = $product->UpdateProduct();		
	}else{
		$product->error = $isUploaded;
	}
}

if($result){
  echo json_encode($product); //converting the output data into JSON
}else{
  echo json_encode($product); //converting the output data into JSON
}

?>

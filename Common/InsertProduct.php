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
include_once '../Objects/Product.php';
include_once '../Common/UploadImage.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetProductConnection();
$product = new Product($db);

$product->name    = $_GET['name'];
$product->description = $_GET['description'];
$product->imageUrl = '';
$product->status = $_GET['status'];
$product->nativeName = ''; //$_GET['nativeName'];
$product->nativeDescription =''; // $_GET['nativeDescription'];
$product->isTurnOnRequired =''; // $_GET['isTurnOnRequired'];
$product->nativeNote = ''; //$_GET['nativeNote'];

/*
$product->name    = $_GET['name'];
$product->description = 'description';
$product->imageUrl = '';
$product->status = '1';
*/
$product->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));


$result = $product->InsertProduct();

if (isset($_FILES['file'])) {
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
		
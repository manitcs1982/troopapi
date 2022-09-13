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
include_once '../Objects/CustomerProduct.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetCustomerProductConnection();
$customerProduct = new CustomerProduct($db);

$customerProduct->customerId = $data->customerId;
$customerProduct->productId = $data->productId;
/*
//$customerProduct->imageUrl = $data->imageUrl;
$customerProduct->phoneNumber = $data->phoneNumber;
$customerProduct->name = $data->name;
$customerProduct->capacity = $data->capacity;
$customerProduct->notes = $data->notes;
$customerProduct->productName = $data->productName;
$customerProduct->model = $data->model;
$customerProduct->brand = $data->brand;
$customerProduct->manDate = $data->manDate;
*/
$customerProduct->status = $data->status;
$customerProduct->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $customerProduct->InsertCustomerProduct();

/*
if (isset($_FILES['file'])) {
	$file_name = $_FILES['file']['name'];

	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

	$currentDirectory = getcwd();
	$imageDirectory = str_replace("Common","Images/CustomerProduct/",$currentDirectory);

	//$imageDirectory = "http://13.233.85.98/Troop/Images//CustomerProduct/";
	echo $imageDirectory = $imageDirectory.$product->productId."_CustomerProduct.".$extension;
	//$imageUrl = $imageDirectory.".".$extension;
	$isUploaded = UploadImage($_FILES['file'],$imageDirectory);
	if ($isUploaded==1) {
		$product->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
		$product->imageUrl = "https://www.oncefyxd.com/Troop/Images/CustomerProduct/".$product->productId."_CustomerProduct.".$extension;
		$result = $product->UpdateProduct();
	} else {
		$product->error = $isUploaded;
	}
}
*/
if($result){
  echo json_encode($customerProduct); //converting the output data into JSON
}else{
  echo json_encode($customerProduct); //converting the output data into JSON
}

?>

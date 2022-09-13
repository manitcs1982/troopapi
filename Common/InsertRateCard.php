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
include_once '../Objects/RateCard.php';
include_once '../Common/UploadImage.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetRateCardConnection();
$rateCard = new RateCard($db);

$rateCard->productId = $_GET['productId'];
$rateCard->imageUrl = '';
$rateCard->imageDescription =$_GET['imageDescription'];
$rateCard->userDescription = $_GET['userDescription'];
$rateCard->vendorPrice = $_GET['vendorPrice'];
$rateCard->customerPrice = $_GET['customerPrice'];
$rateCard->status = $_GET['status'];
$rateCard->quantity = $_GET['quantity'];
$rateCard->nativeImageDescription = $_GET['nativeImageDescription'];
$rateCard->nativeUserDescription = $_GET['nativeUserDescription'];
$rateCard->GSTPercentage = $_GET['GSTPercentage'];
$rateCard->GSTPrice = $_GET['GSTPrice'];
$rateCard->customerDisplayPrice = $_GET['customerDisplayPrice'];
$rateCard->customerPricePercentage = $_GET['customerPricePercentage'];
$rateCard->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $rateCard->InsertRateCard();

if (isset($_FILES['file'])) {
	$file_name = $_FILES['file']['name'];
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

	$currentDirectory = getcwd();
	$imageDirectory = str_replace("Common","Images/Defect/",$currentDirectory);
	
	//$imageDirectory = "http://13.233.85.98/Troop/Images/RateCard/";
	
	$imageDirectory = $imageDirectory.$rateCard->id."_".$rateCard->productId."_defect.".$extension;
	//$imageUrl = $imageDirectory.".".$extension;
	$isUploaded = UploadImage($_FILES['file'],$imageDirectory);
	if ($isUploaded==1) {
		$rateCard->modifiedOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));
		$rateCard->imageUrl = "http://13.233.85.98/Troop/Images/Defect/".$rateCard->id."_".$rateCard->productId."_defect.".$extension;
		$result = $rateCard->UpdateRateCard();
	} else {
		$rateCard->error = $isUploaded;
	}
}

if($result){
 echo json_encode($rateCard); //converting the output data into JSON
}else{
  echo json_encode($rateCard); //converting the output data into JSON
}

?>
		
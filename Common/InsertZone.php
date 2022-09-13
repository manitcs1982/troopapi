<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../Config/database.php';
include_once '../Objects/Zone.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetZoneConnection();
$zone = new Zone($db);
function my_error_handler($errorNo, $errorMsg, $fileName, $lineNo)
{
	$database = new Database(); //Declaring object for database class
	$db = $database->GetZoneConnection();
	$zone = new Zone($db);
    $zone->error ="Error No: ".$errorNo." Error Msg: ".$errorMsg." in line no ".$lineNo." in ".$fileName;	  
    echo json_encode($zone); 	
  	die;
}
set_error_handler("my_error_handler");

$zone->zoneId = $data->zoneId;
$zone->name = $data->name;
$zone->zipCode = $data->zipCode;
$zone->status = $data->status;
$zone->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));



$result = $zone->InsertZone();

if($result){
 echo json_encode($zone); //converting the output data into JSON
}else{
  echo json_encode($zone); //converting the output data into JSON
}

?>
		
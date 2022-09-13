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
include_once '../Objects/PincodeMaster.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetPincodeMasterConnection();

$Pincode = new Pincode($db);

$Pincode->pincodeName = $_GET['pincodeName'];


$result = $Pincode->GetCheckPincodeValidation();
$database->CloseConnection();
if($result){
  $num = $result->rowCount();
//echo $result;
  // check if more than 0 record found
  if($num>0){
    
//       //Fetching the result data from result object
//       while ($row = $result->fetch(PDO::FETCH_ASSOC))
//       {
		  
//           extract($row);
//         //   print_r($row); 
//         //   echo $PIN_pincode;
         
		  		  

// // $Pincode->pincodeName = $PIN_pincode;
// if($Pincode->pincodeName == $PIN_pincode){
//     echo("1");

// }else{
//     echo("2");
// }

echo("1");

		  		  
     
    
    //   echo json_encode($Pincode); 
	  //converting the output data into JSON
  }else{
  	 echo("0");
  }
}else{
  echo json_encode($Pincode); //converting the output data into JSON
}

?>
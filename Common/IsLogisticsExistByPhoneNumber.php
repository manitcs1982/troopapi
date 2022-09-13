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
include_once '../Objects/Logistics.php';

$database = new Database(); //Declaring object for database class
$db = $database->GetLogisticsConnection();

$logistics = new Logistics($db);
//$logistics->phoneNumber = $data->phoneNumber = '7353504390';
$logistics->phoneNumber = $_GET['phoneNumber'];

$result = $logistics->IsLogisticsExistByPhoneNumber();

if($result){
  $num = $result->rowCount();

  // check if more than 0 record found
  if($num>0){
  
      //Fetching the result data from result object
      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);
          $logistics->isExist = $isExist;          
          echo json_encode($logistics); 
      }   
  }
}else{
  echo json_encode($logistics); //converting the output data into JSON
}

?>
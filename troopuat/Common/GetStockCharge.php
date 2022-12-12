<?php
use function GuzzleHttp\json_encode;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

date_default_timezone_set('Asia/Kolkata');
//echo date('d-m-Y H:i');
$startDateTime = $_GET['startDateTime'];
$endDateTime = $_GET['endDateTime'];
//$endDateTime = time();
$startTimestamp= strtotime($startDateTime);
$endTimestamp= strtotime($endDateTime);
$duration = round(abs($startTimestamp-$endTimestamp)/60/60);
$stockCharge = $duration * 10;
$data = array("StockCharge" => $stockCharge, "Duration" => $duration);
header("Content-Type: application/json");
echo \json_encode($data,true);
?>
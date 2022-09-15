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
include_once '../Config/config.php';
include_once '../Objects/Service.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$service = new Service($db);

$auth = base64_encode("rzp_test_bnd95CmdiBSRc9:sJJzTDMFT8xiAiwAmUejv6RE");
$context = stream_context_create([
    "http" => [
        "header" => "Authorization: Basic $auth"
    ]
]);
$homepage = file_get_contents("https://api.razorpay.com/v1/payments/pay_InxsPkRleRouRs", false, $context );

//https://api.razorpay.com/v1/payments/pay_InxsPkRleRouRs?username=rzp_test_bnd95CmdiBSRc9&password=sJJzTDMFT8xiAiwAmUejv6RE
echo $homepage;

?>
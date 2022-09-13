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
include_once '../Objects/Payment.php';

$database = new Database(); //Declaring object for database class

$data = json_decode(file_get_contents("php://input")); //Recieving input data

$db = $database->GetServiceConnection();
$payment = new Payment($db);

$paymentUrl = "https://api.razorpay.com/v1/payments/".$data->paymentIdValue;
$auth = base64_encode("rzp_live_lE9TYaOHSgBucU:GR5K58cCqiUcLeWnFo3kPASc");
$context = stream_context_create([
    "http" => [
        "header" => "Authorization: Basic $auth"
    ]
]);
$razorResponse = json_decode(file_get_contents($paymentUrl, false, $context ));

$payment->serviceId = $data->serviceId;
$payment->customerId = $data->customerId;
$payment->vendorId = $data->vendorId;
$payment->logisticsId = $data->logisticsId;
$payment->referenceNumber = $data->referenceNumber;
$payment->customerTotal = $data->customerTotal;
$payment->paymentStatus  = $data->paymentStatus;
$payment->isActive  = $data->isActive;

$payment->paymentIdValue = $razorResponse->id;
$payment->paidAmount  = $razorResponse->amount / 100;
$payment->description  = $razorResponse->description;
$payment->paymentMethod  = $razorResponse->method;

$payment->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $payment->InsertPaymentDetails();

if($result){
 echo json_encode($payment); //converting the output data into JSON
}else{
  echo json_encode($payment); //converting the output data into JSON
}
?>
		
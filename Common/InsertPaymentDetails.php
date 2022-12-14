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
if($data->customerTotal == ''){
	$payment->customerTotal = 0;
}else{
	$payment->customerTotal = $data->customerTotal;
}
$payment->paymentStatus  = $data->paymentStatus;
if($data->isActive == ''){
	$payment->isActive  = 0;
}else{
	$payment->isActive  = $data->isActive;
}
$payment->paymentIdValue = $razorResponse->id;
$payment->paidAmount  = $razorResponse->amount / 100;
$payment->description  = $razorResponse->description;
$payment->paymentMethod  = $razorResponse->method;

$payment->createdOn = htmlspecialchars(strip_tags(date('Y/m/d H:i:s', time())));

$result = $payment->InsertPaymentDetails();
if(isset($data->discountDetails)){
	foreach($data->discountDetails as $discount){
			$url = $apiRootPath.'InsertServiceDiscount.php';
			
			$data = array("serviceId" => $payment->serviceId, "discountMasterId" => $discount->discountMasterId, "name" => $discount->name,"isActive" => 1, "description"=>$discount->description,"amount" => $discount->amount,"name" => $discount->name);	
						
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => json_encode($data), 
			    ),
			);			
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);			
	}
}
if($result){
 echo json_encode($payment); //converting the output data into JSON
}else{
  echo json_encode($payment); //converting the output data into JSON
}
?>
		
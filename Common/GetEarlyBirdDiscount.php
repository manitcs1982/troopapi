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
include_once '../Objects/Service.php';


$database = new Database(); //Declaring object for database class



$db = $database->GetServiceConnection();
$service = new Service($db);
$service->serviceId = $_GET['serviceId'];

$url = $apiRootPath . 'GetAllServicesStatusByServiceId.php?type=awaiting_for_confirmation&serviceId=' . $service->serviceId;
$options = array(
	'http' => array(
		'header' => "Content-type: application/x-www-form-urlencoded\r\n",
		'method' => 'GET',
	),
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);


$userPersonalData = json_decode($result, true);
$date = date('Y/m/d H:i:s', time());
$discountAmount = 0;
$isDiscountAvailable = "0";
//echo $date;
foreach ($userPersonalData as $array) {
	// print_r($array);

	if ($array['status'] == 'ready_to_fixed') {
		$to_time = strtotime($array['date']);
		$from_time = strtotime($date);
		$minutes = round(abs($to_time - $from_time) / 60, 2) . " minute";
		//echo $minutes;
		if (((int) date($minutes)) >= 120) {
			$isDiscountAvailable = "0";


		} else {
			$isDiscountAvailable = "1";

			$url = $apiRootPath . 'GetDiscountMasterByName.php?discountName=EarlyBird';
			$options = array(
				'http' => array(
					'header' => "Content-type: application/x-www-form-urlencoded\r\n",
					'method' => 'GET',
				),
			);


			$context = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			$t = json_decode($result, true);
			//echo $t['discountAmount'];
			if (((int) date($minutes)) >= 120) {
                $discountAmount = 0;
			} else {
				$discountAmount = $t['discountAmount'];
				$discountName = $t['discountName'];
				$discountReason = $t['discountReason'];
				$discountDescription = $t['discountDescription'];
				$discountPercentage = $t['discountPercentage'];
			}


		}
		$data = array("isDiscountAvailable" => $isDiscountAvailable, "discountAmount" => $discountAmount,
		"discountName" => $discountName,"discountReason" => $discountReason,"discountDescription" => $discountDescription,
		"discountPercentage" => $discountPercentage);
		header("Content-Type: application/json");
		echo json_encode($data);



	}

}
;

?>
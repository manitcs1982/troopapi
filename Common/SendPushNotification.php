<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Objects/Firebase.php';
include_once '../Objects/FirebasePush.php';

$data = json_decode(file_get_contents("php://input")); //Recieving input data
$firebase = new Firebase();

$push = new Push();

// optional payload
$payload = array();
$title=''; $message='';

if(strtolower($data->language)=='english'){
	// notification title
	$title = $data->title;
	// notification message
	$message = $data->message;

}else if(strtolower($data->language)=='tamil'){
	// notification title
	$title = $data->nativeTitle;
	// notification message
	$message = $data->nativeMessage;
}

$notificationType = $data->notificationType;
$additionalJson = $data->additionalJson;


// push type - single user / topic
$push_type = $data->pushType; 

$apiKey = $data->apiKey;

$push->setImage('');


$push->setTitle($title);
$push->setMessage($message);
$push->setNativeTitle($title);
$push->setNativeMessage($message);
$push->setNotificationType($notificationType);
$push->setAdditionalJson($additionalJson);

/*
// whether to include to image or not
$include_image = $data->includeImage;
if ($include_image) {
    $push->setImage('https://api.androidhive.info/images/minion.jpg');
} else {
    $push->setImage('');
}
*/


$push->setIsBackground(FALSE);
$push->setPayload($payload);


$json = '';
$response = '';

if ($push_type == 'topic') {
    $json = $push->getPush();
	$response = $firebase->sendToTopic('global', $json,$apiKey);
} else if ($push_type == 'individual') {    
	$regId = $data->key;	
	$json = $push->getPush();		
	if(strtolower($data->deviceType)=='android'){			
		$response = $firebase->send($regId, $json,$apiKey,$additionalJson);		
	}else if(strtolower($data->deviceType)=='ios'){		
		$response = $firebase->sendForIOS($regId, $title,$message,$apiKey,$json,$additionalJson);		
	}	
} else if ($push_type == 'multiple') {
	$json = $push->getPush();
	$temp = array();
	$temp = $data->key;
	$regIds = $temp;
	$response = $firebase->sendMultiple($regIds, $json,$apiKey);
}

print_r($response);
if($response){
  //echo true;
}else{
  echo false;
}

?>

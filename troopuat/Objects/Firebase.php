<?php
include_once '../Config/config.php';
class Firebase {
      
    // sending push message to single user by firebase reg id
	public function send($to, $message, $apiKey)
	{		

        $fields = array(
            'to' => $to,            
            'data' => $message,
        );        
		return $this->sendPushNotification($fields,$apiKey);

    }
    
    // sending push message to single user by firebase reg id
	public function sendForIOS($to, $title, $message, $apiKey,$json)
	{		
        $notification = [
            'title' =>$title,
            'body' => $message,
            'icon' =>'myIcon', 
            'sound' => 'default',
            'data' => $json            
        ];
        $fields = array(
            'to' => $to,
            'notification' => $notification,
            //'data' => $json,
        );        
        
		return $this->sendPushNotification($fields,$apiKey);
    }
 
    // Sending message to a topic by topic name
	public function sendToTopic($to, $message, $apiKey)
	{		
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
		return $this->sendPushNotification($fields,$apiKey);
    }
 
    // sending push message to multiple users by firebase registration ids
	public function sendMultiple($registration_ids, $message, $apiKey)
	{
        $fields = array(
		'registration_ids' => $registration_ids,
        'data' => $message,
        );
		
		return $this->sendPushNotification($fields,$apiKey);
    }
 
    // function makes curl request to firebase servers
	private function sendPushNotification($fields, $apiKey)
	{		 
		$FIREBASE_API_KEY = $apiKey;
		//'AAAAuPOGh1k:APA91bFhZSLShbbq2rgNK2ROeRdjP82xZR-JQw0rWgNtOfGGCLn4dGku9PjQgk71ze92jcDw52zxGD7DjjkJgMb245Jc9OvTr7bMH1knWKw6YpKO1WlVgpSseFOFVZ5Wh5fznKZqa1U3';      
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=' . $FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }
    
}
?>
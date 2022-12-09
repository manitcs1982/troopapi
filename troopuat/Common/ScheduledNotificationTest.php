<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
echo "aa";

$res = array();
        $res['title'] = "Christmas Offer";       
        $res['message'] =  "Grab 90% Discount on Mobile Phones";
        $res['body'] =  "Grab 90% Discount on Mobile Phones";
        
        $res['notificationType'] = "customized";
        //$res['additionalJson'] = $this->additionalJson;
        //$res['image'] = $this->image;
        $payload = array();
       // $res['payload'] = $payload;
        //$res['timestamp'] = date('Y-m-d G:i:s');
        $res['isScheduled'] = "true";
        $res['scheduledTime'] = "2022-11-15 19:35:00";  
        $res['timestamp'] = "2022-11-15 19:40:00";  
        $res['icon'] ='myIcon';
        $res['sound'] = 'default';
$fields = array(
            'to' =>'ck6nN3PCjEmutuxkxbCjbV:APA91bGzXp5HCvSsH70BRIdLsd3jsY-Qe_bcP-car9KeY30LXhM2lb5laUkGC1Tfe6oNQcv0900Nv800-FWijRtW8QSLTYZA2ZmCT6d0uR28W-wyaPn0a1ng4ayyX4hyJVvrEvpXx26t',
           // 'data' => $res,
           'notification' => $res
           
        ); 


$FIREBASE_API_KEY = "AAAAuPOGh1k:APA91bFhZSLShbbq2rgNK2ROeRdjP82xZR-JQw0rWgNtOfGGCLn4dGku9PjQgk71ze92jcDw52zxGD7DjjkJgMb245Jc9OvTr7bMH1knWKw6YpKO1WlVgpSseFOFVZ5Wh5fznKZqa1U3";

		     
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=' . $FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        
    
        print_r($fields);
        
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
        
        print_r($result);
        
        echo "success";


?>

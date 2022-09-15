<?php
 //$apiRootPath = "https://www.oncefyxd.com/Troop/Common/";
 $apiRootPath = "http://13.233.85.98/Troop/Common/";
 //$apiRootPath = "http://localhost:80/Troop/Common/";
 
 //date_default_timezone_set('Asia/Kolkata');
 date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
 
 //Duration when the Service needs to return for Logistics
 $startTimeMorning = '07:00';
 $startTimeEvening = '12:00';
 $endTimeMorning = '16:00';
 $endTimeEvening = '21:00';
 
 //statusList
 $srCreated = 'sr_created';
 $picked = 'picked_from_customer';
 $fixed = 'fixed';
 $scheduled_for_drop = "scheduled_for_drop";
 
 $testScheduleSlot = "Morning";
 $testScheduleDate = '2020-12-31';
 
 //Firebase Notification
 $customerApiKey = "AAAAuPOGh1k:APA91bFhZSLShbbq2rgNK2ROeRdjP82xZR-JQw0rWgNtOfGGCLn4dGku9PjQgk71ze92jcDw52zxGD7DjjkJgMb245Jc9OvTr7bMH1knWKw6YpKO1WlVgpSseFOFVZ5Wh5fznKZqa1U3";
 $logisticsApiKey = "AAAADq0v18A:APA91bHC4KL7eKfwXVzQkLatQQYgt8qrHPq0pVyLiw6fQ7ttm7KtA9AbZUIt1vqtUDJjLxya5hMdItFTEPAkAzaVgJBZBK6B6FEm0uFUnpZMUE7Yjl_B8hsWWnfFpJEQ5PL0SqnOqXmN";
 $vendorApiKey = "AAAAz5vDt3k:APA91bGz7A82h7yOzoNRGbv2augVEbnHVEJE25NzGl4mrZTi1udCBi6hApwoYlxxIfsHqD5suodg8BOCtfhyA4lp_99nwzwQaUDbzzrglyXpSPiz2DEkJKpaGPtwNT0qI1MWPqv9Ysbj";
 
 
 $customerProductPath = '../Images/CustomerProduct/';
 $chatMediaPath = '../Images/ChatMedia/';
 $fixedVideoPath = '../Images/fixedVideo/';
 $defectAudioPath = '../Images/DefectAudio/';
 
 $customerProductDBPath = 'https://www.oncefyxd.com/Troop/Images/CustomerProduct/';
 $chatMediaDBPath = 'https://www.oncefyxd.com/Troop/Images/ChatMedia/';
 $fixedVideoDBPath = 'https://www.oncefyxd.com/Troop/Images/fixedVideo/';
 $defectAudioDBPath = 'https://www.oncefyxd.com/Troop/Images/DefectAudio/';
 


?>
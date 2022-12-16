<?php

//Prod
 //$apiRootPath = "https://oncefyxd.com/Common/"; 
 //$invoicePdfPath = "https://oncefyxd.com/Invoice/PDF/";
 
 // Local
 //$apiRootPath = "http://localhost/Troop/Common/";
 //$invoicePdfPath = "http://localhost:80/Troop/Common/";
 
 //UAT
 $apiRootPath = "https://oncefyxd.com/troopuat/Common/"; 
 $invoicePdfPath = "https://oncefyxd.com/troopuat/Invoice/PDF/";
 
 
 
 
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
 
 $deliveryFeeConfig = "70.8";
 
 //Firebase Notification
 $customerApiKey = "AAAAuPOGh1k:APA91bFhZSLShbbq2rgNK2ROeRdjP82xZR-JQw0rWgNtOfGGCLn4dGku9PjQgk71ze92jcDw52zxGD7DjjkJgMb245Jc9OvTr7bMH1knWKw6YpKO1WlVgpSseFOFVZ5Wh5fznKZqa1U3";
 $logisticsApiKey = "AAAADq0v18A:APA91bHC4KL7eKfwXVzQkLatQQYgt8qrHPq0pVyLiw6fQ7ttm7KtA9AbZUIt1vqtUDJjLxya5hMdItFTEPAkAzaVgJBZBK6B6FEm0uFUnpZMUE7Yjl_B8hsWWnfFpJEQ5PL0SqnOqXmN";
 $vendorApiKey = "AAAAz5vDt3k:APA91bGz7A82h7yOzoNRGbv2augVEbnHVEJE25NzGl4mrZTi1udCBi6hApwoYlxxIfsHqD5suodg8BOCtfhyA4lp_99nwzwQaUDbzzrglyXpSPiz2DEkJKpaGPtwNT0qI1MWPqv9Ysbj";
 
 
 $customerProductPath = 'customerproduct';
 $chatMediaPath = 'chatmedia';
 $fixedVideoPath = 'fixedvideo';
 $defectAudioPath = 'defectaudio';
 $defectImagePath = 'defect';
 
 $customerProductDBPath = 'https://oncefyxdblob.blob.core.windows.net/customerproduct/';
 $chatMediaDBPath = 'https://oncefyxdblob.blob.core.windows.net/chatmedia/';
 $fixedVideoDBPath = 'https://oncefyxdblob.blob.core.windows.net/fixedvideo/';
 $defectAudioDBPath = 'https://oncefyxdblob.blob.core.windows.net/defectaudio/';
 $defectImageDBPath = 'https://oncefyxdblob.blob.core.windows.net/defect/';
 $ConstantValuesDBPath = 'https://oncefyxdblob.blob.core.windows.net/banner/';
 $ProductDBPath = 'https://oncefyxdblob.blob.core.windows.net/product/';
 
 $blobConnectionString = "DefaultEndpointsProtocol=https;AccountName=oncefyxdblob;AccountKey=TLS9bfXrKQn5JvPcbcmtKP1NqKqb5jNireOg8Gzf2FCQfJEVYumVXJaBAFd5Ue1eW+VjrimSJCpw+AStuDfOcQ==";
 $blobName = "oncefyxdblob";

?>
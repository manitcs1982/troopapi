<?php

// Include the SDK using the Composer autoloader
require '../libs/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
ini_set('memory_limit', '64M');     
/*
include('image64.php');
$fileName = 'item.jpg';
imageUpload($image64,$fileName);
*/
function imageUpload($base64img,$fileName){
	if(isset($base64img)){		
		include('../config.php');
				
		//to get TYPEAPPLICATION$string = $base64;
		$string = $base64img;
		$start='/';
		$end=';base64';
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    $type = substr($string, $ini, $len);
		$fileName = $fileName.'.'.$type;
		$result=false;		
		$base64code = explode(',',$base64img)[1];
		//$base64code =$base64img;


		$encodedData = str_replace(' ','+',$base64code);
		$encodedImg = base64_decode($encodedData);
	
	
	  $client = S3Client::factory(
	      array(
	     // 'key'    => awsAccessKey,
	      //'secret' => awsSecretKey,
		  'region'      => region,
		   'version'     => version,
		    'credentials' => [
	        'key'    => awsAccessKey,
	        'secret' => awsSecretKey,
	    ],
	       )
	      );

	
	 try {
	        $client->putObject(array(
	             'Bucket'=>$bucket,
	             'Key' =>  $fileName,
	             //'SourceFile' => $tmp,
	             'StorageClass' => 'REDUCED_REDUNDANCY',
	        'Body'            => $encodedImg,
	       // 'ContentType'     => 'image/' . $type,
	        'ACL'             => 'public-read'
	        ));
	        
	        $result= true;

	    } catch (S3Exception $e) {
	         // Catch an S3 specific exception.
			print_r($e);
	        $result= false;
	    }
	 
	}
	return $result;
}
?>

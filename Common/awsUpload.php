<?php

	$data = json_decode(file_get_contents("php://input"));
	
	
	define('UPLOAD_DIR', '../Images/CustomerProduct/');
	
	$string = $data->image;
	$start='/';
	$end=';base64';
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0)
		return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	$type = substr($string, $ini, $len);
	
	
    $image_parts = explode(";base64,", $data->image);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
	$file = UPLOAD_DIR . uniqid() .'.'. $type;
    file_put_contents($file, $image_base64);
?>
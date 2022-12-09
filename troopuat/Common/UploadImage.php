<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


function UploadImage($files, $imageDirectory)
{	
	$errors= array();
	$file_name = $files['name'];
	$file_size =$files['size'];
	$file_tmp = $files['tmp_name'];
	$file_type= $files['type'];
	$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$extensions = array("jpeg","jpg","png");
	if (in_array($file_ext,$extensions)=== false) {
		$errors[]="image extension not allowed, please choose a JPEG or PNG file.";
	}
	if ($file_size > 2097152) {
		$errors[]='File size cannot exceed 2 MB';
	}
	if (empty($errors)==true) {
		//echo $imageDirectory.$file_name;
		move_uploaded_file($file_tmp,$imageDirectory);		
		return 1;
		//update
	} else {
		return $errors;
	}	
}


?>

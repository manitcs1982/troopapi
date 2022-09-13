<?php	
	
	function imageUploadToDisk($image,$uploadPath, $fileName)
	{
		//if (strpos($image, 'base64') !== false ) {
			
			$string = $image;
			$start='/';
			$end=';base64';
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0)
				return 0;
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			$type = substr($string, $ini, $len);

			$image_parts = explode(";base64,", $image);
			//$image_type_aux = explode("image/", $image_parts[0]);
			//$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$file = $uploadPath . $fileName .'.'. $type;
			file_put_contents($file, $image_base64);

			return $fileName .'.'. $type;
		/*}else{
			return 0;
		}
		*/
	}
?>
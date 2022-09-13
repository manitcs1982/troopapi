<?php	
include_once '../Config/config.php';
require_once '../vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$GLOBALS['blobConnectionString'] = $blobConnectionString;
$GLOBALS['blobName'] = $blobName;

	function imageUploadToDisk($base64_string,$uploadPath, $fileName)
	{
		
		$base64Image = explode( ',', $base64_string );
		$base64Image = $base64Image[1];
		//To find the extension of base64
		$string = $base64_string;
		$start='/';
		$end=';base64';
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0)
			return 0;
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		$extension = substr($string, $ini, $len);
		
		
			
		$connectionString = $GLOBALS['blobConnectionString'];
		$blobClient = BlobRestProxy::createBlobService($connectionString);
	    $createContainerOptions = new CreateContainerOptions();
	    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
	    
	    $containerName = $uploadPath;
	    $output_file = './tempUploadFile.'.$extension;
		//$fileToUpload = base64_to_jpeg($image, $output_file);		
		$blobName = $GLOBALS['blobName']; //From config

		$imgdata = base64_decode($base64Image);
		
		$f = finfo_open();
		$mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
		$blobRestProxy = $blobClient->createBlobService($connectionString);
		
		
		$blobRestProxy->createBlockBlob($containerName, $fileName.'.'.$extension, $imgdata);
		//$blobClient->createBlockBlob($containerName, $fileName.'.'.$extension, $fileToUpload);
		
		//unlink($fileToUpload);
		return $fileName.'.'.$extension;
	}
	
	function base64_to_jpeg($base64_string, $output_file) {
			// open the output file for writing
			$ifp = fopen( $output_file, 'wb' ); 

			// split the string on commas
			// $data[ 0 ] == "data:image/png;base64"
			// $data[ 1 ] == <actual base64 string>
			$data = explode( ',', $base64_string );

			// we could add validation here with ensuring count( $data ) > 1
			fwrite( $ifp, base64_decode( $data[ 1 ] ) );

			// clean up the file resource
			fclose( $ifp ); 

			return $output_file; 
		}
?>
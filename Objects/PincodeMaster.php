
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../Config/config.php';

class Pincode{
	
		private $conn;		
		public $pincodeId;
		public $pincodeName;	
		public $location;
		public $latitude;
		public $longitude;
        public $status;
        public $createdOn;
        public $modifiedOn;			
		
		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		//Inserting the InsertPincodeMaster
		public function InsertPincodeMaster(){

			try{
				
				$sql = "Insert into Pincode_Master Set PIN_pincode=:pincodeName,PIN_location=:location,PIN_latitude=:latitude,PIN_longitude=:longitude,PIN_status=:status,PIN_createdOn=:createdOn,PIN_modifiedOn=:modifiedOn";
			    $result = $this->conn->prepare($sql);
			    
                $this->pincodeName=htmlspecialchars(strip_tags($this->pincodeName));
				$result->bindParam(":pincodeName", $this->pincodeName);
                $this->location=htmlspecialchars(strip_tags($this->location));
				$result->bindParam(":location", $this->location);                
				$this->latitude=htmlspecialchars(strip_tags($this->latitude));
				$result->bindParam(":latitude", $this->latitude);
                $this->longitude=htmlspecialchars(strip_tags($this->longitude));
				$result->bindParam(":longitude", $this->longitude);
                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
                $this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);					
				
				$result->execute();
				$this->pincodeId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Inserting the InsertPincodeMaster
		public function UpdatePincodeMaster(){

			try{
				
				$sql = "Update Pincode_Master Set PIN_pincode=:pincodeName,PIN_location=:location,PIN_latitude=:latitude,PIN_longitude=:longitude,PIN_status=:status,PIN_modifiedOn=:modifiedOn where PIN_GPK=:pincodeId";
			    $result = $this->conn->prepare($sql);
			    
			    $this->pincodeId=htmlspecialchars(strip_tags($this->pincodeId));
				$result->bindParam(":pincodeId", $this->pincodeId);
                $this->pincodeName=htmlspecialchars(strip_tags($this->pincodeName));
				$result->bindParam(":pincodeName", $this->pincodeName);
                $this->location=htmlspecialchars(strip_tags($this->location));
				$result->bindParam(":location", $this->location);                
				$this->latitude=htmlspecialchars(strip_tags($this->latitude));
				$result->bindParam(":latitude", $this->latitude);
                $this->longitude=htmlspecialchars(strip_tags($this->longitude));
				$result->bindParam(":longitude", $this->longitude);
                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);                
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);					
				
				$result->execute();
				
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Get All Pincode Master
		public function GetAllPincodeMaster()
		{
			try {
				$sql = "select * from Pincode_Master"; 
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Get PincodeMaster By Status

public function GetPincodeMasterByStatus(){

			try{
				
				$sql = "Select * from Pincode_Master where PIN_status=:status";
			    $result = $this->conn->prepare($sql);
			    $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);				
				$result->execute();													  	
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		// Get Check Pincode Validation
		public function GetCheckPincodeValidation(){

			try{
				
				$sql = "Select * from Pincode_Master where PIN_pincode=:pincodeName and PIN_status=1";
			    $result = $this->conn->prepare($sql);
			    $this->pincodeName=htmlspecialchars(strip_tags($this->pincodeName));
				$result->bindParam(":pincodeName", $this->pincodeName);				
				$result->execute();													  	
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}


		
		
}
?>

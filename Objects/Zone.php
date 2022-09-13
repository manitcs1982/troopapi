<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Zone{
		private $conn;		
		public $zoneId;
		public $name;
		public $zipCode;
		public $status;
		public $createdOn;
		public $modifiedOn;
		public $error;
		

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Inserting Zone{
			public function InsertZone(){			
			try{
				
				$sql = "Insert into Zone_Master Set ZNM_name=:name,ZNM_zipcode=:zipCode,ZNM_status=:status,ZNM_createdOn=:createdOn";//
				
				$result = $this->conn->prepare($sql);
				
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				
				$this->zipCode=htmlspecialchars(strip_tags($this->zipCode));
				$result->bindParam(":zipCode", $this->zipCode);
				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				
				$result->execute();
				 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Zone
		public function GetAllZone(){			
			try{
				$sql = "select * from Zone_Master"; //
				$result = $this->conn->prepare($sql);				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating zone
		public function UpdateZone(){

			try{
				
				$sql ="Update Zone_Master Set ZNM_name=:name,ZNM_zipcode=:zipCode,ZNM_status=:status,ZNM_modifiedOn=:modifiedOn where ZNM_GPK=:zoneId";
			    $result = $this->conn->prepare($sql);
				
			    $this->zoneId=htmlspecialchars(strip_tags($this->zoneId));
				$result->bindParam(":zoneId", $this->zoneId);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				
				$this->zipCode=htmlspecialchars(strip_tags($this->zipCode));
				$result->bindParam(":zipCode", $this->zipCode);
				
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
}
?>

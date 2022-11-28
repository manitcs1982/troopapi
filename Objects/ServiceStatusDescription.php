<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ServiceStatusDescription{
		private $conn;		
		public $id;
		public $status;
		public $description;		
		public $nativeDescription;		
		public $isActive;
		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Getting customer details by PhoneNumber
		public function GetServiceDescriptionByStatus(){			
			try{
				$sql = "select * from service_status_description where SSD_status=:status"; //
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
	
		
}
?>

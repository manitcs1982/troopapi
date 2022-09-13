<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ConstantValues{
		private $conn;
		public  $constvalueId;
		public  $type;
		public  $value;
		public  $title;
		public  $isMedia;
		public  $isActive;
		public  $createdOn;
		public  $modifiedOn;

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
	
		
		//GetAllConstantValuesByType
		public function GetAllConstantValuesByType(){			
			try{
				
				$sql = "select * from Constant_Values where CNV_type= :type"; //
				$result = $this->conn->prepare($sql);
				
				$this->type=htmlspecialchars(strip_tags($this->type));		
				$result->bindParam(":type", $this->type);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}

	
}
?>
				
				
				
				
				
				
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class nonServiceable{
		private $conn;		
		public $nonServiceableId;
		public $customerId;
		public $productId;
        public $notes;
		public $isActive;
		public $createdOn;
        public $modifiedOn;
        public $error;
			
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	
		public function InsertNonServiceableDetails(){
			try{
				$sql = "Insert into non_serviceable_details Set NSD_CST_GFK=:customerId,NSD_PDM_GFK=:productId,NSD_notes=:notes,NSD_isActive=:isActive,NSD_createdOn=:createdOn,NSD_modifiedOn=:modifiedOn";
			    $result = $this->conn->prepare($sql);
			  
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);		
				$this->isActive=htmlspecialchars(strip_tags($this->isActive));
				$result->bindParam(":isActive", $this->isActive);	
                $this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);	
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);		
				$result->execute();
				$this->nonServiceableId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}	
	

	}
	
?>

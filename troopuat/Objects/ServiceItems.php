<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ServiceItems{
		private $conn;	
		public  $itemId;
		public  $serviceId;		
		public  $name;	
		public  $isActive;	
		public  $optionAnswer;	
		public  $createdOn;
		public  $modifiedOn;
		public  $nativeName; 
		public  $nativeOptionAnswer; 

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		//Inserting Product{
		public function InsertServiceItem(){			
			try{				
				$sql = "Insert into Service_Items Set SRI_name=:name,SRI_SVC_GFK=:serviceId,SRI_ITM_GFK=:itemId,SRI_type=:type,SRI_optionAnswer=:optionAnswer,SRI_isActive=:isActive,SRI_createdOn=:createdOn,SRI_nativeName=:nativeName,SRI_nativeOptionAnswer=:nativeOptionAnswer";//
				
				$result = $this->conn->prepare($sql);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				$this->itemId=htmlspecialchars(strip_tags($this->itemId));
				$result->bindParam(":itemId", $this->itemId);				
				$this->isActive=htmlspecialchars(strip_tags($this->isActive));
				$result->bindParam(":isActive", $this->isActive);				
				echo "**".$this->optionAnswer=htmlspecialchars(strip_tags($this->optionAnswer));
				$result->bindParam(":optionAnswer", $this->optionAnswer);		
				$this->type=htmlspecialchars(strip_tags($this->type));
				$result->bindParam(":type", $this->type);					
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				$this->nativeName=htmlspecialchars(strip_tags($this->nativeName));
				$result->bindParam(":nativeName", $this->nativeName);
				echo $this->nativeOptionAnswer=htmlspecialchars(strip_tags($this->nativeOptionAnswer));
				$result->bindParam(":nativeOptionAnswer", $this->nativeOptionAnswer);
				
				$result->execute();
				$this->productId = $this->conn->lastInsertId(); 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting product by serviceId
		public function GetServiceItemsByServiceId(){			
			try{				
				$sql = "select * from Service_Items where SRI_SVC_GFK= :serviceId"; //
				$result = $this->conn->prepare($sql);
				
				$this->serviceId=htmlspecialchars(strip_tags($this->serviceId));		
				$result->bindParam(":serviceId", $this->serviceId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
}
?>
				
				
				
				
				
				
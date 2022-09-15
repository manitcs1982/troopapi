<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class TempServiceItems{
		private $conn;	
		public  $itemId;
		public  $tempServiceId;		
		public  $name;	
		public  $isActive;	
		public  $optionAnswer;	
		public  $createdOn;
		public  $modifiedOn;
		public  $nativeName; 
		public $type;
		public $error;
		public  $nativeOptionAnswer; 

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		//Inserting Product{
		public function InsertTempServiceItem(){			
			try{				
				$sql = "Insert into Temporary_Service_Items Set TSI_name=:name,TSI_TPS_GFK=:tempServiceId,TSI_ITM_GFK=:itemId,TSI_type=:type,TSI_optionAnswer=:optionAnswer,TSI_isActive=:isActive,TSI_createdOn=:createdOn,TSI_nativeName=:nativeName,TSI_nativeOptionAnswer=:nativeOptionAnswer";//
				
				$result = $this->conn->prepare($sql);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->tempServiceId=htmlspecialchars(strip_tags($this->tempServiceId));
				$result->bindParam(":tempServiceId", $this->tempServiceId);
				$this->itemId=htmlspecialchars(strip_tags($this->itemId));
				$result->bindParam(":itemId", $this->itemId);				
				$this->isActive=htmlspecialchars(strip_tags($this->isActive));
				$result->bindParam(":isActive", $this->isActive);				
				$this->optionAnswer=htmlspecialchars(strip_tags($this->optionAnswer));
				$result->bindParam(":optionAnswer", $this->optionAnswer);		
				$this->type=htmlspecialchars(strip_tags($this->type));
				$result->bindParam(":type", $this->type);					
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				$this->nativeName=htmlspecialchars(strip_tags($this->nativeName));
				$result->bindParam(":nativeName", $this->nativeName);
				$this->nativeOptionAnswer=htmlspecialchars(strip_tags($this->nativeOptionAnswer));
				$result->bindParam(":nativeOptionAnswer", $this->nativeOptionAnswer);
				
				$result->execute();
				$this->productId = $this->conn->lastInsertId(); 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting product by tempServiceId
		public function GetTempServiceItemsByTempServiceId(){			
			try{				
				$sql = "select * from Temporary_Service_Items where TSI_TPS_GFK= :tempServiceId"; //
				$result = $this->conn->prepare($sql);
				
				$this->tempServiceId=htmlspecialchars(strip_tags($this->tempServiceId));		
				$result->bindParam(":tempServiceId", $this->tempServiceId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
}
?>
				
				
				
				
				
				
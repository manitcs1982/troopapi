<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ItemMaster{
		private $conn;	
		public  $itemId;
		public  $productId;
		public  $name;	
		public  $type;
		public  $options;
		public  $createdOn;
		public  $modifiedOn;
		public  $nativeName;
		public  $nativeOptions;
		public  $isAll;
		public  $refererItemId;
		public  $refItemId;
		public  $refOption;
		public  $isMandatory;
		public  $refTamilOption;
		


		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		/*
		//Inserting Product{
		public function InsertProduct(){			
			try{
				
				$sql = "Insert into Product_Master  Set PDM_name=:name,PDM_description=:description,PDM_imageUrl=:imageUrl,PDM_status=:status,PDM_createdOn=:createdOn";//
				
				$result = $this->conn->prepare($sql);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->description=htmlspecialchars(strip_tags($this->description));
				$result->bindParam(":description", $this->description);
				$this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);
				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				
				$result->execute();
				$this->productId = $this->conn->lastInsertId(); 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		*/
		//Getting product by productId
		public function GetItemsByProductId(){			
			try{
				
				$sql = "select * from Item_Master where ITM_PDM_GFK= :productId and ITM_isActive=1"; //
				$result = $this->conn->prepare($sql);
				
				$this->productId=htmlspecialchars(strip_tags($this->productId));		
				$result->bindParam(":productId", $this->productId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
}
?>
				
				
				
				
				
				
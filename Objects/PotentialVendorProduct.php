<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PotentialVendorProduct{
		private $conn;		
		public $id;
		public $vendorId;
		public $productId;
		public $status;
		public $createdOn;
		public $modifiedOn;
		
				
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		//Inserting PotentialVendorProduct{
			public function InsertPotentialVendorProduct(){			
			try{
				
				$sql = "Insert into Potential_Vendor_Product Set PVP_PVD_GFK=:vendorId,PVP_PDM_GFK=:productId,PVP_Status=:status,PVP_createdOn=:createdOn,PVP_modifiedOn=:modifiedOn";//
				
				$result = $this->conn->prepare($sql);
				
			
				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				
				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				
				$result->execute();
				$this->id = $this->conn->lastInsertId(); 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false; 
			}
		}
		//Getting all PotentialVendorProduct
		public function GetAllPotentialVendorProductByPotentialVendorId(){			
			try{
				$sql = "select * from Potential_Vendor_Product where PVP_PVD_GFK=:vendorId"; //
				$result = $this->conn->prepare($sql);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
}
		?>
		

		
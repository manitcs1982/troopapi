
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ServiceDefects{
	
		private $conn;		
		public $serviceDefectId;
		public $serviceId;		
		public $productId;
		public $vendorPrice;
		public $customerPrice;
		public $GSTPrice;
		public $status;
		public $quantity;
		public $imageUrl;
		public $imageDescription;
		public $createdOn;
		public $modifiedOn;
		public $error;
		
		public $customerTotal;
		public $vendorTotal;
		public $GSTAmount;
		public $nativeImageDescription;
			
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		//Inserting the Service details
		public function InsertServiceDefects(){

			try{
				
				$sql = "Insert into Service_Defects Set SVD_SVC_GFK=:serviceId,SVD_PDM_GFK=:productId,SVD_vendorPrice=:vendorPrice,SVD_customerPrice=:customerPrice,SVD_status=:status,SVD_quantity=:quantity,SVD_imageUrl=:imageUrl,SVD_imageDescription=:imageDescription,SVD_createdOn=:createdOn,SVD_nativeImageDescription=:nativeImageDescription,SVD_GSTPercentage=:GSTPercentage,SVD_customerDisplayPrice=:customerDisplayPrice";
			    $result = $this->conn->prepare($sql);
			    

			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);				
				$this->vendorPrice=htmlspecialchars(strip_tags($this->vendorPrice));
				$result->bindParam(":vendorPrice", $this->vendorPrice);				
				$this->customerPrice=htmlspecialchars(strip_tags($this->customerPrice));
				$result->bindParam(":customerPrice", $this->customerPrice);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->quantity=htmlspecialchars(strip_tags($this->quantity));
				$result->bindParam(":quantity", $this->quantity);
                $this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);
                $this->imageDescription=htmlspecialchars(strip_tags($this->imageDescription));
				$result->bindParam(":imageDescription", $this->imageDescription);
                $this->nativeImageDescription=htmlspecialchars(strip_tags($this->nativeImageDescription));
				$result->bindParam(":nativeImageDescription", $this->nativeImageDescription);
				$this->GSTPercentage=htmlspecialchars(strip_tags($this->GSTPercentage));
				$result->bindParam(":GSTPercentage", $this->GSTPercentage);
				$this->customerDisplayPrice=htmlspecialchars(strip_tags($this->customerDisplayPrice));
				$result->bindParam(":customerDisplayPrice", $this->customerDisplayPrice);
                $this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
                
				$result->execute();
				$this->serviceDefectId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
							
		//Updating the Service details
	/*	public function GetServiceByServiceId(){

			try{
				
				$sql = "Select * Service_Defects where SVC_GPK=:serviceId";
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
	*/			
		
		//Getting All Services by vendorId
        public function GetAllServiceDefectsByServiceId(){			
			try{
				$sql = "select * from Service_Defects where SVD_SVC_GFK=:serviceId"; //
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

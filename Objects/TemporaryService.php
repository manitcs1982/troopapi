
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../Config/config.php';

class TemporaryService{
	
		private $conn;		
		public $tempServiceId;
		public $customerId;		
		public $customerProductId;
		public $productId;
		public $customerAddressId;		
		public $status;			
		public $stage;			
		public $notes;
		public $isTurnOn;
		public $pickUpDate;
		public $pickUpSlot;
		public $createdOn;
		public $modifiedOn;
		
		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		//Inserting the Service details
		public function InsertTempServiceDetails(){

			try{
				
				$sql = "Insert into Temporary_Service Set TPS_CST_GFK=:customerId,TPS_CSP_GFK=:customerProductId,TPS_PDM_GFK=:productId,TPS_ADR_GFK=:addressId,TPS_stage=:stage,TPS_status=:status,TPS_pickUpDate=:pickUpDate,TPS_pickUpSlot=:pickUpSlot,TPS_notes=:notes,TPS_isTurnOn=:isTurnOn,TPS_createdOn=:createdOn";
			    $result = $this->conn->prepare($sql);
			    $this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);				
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));
				$result->bindParam(":customerProductId", $this->customerProductId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->addressId=htmlspecialchars(strip_tags($this->addressId));
				$result->bindParam(":addressId", $this->addressId);								
                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);  
				$this->stage=htmlspecialchars(strip_tags($this->stage));
				$result->bindParam(":stage", $this->stage);                 
				$this->pickUpDate=htmlspecialchars(strip_tags($this->pickUpDate));
				$result->bindParam(":pickUpDate", $this->pickUpDate);
				$this->pickUpSlot=htmlspecialchars(strip_tags($this->pickUpSlot));
				$result->bindParam(":pickUpSlot", $this->pickUpSlot);
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);
				$this->isTurnOn=htmlspecialchars(strip_tags($this->isTurnOn));
				$result->bindParam(":isTurnOn", $this->isTurnOn);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);								
				
				$result->execute();
				$this->tempServiceId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Update the Service details
		public function UpdateTempServiceDetails(){

			try{
				
				$sql = "Update Temporary_Service Set TPS_CST_GFK=:customerId,TPS_CSP_GFK=:customerProductId,TPS_PDM_GFK=:productId,TPS_ADR_GFK=:addressId,TPS_status=:status,TPS_pickUpDate=:pickUpDate,TPS_pickUpSlot=:pickUpSlot,TPS_notes=:notes,TPS_isTurnOn=:isTurnOn,TPS_stage=:stage, TPS_modifiedOn=:createdOn where TPS_GPK=:tempServiceId";
			    $result = $this->conn->prepare($sql);
			    $this->tempServiceId=htmlspecialchars(strip_tags($this->tempServiceId));
				$result->bindParam(":tempServiceId", $this->tempServiceId);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);				
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));
				$result->bindParam(":customerProductId", $this->customerProductId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->addressId=htmlspecialchars(strip_tags($this->addressId));
				$result->bindParam(":addressId", $this->addressId);								
                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status); 
				$this->stage=htmlspecialchars(strip_tags($this->stage));
				$result->bindParam(":stage", $this->stage);                
				$this->pickUpDate=htmlspecialchars(strip_tags($this->pickUpDate));
				$result->bindParam(":pickUpDate", $this->pickUpDate);
				$this->pickUpSlot=htmlspecialchars(strip_tags($this->pickUpSlot));
				$result->bindParam(":pickUpSlot", $this->pickUpSlot);
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);
				$this->isTurnOn=htmlspecialchars(strip_tags($this->isTurnOn));
				$result->bindParam(":isTurnOn", $this->isTurnOn);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);								
				
				$result->execute();
					
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating the Service details
		public function DeleteTempService(){

			try{
				
				$sql = "Update Temporary_Service Set TPS_status=0,TPS_modifiedOn=:modifiedOn where find_in_set(TPS_GPK,:tempServiceId)";
			    $result = $this->conn->prepare($sql);
			    $this->tempServiceId=htmlspecialchars(strip_tags($this->tempServiceId));
				$result->bindParam(":tempServiceId", $this->tempServiceId);
               
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		//Getting All Services by customerId
        public function GetAllTempServicesByCustomerIdAndProductId(){			
			try{
				$sql = "select * from Temporary_Service where TPS_CST_GFK=:customerId and TPS_PDM_GFK=:productId and TPS_status=1 order by TPS_createdOn desc"; 
				$result = $this->conn->prepare($sql);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));				
				$result->bindParam(":customerId", $this->customerId);				
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Temporaray Services
		public function GetAllTemporaryService(){			
			try{
				$sql = "select * from Temporary_Service Where TPS_status=1";
				$result = $this->conn->prepare($sql);				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
				
		//Getting All Services by customerId
        public function GetTempServicesByTempServiceId(){			
			try{
				$sql = "select * from Temporary_Service where TPS_GPK=:tempServiceId and TPS_status=1"; 
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
					//Getting All Services by customerId
        public function IsTempServiceEligible(){			
			try{
				$sql = "select count(*) as TempSRCount from Temporary_Service where TPS_CST_GFK=:customerId and TPS_PDM_GFK=:productId and TPS_status=1"; //
				$result = $this->conn->prepare($sql);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));				
				$result->bindParam(":customerId", $this->customerId);				
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

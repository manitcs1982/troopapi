
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../Config/config.php';

class Payment{

		private $conn;	
		public $paymentId;	
		public $serviceId;
		public $customerId;
		public $vendorId;
		public $logisticsId;
		public $referenceNumber;
		public $customerTotal;
		public $paymentIdValue;
		public $paymentStatus;		
		public $paymentMethod;
		public $paidAmount;
		public $description;
		public $isActive;
		public $createdOn;
		public $modifiedOn;
				
		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		//Inserting the Service details
		public function InsertPaymentDetails(){

			try{

				$sql = "Insert into Payment Set PMT_SVC_GFK=:serviceId,PMT_CSR_GFK=:customerId,PMT_VDR_GFK=:vendorId,PMT_LGT_GFK=:logisticsId,PMT_referenceNumber=:referenceNumber,PMT_customerTotal=:customerTotal,PMT_paymentIdValue=:paymentIdValue,PMT_paymentStatus=:paymentStatus,PMT_paymentMethod=:paymentMethod,PMT_description=:description,PMT_paidAmount=:paidAmount,PMT_type=:type,PMT_STK_GFK=:stockId,PMT_isActive=:isActive,PMT_createdOn=:createdOn; Update Service SVC_isPaymentCompleted=1 where SVC_GPK=:serviceId";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->referenceNumber=htmlspecialchars(strip_tags($this->referenceNumber));
				$result->bindParam(":referenceNumber", $this->referenceNumber);
				$this->customerTotal=htmlspecialchars(strip_tags($this->customerTotal));
				$result->bindParam(":customerTotal", $this->customerTotal);
				$this->paymentIdValue=htmlspecialchars(strip_tags($this->paymentIdValue));
				$result->bindParam(":paymentIdValue", $this->paymentIdValue);
				$this->paymentStatus=htmlspecialchars(strip_tags($this->paymentStatus));
				$result->bindParam(":paymentStatus", $this->paymentStatus);
				$this->paymentMethod=htmlspecialchars(strip_tags($this->paymentMethod));
				$result->bindParam(":paymentMethod", $this->paymentMethod);
				$this->description=htmlspecialchars(strip_tags($this->description));
				$result->bindParam(":description", $this->description);
				$this->paidAmount=htmlspecialchars(strip_tags($this->paidAmount));
				$result->bindParam(":paidAmount", $this->paidAmount);
                $this->isActive=htmlspecialchars(strip_tags($this->isActive));
				$result->bindParam(":isActive", $this->isActive);                
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);	                
				$this->stockId=htmlspecialchars(strip_tags($this->stockId));
				$result->bindParam(":stockId", $this->stockId);                
				$this->type=htmlspecialchars(strip_tags($this->type));
				$result->bindParam(":type", $this->type);	
													
				$result->execute();
				$this->paymentId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating the Service details
		public function UpdateServiceStatus(){

			try{
				
				$sql = "Update Service Set SVC_status=:status,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);

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
							
		
		//Updating the Service details
		public function GetPaymentDetailsByServiceId(){

			try{
				
				$sql = "Select * from Payment where PMT_SVC_GFK=:serviceId";
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
		
		//Updating the Service details
		public function GetAllPaymentDetailsByCustomerId(){

			try{
				
				$sql = "Select * from Payment where PMT_CSR_GFK=:customerId";
			    $result = $this->conn->prepare($sql);
			    $this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);				
				$result->execute();													  	
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}	
		
		//Updating the Service details
		public function GetAllPaymentDetails(){

			try{
				
				$sql = "Select * from Payment";
			    $result = $this->conn->prepare($sql);
			    $this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);				
				$result->execute();													  	
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}			
		
}
?>

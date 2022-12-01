<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Discount{
		private $conn;		
		public $serviceDiscountId;
		public $serviceId;
		public $discountMasterId;
		public $name;	
		public $description;
        public $notes;
		public $amount;
		public $isActive;
		public $createdOn;
        public $modifiedOn;
        public $isDiscountAvailable;
        public $error;
			
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	
		public function InsertServiceDiscount(){
			try{
				$sql = "Insert into service_discount Set SDC_SVC_GFK=:serviceId,SDC_DSM_GFK=:discountMasterId,SDC_name=:name,SDC_description=:description,SDC_notes=:notes,SDC_amount=:amount,SDC_isActive=:isActive,SDC_createdOn=:createdOn,SDC_modifiedOn=:modifiedOn";
			    $result = $this->conn->prepare($sql);
			  
				$this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				$this->discountMasterId=htmlspecialchars(strip_tags($this->discountMasterId));
				$result->bindParam(":discountMasterId", $this->discountMasterId);
                $this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->description=htmlspecialchars(strip_tags($this->description));
				$result->bindParam(":description", $this->description);
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);		
				$this->amount=htmlspecialchars(strip_tags($this->amount));
				$result->bindParam(":amount", $this->amount);	
                $this->isActive=htmlspecialchars(strip_tags($this->isActive));
				$result->bindParam(":isActive", $this->isActive);
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
	

    //Get Service _Discount Details by service Id
		public function GetServiceDiscountDetailsbyServiceId(){			
			try{
                
				$sql = "select * from service_discount where SDC_SVC_GFK=:serviceId"; 
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

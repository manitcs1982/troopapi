<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Reports{
		private $conn;
		public  $Id;
		public  $serviceId;
		public  $referenceNumber;
		public  $customerId;
		public  $vendorId;
		public  $logisticsId;
		public  $productId;
        public  $reportMessage;
		public  $createdOn;
		public  $modifiedOn;

// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
//Inserting reports
		public function InsertReports(){
			try{
				
				$sql = "Insert into Reports Set RPT_SVC_GFK=:serviceId,RPT_referenceNumber=:referenceNumber,RPT_CSR_GFK=:customerId,RPT_PDM_GFK=:productId,RPT_VDR_GFK=:vendorId,RPT_LGT_GFK=:logisticsId,RPT_reportMessage=:reportMessage,RPT_createdOn=:createdOn,RPT_modifiedOn=:modifiedOn";
			    $result = $this->conn->prepare($sql);
			    
				 $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				 $this->referenceNumber=htmlspecialchars(strip_tags($this->referenceNumber));
				$result->bindParam(":referenceNumber", $this->referenceNumber);
				 $this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				 $this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);	
				 $this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);	
				 $this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);	
				 $this->reportMessage=htmlspecialchars(strip_tags($this->reportMessage));
				$result->bindParam(":reportMessage", $this->reportMessage);
				 $this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
                 $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				
				$result->execute();
				$this->Id = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}

		//GetAllReports
		public function GetAllReports()
		{
			try {

				$sql = "select * from Reports";
				$result = $this->conn->prepare($sql);

				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}


		//GetReportsByCustomerId
		public function GetReportsByCustomerId(){			
			try{
				$sql = "select * from Reports where RPT_CSR_GFK=:customerId"; 
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
		
			//GetReportsByVendorId
			public function GetReportsByVendorId(){			
				try{
					$sql = "select * from Reports where RPT_VDR_GFK=:vendorId"; 
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
			
			//GetReportsByServiceId
			public function GetReportsByServiceId(){			
				try{
					$sql = "select * from Reports where RPT_SVC_GFK=:serviceId"; 
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
		
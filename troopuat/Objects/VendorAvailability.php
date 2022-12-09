<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class VendorAvailability{
		private $conn;	
		public $vendorAvailabilityId;
		public $vendorId;
		public $vendorAvailabilityDay01;
		public $vendorAvailabilityDay02;
		public $vendorAvailabilityDay03;
		public $vendorAvailabilityDay04;
		public $vendorAvailabilityDay05;
		public $vendorAvailabilityDay06;
		public $vendorAvailabilityDay07;
		public $startDate;
		public $endDate;
		public $availability;
		public $createdOn;
		public $modifiedOn;
		public $error;
		
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Inserting vendoravailability
		public function InsertVendorAvailability(){			
			try{
				
				$sql = "Insert into Vendor_Availability Set VDA_VDR_GFK=:vendorId, VDA_day01=:vendorAvailabilityDay01,VDA_day02=:vendorAvailabilityDay02,VDA_day03=:vendorAvailabilityDay03,VDA_day04=:vendorAvailabilityDay04,VDA_day05=:vendorAvailabilityDay05,VDA_day06=:vendorAvailabilityDay06,VDA_day07=:vendorAvailabilityDay07,VDA_startDate=:startDate,VDA_endDate=:endDate, VDA_createdOn=:createdOn";//
				
				$result = $this->conn->prepare($sql);
				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				$this->vendorAvailabilityDay01=htmlspecialchars(strip_tags($this->vendorAvailabilityDay01));
				$result->bindParam(":vendorAvailabilityDay01", $this->vendorAvailabilityDay01);
				$this->vendorAvailabilityDay02=htmlspecialchars(strip_tags($this->vendorAvailabilityDay02));
				$result->bindParam(":vendorAvailabilityDay02", $this->vendorAvailabilityDay02);
				$this->vendorAvailabilityDay03=htmlspecialchars(strip_tags($this->vendorAvailabilityDay03));
				$result->bindParam(":vendorAvailabilityDay03", $this->vendorAvailabilityDay03);
				$this->vendorAvailabilityDay04=htmlspecialchars(strip_tags($this->vendorAvailabilityDay04));
				$result->bindParam(":vendorAvailabilityDay04", $this->vendorAvailabilityDay04);
				$this->vendorAvailabilityDay05=htmlspecialchars(strip_tags($this->vendorAvailabilityDay05));
				$result->bindParam(":vendorAvailabilityDay05", $this->vendorAvailabilityDay05);
				$this->vendorAvailabilityDay06=htmlspecialchars(strip_tags($this->vendorAvailabilityDay06));
				$result->bindParam(":vendorAvailabilityDay06", $this->vendorAvailabilityDay06);
				$this->vendorAvailabilityDay07=htmlspecialchars(strip_tags($this->vendorAvailabilityDay07));
				$result->bindParam(":vendorAvailabilityDay07", $this->vendorAvailabilityDay07);
				$this->startDate=htmlspecialchars(strip_tags($this->startDate));
				$result->bindParam(":startDate", $this->startDate);
				$this->endDate=htmlspecialchars(strip_tags($this->endDate));
				$result->bindParam(":endDate", $this->endDate);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);				
								
				$result->execute();
				$this->id = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Update vendor availability
		public function UpdateVendorAvailability(){			
			try{
				
				$sql = "Update Vendor_Availability Set VDA_VDR_GFK=:vendorId, VDA_day01=:vendorAvailabilityDay01,
				VDA_day02=:vendorAvailabilityDay02,VDA_day03=:vendorAvailabilityDay03,VDA_day04=:vendorAvailabilityDay04,
				VDA_day05=:vendorAvailabilityDay05,VDA_day06=:vendorAvailabilityDay06,VDA_day07=:vendorAvailabilityDay07,
				VDA_modifiedOn=:modifiedOn,VDA_startDate=:startDate,VDA_endDate=:endDate
				where VDA_GPK=:vendorAvailabilityId";//
				
				$result = $this->conn->prepare($sql);
				
				$this->vendorAvailabilityId=htmlspecialchars(strip_tags($this->vendorAvailabilityId));
				$result->bindParam(":vendorAvailabilityId", $this->vendorAvailabilityId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				$this->vendorAvailabilityDay01=htmlspecialchars(strip_tags($this->vendorAvailabilityDay01));
				$result->bindParam(":vendorAvailabilityDay01", $this->vendorAvailabilityDay01);
				$this->vendorAvailabilityDay02=htmlspecialchars(strip_tags($this->vendorAvailabilityDay02));
				$result->bindParam(":vendorAvailabilityDay02", $this->vendorAvailabilityDay02);
				$this->vendorAvailabilityDay03=htmlspecialchars(strip_tags($this->vendorAvailabilityDay03));
				$result->bindParam(":vendorAvailabilityDay03", $this->vendorAvailabilityDay03);
				$this->vendorAvailabilityDay04=htmlspecialchars(strip_tags($this->vendorAvailabilityDay04));
				$result->bindParam(":vendorAvailabilityDay04", $this->vendorAvailabilityDay04);
				$this->vendorAvailabilityDay05=htmlspecialchars(strip_tags($this->vendorAvailabilityDay05));
				$result->bindParam(":vendorAvailabilityDay05", $this->vendorAvailabilityDay05);
				$this->vendorAvailabilityDay06=htmlspecialchars(strip_tags($this->vendorAvailabilityDay06));
				$result->bindParam(":vendorAvailabilityDay06", $this->vendorAvailabilityDay06);
				$this->vendorAvailabilityDay07=htmlspecialchars(strip_tags($this->vendorAvailabilityDay07));
				$result->bindParam(":vendorAvailabilityDay07", $this->vendorAvailabilityDay07);
				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				$this->startDate=htmlspecialchars(strip_tags($this->startDate));
				$result->bindParam(":startDate", $this->startDate);
				$this->endDate=htmlspecialchars(strip_tags($this->endDate));
				$result->bindParam(":endDate", $this->endDate);
				$result->execute();
								
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Vendor Availability by vendorId
		public function GetVendorAvailabilityByVendorId(){			
			try{
				
				$sql = "select * from Vendor_Availability where VDA_VDR_GFK=:vendorId"; //
				$result = $this->conn->prepare($sql);
				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));			$result->bindParam(":vendorId", $this->vendorId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Vendor Availability by vendorId
		public function GetVendorAvailabilityCheckByVendorIdAndDate(){			
			try{
				
				$sql = "select * from Vendor_Availability where VDA_VDR_GFK=:vendorId and VDA_startDate=:startDate and VDA_endDate=:endDate"; //
				$result = $this->conn->prepare($sql);
				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));			
				$result->bindParam(":vendorId", $this->vendorId);
				$this->startDate=htmlspecialchars(strip_tags($this->startDate));			
				$result->bindParam(":startDate", $this->startDate);
				$this->endDate=htmlspecialchars(strip_tags($this->endDate));			
				$result->bindParam(":endDate", $this->endDate);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Vendor Availability by vendorId
		public function GetVendorAvailabilityByVendorIdAndDate(){			
			try{
				
				$sql = "select VDA_GPK,VDA_VDR_GFK,availability,VDA_startDate,VDA_endDate,actualDate from 
 (
 SELECT VDA_GPK,VDA_VDR_GFK,VDA_day01 availability,VDA_startDate,VDA_endDate,DATE_ADD(VDA_startDate,INTERVAL 0 day) actualDate, 1 as temp FROM Vendor.Vendor_Availability where VDA_VDR_GFK=:vendorId
   UNION ALL
 SELECT VDA_GPK,VDA_VDR_GFK,VDA_day02 availability,VDA_startDate,VDA_endDate,DATE_ADD(VDA_startDate,INTERVAL 1 day) actualDate, 2 as temp FROM Vendor.Vendor_Availability where VDA_VDR_GFK=:vendorId
    UNION ALL
 SELECT VDA_GPK,VDA_VDR_GFK,VDA_day03 availability,VDA_startDate,VDA_endDate,DATE_ADD(VDA_startDate,INTERVAL 2 day) actualDate, 3 as temp FROM Vendor.Vendor_Availability where VDA_VDR_GFK=:vendorId
    UNION ALL
 SELECT VDA_GPK,VDA_VDR_GFK,VDA_day04 availability,VDA_startDate,VDA_endDate,DATE_ADD(VDA_startDate,INTERVAL 3 day) actualDate, 4 as temp FROM Vendor.Vendor_Availability where VDA_VDR_GFK=:vendorId
    UNION ALL
 SELECT VDA_GPK,VDA_VDR_GFK,VDA_day05 availability,VDA_startDate,VDA_endDate,DATE_ADD(VDA_startDate,INTERVAL 4 day) actualDate, 5 as temp FROM Vendor.Vendor_Availability where VDA_VDR_GFK=:vendorId
    UNION ALL
 SELECT VDA_GPK,VDA_VDR_GFK,VDA_day06 availability,VDA_startDate,VDA_endDate,DATE_ADD(VDA_startDate,INTERVAL 5 day) actualDate, 6 as temp FROM Vendor.Vendor_Availability where VDA_VDR_GFK=:vendorId
    UNION ALL
 SELECT VDA_GPK,VDA_VDR_GFK,VDA_day07 availability,VDA_startDate,VDA_endDate,DATE_ADD(VDA_startDate,INTERVAL 6 day) actualDate, 7 as temp FROM Vendor.Vendor_Availability where VDA_VDR_GFK=:vendorId
 )as Pivot

 order by VDA_startDate,temp "; 
 
				$result = $this->conn->prepare($sql);
				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));			
				$result->bindParam(":vendorId", $this->vendorId);
				$this->startDate=htmlspecialchars(strip_tags($this->startDate));			
				$result->bindParam(":startDate", $this->startDate);
				$this->endDate=htmlspecialchars(strip_tags($this->endDate));			
				$result->bindParam(":endDate", $this->endDate);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Vendor Availability
		public function GetAllVendorAvailability(){			
			try{
				
				$sql = "select * from Vendor_Availability"; //
				$result = $this->conn->prepare($sql);
				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));			$result->bindParam(":vendorId", $this->vendorId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
}
?>
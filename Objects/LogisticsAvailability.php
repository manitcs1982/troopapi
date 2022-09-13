<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class LogisticsAvailability{
		private $conn;	
		public $logisticsAvailabilityId;
		public $logisticsId;
		public $logisticsAvailabilityDay01;
		public $logisticsAvailabilityDay02;
		public $logisticsAvailabilityDay03;
		public $logisticsAvailabilityDay04;
		public $logisticsAvailabilityDay05;
		public $logisticsAvailabilityDay06;
		public $logisticsAvailabilityDay07;
		public $startDate;
		public $endDate;
		public $createdOn;
		public $modifiedOn;
		public $error;
		
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Inserting logisticsavailability
		public function InsertLogisticsAvailability(){			
			try{
				
				$sql = "Insert into Logistics_Availability Set LGA_LGT_GFK=:logisticsId, LGA_day01=:logisticsAvailabilityDay01,LGA_day02=:logisticsAvailabilityDay02,LGA_day03=:logisticsAvailabilityDay03,LGA_day04=:logisticsAvailabilityDay04,LGA_day05=:logisticsAvailabilityDay05,LGA_day06=:logisticsAvailabilityDay06,LGA_day07=:logisticsAvailabilityDay07,LGA_startDate=:startDate,LGA_endDate=:endDate, LGA_createdOn=:createdOn";//
				
				$result = $this->conn->prepare($sql);
				
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->logisticsAvailabilityDay01=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay01));
				$result->bindParam(":logisticsAvailabilityDay01", $this->logisticsAvailabilityDay01);
				$this->logisticsAvailabilityDay02=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay02));
				$result->bindParam(":logisticsAvailabilityDay02", $this->logisticsAvailabilityDay02);
				$this->logisticsAvailabilityDay03=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay03));
				$result->bindParam(":logisticsAvailabilityDay03", $this->logisticsAvailabilityDay03);
				$this->logisticsAvailabilityDay04=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay04));
				$result->bindParam(":logisticsAvailabilityDay04", $this->logisticsAvailabilityDay04);
				$this->logisticsAvailabilityDay05=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay05));
				$result->bindParam(":logisticsAvailabilityDay05", $this->logisticsAvailabilityDay05);
				$this->logisticsAvailabilityDay06=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay06));
				$result->bindParam(":logisticsAvailabilityDay06", $this->logisticsAvailabilityDay06);
				$this->logisticsAvailabilityDay07=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay07));
				$result->bindParam(":logisticsAvailabilityDay07", $this->logisticsAvailabilityDay07);
				$this->startDate=htmlspecialchars(strip_tags($this->startDate));
				$result->bindParam(":startDate", $this->startDate);
				$this->endDate=htmlspecialchars(strip_tags($this->endDate));
				$result->bindParam(":endDate", $this->endDate);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);				
								
				$result->execute();
				$this->logisticsAvailabilityId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Update logistics availability
		public function UpdateLogisticsAvailability(){			
			try{
				
				$sql = "Update Logistics_Availability Set LGA_LGT_GFK=:logisticsId, LGA_day01=:logisticsAvailabilityDay01,
				LGA_day02=:logisticsAvailabilityDay02,LGA_day03=:logisticsAvailabilityDay03,LGA_day04=:logisticsAvailabilityDay04,
				LGA_day05=:logisticsAvailabilityDay05,LGA_day06=:logisticsAvailabilityDay06,LGA_day07=:logisticsAvailabilityDay07,
				LGA_modifiedOn=:modifiedOn,LGA_startDate=:startDate,LGA_endDate=:endDate
				where LGA_GPK=:logisticsAvailabilityId";//
				
				$result = $this->conn->prepare($sql);
				
				$this->logisticsAvailabilityId=htmlspecialchars(strip_tags($this->logisticsAvailabilityId));
				$result->bindParam(":logisticsAvailabilityId", $this->logisticsAvailabilityId);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->logisticsAvailabilityDay01=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay01));
				$result->bindParam(":logisticsAvailabilityDay01", $this->logisticsAvailabilityDay01);
				$this->logisticsAvailabilityDay02=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay02));
				$result->bindParam(":logisticsAvailabilityDay02", $this->logisticsAvailabilityDay02);
				$this->logisticsAvailabilityDay03=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay03));
				$result->bindParam(":logisticsAvailabilityDay03", $this->logisticsAvailabilityDay03);
				$this->logisticsAvailabilityDay04=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay04));
				$result->bindParam(":logisticsAvailabilityDay04", $this->logisticsAvailabilityDay04);
				$this->logisticsAvailabilityDay05=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay05));
				$result->bindParam(":logisticsAvailabilityDay05", $this->logisticsAvailabilityDay05);
				$this->logisticsAvailabilityDay06=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay06));
				$result->bindParam(":logisticsAvailabilityDay06", $this->logisticsAvailabilityDay06);
				$this->logisticsAvailabilityDay07=htmlspecialchars(strip_tags($this->logisticsAvailabilityDay07));
				$result->bindParam(":logisticsAvailabilityDay07", $this->logisticsAvailabilityDay07);
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
		
		//Getting Logistics Availability by logisticsId
		public function GetLogisticsAvailabilityByLogisticsId(){			
			try{
				
				$sql = "select * from Logistics_Availability where LGA_LGT_GFK=:logisticsId"; //
				$result = $this->conn->prepare($sql);
				
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));			$result->bindParam(":logisticsId", $this->logisticsId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Logistics Availability
		public function GetAllLogisticsAvailability(){			
			try{
				
				$sql = "select * from Logistics_Availability"; //
				$result = $this->conn->prepare($sql);
				
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));			$result->bindParam(":logisticsId", $this->logisticsId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
}
?>
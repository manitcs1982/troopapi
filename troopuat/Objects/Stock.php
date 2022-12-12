<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Stock{
		private $conn;		
		public $stockId;
		public $stockserviceId;
		public $stockcustomerId;
		public $stockvendorId;
		public $duration;
		public $starttime;
		public $endtime;
		public $amount;
		public $status;
		public $stockIsActive;
		public $createdOn;
		public $modifiedOn;
		public $error;
				
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		//Inserting Logistics{
			public function InsertStocking(){			
			try{
				
				$sql = "Insert into stock Set STK_SVC_GFK=:stockserviceId,STK_CST_GFK=:stockcustomerId,STK_VDR_GFK=:stockvendorId,STK_duration=:duration,
				STK_startTime=:starttime,STK_endTime=:endtime,STK_amount=:amount,STK_status=:status,STK_isActive=:stockIsActive,
				STK_createdOn=:createdOn,STK_modifiedOn=:modifiedOn";
				
				$result = $this->conn->prepare($sql);
				
			    $this->stockserviceId=htmlspecialchars(strip_tags($this->stockserviceId));
				$result->bindParam(":stockserviceId", $this->stockserviceId);
				
				$this->stockcustomerId=htmlspecialchars(strip_tags($this->stockcustomerId));
				$result->bindParam(":stockcustomerId", $this->stockcustomerId);
				
				$this->stockvendorId=htmlspecialchars(strip_tags($this->stockvendorId));
				$result->bindParam(":stockvendorId", $this->stockvendorId);
				
				$this->duration=htmlspecialchars(strip_tags($this->duration));
				$result->bindParam(":duration", $this->duration);
				
				$this->starttime=htmlspecialchars(strip_tags($this->starttime));
				$result->bindParam(":starttime", $this->starttime);
				
				$this->endtime=htmlspecialchars(strip_tags($this->endtime));
				$result->bindParam(":endtime", $this->endtime);
				
				$this->amount=htmlspecialchars(strip_tags($this->amount));
				$result->bindParam(":amount", $this->amount);

				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);

				$this->stockIsActive=htmlspecialchars(strip_tags($this->stockIsActive));
				$result->bindParam(":stockIsActive", $this->stockIsActive);
			
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);

				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
               
				$result->execute();
				$this->stockId = $this->conn->lastInsertId(); 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		
}
		?>
		

		 

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../Config/config.php';

class ServiceStatus{
	
		private $conn;		
		public $serviceStatusId;
		public $serviceId;	
		public $status;
		public $date;
		public $logisticsId;			
		
		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		//Inserting the ServiceStatus details
		public function InsertServiceStatus(){

			try{
				
				$sql = "Insert into Service_Status Set SVS_SVC_GFK=:serviceId,SVS_status=:status,SVS_date=:date,SVS_LGT_GFK=:logisticsId";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
                $this->date=htmlspecialchars(strip_tags($this->date));
				$result->bindParam(":date", $this->date);                
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);					
				
				$result->execute();
				$this->serviceStatusId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		//Getting All ServiceStatuss by vendorId
        public function GetAllServiceStatussByServiceId(){			
			try{
				$sql = "select * from Service_Status where SVS_SVC_GFK=:serviceId order by SVS_date"; //
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
		//GetLogisticsHistoryByLogisticsId

        public function GetLogisticsHistoryByLogisticsId(){			
			try{
				$sql = "select * from Service_Status where SVS_LGT_GFK=:logisticsId and (SVS_status='under_inspection' or SVS_status='delivered') order by SVS_date desc"; //
				$result = $this->conn->prepare($sql);			
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
}
?>

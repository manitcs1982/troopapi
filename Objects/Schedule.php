
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Schedule{

		private $conn;		
		public $scheduleId;		
		public $pickupSlot1;
		public $pickupSlot2;
		public $dropSlot1;
		public $dropSlot2;
		public $pickupCutOff1;
		public $pickupCutOff2;
		public $dropCutOff1;
		public $dropCutOff2;
		public $holiday;
		public $status;		
		public $createdOn;
		public $modifiedOn;		
		//public $scheduledSlots = array();
		public $scheduledSlot1;
		public $scheduledSlot2;
		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Getting Schedule details by PickupSlot1
		public function GetScheduleDetailsByTime(){			
			try{
				$sql = "select * from Schedule_Master where SCM_status=1"; //
				$result = $this->conn->prepare($sql);				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
	
		
}
?>

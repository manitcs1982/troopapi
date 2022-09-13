<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class NotificationMaster{
		private $conn;
		public  $notificationId;
		public  $type;
		public  $title;
		public  $message;		
		public  $notificationPerson;
		public  $status;
		public  $createdOn;
		public  $modifiedOn;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
				
		//Getting product by productId
		public function GetNotificationByType(){			
			try{
				
				$sql = "select * from Notification_Master where NFM_type=:type"; //
				$result = $this->conn->prepare($sql);
				
				$this->type=htmlspecialchars(strip_tags($this->type));		
				$result->bindParam(":type", $this->type);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
//Getting All products{
	public function GetAllProducts(){			
			try{
				
				$sql = "select * from Notification_Master";//
				
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
				
				
				
				
				
				
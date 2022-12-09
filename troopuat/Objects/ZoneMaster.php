<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ZoneMaster{
		private $conn;		
		public $zoneId;
		
		public $status;
		public $createdOn;
		public $modifiedOn;		
		
		
		public $error;
		

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		
}
?>

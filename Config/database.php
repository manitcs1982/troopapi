<?php

class Database{
	
	// Production server DB	
	//private $servername= "labroot.mysql.database.azure.com";
	//private $username = "adminlab";
	//private $password = "Gesa@12345";
	
	private $servername= "52.140.48.67";
	private $username = "oncefyxdvm";
	private $password = "Gesa@2022";
	
	
	
		
	private $databaseCustomer = "Customer";
	private $databaseRateCard = "Ratecard_master";
	private $databaseAddress = "Address";
	private $databaseService = "Service";
	private $databaseVendor = "Vendor";
	private $databaseSchedule = "Schedule_Master";
	private $databaseCustomerProduct = "Customer_Product";
	private $databaseProduct = "Product_Master";
	private $databaseLogistics = "Logistics";
	private $databaseZone = "Zone_Master";
	// private $databaseZone = "Zone_Master";
	private $databaseNotificationMaster = "Notification_Master";
	private $databasePincodeMaster = "Pincode_Master";
	private $databaseRoleMaster = "Role_Master";
	private $databaseChat = "Chat";
	private $databaseConstantValues = "Constant_Values";
	public  $conn;
	
	
	// DB connection for Customer database
	public function GetCustomerConnection(){	
	
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseCustomer, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Rate card master database
	public function GetRateCardConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseRateCard, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Address database
	public function GetAddressConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseAddress, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Pincode Master database
	public function GetPincodeMasterConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databasePincodeMaster, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Service database
	public function GetServiceConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseService, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}

	// DB connection for Service database
	public function GetVendorConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseVendor, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Schedule database
	public function GetScheduleConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseSchedule, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Customer Product database
	public function GetCustomerProductConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseCustomerProduct, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Product Master database
	public function GetProductConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseProduct, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	// DB connection for Logistics database
	public function GetLogisticsConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseLogistics, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}

	// DB connection for Zone database
	public function GetNotificationMasterConnection()
	{		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseNotificationMaster, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Role_Master database
	public function GetRoleMasterConnection()
	{		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseRoleMaster, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	// DB connection for Chat database
	public function GetChatConnection()
	{		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseChat, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}
	
	public function CloseConnection()
	{
		$this->conn = null;
	}
	public function GetConstantValuesConnection(){		
		try{
			$this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->databaseConstantValues, $this->username, $this->password);
			$this->conn->exec("set names utf8");			
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		
		catch(Exception $exception){
			echo "Connection error: " . $exception->getMessage();
			die;
		}
		return $this->conn;
	}



} 
?>

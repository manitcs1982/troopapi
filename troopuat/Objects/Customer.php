<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Customer{
		private $conn;		
		public $id;
		public $phoneNumber;
		public $name;
		public $email;		
		public $status;
		public $createdOn;
		public $modifiedOn;
		public $isExist;
		public $Address;
		public $tokenId;
		public $addressId;
		public $error;
		public $isAdmin;
		public $sessionId;	
	    public $LanguageId;
		public $APKVersion;
		public $DeviceVersion;
		public $DeviceType;		
		public $IMEI;		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Getting customer details by PhoneNumber
		public function GetCustomerDetailsByPhoneNumber(){			
			try{
				$sql = "select * from Customer where CSR_phoneNumber=:phoneNumber"; //
				$result = $this->conn->prepare($sql);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));				
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function GetCustomerDetailsById(){			
			try{
				$sql = "select * from Customer where CSR_GPK=:id"; //
				$result = $this->conn->prepare($sql);
				$this->id=htmlspecialchars(strip_tags($this->id));				
				$result->bindParam(":id", $this->id);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Inserting the customer details
		public function InsertCustomerDetails(){
			try{
				
				$sql = "Insert into Customer Set CSR_name=:name,CSR_phoneNumber=:phoneNumber,CSR_email=:email,CSR_status=:status,CSR_tokenId=:tokenId,CSR_createdOn=:createdOn,CSR_LanguageId=:LanguageId,CSR_APKVersion=:APKVersion,CSR_DeviceVersion=:DeviceVersion,CSR_DeviceType=:DeviceType,CSR_IMEI=:IMEI";
			    $result = $this->conn->prepare($sql);
			    $this->Name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$this->email=htmlspecialchars(strip_tags($this->email));
				$result->bindParam(":email", $this->email);				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);				
					$this->LanguageId=htmlspecialchars(strip_tags($this->LanguageId));
				$result->bindParam(":LanguageId", $this->LanguageId);	
					$this->APKVersion=htmlspecialchars(strip_tags($this->APKVersion));
				$result->bindParam(":APKVersion", $this->APKVersion);	
					$this->DeviceVersion=htmlspecialchars(strip_tags($this->DeviceVersion));
				$result->bindParam(":DeviceVersion", $this->DeviceVersion);	
					$this->DeviceType=htmlspecialchars(strip_tags($this->DeviceType));
				$result->bindParam(":DeviceType", $this->DeviceType);	
					$this->IMEI=htmlspecialchars(strip_tags($this->IMEI));
				$result->bindParam(":IMEI", $this->IMEI);
				$result->execute();
				$this->id = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
				
		
		public function IsCustomerExistByPhoneNumber(){			
			try{
				$sql = "SELECT count(CSR_GPK) as isExist FROM `Customer` where CSR_phoneNumber=:phoneNumber"; //
				$result = $this->conn->prepare($sql);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));				
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Updating customer
		public function UpdateCustomer(){

			try{
				
				$sql = "Update Customer Set CSR_phoneNumber=:phoneNumber,CSR_name=:name,CSR_email=:email,CSR_status=:status,CSR_modifiedOn=:modifiedOn where CSR_GPK=:id";
			    $result = $this->conn->prepare($sql);
				
			    $this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				
                $this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
               
                $this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);

                $this->email=htmlspecialchars(strip_tags($this->email));
				$result->bindParam(":email", $this->email);
				
                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);

                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
			public function UpdateCustomerLanguage(){

			try{
				
				$sql = "Update Customer Set CSR_LanguageId=:LanguageId where CSR_GPK=:id";
			    $result = $this->conn->prepare($sql);
				
			    $this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				
                    $this->LanguageId=htmlspecialchars(strip_tags($this->LanguageId));
				$result->bindParam(":LanguageId", $this->LanguageId);
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		//Getting customer details by PhoneNumber
		public function UpdateTokenIdByPhoneNumber()
		{
			try {
				$sql = "update Customer set CSR_tokenId=:tokenId, CSR_APKVersion=:APKVersion,CSR_DeviceVersion=:DeviceVersion,CSR_DeviceType=:DeviceType,CSR_IMEI=:IMEI  where CSR_phoneNumber=:phoneNumber"; 
				$result = $this->conn->prepare($sql);
				
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$this->APKVersion=htmlspecialchars(strip_tags($this->APKVersion));
				$result->bindParam(":APKVersion", $this->APKVersion);	
					$this->DeviceVersion=htmlspecialchars(strip_tags($this->DeviceVersion));
				$result->bindParam(":DeviceVersion", $this->DeviceVersion);	
					$this->DeviceType=htmlspecialchars(strip_tags($this->DeviceType));
				$result->bindParam(":DeviceType", $this->DeviceType);	
					$this->IMEI=htmlspecialchars(strip_tags($this->IMEI));
				$result->bindParam(":IMEI", $this->IMEI);	

				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		//Getting All customer details 
		public function GetAllCustomer()
		{
			try {
				$sql = "select * from Customer where CSR_status=1"; //
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All customer details 
		public function GetAllCustomerWithLastSR()
		{
			try {
				$sql = "select *, group_concat(A.ADR_zipcode) as zipcodeList from Customer.Customer as C
left join Address.Address as A on A.ADR_CSR_GFK = C.CSR_GPK and A.ADR_status=1 
left join 
(
select * from Service.Service where SVC_GPK in
(
select max(SVC_GPK) from Service.Service where SVC_createdOn in
(select max(SVC_createdOn) from Service.Service group by SVC_CST_GFK)
group by SVC_CST_GFK
)  
) as S
on S.SVC_CST_GFK=C.CSR_GPK
group by C.CSR_GPK
order by S.SVC_GPK desc"; 
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		public function UpdateTokenIdByCustomerId()
		{
			try {
				$sql = "update Customer set CSR_tokenId=:tokenId where CSR_GPK=:id"; //
				$result = $this->conn->prepare($sql);
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}					
		
		public function UpdateSessionIdByCustomerId()
		{
			try {
				$sql = "update Customer set CSR_sessionId=:sessionId where CSR_GPK=:id"; //
				$result = $this->conn->prepare($sql);
				$this->sessionId=htmlspecialchars(strip_tags($this->sessionId));
				$result->bindParam(":sessionId", $this->sessionId);
				$this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateSessionTokenIdByCustomerId()
		{
			try {
				$sql = "update Customer set CSR_sessionId=:sessionId,CSR_tokenId=:tokenId where CSR_GPK=:id"; //
				$result = $this->conn->prepare($sql);
				$this->sessionId=htmlspecialchars(strip_tags($this->sessionId));
				$result->bindParam(":sessionId", $this->sessionId);
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function UpdateSessionIdByPhoneNumber()
		{
			try {
				$sql = "update Customer set CSR_sessionId=:sessionId where CSR_phoneNumber=:phoneNumber"; //
				$result = $this->conn->prepare($sql);
				$this->sessionId=htmlspecialchars(strip_tags($this->sessionId));
				$result->bindParam(":sessionId", $this->sessionId);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
}
?>

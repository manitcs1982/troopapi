<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Logistics{
		private $conn;		
		public $id;
		public $phoneNumber;
		public $name;
		public $email;
		public $latitude;
		public $longitude;
		public $status;
		public $createdOn;
		public $modifiedOn;
		public $tokenId;
		public $vehicleType;
		public $date;
		public $accountNumber;
		public $bankName;
		public $ifscCode;
		public $branch;
		public $upiId;
		public $panNumber;
		public $aadharNumber;
		public $vehicleNumber;
		public $licenseNumber;
		public $LanguageId;
		public $APKVersion;
		public $DeviceVersion;
		public $DeviceType;
		public $sessionId;
		public $IMEI;
		public $error;
				
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		//Inserting Logistics{
			public function InsertLogistics(){			
			try{
				
				$sql = "Insert into Logistics Set LGT_phoneNumber=:phoneNumber,LGT_name=:name,LGT_email=:email,LGT_lat=:latitude,LGT_long=:longitude,LGT_status=:status,LGT_tokenId=:tokenId,LGT_vehicleType=:vehicleType,LGT_createdOn=:createdOn,LGT_accountNumber=:accountNumber,LGT_bankName=:bankName,LGT_ifscCode=:ifscCode,LGT_panNumber=:panNumber,LGT_aadharNumber=:aadharNumber,LGT_vehicleNumber=:vehicleNumber,LGT_licenseNumber=:licenseNumber,LGT_branch=:branch,LGT_upiId=:upiId,LGT_sessionId=:sessionId,LGT_modifiedOn=:modifiedOn,LGT_LanguageId=:LanguageId,LGT_APKVersion=:APKVersion,LGT_DeviceVersion=:DeviceVersion,LGT_DeviceType=:DeviceType,LGT_IMEI=:IMEI";
				
				$result = $this->conn->prepare($sql);
				
			    $this->bankName=htmlspecialchars(strip_tags($this->bankName));
				$result->bindParam(":bankName", $this->bankName);
				
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				
				$this->email=htmlspecialchars(strip_tags($this->email));
				$result->bindParam(":email", $this->email);
				
				$this->latitude=htmlspecialchars(strip_tags($this->latitude));
				$result->bindParam(":latitude", $this->latitude);
				
				$this->longitude=htmlspecialchars(strip_tags($this->longitude));
				$result->bindParam(":longitude", $this->longitude);
				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$this->sessionId=htmlspecialchars(strip_tags($this->sessionId));
				$result->bindParam(":sessionId", $this->sessionId);
				
				$this->vehicleType=htmlspecialchars(strip_tags($this->vehicleType));
				$result->bindParam(":vehicleType", $this->vehicleType);
				
				$this->accountNumber=htmlspecialchars(strip_tags($this->accountNumber));
				$result->bindParam(":accountNumber", $this->accountNumber);
				$this->ifscCode=htmlspecialchars(strip_tags($this->ifscCode));
				$result->bindParam(":ifscCode", $this->ifscCode);
				$this->branch=htmlspecialchars(strip_tags($this->branch));
				$result->bindParam(":branch", $this->branch);
				$this->upiId=htmlspecialchars(strip_tags($this->upiId));
				$result->bindParam(":upiId", $this->upiId);
				$this->panNumber=htmlspecialchars(strip_tags($this->panNumber));
				$result->bindParam(":panNumber", $this->panNumber);
				$this->aadharNumber=htmlspecialchars(strip_tags($this->aadharNumber));
				$result->bindParam(":aadharNumber", $this->aadharNumber);
				$this->vehicleNumber=htmlspecialchars(strip_tags($this->vehicleNumber));
				$result->bindParam(":vehicleNumber", $this->vehicleNumber);
				$this->licenseNumber=htmlspecialchars(strip_tags($this->licenseNumber));
				$result->bindParam(":licenseNumber", $this->licenseNumber);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
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
		//Getting Logistics by phoneNumber{
			public function GetLogisticsByPhoneNumber(){			
			try{
				
				$sql = "select * from Logistics where LGT_phoneNumber=:phoneNumber"; //
				$result = $this->conn->prepare($sql);
				
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));	$result->bindParam(":phoneNumber", $this->phoneNumber);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Logistics by phoneNumber{
		public function GetLogisticsById()
		{
			try {

				$sql = "select * from Logistics where LGT_GPK=:id"; //
				$result = $this->conn->prepare($sql);

				$this->id=htmlspecialchars(strip_tags($this->id));	$result->bindParam(":id", $this->id);

				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Logistics by phoneNumber{
			public function GetAvailableLogistics()
		{
			try {
				$sql = "select *from Logistics.Logistics_Availability LGA
	inner join Logistics.Logistics LGT on LGA.LGA_LGT_GFK=LGT.LGT_GPK
	inner join Logistics.Logistics_Capacity LGC on LGC.LGC_GPK=LGT.LGT_vehicleType
where LGT_status=1 and (date(:date) between LGA.LGA_startDate and LGA.LGA_endDate)
and
	case
		when abs(datediff(:date,LGA.LGA_startDate))+1=1 then LGA.LGA_day01=1
		when abs(datediff(:date,LGA.LGA_startDate))+1=2 then LGA.LGA_day02=1
		when abs(datediff(:date,LGA.LGA_startDate))+1=3 then LGA.LGA_day03=1
		when abs(datediff(:date,LGA.LGA_startDate))+1=4 then LGA.LGA_day04=1
		when abs(datediff(:date,LGA.LGA_startDate))+1=5 then LGA.LGA_day05=1
		when abs(datediff(:date,LGA.LGA_startDate))+1=6 then LGA.LGA_day06=1
		when abs(datediff(:date,LGA.LGA_startDate))+1=7 then LGA.LGA_day07=1
	End
	and LGC.LGC_capacity> (select count(*) from Service.Service where SVC_LGT_GFK=LGT.LGT_GPK and (SVC_pickUpDate=:date or SVC_dropDate=:date))
order by LGC.LGC_capacity desc limit 1";

			/*$sql = "select * from Logistics.Logistics_Availability LGA
							inner join Logistics.Logistics LGT on LGA.LGA_LGT_GFK=LGT.LGT_GPK
						where LGT_status=1 and (date(:date) between LGA.LGA_startDate and LGA.LGA_endDate)
						and
							case
								when abs(datediff(:date,LGA.LGA_startDate))+1=1 then LGA.LGA_day01=1
								when abs(datediff(:date,LGA.LGA_startDate))+1=2 then LGA.LGA_day02=1
								when abs(datediff(:date,LGA.LGA_startDate))+1=3 then LGA.LGA_day03=1
								when abs(datediff(:date,LGA.LGA_startDate))+1=4 then LGA.LGA_day04=1
								when abs(datediff(:date,LGA.LGA_startDate))+1=5 then LGA.LGA_day05=1
								when abs(datediff(:date,LGA.LGA_startDate))+1=6 then LGA.LGA_day06=1
								when abs(datediff(:date,LGA.LGA_startDate))+1=7 then LGA.LGA_day07=1
						    End
						order by LGT.LGT_vehicleType desc limit 1"; 
						*/
				$result = $this->conn->prepare($sql);

				$this->date=htmlspecialchars(strip_tags($this->date));	$result->bindParam(":date", $this->date);

				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		//Getting All Logistics
		public function GetAllLogistics()
		{
			try {

				$sql = "select * from Logistics"; //
				$result = $this->conn->prepare($sql);

				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function IsLogisticsExistByPhoneNumber(){			
			try{
				$sql = "SELECT count(LGT_GPK) as isExist FROM `Logistics` where LGT_phoneNumber=:phoneNumber"; //
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
		//Updating logistics
		public function UpdateLogistics(){

			try{
				
				$sql = "Update Logistics Set LGT_phoneNumber=:phoneNumber,LGT_name=:name,LGT_email=:email,LGT_lat=:lat,LGT_long=:long,LGT_vehicleType=:vehicleType,LGT_status=:status ,LGT_modifiedOn=:modifiedOn,LGT_accountNumber=:accountNumber,LGT_bankName=:bankName,LGT_ifscCode=:ifscCode,LGT_panNumber=:panNumber,LGT_aadharNumber=:aadharNumber,LGT_vehicleNumber=:vehicleNumber,LGT_licenseNumber=:licenseNumber,LGT_branch=:branch,LGT_upiId=:upiId where LGT_GPK=:id";
			    $result = $this->conn->prepare($sql);
				
			    $this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				
				$this->bankName=htmlspecialchars(strip_tags($this->bankName));
				$result->bindParam(":bankName", $this->bankName);
				
                $this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
               
                $this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);

                $this->email=htmlspecialchars(strip_tags($this->email));
				$result->bindParam(":email", $this->email);
				
				$this->latitude=htmlspecialchars(strip_tags($this->latitude));
				$result->bindParam(":lat", $this->latitude);
				
				$this->longitude=htmlspecialchars(strip_tags($this->longitude));
				$result->bindParam(":long", $this->longitude);
				
				$this->vehicleType=htmlspecialchars(strip_tags($this->vehicleType));
				$result->bindParam(":vehicleType", $this->vehicleType);

                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->accountNumber=htmlspecialchars(strip_tags($this->accountNumber));
				$result->bindParam(":accountNumber", $this->accountNumber);
				$this->ifscCode=htmlspecialchars(strip_tags($this->ifscCode));
				$result->bindParam(":ifscCode", $this->ifscCode);
				$this->branch=htmlspecialchars(strip_tags($this->branch));
				$result->bindParam(":branch", $this->branch);
				$this->upiId=htmlspecialchars(strip_tags($this->upiId));
				$result->bindParam(":upiId", $this->upiId);
				$this->panNumber=htmlspecialchars(strip_tags($this->panNumber));
				$result->bindParam(":panNumber", $this->panNumber);
				$this->aadharNumber=htmlspecialchars(strip_tags($this->aadharNumber));
				$result->bindParam(":aadharNumber", $this->aadharNumber);
				$this->vehicleNumber=htmlspecialchars(strip_tags($this->vehicleNumber));
				$result->bindParam(":vehicleNumber", $this->vehicleNumber);
                $this->licenseNumber=htmlspecialchars(strip_tags($this->licenseNumber));
				$result->bindParam(":licenseNumber", $this->licenseNumber);
                

                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		
		public function UpdateLogisticsLanguage(){

			try{
				
				$sql = "Update Logistics Set LGT_LanguageId=:LanguageId where LGT_GPK=:id";
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
		
		public function UpdateTokenIdByPhoneNumber()
		{
			try {

				$sql = "update Logistics set LGT_tokenId=:tokenId, LGT_APKVersion=:APKVersion,LGT_DeviceVersion=:DeviceVersion,LGT_DeviceType=:DeviceType,LGT_IMEI=:IMEI where LGT_phoneNumber=:phoneNumber"; //
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
		
		
		
		public function UpdateTokenIdBylogisticsId()
		{
			try {

				$sql = "update Logistics set LGT_tokenId=:tokenId where LGT_GPK=:id"; //
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
		
		
		
		
		public function UpdateSessionIdBylogisticsId()
		{
			try {

				$sql = "update Logistics set LGT_sessionId=:sessionId where LGT_GPK=:id"; //
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

		
		public function UpdateSessionTokenIdBylogisticsId()
		{
			try {

				$sql = "update Logistics set LGT_sessionId=:sessionId,LGT_tokenId=:tokenId where LGT_GPK=:id"; //
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
		
		public function UpdateSessionIdByPhoneNumber()
		{
			try {

				$sql = "update Logistics set LGT_sessionId=:sessionId where LGT_phoneNumber=:phoneNumber"; //
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
		

		 
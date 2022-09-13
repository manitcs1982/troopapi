<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Vendor{
		private $conn;
		public $vendorId;
		public $zoneId;
		public $geoLocationLat;
		public $geoLocationLong;
		public $businessName;
		public $phone;
		public $businessOwnerName;
		public $alternatePhoneNo1;
		public $alternatePhoneNo2;
		public $alternatePhoneNo3;
		public $itemMasterId;
		public $interested;
		public $currentVolume;
		public $notes;
		public $status;
		public $createdOn;
		public $modifiedOn;
		public $address;
		public $pendingServiceCount;
		public $productId;
		public $capacity;		
		public $dayId;
		public $tokenId;		
		public $date;
		public $error;
		public $sessionId;
		public $bankAccountNumber;
		public $ifscCode;
		public $bankBrach;
		public $bankName;
		public $aadharNumber;
		public $upiId;
		public $panNumber;		
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
		
		
		//Insertng the Vendor details
		public function InsertVendorDetails(){
			try{
				
				$sql = "Insert into Vendor Set VDR_geoLocationLat=:geoLocationLat,VDR_geoLocationLong=:geoLocationLong,VDR_businessName=:businessName,VDR_phone=:phone,
				VDR_businessOwnerName=:businessOwnerName,VDR_alternatePhoneNo1=:alternatePhoneNo1,VDR_alternatePhoneNo2=:alternatePhoneNo2,VDR_alternatePhoneNo3=:alternatePhoneNo3,
				VDR_itemMasterId=:itemMasterId,VDR_interested=:interested,VDR_currentVolume=:currentVolume,VDR_notes=:notes,VDR_status=:status,VDR_createdOn=:createdOn,
				VDR_bankAccountNumber=:bankAccountNumber,VDR_ifscCode=:ifscCode,VDR_upiId=:upiId,VDR_panNumber=:panNumber,VDR_bankBranch=:bankBranch,VDR_bankName=:bankName,VDR_aadharNumber=:aadharNumber,VDR_LanguageId=:LanguageId,VDR_APKVersion=:APKVersion,VDR_DeviceVersion=:DeviceVersion,VDR_DeviceType=:DeviceType,VDR_IMEI=:IMEI";
			    $result = $this->conn->prepare($sql);
			    			    				
				$this->geoLocationLat=htmlspecialchars(strip_tags($this->geoLocationLat));
				$result->bindParam(":geoLocationLat", $this->geoLocationLat);
				$this->geoLocationLong=htmlspecialchars(strip_tags($this->geoLocationLong));
				$result->bindParam(":geoLocationLong", $this->geoLocationLong);
				$this->businessName=htmlspecialchars(strip_tags($this->businessName));
				$result->bindParam(":businessName", $this->businessName);
				$this->phone=htmlspecialchars(strip_tags($this->phone));
				$result->bindParam(":phone", $this->phone);	
				$this->businessOwnerName=htmlspecialchars(strip_tags($this->businessOwnerName));
				$result->bindParam(":businessOwnerName", $this->businessOwnerName);	
				$this->alternatePhoneNo1=htmlspecialchars(strip_tags($this->alternatePhoneNo1));
				$result->bindParam(":alternatePhoneNo1", $this->alternatePhoneNo1);	
				$this->alternatePhoneNo2=htmlspecialchars(strip_tags($this->alternatePhoneNo2));
				$result->bindParam(":alternatePhoneNo2", $this->alternatePhoneNo2);	
				$this->alternatePhoneNo3=htmlspecialchars(strip_tags($this->alternatePhoneNo3));
				$result->bindParam(":alternatePhoneNo3", $this->alternatePhoneNo3);	
				$this->itemMasterId=htmlspecialchars(strip_tags($this->itemMasterId));
				$result->bindParam(":itemMasterId", $this->itemMasterId);	
				$this->interested=htmlspecialchars(strip_tags($this->interested));
				$result->bindParam(":interested", $this->interested);	
				$this->currentVolume=htmlspecialchars(strip_tags($this->currentVolume));
				$result->bindParam(":currentVolume", $this->currentVolume);	
                $this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				$this->bankAccountNumber=htmlspecialchars(strip_tags($this->bankAccountNumber));
				$result->bindParam(":bankAccountNumber", $this->bankAccountNumber);
				$this->ifscCode=htmlspecialchars(strip_tags($this->ifscCode));
				$result->bindParam(":ifscCode", $this->ifscCode);
				$this->upiId=htmlspecialchars(strip_tags($this->upiId));
				$result->bindParam(":upiId", $this->upiId);
				$this->panNumber=htmlspecialchars(strip_tags($this->panNumber));
				$result->bindParam(":panNumber", $this->panNumber);
				$this->bankBranch=htmlspecialchars(strip_tags($this->bankBranch));
				$result->bindParam(":bankBranch", $this->bankBranch);
				$this->bankName=htmlspecialchars(strip_tags($this->bankName));
				$result->bindParam(":bankName", $this->bankName);
				$this->aadharNumber=htmlspecialchars(strip_tags($this->aadharNumber));
				$result->bindParam(":aadharNumber", $this->aadharNumber);
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
				$this->vendorId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Insertng the Vendor details
		public function UpdateVendorDetails(){
			try{
				
				$sql = "Update Vendor Set VDR_geoLocationLat=:geoLocationLat,VDR_geoLocationLong=:geoLocationLong,VDR_businessName=:businessName,VDR_phone=:phone,
				VDR_businessOwnerName=:businessOwnerName,VDR_alternatePhoneNo1=:alternatePhoneNo1,VDR_alternatePhoneNo2=:alternatePhoneNo2,VDR_alternatePhoneNo3=:alternatePhoneNo3,
				VDR_itemMasterId=:itemMasterId,VDR_interested=:interested,VDR_currentVolume=:currentVolume,VDR_notes=:notes,VDR_status=:status,VDR_modifiedOn=:createdOn,
				VDR_bankAccountNumber=:bankAccountNumber,VDR_ifscCode=:ifscCode,VDR_upiId=:upiId,VDR_panNumber=:panNumber,VDR_bankBranch=:bankBranch,VDR_bankName=:bankName,VDR_aadharNumber=:aadharNumber where VDR_GPK=:vendorId";
			    $result = $this->conn->prepare($sql);
			    			    				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);				
				$this->geoLocationLat=htmlspecialchars(strip_tags($this->geoLocationLat));
				$result->bindParam(":geoLocationLat", $this->geoLocationLat);
				$this->geoLocationLong=htmlspecialchars(strip_tags($this->geoLocationLong));
				$result->bindParam(":geoLocationLong", $this->geoLocationLong);
				$this->businessName=htmlspecialchars(strip_tags($this->businessName));
				$result->bindParam(":businessName", $this->businessName);
				$this->phone=htmlspecialchars(strip_tags($this->phone));
				$result->bindParam(":phone", $this->phone);	
				$this->businessOwnerName=htmlspecialchars(strip_tags($this->businessOwnerName));
				$result->bindParam(":businessOwnerName", $this->businessOwnerName);	
				$this->alternatePhoneNo1=htmlspecialchars(strip_tags($this->alternatePhoneNo1));
				$result->bindParam(":alternatePhoneNo1", $this->alternatePhoneNo1);	
				$this->alternatePhoneNo2=htmlspecialchars(strip_tags($this->alternatePhoneNo2));
				$result->bindParam(":alternatePhoneNo2", $this->alternatePhoneNo2);	
				$this->alternatePhoneNo3=htmlspecialchars(strip_tags($this->alternatePhoneNo3));
				$result->bindParam(":alternatePhoneNo3", $this->alternatePhoneNo3);	
				$this->itemMasterId=htmlspecialchars(strip_tags($this->itemMasterId));
				$result->bindParam(":itemMasterId", $this->itemMasterId);	
				$this->interested=htmlspecialchars(strip_tags($this->interested));
				$result->bindParam(":interested", $this->interested);	
				$this->currentVolume=htmlspecialchars(strip_tags($this->currentVolume));
				$result->bindParam(":currentVolume", $this->currentVolume);	
                $this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				$this->bankAccountNumber=htmlspecialchars(strip_tags($this->bankAccountNumber));
				$result->bindParam(":bankAccountNumber", $this->bankAccountNumber);
				$this->ifscCode=htmlspecialchars(strip_tags($this->ifscCode));
				$result->bindParam(":ifscCode", $this->ifscCode);
				$this->upiId=htmlspecialchars(strip_tags($this->upiId));
				$result->bindParam(":upiId", $this->upiId);
				$this->panNumber=htmlspecialchars(strip_tags($this->panNumber));
				$result->bindParam(":panNumber", $this->panNumber);
				$this->bankBranch=htmlspecialchars(strip_tags($this->bankBranch));
				$result->bindParam(":bankBranch", $this->bankBranch);
					$this->bankName=htmlspecialchars(strip_tags($this->bankName));
				$result->bindParam(":bankName", $this->bankName);
				$this->aadharNumber=htmlspecialchars(strip_tags($this->aadharNumber));
				$result->bindParam(":aadharNumber", $this->aadharNumber);
				$result->execute();
				
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		
				public function UpdateVendorDetailsLanguage(){
			try{
				
				$sql = "Update Vendor Set VDR_LanguageId=:LanguageId where VDR_GPK=:vendorId";
			    $result = $this->conn->prepare($sql);
			    			    				
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);	
			
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
		public function GetAllVendorDetails(){			
			try{
				$sql = "select * from Vendor"; //
				$result = $this->conn->prepare($sql);				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function GetvendorIdDetailsByVendorId(){			
			try{
				$sql = "select * from Vendor where VDR_GPK=:vendorId"; //
				$result = $this->conn->prepare($sql);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		public function GetVendorDetailsByZipcode(){			
			try{
				
				$sql = "SELECT * FROM Vendor.Vendor
                         inner JOIN Address.Address
                         ON Address.ADR_VDR_GFK = Vendor.VDR_GPK
                         where ADR_zipcode =:zipcode";
				$result = $this->conn->prepare($sql);
				$this->zipcode=htmlspecialchars(strip_tags($this->zipcode));				
				$result->bindParam(":zipcode", $this->zipcode);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Getting customer details by PhoneNumber
		public function GetAvailableVendor(){			
			try{
				$sql = "select * from Vendor as VDR
							inner join Vendor_Availability as VDA
							on VDR.VDR_GPK=VDA.VDA_VDR_GFK
							inner join Vendor_Capacity as VDC
							on VDR.VDR_GPK=VDC.VDC_VDR_GFK
							where VDR_ZNM_GFK=:zoneId and VDC.VDC_PDM_GFK=:productId and VDC_status=1 and VDR_status=1 and (date(:date) between VDA.VDA_startDate and VDA.VDA_endDate)
								and case
									when abs(datediff(:date,VDA.VDA_startDate))+1=1 then VDA.VDA_day01=1
									when abs(datediff(:date,VDA.VDA_startDate))+1=2 then VDA.VDA_day02=1
									when abs(datediff(:date,VDA.VDA_startDate))+1=3 then VDA.VDA_day03=1
									when abs(datediff(:date,VDA.VDA_startDate))+1=4 then VDA.VDA_day04=1
									when abs(datediff(:date,VDA.VDA_startDate))+1=5 then VDA.VDA_day05=1
									when abs(datediff(:date,VDA.VDA_startDate))+1=6 then VDA.VDA_day06=1
									when abs(datediff(:date,VDA.VDA_startDate))+1=7 then VDA.VDA_day07=1
								End

							and VDC.VDC_capacity> (select count(*) from Service.Service where SVC_VDR_GFK=VDR.VDR_GPK and SVC_pickUpDate=:date)";
				$result = $this->conn->prepare($sql);
				$this->zoneId=htmlspecialchars(strip_tags($this->zoneId));				
				$result->bindParam(":zoneId", $this->zoneId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);		
				$this->date=htmlspecialchars(strip_tags($this->date));				
				$result->bindParam(":date", $this->date);				
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Getting vendor details by PhoneNumber
		public function GetVendorDetailsByPhoneNumber(){			
			try{
				$sql = "select * from Vendor where VDR_phone=:phone"; //
				$result = $this->conn->prepare($sql);
				$this->phone=htmlspecialchars(strip_tags($this->phone));				
				$result->bindParam(":phone", $this->phone);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		public function IsVendorExistByPhoneNumber(){			
			try{
				$sql = "SELECT count(VDR_GPK) as isExist FROM `Vendor` where VDR_phone=:phone"; //
				$result = $this->conn->prepare($sql);
				$this->phone=htmlspecialchars(strip_tags($this->phone));				
				$result->bindParam(":phone", $this->phone);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting all vendor
		public function GetAllVendor(){			
			try{
				$sql = "select * from Vendor"; //
				$result = $this->conn->prepare($sql);				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function UpdateTokenIdByPhoneNumber()
		{
			try {
				$sql = "update Vendor set VDR_tokenId=:tokenId , VDR_APKVersion=:APKVersion,VDR_DeviceVersion=:DeviceVersion,VDR_DeviceType=:DeviceType,VDR_IMEI=:IMEI where VDR_phone=:phone"; 
				$result = $this->conn->prepare($sql);
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$this->phone=htmlspecialchars(strip_tags($this->phone));
				$result->bindParam(":phone", $this->phone);	
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
				$this->error = "Error: token ".$e->getMessage();
				return false;
			}
		}
		
		
		// updating tokenid by usig vendorid
		public function UpdateToken()
		{
			try {
				$sql = "update Vendor set VDR_tokenId=:tokenId where VDR_GPK=:vendorId"; //
				$result = $this->conn->prepare($sql);
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);	
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: token ".$e->getMessage();
				return false;
			}
		}
		//updating table with sessionId using id
		public function UpdateSessionIdByVendorId()
		{
			try {
				$sql = "update Vendor set VDR_sessionId=:sessionId where VDR_GPK=:vendorId"; //
				$result = $this->conn->prepare($sql);
				$this->sessionId=htmlspecialchars(strip_tags($this->sessionId));
				$result->bindParam(":sessionId", $this->sessionId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);	
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: token ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateSessionTokenIdByVendorId()
		{
			try {
				$sql = "update Vendor set VDR_sessionId=:sessionId,VDR_tokenId=:tokenId where VDR_GPK=:vendorId";
				$result = $this->conn->prepare($sql);
				$this->sessionId=htmlspecialchars(strip_tags($this->sessionId));
				$result->bindParam(":sessionId", $this->sessionId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				$this->tokenId=htmlspecialchars(strip_tags($this->tokenId));
				$result->bindParam(":tokenId", $this->tokenId);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: token ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateSessionIdByPhoneNumber()
		{
			try {
				$sql = "update Vendor set VDR_sessionId=:sessionId where VDR_phone=:phone"; //
				$result = $this->conn->prepare($sql);
				$this->sessionId=htmlspecialchars(strip_tags($this->sessionId));
				$result->bindParam(":sessionId", $this->sessionId);
				$this->phone=htmlspecialchars(strip_tags($this->phone));
				$result->bindParam(":phone", $this->phone);	
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: token ".$e->getMessage();
				return false;
			}
		}
}
?>

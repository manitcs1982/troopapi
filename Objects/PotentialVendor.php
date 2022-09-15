<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PotentialVendor{
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
		public $productList;
		
		public $error;
		

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		//Insertng the Vendor details
		public function InsertPotentialVendorDetails(){
			try{
				
				$sql = "Insert into Potential_Vendor Set PVD_geoLocationLat=:geoLocationLat,PVD_geoLocationLong=:geoLocationLong,PVD_businessName=:businessName,PVD_phone=:phone,
				PVD_businessOwnerName=:businessOwnerName,PVD_alternatePhoneNo1=:alternatePhoneNo1,PVD_alternatePhoneNo2=:alternatePhoneNo2,PVD_alternatePhoneNo3=:alternatePhoneNo3,
				PVD_itemMasterId=:itemMasterId,PVD_interested=:interested,PVD_currentVolume=:currentVolume,PVD_notes=:notes,PVD_productList=:productList,PVD_status=:status,PVD_createdOn=:createdOn";
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
				$this->productList=htmlspecialchars(strip_tags($this->productList));
				$result->bindParam(":productList", $this->productList);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				
				$result->execute();
				$this->vendorId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
				
		//Getting customer details by PhoneNumber
		public function GetAllPotentialVendorDetails()
		{			
			try{
				$sql = "select * from Potential_Vendor where PVD_status=1"; //
				$result = $this->conn->prepare($sql);				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function GetPotentialVendorIdDetailsByVendorId()
		{			
			try{
				$sql = "select * from Potential_Vendor where PVD_GPK=:vendorId"; //
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
		
		
		//Getting vendor details by PhoneNumber
		public function GetPotentialVendorDetailsByPhoneNumber()
		{			
			try{
				$sql = "select * from Potential_Vendor where PVD_phone=:phone"; //
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
		
		//Updating vendor details
		public function UpdatePotentialVendorDetails(){

			try{
				
				$sql = "Update Potential_Vendor Set PVD_geoLocationLat=:geoLocationLat,PVD_geoLocationLong=:geoLocationLong,PVD_businessName=:businessName,PVD_phone=:phone,
				PVD_businessOwnerName=:businessOwnerName,PVD_alternatePhoneNo1=:alternatePhoneNo1,PVD_alternatePhoneNo2=:alternatePhoneNo2,PVD_alternatePhoneNo3=:alternatePhoneNo3,
				PVD_itemMasterId=:itemMasterId,PVD_interested=:interested,PVD_currentVolume=:currentVolume,PVD_notes=:notes,PVD_status=:status,PVD_createdOn=:createdOn where PVD_GPK=:vendorId";
				
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
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}	
		
}
?>

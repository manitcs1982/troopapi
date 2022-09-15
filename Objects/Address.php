<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Address{
		private $conn;		
		public $id;
		public $customerId;
		public $vendorId;	
		public $potentialVendorId;	
		public $phoneNumber;
		public $addressLabel;
		public $addressLine1;
		public $addressLine2;
		public $city;
		public $state;
		public $zipcode;
		public $status;
		public $createdOn;
		public $modifiedOn;
        public $latitude;
        public $longitude;		
        public $serviceCount;		
		public $error;
		
		public $test;
		
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
		}
		
		//Getting Address by addressId
		public function GetAddressByAddressId(){			
			try{
				$sql = "select * from Address where ADR_GPK=:id"; //
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
		
		//Getting Address by vendorId
		public function GetAddressByVendorId(){			
			try{
				$sql = "select * from Address where ADR_VDR_GFK=:vendorId and ADR_status=1 order by ADR_srCount"; //
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
		
		//Getting Address by customerId
		public function GetAddressByCustomerId(){			
			try{
				$sql = "select * from Address where ADR_CSR_GFK=:customerId and ADR_status=1  order by ADR_srCount"; //
				$result = $this->conn->prepare($sql);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));				
				$result->bindParam(":customerId", $this->customerId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Address by customerId
		public function GetAddressByPotentialVendorId()
		{
			try {
				$sql = "select * from Address where ADR_PVD_GFK=:potentialVendorId and ADR_status=1  order by ADR_srCount"; //
				$result = $this->conn->prepare($sql);
				$this->potentialVendorId=htmlspecialchars(strip_tags($this->potentialVendorId));
				$result->bindParam(":potentialVendorId", $this->potentialVendorId);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Address by customerId and Label
		public function GetAddressByCustomerIdAndAddressLabel(){			
			try{
				$sql = "select * from Address where ADR_CSR_GFK=:customerId and ADR_addressLabel=:addressLabel and ADR_status=1  order by ADR_srCount"; //
				$result = $this->conn->prepare($sql);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));				
				$result->bindParam(":customerId", $this->customerId);
				$this->addressLabel=htmlspecialchars(strip_tags($this->addressLabel));				
				$result->bindParam(":addressLabel", $this->addressLabel);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Insertng the customer details
		public function InsertAddress(){
			try{
				
				if ($this->id) {
					$sql1 = " update Address set ADR_status=0 where ADR_GPK=:id";
					$result1 = $this->conn->prepare($sql1);
					$this->id=htmlspecialchars(strip_tags($this->id));
					$result1->bindParam(":id", $this->id);					
					$result1->execute();
				}
				
				$sql = "Insert into Address Set ADR_CSR_GFK=:customerId ,ADR_VDR_GFK=:vendorId,ADR_PVD_GFK=:potentialVendorId,ADR_phoneNumber=:phoneNumber,ADR_addressLabel=:addressLabel,ADR_addressLine1=:addressLine1,ADR_addressLine2=:addressLine2,ADR_city=:city,ADR_state=:state,ADR_zipcode=:zipcode,ADR_status=:status,ADR_createdOn=:createdOn,ADR_lat=:latitude,ADR_long=:longitude; ";
				
			    $result = $this->conn->prepare($sql);
			    $this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				$this->potentialVendorId=htmlspecialchars(strip_tags($this->potentialVendorId));
				$result->bindParam(":potentialVendorId", $this->potentialVendorId);
				$this->addressLabel=htmlspecialchars(strip_tags($this->addressLabel));
				$result->bindParam(":addressLabel", $this->addressLabel);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$this->addressLine1=htmlspecialchars(strip_tags($this->addressLine1));
				$result->bindParam(":addressLine1", $this->addressLine1);				
				$this->addressLine2=htmlspecialchars(strip_tags($this->addressLine2));
				$result->bindParam(":addressLine2", $this->addressLine2);
				$this->city=htmlspecialchars(strip_tags($this->city));
				$result->bindParam(":city", $this->city);
				$this->state=htmlspecialchars(strip_tags($this->state));
				$result->bindParam(":state", $this->state);
				$this->zipcode=htmlspecialchars(strip_tags($this->zipcode));
				$result->bindParam(":zipcode", $this->zipcode);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);		
                $this->latitude=htmlspecialchars(strip_tags($this->latitude));
				$result->bindParam(":latitude", $this->latitude);
				$this->longitude=htmlspecialchars(strip_tags($this->longitude));
				$result->bindParam(":longitude", $this->longitude);				
				
				$result->execute();
				$this->id = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function DeleteAddress()
		{
			try {
				$sql = " update Address set ADR_status=0 where ADR_GPK=:id;";

				$result = $this->conn->prepare($sql);
				$this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);

				$result->execute();
				return true;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateAddressServiceCount()
		{
			try {
				$sql = "select @prevCount:=ADR_srCount from Address.Address where ADR_GPK=:id;
update Address.Address set ADR_srCount=@prevCount+1  where ADR_GPK=:id";

				$result = $this->conn->prepare($sql);
				$this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);				
				
				$result->execute();
				return true;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		//Getting Address by customerId
		public function IsAddressEligible(){			
			try{
				$sql = "select * from Address.Address A
inner join Pincode_Master.Pincode_Master PM
on A.ADR_zipcode=PM.PIN_pincode
where ADR_GPK=:addressId and PIN_status=1  "; //
//and ADR_status=1
				$result = $this->conn->prepare($sql);
				$this->addressId=htmlspecialchars(strip_tags($this->addressId));				
				$result->bindParam(":addressId", $this->addressId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
}
?>

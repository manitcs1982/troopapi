<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class VendorCapacity{
		private $conn;		
		public $vendorCapacityId;
		public $vendorId;
		public $productId;
		public $capacity;
		public $model;
		public $brand;
		public $status;
		public $createdOn;
		public $modifiedOn;		
		public $name;		
		public $error;


		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Getting customer details by PhoneNumber
		public function GetAllVendorCapacityDetails(){			
			try{
				$sql = "select * from Vendor_Capacity"; //
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
			
		
		//Getting customer details by PhoneNumber
		public function GetVendorCapacityDetailsById(){			
			try{
				$sql = "select * from Vendor_Capacity where VDC_GPK=:vendorCapacityId"; //
				$result = $this->conn->prepare($sql);
				$this->vendorCapacityId=htmlspecialchars(strip_tags($this->vendorCapacityId));				
				$result->bindParam(":vendorCapacityId", $this->vendorCapacityId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by vendorId
		public function GetVendorCapacityDetailsByVendorId()
		{
			try {
						$sql = 	"select * from Vendor.Vendor_Capacity C
	                      right join Product_Master.Product_Master P
		                  on C.VDC_PDM_GFK=P.PDM_GPK and VDC_VDR_GFK=:vendorId 
                          where P.PDM_status=1";
				$result = $this->conn->prepare($sql);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by vendorId and Status
		public function GetVendorCapacityDetailsByVendorIdAndStatus()
		{
			try {
				$sql = "select * from Vendor_Capacity where VDC_VDR_GFK=:vendorId and find_in_set(VDC_status,:status)"; //

				$result = $this->conn->prepare($sql);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function InsertVendorCapacity(){			
			try{
				$sql = "Insert into Vendor_Capacity set VDC_PDM_GFK=:productId, VDC_VDR_GFK=:vendorId, VDC_capacity=:capacity , VDC_model=:model ,VDC_brand=:brand ,VDC_status=:status ,VDC_createdOn=:createdOn,VDC_modifiedOn=:modifiedOn"; //
						
				$result = $this->conn->prepare($sql);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);
				$this->capacity=htmlspecialchars(strip_tags($this->capacity));				
				$result->bindParam(":capacity", $this->capacity);
				$this->model=htmlspecialchars(strip_tags($this->model));				
				$result->bindParam(":model", $this->model);
				$this->brand=htmlspecialchars(strip_tags($this->brand));				
				$result->bindParam(":brand", $this->brand);
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));				
				$result->bindParam(":createdOn", $this->createdOn);
				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));				
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				
				$result->execute();
				$this->vendorCapacityId = $this->conn->lastInsertId();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function UpdateVendorCapacity(){			
			try{
				$sql = "Update Vendor_Capacity set VDC_PDM_GFK=:productId, VDC_VDR_GFK=:vendorId, VDC_capacity=:capacity , VDC_model=:model ,VDC_brand=:brand ,VDC_status=:status ,VDC_modifiedOn=:modifiedOn where VDC_GPK=:vendorCapacityId"; //
						
				$result = $this->conn->prepare($sql);
				$this->vendorCapacityId=htmlspecialchars(strip_tags($this->vendorCapacityId));				
				$result->bindParam(":vendorCapacityId", $this->vendorCapacityId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);
				$this->capacity=htmlspecialchars(strip_tags($this->capacity));				
				$result->bindParam(":capacity", $this->capacity);
				$this->model=htmlspecialchars(strip_tags($this->model));				
				$result->bindParam(":model", $this->model);
				$this->brand=htmlspecialchars(strip_tags($this->brand));				
				$result->bindParam(":brand", $this->brand);
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));				
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				
				$result->execute();				
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
}
?>

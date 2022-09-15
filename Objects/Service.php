
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../Config/config.php';

class Service{
	
		private $conn;		
		public $serviceId;
		public $customerId;
		public $vendorId;
		public $logisticsId;
		public $customerProductId;
		public $productId;
		public $customerAddressId;
		public $vendorAddressId;		
		public $serviceCharge;
		public $otp;
		public $randomNumber;
		public $status;
		
		public $pickUpDate;
		public $pickUpSlot;
		public $dropDate;
		public $dropSlot;
		public $notes;
		public $isTurnOn;
		public $createdOn;
		public $modifiedOn;
		public $isOtpMatch;
		public $pendingServiceCount=0;
		public $logisticsLatitude;
		public $logisticsLongitude;	
		public $referenceId;
		public $isReopened;
		public $reopenSRId;
		public $reopenReferenceId;
		public $isCancelled;
		public $cancelledBy;
		public $cancelledStatus;
		public $customerTotal;
		public $vendorTotal;
		public $customerDisplayTotal;
		public $deliveryFee;
		public $GSTAmount;
		public $fixedVideoPath;
		public $defectAudioPath;		

		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		//Inserting the Service details
		public function InsertServiceDetails(){

			try{
				
				$sql = "Insert into Service Set SVC_CST_GFK=:customerId,SVC_VDR_GFK=:vendorId,SVC_LGT_GFK=:logisticsId,SVC_CSP_GFK=:customerProductId,SVC_PDM_GFK=:productId,SVC_ADR_GFK=:addressId,SVC_serviceCharge=:serviceCharge,SVC_otp=:otp,SVC_randomNumber=:randomNumber,SVC_status=:status,SVC_customerTotal=:customerTotal,SVC_vendorTotal=:vendorTotal,SVC_pickUpDate=:pickUpDate,SVC_pickUpSlot=:pickUpSlot,SVC_notes=:notes,SVC_isTurnOn=:isTurnOn,SVC_createdOn=:createdOn";
			    $result = $this->conn->prepare($sql);
			    $this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));
				$result->bindParam(":customerProductId", $this->customerProductId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->addressId=htmlspecialchars(strip_tags($this->addressId));
				$result->bindParam(":addressId", $this->addressId);
				$this->serviceCharge=htmlspecialchars(strip_tags($this->serviceCharge));
				$result->bindParam(":serviceCharge", $this->serviceCharge);
				$this->otp=htmlspecialchars(strip_tags($this->otp));
				$result->bindParam(":otp", $this->otp);
                $this->randomNumber=htmlspecialchars(strip_tags($this->randomNumber));
				$result->bindParam(":randomNumber", $this->randomNumber);
                $this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
                $this->customerTotal=htmlspecialchars(strip_tags($this->customerTotal));
				$result->bindParam(":customerTotal", $this->customerTotal);
                $this->vendorTotal=htmlspecialchars(strip_tags($this->vendorTotal));
				$result->bindParam(":vendorTotal", $this->vendorTotal);
				$this->pickUpDate=htmlspecialchars(strip_tags($this->pickUpDate));
				$result->bindParam(":pickUpDate", $this->pickUpDate);
				$this->pickUpSlot=htmlspecialchars(strip_tags($this->pickUpSlot));
				$result->bindParam(":pickUpSlot", $this->pickUpSlot);
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);
				$this->isTurnOn=htmlspecialchars(strip_tags($this->isTurnOn));
				$result->bindParam(":isTurnOn", $this->isTurnOn);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);	
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);					
				
				$result->execute();
				$this->serviceId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating the Service details
		public function UpdateServiceStatus(){

			try{
				
				$sql = "Update Service Set SVC_status=:status,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);

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
					
		//Updating the Service details
		public function UpdateCancelStatus(){

			try{
				
				$sql = "Update Service Set SVC_status=:status,SVC_modifiedOn=:modifiedOn,SVC_isCancelled=:isCancelled,SVC_cancelledBy=:cancelledBy,SVC_cancelledStatus=:cancelledStatus where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				
				$this->isCancelled=htmlspecialchars(strip_tags($this->isCancelled));
				$result->bindParam(":isCancelled", $this->isCancelled);
				
				$this->cancelledBy=htmlspecialchars(strip_tags($this->cancelledBy));
				$result->bindParam(":cancelledBy", $this->cancelledBy);
				
				$this->cancelledStatus=htmlspecialchars(strip_tags($this->cancelledStatus));
				$result->bindParam(":cancelledStatus", $this->cancelledStatus);
				
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
		
		//Updating the Service details
		public function UpdateServiceDropSlot(){
			try{
				
				$sql = "Update Service Set SVC_dropDate=:dropDate,SVC_dropSlot=:dropSlot,SVC_status=:status,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);				
                $this->dropDate=htmlspecialchars(strip_tags($this->dropDate));
				$result->bindParam(":dropDate", $this->dropDate);				
				$this->dropSlot=htmlspecialchars(strip_tags($this->dropSlot));
				$result->bindParam(":dropSlot", $this->dropSlot);          
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
		
		//Updating the Service details
		public function GetServiceByServiceId(){

			try{
				
				$sql = "Select * from Service where SVC_GPK=:serviceId";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);				
				$result->execute();													  	
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
				
		//Get count of Pending Service By VendorId and Productid
		public function GetPendingServiceCountByVendorIdAndProductId(){

			try{
				
				$sql = "Select count(*) as pendingServiceCount from Service where SVC_VDR_GFK=:vendorId and SVC_CSP_GFK=:productId and SVC_status!='fixed'";
				//echo $fixed;
			    $result = $this->conn->prepare($sql);
			    $this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);				
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);				
				$result->execute();													  	
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services by vendorId
        public function GetAllServicesByVendorId(){			
			try{
				$sql = "select * from Service where SVC_VDR_GFK=:vendorId order by SVC_createdOn desc"; //
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
		
		//Getting All Services by customerId
        public function GetAllServicesByCustomerId(){			
			try{
				$sql = "select * from Service where SVC_CST_GFK=:customerId order by SVC_createdOn desc"; //
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

		//Getting All Services by customerId and status
        public function GetAllServicesByCustomerIdAndStatus(){			
			try{
				
				$sql = "select * from Service where SVC_CST_GFK=:customerId and find_in_set(SVC_status,:status) order by SVC_createdOn desc"; //
				$result = $this->conn->prepare($sql);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));				
				$result->bindParam(":customerId", $this->customerId);
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services by vendorId and status
        public function GetAllServicesByVendorIdAndStatus(){			
			try{
				$sql = "select * from Service where SVC_VDR_GFK=:vendorId and find_in_set(SVC_status,:status) order by SVC_createdOn desc"; //
				$result = $this->conn->prepare($sql);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services by vendorId
        public function GetAllServices(){			
			try{
				$sql = "select * from Service order by SVC_createdOn desc"; //
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services by vendorId and status
        public function GetAllServicesByStatus(){			
			try{
				$sql = "select * from Service where find_in_set(SVC_status,:status) and SVC_isCancelled!=1 order by SVC_createdOn desc"; //
				$result = $this->conn->prepare($sql);
				
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services PickUp Services From Customer By Logistics
        public function GetAllPickUpServicesFromCustomer(){			
			try{
				$sql = "select *,VADR.ADR_GPK as vendorAddressId,
						(111.111 *
						    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(:logisticsLatitude))
						         * COS(RADIANS(CADR.ADR_lat))
						         * COS(RADIANS(:logisticsLongitude - CADR.ADR_long))
						         + SIN(RADIANS(:logisticsLatitude))
						         * SIN(RADIANS(CADR.ADR_lat)))))
						) as distance
						from Service.Service as SVC
						inner join Address.Address CADR
							on CADR.ADR_GPK = SVC.SVC_ADR_GFK
						inner join Vendor.Vendor VDR
							on VDR.VDR_GPK = SVC.SVC_VDR_GFK
						inner join Address.Address VADR
							on VADR.ADR_VDR_GFK = VDR.VDR_GPK
						where  SVC_status=:status and SVC_LGT_GFK=:logisticsId 
						 and VADR.ADR_status=1 and CADR.ADR_status=1
						order by SVC.SVC_createdOn, distance;";
						
						// SVC_pickUpDate=:pickUpDate and SVC_pickUpSlot=:pickUpSlot and
				$result = $this->conn->prepare($sql);
				$this->logisticsLatitude=htmlspecialchars(strip_tags($this->logisticsLatitude));				
				$result->bindParam(":logisticsLatitude", $this->logisticsLatitude);
				$this->logisticsLongitude=htmlspecialchars(strip_tags($this->logisticsLongitude));				
				$result->bindParam(":logisticsLongitude", $this->logisticsLongitude);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));				
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->pickUpDate=htmlspecialchars(strip_tags($this->pickUpDate));				
				//$result->bindParam(":pickUpDate", $this->pickUpDate);				
				$this->pickUpSlot=htmlspecialchars(strip_tags($this->pickUpSlot));				
				//$result->bindParam(":pickUpSlot", $this->pickUpSlot);
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services PickUp Services From Customer By Logistics
        public function GetAllDeliveryServicesToVendor(){			
			try{
				$sql = "select *,VADR.ADR_GPK as vendorAddressId,
						(111.111 *
						    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(:logisticsLatitude))
						         * COS(RADIANS(VADR.ADR_lat))
						         * COS(RADIANS(:logisticsLongitude - VADR.ADR_long))
						         + SIN(RADIANS(:logisticsLatitude))
						         * SIN(RADIANS(VADR.ADR_lat)))))
						) as distance
						from Service.Service as SVC
						inner join Address.Address CADR
							on CADR.ADR_GPK = SVC.SVC_ADR_GFK
						inner join Vendor.Vendor VDR
							on VDR.VDR_GPK = SVC.SVC_VDR_GFK
						inner join Address.Address VADR
							on VADR.ADR_VDR_GFK = VDR.VDR_GPK
						where SVC_status=:status and SVC_LGT_GFK=:logisticsId 
						 and VADR.ADR_status=1 and CADR.ADR_status=1
						order by SVC.SVC_createdOn, distance;";
				$result = $this->conn->prepare($sql);				
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));				
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->logisticsLatitude=htmlspecialchars(strip_tags($this->logisticsLatitude));				
				$result->bindParam(":logisticsLatitude", $this->logisticsLatitude);
				$this->logisticsLongitude=htmlspecialchars(strip_tags($this->logisticsLongitude));				
				$result->bindParam(":logisticsLongitude", $this->logisticsLongitude);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services PickUp Services From Customer By Logistics
        public function GetAllPickUpServicesFromVendor(){			
			try{
				$sql = "select *,VADR.ADR_GPK as vendorAddressId,
						(111.111 *
						    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(:logisticsLatitude))
						         * COS(RADIANS(CADR.ADR_lat))
						         * COS(RADIANS(:logisticsLongitude - CADR.ADR_long))
						         + SIN(RADIANS(:logisticsLatitude))
						         * SIN(RADIANS(CADR.ADR_lat)))))
						) as distance
						from Service.Service as SVC
						inner join Address.Address CADR
							on CADR.ADR_GPK = SVC.SVC_ADR_GFK
						inner join Vendor.Vendor VDR
							on VDR.VDR_GPK = SVC.SVC_VDR_GFK
						inner join Address.Address VADR
							on VADR.ADR_VDR_GFK = VDR.VDR_GPK
						where SVC_status=:status and SVC_LGT_GFK=:logisticsId 
						 and VADR.ADR_status=1 and CADR.ADR_status=1
						order by SVC.SVC_createdOn, distance;";
						//SVC_pickUpDate=:pickUpDate and SVC_pickUpSlot=:pickUpSlot and 
				$result = $this->conn->prepare($sql);
				$this->pickUpDate=htmlspecialchars(strip_tags($this->pickUpDate));				
				//$result->bindParam(":pickUpDate", $this->pickUpDate);
				$this->pickUpSlot=htmlspecialchars(strip_tags($this->pickUpSlot));				
				//$result->bindParam(":pickUpSlot", $this->pickUpSlot);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));				
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$this->logisticsLatitude=htmlspecialchars(strip_tags($this->logisticsLatitude));				
				$result->bindParam(":logisticsLatitude", $this->logisticsLatitude);
				$this->logisticsLongitude=htmlspecialchars(strip_tags($this->logisticsLongitude));				
				$result->bindParam(":logisticsLongitude", $this->logisticsLongitude);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Assign Service To Logistics
		public function AssignServiceToLogistics(){

			try{
				
				$sql = "Update Service Set SVC_status=:status,SVC_LGT_GFK=:logisticsId, SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);	
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);							
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
		
		//Getting All Services by logisticsId  and status
        public function GetAllServicesByLogisticsIdAndStatus(){
			try{
				$sql = "select *,VADR.ADR_GPK as vendorAddressId,
						(111.111 *
						    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(:logisticsLatitude))
						         * COS(RADIANS(CADR.ADR_lat))
						         * COS(RADIANS(:logisticsLongitude - CADR.ADR_long))
						         + SIN(RADIANS(:logisticsLatitude))
						         * SIN(RADIANS(CADR.ADR_lat)))))
						) as distance
						from Service.Service as SVC
						inner join Address.Address CADR
							on CADR.ADR_GPK = SVC.SVC_ADR_GFK
						inner join Vendor.Vendor VDR
							on VDR.VDR_GPK = SVC.SVC_VDR_GFK
						inner join Address.Address VADR
							on VADR.ADR_VDR_GFK = VDR.VDR_GPK
						where SVC_LGT_GFK=:logisticsId and SVC_status=:status 
						 and VADR.ADR_status=1 and CADR.ADR_status=1
						order by SVC.SVC_createdOn desc, distance";
				
				$result = $this->conn->prepare($sql);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));				
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$this->logisticsLatitude=htmlspecialchars(strip_tags($this->logisticsLatitude));				
				$result->bindParam(":logisticsLatitude", $this->logisticsLatitude);
				$this->logisticsLongitude=htmlspecialchars(strip_tags($this->logisticsLongitude));				
				$result->bindParam(":logisticsLongitude", $this->logisticsLongitude);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services by logisticsId
        public function GetAllServicesByLogisticsId(){			
			try{
				$sql = "select * from Service where SVC_LGT_GFK=:logisticsId order by SVC_createdOn desc"; //
				$result = $this->conn->prepare($sql);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));				
				$result->bindParam(":logisticsId", $this->logisticsId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating the Service details
		public function UpdateServiceOtp(){

			try{
				
				$sql = "Update Service Set SVC_otp=:otp,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				
                $this->otp=htmlspecialchars(strip_tags($this->otp));
				$result->bindParam(":otp", $this->otp);
               
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//updating the Service details
		public function UpdateServiceDetails()
		{

			try {

				$sql = "Update Service Set SVC_VDR_GFK=:vendorId,SVC_LGT_GFK=:logisticsId,SVC_modifiedOn=:modifiedOn where SVC_GPK=:serviceId";
				//SVC_CST_GFK=:customerId,SVC_CSP_GFK=:customerProductId,SVC_PDM_GFK=:productId,SVC_ADR_GFK=:customerAddressId,SVC_serviceCharge=:serviceCharge,SVC_otp=:otp,SVC_randomNumber=:randomNumber,SVC_status=:status,SVC_customerTotal=:customerTotal,SVC_vendorTotal=:vendorTotal,SVC_pickUpDate=:pickUpDate,SVC_pickUpSlot=:pickUpSlot,SVC_notes=:notes,SVC_dropDate=:dropDate,SVC_dropSlot=:dropSlot
				$result = $this->conn->prepare($sql);
				//$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				//$result->bindParam(":customerId", $this->customerId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));				
				$result->bindParam(":vendorId", $this->vendorId);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);
				/*
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));
				$result->bindParam(":customerProductId", $this->customerProductId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->customerAddressId=htmlspecialchars(strip_tags($this->customerAddressId));
				$result->bindParam(":customerAddressId", $this->customerAddressId);
				$this->serviceCharge=htmlspecialchars(strip_tags($this->serviceCharge));
				$result->bindParam(":serviceCharge", $this->serviceCharge);
				$this->otp=htmlspecialchars(strip_tags($this->otp));
				$result->bindParam(":otp", $this->otp);
				$this->randomNumber=htmlspecialchars(strip_tags($this->randomNumber));
				$result->bindParam(":randomNumber", $this->randomNumber);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->customerTotal=htmlspecialchars(strip_tags($this->customerTotal));
				$result->bindParam(":customerTotal", $this->customerTotal);
				$this->vendorTotal=htmlspecialchars(strip_tags($this->vendorTotal));
				$result->bindParam(":vendorTotal", $this->vendorTotal);
				$this->pickUpDate=htmlspecialchars(strip_tags($this->pickUpDate));
				$result->bindParam(":pickUpDate", $this->pickUpDate);
				$this->pickUpSlot=htmlspecialchars(strip_tags($this->pickUpSlot));
				$result->bindParam(":pickUpSlot", $this->pickUpSlot);
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);
				$this->dropDate=htmlspecialchars(strip_tags($this->dropDate));
				$result->bindParam(":dropDate", $this->dropDate);
				$this->dropSlot=htmlspecialchars(strip_tags($this->dropSlot));
				$result->bindParam(":dropSlot", $this->dropSlot);
				*/ 
				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				$this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				

				$result->execute();
				
				return true;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateReferenceIdByServiceId()
		{
			try {
				$sql = "update Service set SVC_referenceId=:referenceId where SVC_GPK=:serviceId"; //
				$result = $this->conn->prepare($sql);
				
				$this->referenceId=htmlspecialchars(strip_tags($this->referenceId));
				$result->bindParam(":referenceId", $this->referenceId);
				$this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating the Service details for reopen
		public function UpdateServiceReopen(){

			try{
				
				$sql = "Update Service Set SVC_isReopened=:isReopened,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				
                $this->isReopened=htmlspecialchars(strip_tags($this->isReopened));
				$result->bindParam(":isReopened", $this->isReopened);
               
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Report Services
        public function GetAllReportServices(){			
			try{
				$sql = "select * from Service S inner join Reports R on R.RPT_SVC_GFK=S.SVC_GPK order by SVC_createdOn desc"; //
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating the Service details for reopen
		public function UpdateServiceAmount(){

			try{
				
				$sql = "Update Service Set SVC_customerTotal=:customerTotal,SVC_customerDisplayTotal=:customerDisplayTotal,SVC_vendorTotal=:vendorTotal,SVC_deliveryFee=:deliveryFee,SVC_serviceCharge=:serviceCharge,SVC_GSTAmount=:GSTAmount,SVC_customerGrandTotal=:customerGrandTotal,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);
				
                $this->customerTotal=htmlspecialchars(strip_tags($this->customerTotal));
				$result->bindParam(":customerTotal", $this->customerTotal);
				
				$this->customerDisplayTotal=htmlspecialchars(strip_tags($this->customerDisplayTotal));
				$result->bindParam(":customerDisplayTotal", $this->customerDisplayTotal);
               
                $this->vendorTotal=htmlspecialchars(strip_tags($this->vendorTotal));
				$result->bindParam(":vendorTotal", $this->vendorTotal);	
				
				$this->deliveryFee=htmlspecialchars(strip_tags($this->deliveryFee));
				$result->bindParam(":deliveryFee", $this->deliveryFee);
				
                $this->serviceCharge=htmlspecialchars(strip_tags($this->serviceCharge));
				$result->bindParam(":serviceCharge", $this->serviceCharge);
               
                $this->GSTAmount=htmlspecialchars(strip_tags($this->GSTAmount));
				$result->bindParam(":GSTAmount", $this->GSTAmount);	
				
				$this->customerGrandTotal=htmlspecialchars(strip_tags($this->customerGrandTotal));
				$result->bindParam(":customerGrandTotal", $this->customerGrandTotal);				
               
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Services by vendorId and status
        public function GetAllCancelledServices(){			
			try{
				$sql = "select * from Service where SVC_isCancelled=1 order by SVC_createdOn desc"; //
				$result = $this->conn->prepare($sql);
				
				$this->status=htmlspecialchars(strip_tags($this->status));				
				$result->bindParam(":status", $this->status);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateFixedVideoPath(){

			try{
				
				$sql = "Update Service Set SVC_fixedVideoPath=:fixedVideoPath,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);

                $this->fixedVideoPath=htmlspecialchars(strip_tags($this->fixedVideoPath));
				$result->bindParam(":fixedVideoPath", $this->fixedVideoPath);
               
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateDefectAudioPath(){

			try{
				
				$sql = "Update Service Set SVC_defectAudioPath=:defectAudioPath,SVC_modifiedOn=:modifiedOn where find_in_set(SVC_GPK,:serviceId)";
			    $result = $this->conn->prepare($sql);
			    $this->serviceId=htmlspecialchars(strip_tags($this->serviceId));
				$result->bindParam(":serviceId", $this->serviceId);

                $this->defectAudioPath=htmlspecialchars(strip_tags($this->defectAudioPath));
				$result->bindParam(":defectAudioPath", $this->defectAudioPath);
               
                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);				
				
				$result->execute();
				
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting All Pending Services by customerId and status
        public function GetAllPendingServicesByCustomerId(){			
			try{
				
				$sql = "select * from Service where SVC_CST_GFK=:customerId and 
( find_in_set(SVC_status,'sr_created,picked_from_customer,under_inspection,awaiting_for_confirmation,ready_to_fixed,fixed,scheduled_for_drop,picked_from_vendor') 
 or (SVC_isCancelled=1 and SVC_cancelledBy!='a' and SVC_status!='delivered'))
order by SVC_createdOn desc"; //
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
		
		//Getting All Completed Services by customerId and status
        public function GetAllCompletedServicesByCustomerId(){			
			try{
				
				$sql = "select * from Service where SVC_CST_GFK=:customerId and 
						(( find_in_set(SVC_status,'delivered') 
						 or (SVC_isCancelled=1 and SVC_cancelledBy!='a' and SVC_status='delivered'))
                         or SVC_cancelledBy='a')
						order by SVC_createdOn desc"; //
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
			
}
?>

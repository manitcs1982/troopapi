<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class RateCard{
		private $conn;		
		public $id;
		public $productId;
		public $imageUrl;
		public $imageDescription;
		public $userDescription;
		public $vendorPrice;
		public $customerPrice;
	    public $customerDisplayPrice;
		public $status;
		public $quantity;
		public $nativeImageDescription;
		public $nativeUserDescription;
		public $customerPricePercentage;
		public $createdOn;
		public $modifiedOn;
		public $error;
				
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Getting customer details by PhoneNumber
		public function GetAllRateCard(){			
			try{
				$sql = "select * from Ratecard_Master where RCM_status=1"; //
				$result = $this->conn->prepare($sql);				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer details by PhoneNumber
		public function GetRateCardById(){			
			try{
				$sql = "select * from Ratecard_Master where RCM_GPK=:id"; //
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
		
		//Getting customer details by PhoneNumber
		public function GetAllRateCardByProductId(){			
			try{
				$sql = "select * from Ratecard_Master where RCM_PDM_GFK=:productId and RCM_status=1"; //
				$result = $this->conn->prepare($sql);
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//GetAllRateCardByProductIdWithOutStatus
		public function GetAllRateCardByProductIdWithOutStatus(){			
			try{
				$sql = "select * from Ratecard_Master where RCM_PDM_GFK=:productId"; //
				$result = $this->conn->prepare($sql);
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Inserting RateCard
		public function InsertRateCard(){			
			try{
				
				$sql = "Insert into Ratecard_Master Set RCM_PDM_GFK=:productId,RCM_imageUrl=:imageUrl,RCM_imageDescription=:imageDescription,RCM_userDescription=:userDescription,RCM_vendorPrice=:vendorPrice,RCM_customerPrice=:customerPrice,RCM_status=:status,RCM_quantity=:quantity,RCM_createdOn=:createdOn,RCM_nativeImageDescription=:nativeImageDescription,RCM_nativeUserDescription=:nativeUserDescription,RCM_GSTPrice=:GSTPrice,RCM_GSTPercentage=:GSTPercentage,RCM_customerDisplayPrice=:customerDisplayPrice,RCM_customerPricePercentage=:customerPricePercentage";
				
				$result = $this->conn->prepare($sql);
								
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				
				$this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);
				
				$this->imageDescription=htmlspecialchars(strip_tags($this->imageDescription));
				$result->bindParam(":imageDescription", $this->imageDescription);
				
				$this->userDescription=htmlspecialchars(strip_tags($this->userDescription));
				$result->bindParam(":userDescription", $this->userDescription);
				
				$this->vendorPrice=htmlspecialchars(strip_tags($this->vendorPrice));
				$result->bindParam(":vendorPrice", $this->vendorPrice);
				
				$this->customerPrice=htmlspecialchars(strip_tags($this->customerPrice));
				$result->bindParam(":customerPrice", $this->customerPrice);
				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->quantity=htmlspecialchars(strip_tags($this->quantity));
				$result->bindParam(":quantity", $this->quantity);
				
				$this->nativeImageDescription=htmlspecialchars(strip_tags($this->nativeImageDescription));
				$result->bindParam(":nativeImageDescription", $this->nativeImageDescription);
				
				$this->nativeUserDescription=htmlspecialchars(strip_tags($this->nativeUserDescription));
				$result->bindParam(":nativeUserDescription", $this->nativeUserDescription);
				
				$this->GSTPercentage=htmlspecialchars(strip_tags($this->GSTPercentage));
				$result->bindParam(":GSTPercentage", $this->GSTPercentage);
				
				$this->GSTPrice=htmlspecialchars(strip_tags($this->GSTPrice));
				$result->bindParam(":GSTPrice", $this->GSTPrice);
				
				$this->customerDisplayPrice=htmlspecialchars(strip_tags($this->customerDisplayPrice));
				$result->bindParam(":customerDisplayPrice", $this->customerDisplayPrice);
				
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				
				$this->customerPricePercentage=htmlspecialchars(strip_tags($this->customerPricePercentage));
				$result->bindParam(":customerPricePercentage", $this->customerPricePercentage);
				
				$result->execute();
				$this->id = $this->conn->lastInsertId();											  			
				 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Updating RateCard
		public function UpdateRateCard(){			
			try{
				
				$sql = "Update Ratecard_Master Set  RCM_PDM_GFK=:productId,RCM_imageUrl=:imageUrl,RCM_imageDescription=:imageDescription,RCM_userDescription=:userDescription,RCM_vendorPrice=:vendorPrice,RCM_customerPrice=:customerPrice,RCM_status=:status,RCM_quantity=:quantity,RCM_modifiedOn=:modifiedOn,RCM_nativeImageDescription=:nativeImageDescription,RCM_nativeUserDescription=:nativeUserDescription,RCM_GSTPrice=:GSTPrice,RCM_GSTPercentage=:GSTPercentage,RCM_customerDisplayPrice=:customerDisplayPrice,RCM_customerPricePercentage=:customerPricePercentage where RCM_GPK=:id";//
				
				$result = $this->conn->prepare($sql);
				
				$this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				
				$this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);
				
				$this->imageDescription=htmlspecialchars(strip_tags($this->imageDescription));
				$result->bindParam(":imageDescription", $this->imageDescription);
				
				$this->userDescription=htmlspecialchars(strip_tags($this->userDescription));
				$result->bindParam(":userDescription", $this->userDescription);
				
				$this->vendorPrice=htmlspecialchars(strip_tags($this->vendorPrice));
				$result->bindParam(":vendorPrice", $this->vendorPrice);
				
				$this->customerPrice=htmlspecialchars(strip_tags($this->customerPrice));
				$result->bindParam(":customerPrice", $this->customerPrice);
				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->quantity=htmlspecialchars(strip_tags($this->quantity));
				$result->bindParam(":quantity", $this->quantity);
				
				$this->nativeImageDescription=htmlspecialchars(strip_tags($this->nativeImageDescription));
				$result->bindParam(":nativeImageDescription", $this->nativeImageDescription);
				
				$this->nativeUserDescription=htmlspecialchars(strip_tags($this->nativeUserDescription));
				$result->bindParam(":nativeUserDescription", $this->nativeUserDescription);
				
				$this->GSTPercentage=htmlspecialchars(strip_tags($this->GSTPercentage));
				$result->bindParam(":GSTPercentage", $this->GSTPercentage);
				
				$this->GSTPrice=htmlspecialchars(strip_tags($this->GSTPrice));
				$result->bindParam(":GSTPrice", $this->GSTPrice);
				
				$this->customerDisplayPrice=htmlspecialchars(strip_tags($this->customerDisplayPrice));
				$result->bindParam(":customerDisplayPrice", $this->customerDisplayPrice);
				
				$this->customerPricePercentage=htmlspecialchars(strip_tags($this->customerPricePercentage));
				$result->bindParam(":customerPricePercentage", $this->customerPricePercentage);
				
				$this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				
				$result->execute();
				 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
}
?>

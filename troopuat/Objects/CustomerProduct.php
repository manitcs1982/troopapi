<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class CustomerProduct{
		private $conn;
		public $customerProductId;
		public $customerId;
		public $productId;
		public $name;
		public $capacity;
		public $imageUrl;
		public $notes;
		public $phoneNumber;
		public $productName;
		public $model;
		public $brand;
		public $manDate;		
		public $status;
		public $createdOn;
		public $modifiedOn;
		
		public $error;
		

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		//Insertng the CustomerProduct details
		public function InsertCustomerProduct(){
			try{
				
				$sql = "Insert into Customer_Product Set CSP_CSR_GFK=:customerId,CSP_PDM_GFK=:productId,CSP_status=:status,CSP_createdOn=:createdOn";
				//,CSP_name=:name,CSP_capacity=:capacity,CSP_imageUrl=:imageUrl,CSP_notes=:notes,CSP_phoneNumber=:phoneNumber,CSP_productName=:productName,CSP_model=:model,CSP_brand=:brand,CSP_manDate=:manDate,
			    $result = $this->conn->prepare($sql);
			    
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				/*$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->capacity=htmlspecialchars(strip_tags($this->capacity));
				$result->bindParam(":capacity", $this->capacity);				
				$this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);				
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);				
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);				
				$this->productName=htmlspecialchars(strip_tags($this->productName));
				$result->bindParam(":productName", $this->productName);				
				$this->model=htmlspecialchars(strip_tags($this->model));
				$result->bindParam(":model", $this->model);	
				$this->brand=htmlspecialchars(strip_tags($this->brand));
				$result->bindParam(":brand", $this->brand);	
				$this->manDate=htmlspecialchars(strip_tags($this->manDate));
				$result->bindParam(":manDate", $this->manDate);	
				*/			
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				
				$result->execute();
				$this->customerProductId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
				
		
		//Getting customer product by customer product id
		public function GetCustomerProductByCustomerProductId(){			
			try{
				$sql = "select * from Customer_Product where CSP_GPK=:customerProductId"; //
				$result = $this->conn->prepare($sql);
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));				
				$result->bindParam(":customerProductId", $this->customerProductId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting customer product by customer id
		public function GetAllCustomerProductByCustomerId(){			
			try{
				$sql = "select * from Customer_Product where CSP_CSR_GFK=:customerId and CSP_status=1"; //
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
		//Getting All customer product by customer id and product id
		public function GetAllCustomerProductByCustomerIdAndProductId(){			
			try{
				$sql = "select * from Customer_Product where CSP_CSR_GFK=:consumerId and CSP_PDM_GFK=:productId  and CSP_status=1"; //
				$result = $this->conn->prepare($sql);
				$this->consumerId=htmlspecialchars(strip_tags($this->consumerId));				
				$result->bindParam(":consumerId", $this->consumerId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating CustomerProduct
		public function UpdateCustomerProduct(){

			try{
				
				$sql = "Update Customer_Product Set  CSP_CSR_GFK=:customerId,CSP_PDM_GFK=:productId,CSP_name=:name,CSP_capacity=:capacity,CSP_imageUrl=:imageUrl,CSP_notes=:notes,CSP_phoneNumber=:phoneNumber,CSP_productName=:productName,CSP_model=:model,CSP_brand=:brand,CSP_manDate=:manDate,CSP_status=:status,CSP_modifiedOn=:modifiedOn where CSP_GPK=:customerProductId";//
				
			    $result = $this->conn->prepare($sql);
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));
				$result->bindParam(":customerProductId", $this->customerProductId);
				
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->capacity=htmlspecialchars(strip_tags($this->capacity));
				$result->bindParam(":capacity", $this->capacity);				
				$this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);				
				$this->notes=htmlspecialchars(strip_tags($this->notes));
				$result->bindParam(":notes", $this->notes);				
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);				
				$this->productName=htmlspecialchars(strip_tags($this->productName));
				$result->bindParam(":productName", $this->productName);				
				$this->model=htmlspecialchars(strip_tags($this->model));
				$result->bindParam(":model", $this->model);	
				$this->brand=htmlspecialchars(strip_tags($this->brand));
				$result->bindParam(":brand", $this->brand);	
				$this->manDate=htmlspecialchars(strip_tags($this->manDate));
				$result->bindParam(":manDate", $this->manDate);					
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
		//Deleting CustomerProduct
		public function DeleteCustomerProduct(){ 

			try{
				
				$sql = "Update Customer_Product Set CSP_status=:status where CSP_GPK=:customerProductId";
			    $result = $this->conn->prepare($sql);				
				
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));
				$result->bindParam(":customerProductId", $this->customerProductId);
									
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
			   				
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
				
}
?>

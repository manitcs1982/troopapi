<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class CustomerProductInfo{
		private $conn;
		public $customerProductInfoId;
		public $customerProductId;
		public $productId;	
		public $customerId;
		public $productInfoId;
		public $answer;
		public $createdOn;
		public $modifiedOn;
		
		public $error;
		

		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		//Insertng the CustomerProductInfo details
		public function InsertCustomerProductInfo(){
			try{
				
				$sql = "Insert into Customer_Product_Info Set CPI_PDM_GFK=:productId,CPI_CSP_GFK=:customerProductId,CPI_CSR_GFK=:customerId,CPI_PIN_GFK=:productInfoId,CPI_answer=:answer,CPI_isImage=:isImage, CPI_createdOn=:createdOn";
			    $result = $this->conn->prepare($sql);
			    
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);				
				$this->customerProductId=htmlspecialchars(strip_tags($this->customerProductId));
				$result->bindParam(":customerProductId", $this->customerProductId);	
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);		
				$this->productInfoId=htmlspecialchars(strip_tags($this->productInfoId));
				$result->bindParam(":productInfoId", $this->productInfoId);
				$this->answer=htmlspecialchars(strip_tags($this->answer));
				$result->bindParam(":answer", $this->answer);								
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);				
				$this->isImage=htmlspecialchars(strip_tags($this->isImage));
				$result->bindParam(":isImage", $this->isImage);
				
				$result->execute();
				$this->customerProductInfoId = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
				
			
		//Getting All customer product by customer id and product id
		public function GetAllCustomerProductInfoByCustomerProductId(){			
			try{
				$sql = "select * from Customer_Product_Info where CPI_CSP_GFK=:customerProductId"; //
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
		
		//Getting All customer product by customer id and product id
		public function GetAllCustomerProductInfoByCustomerId(){			
			try{
				$sql = "select * from Customer_Product_Info where CPI_CSR_GFK=:customerId"; //
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
		public function GetAllProductIdByCustomerId(){			
			try{
				$sql = "select CPI_PDM_GFK from Customer_Product_Info where CPI_CSR_GFK=:customerId group by CPI_PDM_GFK"; //
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
		public function GetAllProductIdByCustomerIdAndProductid(){			
			try{
				$sql = "select * from Customer_Product_Info where CPI_CSR_GFK=:customerId and CPI_PDM_GFK=:productId"; //
				$result = $this->conn->prepare($sql);
				
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));				
				$result->bindParam(":customerId", $this->customerId);
				$this->productId=htmlspecialchars(strip_tags($this->productId));				
				$result->bindParam(":productId", $this->productId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating CustomerProductInfo
		public function UpdateCustomerProductInfo(){

			try{
				
				$sql = "Update Customer_Product_Info Set  CPI_PDM_GFK=:productId,CPI_CSR_GFK=:customerId,CPI_PIN_GFK=:productInfoId,CPI_answer=:answer, CPI_modifiedOn=:modifiedOn where CPI_GPK=:customerProductInfoId";//
				
			    $result = $this->conn->prepare($sql);
				$this->customerProductInfoId=htmlspecialchars(strip_tags($this->customerProductInfoId));
				$result->bindParam(":customerProductInfoId", $this->customerProductInfoId);				
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);				
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);		
				$this->productInfoId=htmlspecialchars(strip_tags($this->productInfoId));
				$result->bindParam(":productInfoId", $this->productInfoId);
				$this->answer=htmlspecialchars(strip_tags($this->answer));
				$result->bindParam(":answer", $this->answer);												
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

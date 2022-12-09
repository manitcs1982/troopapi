<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Product{
		private $conn;
		public  $productId;
		public  $name;
		public  $description;
		public  $imageUrl;
		public  $status;
		public  $isTurnOnRequired;
		public  $note;
		public  $createdOn;
		public  $modifiedOn;
		public  $nativeName;
		public  $nativeDescription;
		public  $nativeNote;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Inserting Product{
		public function InsertProduct(){			
			try{
				
				$sql = "Insert into Product_Master  Set PDM_name=:name,PDM_description=:description,PDM_imageUrl=:imageUrl,PDM_status=:status,PDM_createdOn=:createdOn,PDM_nativeName=:nativeName,PDM_nativeDescription=:nativeDescription,PDM_nativeNote=:nativeNote";//
				
				$result = $this->conn->prepare($sql);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				$this->description=htmlspecialchars(strip_tags($this->description));
				$result->bindParam(":description", $this->description);
				$this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);
				
				$this->nativeNote=htmlspecialchars(strip_tags($this->nativeNote));
				$result->bindParam(":nativeNote", $this->nativeNote);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				
				$this->nativeName=htmlspecialchars(strip_tags($this->nativeName));
				$result->bindParam(":nativeName", $this->nativeName);
				$this->nativeDescription=htmlspecialchars(strip_tags($this->nativeDescription));
				$result->bindParam(":nativeDescription", $this->nativeDescription);
				
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				
				$result->execute();
				$this->productId = $this->conn->lastInsertId(); 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting product by productId
		public function GetProductByProductId(){			
			try{
				
				$sql = "select * from Product_Master where PDM_GPK= :productId"; //
				$result = $this->conn->prepare($sql);
				
				$this->productId=htmlspecialchars(strip_tags($this->productId));		$result->bindParam(":productId", $this->productId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
//Getting All products{
	public function GetAllProducts(){			
			try{
				
				$sql = "select * from Product_Master where PDM_status=1";//
				
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				 											  			
				return $result;
				
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//GetAllProductWithOutStatus
		public function GetAllProductWithOutStatus(){			
			try{
				
				$sql = "select * from Product_Master";//
				
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				 											  			
				return $result;
				
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Updating Product
		public function UpdateProduct(){

			try{
				
				$sql ="Update Product_Master Set PDM_name=:name,PDM_description=:description,PDM_imageUrl=:imageUrl,PDM_status=:status,PDM_nativeNote=:nativeNote,PDM_modifiedOn=:modifiedOn,PDM_nativeName=:nativeName,PDM_nativeDescription=:nativeDescription where PDM_GPK=:productId";
			    $result = $this->conn->prepare($sql);
				
			    $this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				
				$this->description=htmlspecialchars(strip_tags($this->description));
				$result->bindParam(":description", $this->description);
				
				$this->imageUrl=htmlspecialchars(strip_tags($this->imageUrl));
				$result->bindParam(":imageUrl", $this->imageUrl);
				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->nativeNote=htmlspecialchars(strip_tags($this->nativeNote));
				$result->bindParam(":nativeNote", $this->nativeNote);
				
                $this->nativeName=htmlspecialchars(strip_tags($this->nativeName));
				$result->bindParam(":nativeName", $this->nativeName);
				$this->nativeDescription=htmlspecialchars(strip_tags($this->nativeDescription));
				$result->bindParam(":nativeDescription", $this->nativeDescription);

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
				
				
				
				
				
				
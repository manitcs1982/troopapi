<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ProductInfo{
		private $conn;
		public  $productInfoId;
		public  $productId;
		public  $question;
		public  $type;
		public  $answer;
		public  $status;
		public  $minLength;
		public  $maxLength;
		public  $isFloat;
		public  $createdOn;
		public  $modifiedOn;
		public  $IsMandatory;
		public  $nativeQuestion;
		public  $nativeAnswer;
		public  $placeHolder;
		public  $nativePlaceHolder;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		//Inserting ProductInfo{
		public function InsertProductInfo(){			
			try{
				
				$sql = "Insert into Product_Info  Set PIN_PDM_GFK=:productId,PIN_question=:question,PIN_type=:type,PIN_answer=:answer,PIN_status=:status,PIN_minLength=:minLength,PIN_maxLength=:maxLength,PIN_isFloat=:isFloat,PIN_createdOn=:createdOn,PIN_nativeQuestion=:nativeQuestion,PIN_nativeAnswer=:nativeAnswer,PIN_placeHolder=:placeHolder,PIN_nativePlaceHolder=:nativePlaceHolder";//
				
				$result = $this->conn->prepare($sql);				
		
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->question=htmlspecialchars(strip_tags($this->question));
				$result->bindParam(":question", $this->question);
				$this->type=htmlspecialchars(strip_tags($this->type));
				$result->bindParam(":type", $this->type);				
				$this->answer=htmlspecialchars(strip_tags($this->answer));
				$result->bindParam(":answer", $this->answer);				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);	
				$this->minLength=htmlspecialchars(strip_tags($this->minLength));
				$result->bindParam(":minLength", $this->minLength);	
				$this->maxLength=htmlspecialchars(strip_tags($this->maxLength));
				$result->bindParam(":maxLength", $this->maxLength);	
				$this->isFloat=htmlspecialchars(strip_tags($this->isFloat));
				$result->bindParam(":isFloat", $this->isFloat);	
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);
				$this->nativeQuestion=htmlspecialchars(strip_tags($this->nativeQuestion));
				$result->bindParam(":nativeQuestion", $this->nativeQuestion);
				$this->nativeAnswer=htmlspecialchars(strip_tags($this->nativeAnswer));
				$result->bindParam(":nativeAnswer", $this->nativeAnswer);
				$this->placeHolder=htmlspecialchars(strip_tags($this->placeHolder));
				$result->bindParam(":placeHolder", $this->placeHolder);
				$this->nativePlaceHolder=htmlspecialchars(strip_tags($this->nativePlaceHolder));
				$result->bindParam(":nativePlaceHolder", $this->nativePlaceHolder);
				
				$result->execute();
				$this->productInfoId = $this->conn->lastInsertId(); 											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting productInfo by productInfoId
		public function GetProductInfoByProductId(){			
			try{
				
				$sql = "select * from Product_Info where PIN_PDM_GFK= :productId and PIN_status=1 order by PIN_order"; //and PIN_status=1
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
		
		//Getting productInfo by productInfoId
		public function GetProductInfoByProductInfoId(){			
			try{
				
				$sql = "select * from Product_Info where PIN_GPK=:productInfoId"; //
				$result = $this->conn->prepare($sql);
				
				$this->productInfoId=htmlspecialchars(strip_tags($this->productInfoId));		
				$result->bindParam(":productInfoId", $this->productInfoId);
				
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Updating ProductInfo
		public function UpdateProductInfo(){

			try{
				
				$sql ="Update Product_Info Set PIN_PDM_GFK=:productId,PIN_question=:question,PIN_type=:type,PIN_answer=:answer,PIN_status=:status,PIN_minLength=:minLength,PIN_maxLength=:maxLength,PIN_isFloat=:isFloat,PIN_modifiedOn=:modifiedOn,PIN_nativeQuestion=:nativeQuestion,PIN_nativeAnswer=:nativeAnswer,PIN_placeHolder=:placeHolder,PIN_nativePlaceHolder=:nativePlaceHolder where PIN_GPK=:productInfoId";
			    $result = $this->conn->prepare($sql);
				
			    $this->productInfoId=htmlspecialchars(strip_tags($this->productInfoId));
				$result->bindParam(":productInfoId", $this->productInfoId);
				
				$this->productId=htmlspecialchars(strip_tags($this->productId));
				$result->bindParam(":productId", $this->productId);
				$this->question=htmlspecialchars(strip_tags($this->question));
				$result->bindParam(":question", $this->question);
				$this->type=htmlspecialchars(strip_tags($this->type));
				$result->bindParam(":type", $this->type);				
				$this->answer=htmlspecialchars(strip_tags($this->answer));
				$result->bindParam(":answer", $this->answer);				
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);		
				$this->minLength=htmlspecialchars(strip_tags($this->minLength));
				$result->bindParam(":minLength", $this->minLength);	
				$this->maxLength=htmlspecialchars(strip_tags($this->maxLength));
				$result->bindParam(":maxLength", $this->maxLength);	
				$this->isFloat=htmlspecialchars(strip_tags($this->isFloat));
				$result->bindParam(":isFloat", $this->isFloat);				            

                $this->modifiedOn=htmlspecialchars(strip_tags($this->modifiedOn));
				$result->bindParam(":modifiedOn", $this->modifiedOn);
				$this->nativeQuestion=htmlspecialchars(strip_tags($this->nativeQuestion));
				$result->bindParam(":nativeQuestion", $this->nativeQuestion);
				$this->nativeAnswer=htmlspecialchars(strip_tags($this->nativeAnswer));
				$result->bindParam(":nativeAnswer", $this->nativeAnswer);			
				$this->placeHolder=htmlspecialchars(strip_tags($this->placeHolder));
				$result->bindParam(":placeHolder", $this->placeHolder);
				$this->nativePlaceHolder=htmlspecialchars(strip_tags($this->nativePlaceHolder));
				$result->bindParam(":nativePlaceHolder", $this->nativePlaceHolder);
				
				$result->execute();
														  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
}
?>
				
				
				
				
				
				
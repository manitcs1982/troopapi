<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Chat{
		private $conn;				
		public $customerId;
		public $vendorId;	
		public $logisticsId;	
		public $roleId;
		public $senderType;
		public $receiverType;
		public $customerTokenId;
		public $roleTokenId;
		public $message;
		public $media;
		public $status;
		public $isRead;
		public $isMedia;
		public $mediaType;
		public $createdOn;
		public $modifiedOn;        
		public $error;						
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
		}
		
		function encrypt($string, $key=5) {
			$result = '';
			for($i=0, $k= strlen($string); $i<$k; $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)+ord($keychar));
				$result .= $char;
			}
			return base64_encode($result);
		}

		function decrypt($string, $key=5) {
			$result = '';
			$string = base64_decode($string);
			for($i=0,$k=strlen($string); $i< $k ; $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)-ord($keychar));
				$result.=$char;
			}
			return $result;
		}
		
		//Getting Address by addressId
		public function GetAllChatByCustomerId(){			
			try{
				$sql = "select * from Chat where CHT_CST_GFK=:customerId"; //
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
		
		//Getting Address by addressId
		public function GetLastChatByCustomerId(){			
			try{
				$sql = "select * from Chat where CHT_CST_GFK=:customerId order by CHT_createdOn desc limit 1"; //
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
		
		//Getting Address by addressId
		public function GetAllChatByRoleId(){			
			try{
				$sql = "select * from Chat where CHT_VDR_GFK=:vendorId"; //
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
		
		//Insertng the customer details
		public function InsertChat(){
			try{
								
				$sql = "Insert into Chat Set CHT_CST_GFK=:customerId,CHT_VDR_GFK=:vendorId,CHT_LGT_GFK=:logisticsId,CHT_RLM_GFK=:roleId,CHT_senderType=:senderType,CHT_receiverType=:receiverType,CHT_customerTokenId=:customerTokenId,CHT_roleTokenId=:roleTokenId,CHT_message=:message,CHT_media=:media,CHT_isMedia=:isMedia,CHT_mediaType=:mediaType,CHT_isRead=:isRead,CHT_status=:status,CHT_createdOn=:createdOn;";						
				
			    $result = $this->conn->prepare($sql);
			    $this->customerId=htmlspecialchars(strip_tags($this->customerId));
				$result->bindParam(":customerId", $this->customerId);
				$this->vendorId=htmlspecialchars(strip_tags($this->vendorId));
				$result->bindParam(":vendorId", $this->vendorId);
				$this->logisticsId=htmlspecialchars(strip_tags($this->logisticsId));
				$result->bindParam(":logisticsId", $this->logisticsId);
				$this->roleId=htmlspecialchars(strip_tags($this->roleId));
				$result->bindParam(":roleId", $this->roleId);
				$this->senderType=htmlspecialchars(strip_tags($this->senderType));
				$result->bindParam(":senderType", $this->senderType);
				$this->receiverType=htmlspecialchars(strip_tags($this->receiverType));
				$result->bindParam(":receiverType", $this->receiverType);				
				$this->customerTokenId=htmlspecialchars(strip_tags($this->customerTokenId));
				$result->bindParam(":customerTokenId", $this->customerTokenId);
				$this->roleTokenId=htmlspecialchars(strip_tags($this->roleTokenId));
				$result->bindParam(":roleTokenId", $this->roleTokenId);
				$this->message=htmlspecialchars(strip_tags($this->message));
				$result->bindParam(":message", $this->message);
				$this->media=htmlspecialchars(strip_tags($this->media));
				$result->bindParam(":media", $this->media);
				$this->isMedia=htmlspecialchars(strip_tags($this->isMedia));
				$result->bindParam(":isMedia", $this->isMedia);				
				$this->mediaType=htmlspecialchars(strip_tags($this->mediaType));
				$result->bindParam(":mediaType", $this->mediaType);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->isRead=htmlspecialchars(strip_tags($this->isRead));
				$result->bindParam(":isRead", $this->isRead);
				$this->createdOn=htmlspecialchars(strip_tags($this->createdOn));
				$result->bindParam(":createdOn", $this->createdOn);	
				
				$result->execute();
				$this->id = $this->conn->lastInsertId();											  			
				return true;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		public function UpdateChatMediaPath()
		{
			try {
				$sql = " update Chat set CHT_media=:media where CHT_GPK=:id;";

				$result = $this->conn->prepare($sql);
				$this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				$this->media=htmlspecialchars(strip_tags($this->media));
				$result->bindParam(":media", $this->media);

				$result->execute();
				return true;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		
		//Admin chat with particular person
		public function GetAllChatByAdminIdAndCustomerId(){			
			try{
				$sql = "select * from Chat where CHT_CST_GFK=:customerId and CHT_RLM_GFK=:roleId"; //
				$result = $this->conn->prepare($sql);
				$this->customerId=htmlspecialchars(strip_tags($this->customerId));				
				$result->bindParam(":customerId", $this->customerId);
				$this->roleId=htmlspecialchars(strip_tags($this->roleId));				
				$result->bindParam(":roleId", $this->roleId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Admin chat screen
		public function GetAllLastChatWithCustomerDetailsByAdminId(){			
			try{
				$sql = "select * from Chat.Chat where CHT_GPK in
(
select max(CHT_GPK) from Chat.Chat where CHT_createdOn in
(select max(CHT_createdOn) from Chat.Chat where CHT_RLM_GFK=:roleId group by CHT_CST_GFK)
group by CHT_CST_GFK
) order by CHT_createdOn desc
";
				$result = $this->conn->prepare($sql);				
				$this->roleId=htmlspecialchars(strip_tags($this->roleId));				
				$result->bindParam(":roleId", $this->roleId);
				$result->execute();
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Getting Address by addressId
		public function GetLastChatByAdminIdAndCustomerId(){			
			try{
				$sql = "select * from Chat where CHT_RLM_GFK=:roleId and CHT_CST_GFK=:customerId order by CHT_createdOn desc limit 1"; //
				$result = $this->conn->prepare($sql);
				$this->roleId=htmlspecialchars(strip_tags($this->roleId));				
				$result->bindParam(":roleId", $this->roleId);
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

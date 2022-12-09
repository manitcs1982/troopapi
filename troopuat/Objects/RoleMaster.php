
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../Config/config.php';

class RoleMaster{
	
		private $conn;		
		public $id;
		public $name;	
		public $type;
		public $password;
		public $username;
        public $email;
        public $phoneNumber;
        public $status;
        public $createdOn;
        public $modifiedOn;			
		
		public $error;
		
		// Assigning the DB connection
		public function __construct($db){
			$this->conn = $db;
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		
		
		//Inserting the InsertRollMaster
		public function InsertRoleMaster(){			
			try{
				
				$sql = "Insert into Role_Master Set RLM_name=:name,RLM_type=:type,RLM_email=:email,RLM_phoneNumber=:phoneNumber,RLM_username=:username,RLM_password=:password,RLM_status=:status,RLM_createdOn=:createdOn";
				
				$result = $this->conn->prepare($sql);
				
	
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				
				$this->type=htmlspecialchars(strip_tags($this->type));
				$result->bindParam(":type", $this->type);
				
				$this->email=htmlspecialchars(strip_tags($this->email));
				$result->bindParam(":email", $this->email);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$this->username=htmlspecialchars(strip_tags($this->username));
				$result->bindParam(":username", $this->username);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->password=htmlspecialchars(strip_tags($this->password));
				$result->bindParam(":password", $this->password);
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
		
		
		//GetAllRoleMaster
		public function GetAllRoleMaster()
		{
			try {
				$sql = "select * from Role_Master"; 
				$result = $this->conn->prepare($sql);
				
				$result->execute();
				return $result;
			} catch (PDOException $e) {
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		
		//Get PincodeMaster By username
		public function GetRoleByUsername(){

			try{
				
				$sql = "Select * from Role_Master where RLM_username=:username and RLM_status=1";
			    $result = $this->conn->prepare($sql);
			    $this->username=htmlspecialchars(strip_tags($this->username));
				$result->bindParam(":username", $this->username);				
				$result->execute();													  	
				return $result;
			}catch(PDOException $e){
				$this->error = "Error: ".$e->getMessage();
				return false;
			}
		}
		//Updating logistics
		public function UpdateRoleMaster(){

			try{
				
				$sql = "Update Role_Master Set RLM_name=:name,RLM_type=:type,RLM_email=:email,RLM_phoneNumber=:phoneNumber,RLM_username=:username,RLM_password=:password,RLM_status=:status,RLM_modifiedOn=:modifiedOn where RLM_GPK=:id";
			    $result = $this->conn->prepare($sql);
				
			    $this->id=htmlspecialchars(strip_tags($this->id));
				$result->bindParam(":id", $this->id);
				
				$this->name=htmlspecialchars(strip_tags($this->name));
				$result->bindParam(":name", $this->name);
				
				$this->type=htmlspecialchars(strip_tags($this->type));
				$result->bindParam(":type", $this->type);
				
				$this->email=htmlspecialchars(strip_tags($this->email));
				$result->bindParam(":email", $this->email);
				$this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
				$result->bindParam(":phoneNumber", $this->phoneNumber);
				$this->username=htmlspecialchars(strip_tags($this->username));
				$result->bindParam(":username", $this->username);
				$this->status=htmlspecialchars(strip_tags($this->status));
				$result->bindParam(":status", $this->status);
				$this->password=htmlspecialchars(strip_tags($this->password));
				$result->bindParam(":password", $this->password);

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

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../Config/config.php';

class discountmaster
{

    private $conn;
    public $discountMasterId;
    public $discountName;
    public $discountReason;
    public $discountDescription;
    public $discountPercentage;
    public $discountAmount;
    public $discountIsActive;
    public $error;

    // Assigning the DB connection
    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function GetDiscountMasterByName()
    {

        try {

            $sql = "Select * from discount_master where DSM_name=:discountName";
            $result = $this->conn->prepare($sql);
            $this->discountName = htmlspecialchars(strip_tags($this->discountName));
            $result->bindParam(":discountName", $this->discountName);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $this->error = "Error: " . $e->getMessage();
            return false;
        }
    }




}
?>
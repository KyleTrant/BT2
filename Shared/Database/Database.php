<?php
namespace Shared\Database;
require_once ROOT_DIR .'/Config/config.php';

class Database{
    private $conn;
    private static $instance = null;
    private function __construct(){
        $this->connect();
    }
// region connect database
    public function connect(){
        if($this->conn != null){
            return;
        }
        try{
            // mysqli_report(MYSQLI_REPORT_OFF); //automatically throw exceptions
            $this->conn = new \mysqli(DB_HOST, DB_USER, DB_PASS);
            // Check DB_NAME exist
            $result = $this->conn->query("SHOW DATABASES LIKE '". DB_NAME ."'");
            if ($result->num_rows === 0) {
                $sql = "CREATE DATABASE " . DB_NAME;
                $this->conn->query($sql);  
             }
            $this->conn->select_db(DB_NAME);
        }
        catch(\Exception $e){
            die($e->getMessage());
        }        
    }
    public function disConnect(){
        if ($this->conn !== null) {
            $this->conn->close();
            $this->conn = null;
        }
    }
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function getConnection() {
        if ($this->conn === null) {
            $this->connect(); 
        }
        return $this->conn;
    }
    
//endregion

// region  Database CRUD
public function query($sql, $params = []) {
    try {
        if ($this->conn === null || $this->conn->connect_errno) {
            throw new \Exception("Database connection error: " . $this->conn->connect_error);
        }
     
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new \Exception("Error query " . $this->conn->error);
        }
       
        if (!empty($params)) {
            $types = '';
            foreach($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';  
                } elseif (is_double($param)) {
                    $types .= 'd';  
                } elseif (is_string($param)) {
                    $types .= 's';  
                }
                else {
                    $types .= 'b';
                }
            }
            try{
              
                $stmt->bind_param($types, ...$params);
            }
            catch (\Exception $e) {
                die(": " . $e->getMessage()); }
            
        }
       
        $stmt->execute();
        return $stmt;
    } catch (\Exception $e) {
        die(": " . $e->getMessage()); }
}


// endregion



} ?>
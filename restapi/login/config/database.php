<?php

class Database{

    private $host = "localhost";
    private $dbname = "DatabaseN";
    private $username = "postgres";
    private $password = "534478";
    public $conn;

    public function getConnection() {

        $this->conn = null;

        try {
            $this->conn = new PDO("pgsql:host=$this->host; port=5432; dbname=$this->dbname; user=$this->username; password=$this->password");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>
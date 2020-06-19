<?php
  class Database {
    // DB Params
    /*
    private $host = 'localhost';
    private $db_name = 'db_iaitl';
    private $username = 'root';
    private $password = '';
    */
    private $host = 'https://remotemysql.com';
    private $db_name = 'TJbC6Yte84';
    private $username = 'TJbC6Yte84';
    private $password = '8dEGffwvcZ';
    private $conn;


    // DB Connect
    public function connect() {
      $this->conn = null;

      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }

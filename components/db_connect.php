<?php

    class DatabaseConnection
    {
        private $dbHost = 'localhost';
        private $dbName = 'project';
        private $dbUser = 'root';
        private $dbPass = '';
        private $pdo;

        public function __construct()
        {
            try {
                $this->pdo = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        public function getConnection()
        {
            return $this->pdo;
        }
    }

?>

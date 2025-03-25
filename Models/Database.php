<?php
    class Database {
        public $pdo;

        function __construct() {
            $host = "localhost";
            $db = "theshop";
            $user = "root";
            $pass = "root";

            $dsn = "mysql:host=$host;port=8889;dbname=$db";
            $this->pdo = new PDO($dsn, $user, $pass);
        }

        function getAllProducts(){
            $query = $this->pdo->query("SELECT * FROM Products");
            return $query->fetchAll(PDO::FETCH_CLASS,"Product");
        }

    }
        
?>
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
            $this->initDatabase();
        }

        function initDatabase(){
            $this->pdo->query("CREATE TABLE IF NOT EXISTS Products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                price INT,
                stockLevel INT,
                categoryName VARCHAR(50)
            )");
        }

        function getAllProducts($sortCol="id", $sortOrder="asc"){
            if(!in_array($sortCol,["id", "title", "price", "stockLevel"])){
                $sortCol = "id";

            }
            if(!in_array($sortOrder, ["asc", "desc"])){
                $sortOrder = "asc";

            }

            $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder");
            return $query->fetchAll(PDO::FETCH_CLASS,"Product");
        }

        function getAllCategories (){
            $data = $this->pdo->query("SELECT DISTINCT categoryName FROM Products")->fetchAll(PDO::FETCH_COLUMN);
            return $data;


        }

    }
        
?>
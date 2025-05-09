<?php 

require_once('Models/UserDatabase.php');
require_once('Models/CartItem.php');
require_once("vendor/autoload.php");

    class Database{
        public $pdo;

        private $usersDatabase;
        function getUsersDatabase(){
            return $this->usersDatabase;
        }

        function __construct() {    
            $host = $_ENV['HOST'];
            $db   = $_ENV['DB'];
            $user = $_ENV['USER'];
            $pass = $_ENV['PASSWORD'];
            $port = $_ENV['PORT'];

            $dsn = "mysql:host=$host:$port;dbname=$db"; // connection string
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->initDatabase();
            $this->initData();
            $this->usersDatabase = new UserDatabase($this->pdo);
            $this->usersDatabase->setupUsers();
            $this->usersDatabase->seedUsers();
        }
        function initData(){
            $sql = "SELECT COUNT(*) FROM Products";
            $res = $this->pdo->query($sql);
            $count = $res->fetchColumn();
            if($count == 0){
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Beach', 10, 100, 'Landscape','/assets/beach.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Sunny Beach', 5, 50, 'Landscape','/assets/beachsun.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Cats', 7, 70, 'Illustration','/assets/cats.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Cave', 15, 30, 'Landscape','/assets/cave.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Cliff', 20, 40, 'Landscape','/assets/cliff.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Cow', 10, 20, 'Animal','assets/cow.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Dog', 10, 20, 'Illustration','assets/dog.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Dolphin', 10, 20, 'Animal','assets/dolphin.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Drinks', 10, 20, 'Illustration','assets/drinks.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Elephant', 10, 20, 'Animal','assets/elephant.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Flowerfield', 10, 20, 'Flower','assets/flowerfield.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Flowerfield edition 2', 10, 20, 'Flower','assets/flowerfield2.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Giraff', 10, 20, 'Animal','assets/giraff.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Horse', 10, 20, 'Animal','assets/horse.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Lamb', 10, 20, 'Animal','assets/lamb.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Lupin', 10, 20, 'Flower','assets/lupin.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Magnolia', 10, 20, 'Flower','assets/magnolia.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Mountain', 10, 20, 'Landscape','assets/mountain.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Palm Tree', 10, 20, 'Landscape','assets/palm.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Pho', 10, 20, 'Illustration','assets/pho.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Poppy', 10, 20, 'Illustration','assets/poppy.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Riviera', 10, 20, 'Landscape','assets/riviera.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Seaside', 10, 20, 'Landscape','assets/seaside.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Sunset', 10, 20, 'Illustration','assets/sunset.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Tulip', 10, 20, 'Flower','assets/tulip.png')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES ('Tulip edition 2', 10, 20, 'Flower','assets/tulip2.png')");
            }
        }

        function initDatabase(){
            $this->pdo->query('CREATE TABLE IF NOT EXISTS Products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                price INT,
                stockLevel INT,
                categoryName VARCHAR(50),
                imageUrl VARCHAR(500)
            )');
            $this->pdo->query('CREATE TABLE IF NOT EXISTS CartItem (
                id INT AUTO_INCREMENT PRIMARY KEY,
                productId INT,
                quantity INT,
                addedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                sessionId VARCHAR(50), # b77e0a1d7b4f9286f4ddcb8c61b80403
                userId INT NULL,
                FOREIGN KEY (productId) REFERENCES Products(id) ON DELETE CASCADE
                )');
        }

        function getProduct($id){
            $query = $this->pdo->prepare("SELECT * FROM Products WHERE id = :id");
            $query->execute(['id' => $id]);
            $query->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $query->fetch();
        }

        function updateProduct($product){
            $s = "UPDATE Products SET title = :title," .
                " price = :price, stockLevel = :stockLevel, categoryName = :categoryName, imageUrl = :imageUrl WHERE id = :id";
            $query = $this->pdo->prepare($s);
            $query->execute(['title' => $product->title, 'price' => $product->price,
                'stockLevel' => $product->stockLevel, 'categoryName' => $product->categoryName, 'imageUrl' => $product->imageUrl, 
                'id' => $product->id]);
        }

        function deleteProduct($id){
            $query = $this->pdo->prepare("DELETE FROM Products WHERE id = :id");
            $query->execute(['id' => $id]);
        }

        function insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl) {
            $sql = "INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl) VALUES (:title, :price, :stockLevel, :categoryName, :imageUrl)";
            $query = $this->pdo->prepare($sql);
            $query->execute(['title' => $title, 'price' => $price,'stockLevel' => $stockLevel, 'categoryName' => $categoryName, 'imageUrl' => $imageUrl]);
        }
      
        function searchProducts($q,$sortCol, $sortOrder){
            if(!in_array($sortCol,[ "title","price"])){
                $sortCol = "title";
            }
            if(!in_array($sortOrder,["asc", "desc"])){
                $sortOrder = "asc";
            }
    
            $query = $this->pdo->prepare("SELECT * FROM Products WHERE title LIKE :q or categoryName like :q ORDER BY $sortCol $sortOrder");

            $query->execute(['q' => "%$q%"]);
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
        }

        //function getAllProducts($sortCol, $sortOrder){
        function getAllProducts($sortCol="id", $sortOrder= "asc"){
            if(!in_array($sortCol,["id", "categoryName",  "title","price","stockLevel", "imageUrl"])){
                $sortCol = "id";
            }
            if(!in_array($sortOrder,["asc", "desc"])){
                $sortOrder = "asc";
            }

            // SELECT * FROM Products ORDER BY  id asc
            $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder"); // Products är TABELL 
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
        }

        function getCategoryProducts($catName){
            if($catName == ""){
                $query = $this->pdo->query("SELECT * FROM Products"); // Products är TABELL 
                return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
            }
            $query = $this->pdo->prepare("SELECT * FROM Products WHERE categoryName = :categoryName");
            $query->execute(['categoryName' => $catName]);
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
        }
        function getAllCategories(){
                // SELECT DISTINCT categoryName FROM Products
            $data = $this->pdo->query('SELECT DISTINCT categoryName FROM Products')->fetchAll(PDO::FETCH_COLUMN);
            return $data;
        }
 
        function getCartItems($userId, $sessionId){
            

            $query = $this->pdo->prepare("SELECT CartItem.Id as id, CartItem.productId, CartItem.quantity, Products.title as productName, Products.price as productPrice, Products.price * CartItem.quantity as rowPrice     FROM CartItem JOIN Products ON Products.id=CartItem.productId  WHERE userId=:userId or sessionId = :sessionId");
            $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);


            return $query->fetchAll(PDO::FETCH_CLASS, 'CartItem');
        }

        function convertSessionToUser($session_id, $userId, $newSessionId){
            $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId, sessionId=:newSessionId WHERE sessionId = :sessionId");
            $query->execute(['sessionId' => $session_id, 'userId' => $userId, 'newSessionId' => $newSessionId]);
        }

        function updateCartItem($userId, $sessionId,$productId, $quantity){
            if($quantity <= 0){
                $query = $this->pdo->prepare("DELETE FROM CartItem WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
                $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
                return;
            }
            $query = $this->pdo->prepare("SELECT * FROM CartItem  WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
            $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
            if($query->rowCount() == 0){
                $query = $this->pdo->prepare("INSERT INTO CartItem (productId, quantity, sessionId, userId) VALUES (:productId, :quantity, :sessionId, :userId)");
                $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
            }
            else{
                $query = $this->pdo->prepare("UPDATE CartItem SET quantity = :quantity WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
                $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
            }
        }

    }
?>
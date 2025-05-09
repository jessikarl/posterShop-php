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

        function addProductIfNotExists($title, $price, $stockLevel, $categoryName, $imageUrl, $popularityFactor){
            $query = $this->pdo->prepare("SELECT * FROM Products WHERE title = :title");
            $query->execute(['title' => $title]);
            if($query->rowCount() == 0){
                $this->insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl,$popularityFactor);
            }
        }

        function initData(){
            $sql = "SELECT COUNT(*) FROM Products";
            $res = $this->pdo->query($sql);
            $count = $res->fetchColumn();
            if($count == 0){
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Beach', 10, 100, 'Landscape','/assets/beach.png','6')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Sunny Beach', 8, 65, 'Landscape','/assets/beachsun.png','5')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Cats', 9, 70, 'Illustration','/assets/cats.png','4')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Cave', 15, 300, 'Landscape','/assets/cave.png','7')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Cliff', 20, 55, 'Landscape','/assets/cliff.png','3')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Cow', 15, 780, 'Animal','assets/cow.png','4')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Dog', 5, 250, 'Illustration','assets/dog.png','3')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Dolphin', 10, 800, 'Animal','assets/dolphin.png','4')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Drinks', 100, 2800, 'Illustration','assets/drinks.png','8')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Elephant', 60, 78, 'Animal','assets/elephant.png','6')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Flowerfield', 40, 50, 'Flower','assets/flowerfield.png','2')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Flowerfield edition 2', 15, 60, 'Flower','assets/flowerfield2.png','4')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Giraff', 100, 20, 'Animal','assets/giraff.png','5')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Horse', 8, 60, 'Animal','assets/horse.png','9')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Lamb', 100, 20, 'Animal','assets/lamb.png','7')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Lupin', 9, 20, 'Flower','assets/lupin.png','9')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Magnolia', 100, 25, 'Flower','assets/magnolia.png','6')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Mountain', 100, 270, 'Landscape','assets/mountain.png','5')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Palm Tree', 160, 270, 'Landscape','assets/palm.png','7')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Pho', 15, 200, 'Illustration','assets/pho.png','7')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Poppy', 100, 200, 'Illustration','assets/poppy.png','8')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Riviera', 15, 40, 'Landscape','assets/riviera.png','10')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Seaside', 10, 30, 'Landscape','assets/seaside.png','3')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Sunset', 6, 20, 'Illustration','assets/sunset.png','2')");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Tulip', 100, 200, 'Flower','assets/tulip.png'),'10'");
                $this->pdo->query("INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES ('Tulip edition 2', 10, 80, 'Flower','assets/tulip2.png','4')");
            }
        }

        function initDatabase(){
            $this->pdo->query('CREATE TABLE IF NOT EXISTS Products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                price INT,
                stockLevel INT,
                categoryName VARCHAR(50),
                imageUrl VARCHAR(500),
                popularityFactor INT DEFAULT 0
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
                " price = :price, stockLevel = :stockLevel, categoryName = :categoryName, imageUrl = :imageUrl, popularityFactor=:popularityFactor WHERE id = :id";
            $query = $this->pdo->prepare($s);
            $query->execute(['title' => $product->title, 'price' => $product->price,
                'stockLevel' => $product->stockLevel, 'categoryName' => $product->categoryName, 'imageUrl' => $product->imageUrl, 
                'popularityFactor' => $product->popularityFactor,'id' => $product->id]);
        }

        function deleteProduct($id){
            $query = $this->pdo->prepare("DELETE FROM Products WHERE id = :id");
            $query->execute(['id' => $id]);
        }

        function insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl, $popularityFactor) {
            $sql = "INSERT INTO Products (title, price, stockLevel, categoryName, imageUrl, popularityFactor) VALUES (:title, :price,
            :stockLevel, :categoryName, :imageUrl, :popularityFactor)";
            $query = $this->pdo->prepare($sql);
            $query->execute(['title' => $title, 'price' => $price,'stockLevel' => $stockLevel,
            'categoryName' => $categoryName, 'imageUrl' => $imageUrl, 'popularityFactor' => $popularityFactor]);
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
            if(!in_array($sortCol,["id", "categoryName", "title","price","stockLevel", "imageUrl"])){
                $sortCol = "id";
            }
            if(!in_array($sortOrder,["asc", "desc"])){
                $sortOrder = "asc";
            }

            // SELECT * FROM Products ORDER BY  id asc
            $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder"); // Products är TABELL 
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
        }

        function getPopularProducts(){
            $query = $this->pdo->query("SELECT * FROM Products ORDER BY popularityFactor DESC LIMIT 10"); // Products är TABELL 
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
        }

        function getCategoryProducts($catName, $sortCol ="title", $sortOrder = "asc"){
            if(!in_array($sortCol,["id", "categoryName", "title","price","stockLevel", "imageUrl"])){
                $sortCol = "title";
            }
            if(!in_array($sortOrder,["asc", "desc"])){
                $sortOrder = "asc";
            }
            if($catName == ""){
                $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder");
                return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
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
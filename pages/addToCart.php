<?php
 
require_once("Models/Database.php");
require_once("Models/Cart.php");

global $dbContext, $cart;

$productId = $_GET['productId'] ?? "";
$fromPage = $_GET['fromPage'] ?? "";
 
$cart->addItem($productId, 1);
 
header("Location: $fromPage");
?>
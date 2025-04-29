<?php 
require_once("vendor/autoload.php");

require_once(dirname(__FILE__) ."/Utils/router.php");

ob_start(); // Startar output buffering
// ensure_session();
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();
// pilar istället för .
// \ istället .

// import * as dotenv from "dotenv";
//denna fil kommer alltid att laddas först 
//ska mappa urler till pages

$router = new Router();
$router->addRoute('/', function () {
    require_once( __DIR__ .'/pages/home.php');
});
$router->addRoute('/category', function () {
    require_once( __DIR__ .'/pages/category.php');
});
$router->addRoute('/admin/products', function () {
    require_once( __DIR__ .'/pages/admin.php');
});
$router->addRoute('/admin/edit', function () {
    require_once( __DIR__ .'/pages/edit.php');
});
$router->addRoute('/admin/new', function () {
    require_once( __DIR__ .'/pages/new.php');
});
$router->addRoute('/admin/delete', function () {
    require_once( __DIR__ .'/pages/delete.php');
});
$router->addRoute('/user/login', function () {
    require_once( __DIR__ .'/pages/users/login.php');
});
$router->addRoute('/user/logout', function () {
    require_once( __DIR__ .'/pages/users/logout.php');
});
$router->addRoute('/user/register', function () {
    require_once( __DIR__ .'/pages/users/register.php');
});
$router->addRoute('/user/registerThanks', function () {
    require_once( __DIR__ .'/pages/users/registerThanks.php');
});
$router->addRoute('/addToCart', function () {
    require_once( __DIR__ .'/Pages/addToCart.php');
});

$router->dispatch();

?>
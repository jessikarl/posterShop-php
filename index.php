<?php 
require_once("vendor/autoload.php");

require_once(dirname(__FILE__) ."/Utils/router.php");



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
$router->addRoute('/admin/admin', function () {
    require_once( __DIR__ .'/pages/admin.php');
});
$router->addRoute('/admin/edit', function () {
    require_once( __DIR__ .'/pages/edit.php');
});

$router->dispatch();

?>
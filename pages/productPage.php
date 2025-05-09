<?php
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/HeaderNav.php");
require_once("Models/Database.php");

global $dbContext, $cart;

$id = $_GET['id'];

$product = $dbContext->getProduct($id);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product->title = $_POST['title'];
    $product->stockLevel = $_POST['stockLevel'];
    $product->price = $_POST['price'];
    $product->imageUrl = $_POST['imageUrl'];
}else{
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Product page</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php echo HeaderNav($dbContext, $cart) ?>

        <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <?php foreach($dbContext->getProduct($id) as $prod){ ?>
                <div>
                    <?php echo $prod->imageUrl; ?> 
                </div>
                <div>
                    <h1><?php echo $prod->title; ?></h1> 
                </div>
                <div>
                    <p>description </p>
                </div>
                <div>
                    <h2><?php echo $prod->price; ?></h2> 
                </div>
                <div>
                    <h2><?php echo $prod->stockLevel; ?></h2> 
                </div>
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center">
                        <a class="btn btn-outline-dark mt-auto" href="/addToCart?productId=<?php echo $prod->id ?>
                        &fromPage=<?php echo urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') .
                        "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ) ?>">Add to cart</a></div>
                </div>            
            <?php } ?>
        </div>
        </section>
        <?php Footer(); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

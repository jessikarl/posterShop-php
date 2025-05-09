<?php
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/HeaderNav.php");
require_once("Models/Database.php");

global $dbContext, $cart;

$id = $_GET['id'];

$product = $dbContext->getProduct($id);

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
        <link href="/css/custom.css" rel="stylesheet" />

    </head>
    <body>
        <?php echo HeaderNav($dbContext, $cart) ?>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row">
                    <div class="col mb-5">
                        <img class="img-fluid" src="<?php echo $product->imageUrl ?>" alt="<?php echo $product->title ?>">
                    </div>
                    <div class="col mb-5">
                        <h1><?php echo $product->title ?></h1>
                        <h3>Price: $<?php echo $product->price; ?></h3>
                        <p><strong>Stock level:</strong><?php echo $product->stockLevel; ?></p>
                        <p><strong>Description:</strong>Beautiful poster for your home!</p>
                        <a class="btn btn-outline-dark mt-auto" href="/addToCart?productId=<?php echo $product->id ?>
                        &fromPage=<?php echo urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') .
                        "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ) ?>">Add to cart</a>
                    </div>
                </div>            
            </div>
        </section>
        <?php Footer(); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

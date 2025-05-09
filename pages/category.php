<?php
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/HeaderNav.php");
require_once("Models/Database.php");

global $dbContext, $cart;

$catName = $_GET["catname"] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";

$header = $catName;
if($catName == ""){
    $header = "All Products";
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Category</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="/css/custom.css" rel="stylesheet" />

    </head>
    <body>
        <?php echo HeaderNav($dbContext, $cart) ?>

        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder"><?php echo $header; ?></h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="text-center mb-4">
                        <a href="?sortCol=title&sortOrder=asc&catname=<?php echo $catName;?>" class="btn btn-secondary">Title asc</a>
                        <a href="?sortCol=title&sortOrder=desc&catname=<?php echo $catName;?>" class="btn btn-secondary">Title desc</a>
                        <a href="?sortCol=price&sortOrder=asc&catname=<?php echo $catName;?>" class="btn btn-secondary">Price asc</a>
                        <a href="?sortCol=price&sortOrder=desc&catname=<?php echo $catName;?>" class="btn btn-secondary">Price desc</a>
                </div>

                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php 
                foreach($dbContext->getCategoryProducts($catName, $sortCol, $sortOrder) as $prod){
                    ?>
                    <div class="col mb-5">
                            <div class="card h-100">
                                <?php if($prod->price < 10) {  ?>
                                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                <?php } ?>        
                                <a href="/productPage?id=<?php echo $prod->id; ?>">
                                    <img src="<?php echo $prod->imageUrl ?>" alt="<?php echo $prod->title ?>">
                                </a>
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo $prod->title; ?></h5>
                                        $<?php echo $prod->price; ?>.00
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                                </div>
                            </div>
                        </div>    
                    <?php } ?>        
                </div>
            </div> 
        </section>


        <!-- Footer-->
         <?php Footer(); ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/HeaderNav.php");
require_once('Models/Database.php');

global $dbContext, $cart;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $stockLevel = $_POST['stockLevel'];
    $price = $_POST['price'];
    $categoryName = $_POST['categoryName'];
    $dbContext->insertProduct($title, $stockLevel, $price, $categoryName);
    header("Location: /admin/products");
    exit;
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
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
    </head>
<body>
    <?php echo HeaderNav($dbContext, $cart) ?>

    <section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
    <h2>Create new product</h2>
    <form method="POST" > 
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" value="">
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" value="">
        </div>
        <div class="form-group">
            <label for="stockLevel">Stock</label>
            <input type="text" class="form-control" name="stockLevel" value="">
        </div>
        <div class="form-group">
            <label for="categpryName">Category name:</label>
            <input type="text" class="form-control" name="categoryName" value="">
        </div>
        <input type="submit" class="btn btn-primary" value="Create">
    </form>
</div>
</section>



<?php Footer(); ?>
<!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

</body>
</html>

<!-- 
<input type="text" name="title" value="<?php echo $product->title ?>">
        <input type="text" name="price" value="<?php echo $product->price ?>">
        <input type="text" name="stockLevel" value="<?php echo $product->stockLevel ?>">
        <input type="text" name="categoryName" value="<?php echo $product->categoryName ?>">
        <input type="submit" value="Uppdatera"> -->
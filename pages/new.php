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
    $imageUrl = $_POST['imageUrl'];
    $dbContext->insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl);
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
        <title>Shop Homepage</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
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
            <label for="categoryName">Category name:</label>
            <input type="text" class="form-control" name="categoryName" value="">
        </div>
        <div class="form-group">
            <label for="imageUrl">Image Url:</label>
            <input type="text" class="form-control" name="imageUrl" value="">
        </div>
        <br>
        <input type="submit" class="btn btn-primary" value="Create">
    </form>
</div>
</section>



<?php Footer(); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>

</body>
</html>
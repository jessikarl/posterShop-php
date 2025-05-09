<?php

function HeaderNav($dbContext, $cart){
    ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="/">Poster Collection</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategorier</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/category">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                    <?php
                                    foreach($dbContext->getAllCategories() as $cat){
                                        echo "<li><a class='dropdown-item' href='/category?catname=$cat'>$cat</a></li>";
                                    }
                                    ?> 
                            </ul> 
                        </li>
                        <?php
                        if($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){ ?>
                            <li class="nav-item"><a class="nav-link" href="/user/logout">Logout</a></li>
                        <?php }else{ ?>
                            <li class="nav-item"><a class="nav-link" href="/user/login">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="/user/register">Create account</a></li>
                        <?php 
                        }
                        ?>
                    </ul>
                    <form action="/search" method="GET">
                            <input type="text" name="q" placeholder="Search" class="form-control">
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                    </form> 
                    <?php if($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){ ?>
                        Current user: <?php echo $dbContext->getUsersDatabase()->getAuth()->getUsername() ?>
                    <?php } ?>
                    <form class="d-flex">
                        <a href="/cart" class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">
                                <?php echo $cart->getItemsCount(); ?>
                            </span>
                        </a>
                    </form>
                </div>
            </div>
        </nav>
    <?php
}

?>
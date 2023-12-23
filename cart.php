<?php
declare(strict_types=1);
session_start();
require __DIR__."/DatabaseClasses/AbstractCart.php";
require __DIR__."/DatabaseClasses/CartUserExtendsAbstractCart.php";
require __DIR__ . "/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="description" content="Check your cart page and adjust quantity.">
 <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <script src="https://kit.fontawesome.com/cba05393c5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="Methods/script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Cart page</title>
</head>

<body onload="cartFunction()">
    <main id="cartMain">
        <section>
        <h1 class="cartHeading">Items in your cart:</h1>
            <?php 
            /***Render of items put in cart by user (guest in this case)***/
            CartUser::showCart();
            ?> 
            <h2>Total:</h2>
            <hr>
            <p id="cartDelTest"></p>
            <?php 
            ?>
        <p id="cartOutput"></p><!--Rendering total price for user(modified by quantity) -->
        <p id="cartOutput2"></p><!--Rendering total price for user(modified by quantity) -->
        
        </section>
    </main>
    <nav class="goBackCart">
           <a href="index" aria-label="Go Back">Go back</a>
          <input type="button" name="answer" value="Continue" onclick="quantityFunction();"></input> <!--Move forward with chosen quantity amounts -->
    </nav>
    <footer class="frontPage">
        <div class="footerContainer">
            <section class="policies">
                <a href="policy.html">Policy</a>
                <a href="termsandconditions.html">Terms and conditions</a>
                <a href="index">Web shop</a>
            </section>
            <section class="generalData">
           		<p>Afterparty Bookstore e-commerce website</p>
                <p>Developed by Mirza Mehagić</p>
                <p>Copyright © 2023 Mirza Mehagić All rights reserved</p>
                <p>This is personal and non-commercial product</p>
                <p>Contact: mirza.mehagic@hotmail.com (or via page contact form)</p>
            </section>
            <section class="socials">
                <a href="https://www.facebook.com/mirza.mehagic" class="fa fa-facebook"></a>
            </section>
        </div>
    </footer>
</body>
</html>


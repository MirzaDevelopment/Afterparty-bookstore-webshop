<?php
declare(strict_types=1);
session_start();
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); //Declaring general session variable to hold cart items to show on first page
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Details, reviews and average reader score.">
    <!--Removing favicon icon console error-->
    <link rel="icon" href="data:;base64,=">
    <!-- General JS app script-->
    <script src="Methods/script.js"></script>
    <!-- Google recaptcha script. -->
    <title>Bookstore webshop</title>
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <script async src="https://kit.fontawesome.com/cba05393c5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="previewBody">
    <!--Positioned here so it can stay on top while scrolling the entire page-->
    <div class="headerStuff">
        <span id='cartNum'><?php print_r(count($_SESSION['cart'])) ?></span>
        <!--Number of items in cart-->
        <a class='cartIcon' href="cart"><img class='cartMain' src='Methods/img/shopping-cart.png' alt='shopping-cart-icon' width='35' height='35'></a>
        <!--Cart icon-->
        <a class='loginIcon' href="loginPage"><img class="icon" src="Methods/img/userFront.png" alt="user-icon" width="35" height="35"></a>
        <!--Login/register page-->
        <a href="loginPage">Login/Register</a>
    </div>
    
<h2 class='latestEdition' >Book preview</h2>
<?php
require __DIR__ . "/config.php";
require __DIR__ . "/Interfaces/UserBookSelectInterface.php";
require __DIR__ . "/DatabaseClasses/BooksDatabase.php"; //Required for categories
Booksdatabase::bookPreview($_GET['id']);
//Creating logic to correctly back users from preview panel to their corresponding panels.
if(isset($_SESSION['status']) == 2 || isset($_SESSION['status'])==1) {
   echo"<div class='goBackMsg'>
                <a href='Methods/Admin/bookSearch'><img src='Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>
            </div>";
} else if (isset($_SESSION['status']) == 3) {
    echo"<div class='goBackMsg'>
    <a href='Methods/User/userPanel'><img src='Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>
</div>";
} else {
    echo"<div class='goBackMsg'>
    <a href='index'><img src='Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>
</div>";
}
            ?>
    <footer class="frontPage">
        <div class="footerContainer">
            <section class="policies">
                <h3><a href="policy.html">Policy</a></h3>
                <h3><a href="termsandconditions.html">Terms and conditions</a></h3>
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
    <!--Footer end-->  
</body>
</html>
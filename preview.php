<?php
declare(strict_types=1);
session_start();
//putting get into session
if(isset($_GET['id'])){
    $trimmed=trim($_GET['id']);
    $cleaned=htmlspecialchars($trimmed,ENT_QUOTES);
    $_SESSION['id']=(int)$cleaned;
} else if (!isset($_GET['id'])&& empty($_SESSION['id'])){
    header("Location:index.php");
    exit();
}
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); //Declaring general session variable to hold cart items to show on first page
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  	<meta name="description" content="Details, comments and average reader score.">
    <!--Removing favicon icon console error-->
    <link rel="icon" href="data:;base64,=">
    <!-- General JS app script-->
    <script src="Methods/script.js"></script>
  	<script src="Methods/validation.js"></script>
    <!-- Google recaptcha script. -->
    <title>Bookstore webshop</title>
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <script async src="https://kit.fontawesome.com/cba05393c5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body onload="previewFunction()" class="previewBody">
  <main>
    <!--Positioned here so it can stay on top while scrolling the entire page-->
    <div class="headerStuff">
        <span id='cartNum'><?php print_r(count($_SESSION['cart'])) ?></span>
        <!--Number of items in cart-->
        <a class='cartIcon' href="cart"><img class='cartMain' src='Methods/img/shopping-cart.png' alt='shopping-cart-icon' width='35' height='35'></a>
        <!--Cart icon-->
    </div>
    
<h2 class='latestEdition' >Book preview</h2>
<section>
<?php
//Rendering chosen book
require __DIR__ . "/config.php";
require __DIR__ . "/Interfaces/UserBookSelectInterface.php";
require __DIR__ . "/DatabaseClasses/BooksDatabase.php"; //Required for categories
require __DIR__. "/Form.php";//Form for user comments
require __DIR__ . "/DatabaseClasses/RatingDatabase.php";
require __DIR__ . "/GeneralClasses/RatingExtendsDatabase.php";
Booksdatabase::bookPreview($_SESSION['id']);
require __DIR__."/Traits/CleaningLadyTrait.php"; 
require __DIR__."/Traits/PreventDuplicateTrait.php"; 
require __DIR__."/Traits/PasswordResetTrait.php"; 
require __DIR__."/Traits/SelectUserTrait.php"; 
require __DIR__."/GeneralClasses/SetUser.php"; //Variable setting class include
require __DIR__ . "/Interfaces/CommentInterface.php";
require __DIR__ . "/DatabaseClasses/CommentDatabase.php";
require __DIR__ . "/Interfaces/CommentSelectInterface.php";
require __DIR__ . "/DatabaseClasses/CommentSelectDatabase.php";
require __DIR__ . "/GeneralClasses/CommentsExtendsDatabase.php";
//Setting class for insert comments
$objekatSet = new SetUser();
//Comment insert method
$objekatSet->commentInsertSetting();
//"Similiar like this" carousel 
echo "<div class='carouselContainer'>";
Booksdatabase::selectCarousel();
echo "</div>";
//Creating logic to correctly back users from preview panel to their corresponding panels.
if(isset($_SESSION['status']) && $_SESSION['status'] == 2 || isset($_SESSION['status']) && $_SESSION['status']==1) {
   echo"<div class='goBackMsgPreview'>
                <a href='Methods/Admin/bookSearch'><img src='Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>
            </div>";
} else if (isset($_SESSION['status']) && $_SESSION['status'] == 3 && empty($_SESSION['id'])) {
    echo"<div class='goBackMsgPreview'>
    <a href='Methods/User/userPanel'><img src='Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>
</div>";
} else if (isset($_SESSION['status']) && $_SESSION['status'] == 3 && !empty($_SESSION['id'])){
    echo"<div class='goBackMsgPreview'>
    <a href='index'><img src='Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>
</div>";
} else {
    echo"<div class='goBackMsgPreview'>
    <a href='index'><img src='Methods/img/previous.png' alt='back-to-previous-page' width='35' height='35'></a>
</div>"; 
}
echo "<br>";
echo "<div class='mainCommentContainer'>";
CommentSelectDatabase::selectAllComments($_SESSION['id']);
echo "</div>";
echo "</section>";
            ?>
   </main>
               <!--Footer start-->  
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
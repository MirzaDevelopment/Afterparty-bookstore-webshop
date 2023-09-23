<?php
declare(strict_types=1);
require __DIR__ . "../../../config.php";
require __DIR__ . "../../../GeneralClasses/LoginClass.php";
//Making sure user is redirected to correct panel no matter what (normal or super admin)!
session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
}else if ($_SESSION['status'] == 3) {
    header("Location:../User/userPanel.php");
    die();
}
if (isset($_POST['Logout'])) {
    //Logout button which delets user session
    LoginClass::logOut();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="book search panel">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <title>Book search and modify panel</title>
</head>
 <?php
  LoginCLass::userPanelCheck();
  ?>
<body class="background" onload="myFunction()">
    <main>
        <div class="searchContainer">
            <h2>Click the button below to show all books in bookstore (slow):</h2>
            <!--SEARCH FORM--->
            <!--SELECT ALL BOOKS--->
            <form action="bookSearch#searchAnchor" method="POST">
                <br>
                <!--SUBMIT BUTTON FOR ALL SELECT-->
                <input type="submit" name="list" id="list" value="Show all books"></input>
            </form>
            <section class="searchIcon">
                <input type="image" src="../img/AdminIcon.webp" alt="people-work-illustration" />
            </section>
            <!--SELECT BOOKS BY FILTER-->
            <h3>Search for specific books by using filters below (faster):</h3>
            <form action="bookSearch#searchAnchor" method="POST">
                <div class="inputContainer">
                    <label for="title">Search by Title:</label>
                    <input type="text" name="titleSearch" id="title" placeholder="ex. Most"></input>
                    <label for="author">Search by Author:</label>
                    <input type="text" name="author" id="author" placeholder="ex. Nabukov"></input>
                    <label for="number1">Minimum book price</label>
                    <input type="number" name="number1" id="number1" min="0" placeholder="Min price..."></input>
                    <label for="number2">Maximum book price</label>
                    <input type="number" name="number2" id="number2" min="0" placeholder="Max price..."></input>

                </div>
                <!--SUBMIT BUTTON FOR FILTER SELECT-->
                <div class="iconWrapSearch">
                    <input type="image" src="../img/search.png" alt="Submit" width="45" height="45" /></input>
                </div>
                <!--END of iconWrapper class-->
            </form>
        </div>
        <!--END of "searchContainer" class div-->
        <div class="goBackMsg">
            <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
        </div>
        <!--END of "goBackMsg" class div-->
        <p id='searchAnchor'></p>
    </main>
</body>
<?php
/***INCLUDE FILE WITH VARIABLE SETTINGS AND QUERY FINALISATION***/
require __DIR__ . "../../Controllers/controller.php";

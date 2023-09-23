<?php
declare(strict_types=1);
session_start();
require __DIR__ . "/GeneralClasses/LoginClass.php";
require __DIR__ . "/Interfaces/UsersInterface.php";
LoginClass::indexCheck();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login or register">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" rel="stylesheet">
    <script src="Methods/script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Bookstore login page</title>
</head>
<body onload="fancyAnimation()">
  <p class='afterRegMessage'>You are browsing as guest! Please login with your new user name and password...</p>
    <div class="bck-image"><!-- Necessary for background -->
        <span class="introduction"></span>
    </div>
    <div id="animate">
        <p class="loginHere">Login with your user name and password</p>
        <div class="loginWrapper">
            <form>
                <!-- Classic login form -->
             	<div class="firstContainer"><!-- Small containers for better stilisation -->
                <label for="user_name">Insert username </label>
                <input class="inputLogin" type="text" id="user_name" name="user_name">
                 </div>
                <div class="secondContainer"><!-- Small containers for better stilisation -->
                <label for="passwordLogin">Insert password </label>
                <input class="inputLogin" type="password" id="passwordLogin" name="passwordLogin">
                  </div>
                <input id="loginButton" type="button" value="Submit">
            </form>
        </div>
        <br>
        <br>
        <a href="Methods/register">Dont have account? <p class="emph">Register here...</p><br></a>
        <!--Link for user registration panel-->
        <a href="Methods/reset">Forgot password? Click here to reset...<br></a><!-- Link for password reset panel -->
        <footer class="loginNav">
            <!--Bottom navigation -->
            <nav class="goBackCartCheckoutLogin">
                <a href="index">Web shop</a>
                <!--Going back to front page -->
            </nav>
            <p id="output3"></p>
        </footer>
    </div>
</body>

</html>
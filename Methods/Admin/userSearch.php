<?php
declare(strict_types=1);
require_once __DIR__ . "../../../GeneralClasses/LoginClass.php";
require_once __DIR__ . "../../../config.php";
//Making sure user is redirected to correct panel no matter what (normal or super admin)!
session_start();
if ($_SESSION['status'] == 2) {
    header("Location:normalAdminPanel.php");
    die();
 //Login session check, redirect to login if empty
} else if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
} else if ($_SESSION['status'] == 3) {
    header("Location:../User/userPanel.php");
    die();
}
//Logout button which delets user session
if (isset($_POST['Logout'])) {
    LoginClass::logOut();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="user search panel">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>User search and management system</title>
</head>
  <?php
  LoginCLass::userPanelCheck();
  ?>
<body class="gradient">
    <main>
        <div class="bookWrapperUserSearch">
            <div class="userSearchContainer">
                <h2>User search panel</h2>
                <!--SEARCH FORM-->
                <!--SELECT ALL USERS-->
                <form action="userSearch#searchAnchor" method="POST">
                    <br>
                    <!--SUBMIT BUTTON FOR ALL SELECT-->
                    <input type="submit" name="listUsers" id="list" value="Show all users"></input>
                </form>
                <section class="searchIcon">
                    <input type="image" src="../img/jigsawpeople.webp" alt="jigsaw-people-build" />
                </section>
                <!--SELECT USERS BY FILTER-->
                <form class="userSearchForm" action="userSearch#searchAnchor" method="POST">
                    <label for="first_name">Search by First name:</label>
                    <input type="text" name="first_name" id="first_name" placeholder="ex. Amar"></input>
                    <label for="author">Search by Last name:</label>
                    <input type="text" name="last_name" id="author" placeholder="ex. Kapić"></input>
                    <label for="user_name">Search by User name:</label>
                    <input type="text" name="user_name" id="user_name"></input>
                    <!--SUBMIT BUTTON FOR FILTER SELECT-->
                    <input type="submit" value="Search"></input>
                </form>
            </div>
        </div>
        <!--BACK BUTTON TO ADMIN PANEL-->
        <div class="goBackMsgUserSearch">
            <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
        </div>
        <!--END of "goBackMsgUserSearch" class div-->
        <p id='searchAnchor'></p>
    </main>
</body>
<?php
require __DIR__ . "../../Controllers/controller.php";

<?php
declare(strict_types=1);
/***Booksdatabase class with coresponding interface include***/
require __DIR__ . "../../../Interfaces/QueryInterface.php";
require __DIR__ . "../../../DatabaseClasses/Database.php";
require __DIR__ . "../../../BookClasses/BookstoreExtendsDatabase.php";
require __DIR__ . "../../../GeneralClasses/LoginClass.php";
require __DIR__ . "../../../Traits/PreventDuplicateTrait.php";
require __DIR__ . "../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__ . "../../../GeneralClasses/SetAdmin.php"; //Variable setting class include
require __DIR__ . "../../../config.php"; //Variable setting class include
//Logout button which deletes user session
if (isset($_POST['Logout'])) {
    LoginClass::logOut();
}
//Sending logged in user to proper panel
session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
}else if ($_SESSION['status'] == 3) {
    header("Location:../User/userPanel.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="List of discounted items with option to delete discount">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <script src="../validation.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Discount management</title>
</head>
<?php
  LoginCLass::userPanelCheck();
  ?>
<body>
    <?php
    /***ACTIVE DISCOUNTS RENDER FOR ADMIN***/
    Bookstore::adminSelectDiscounts();
    ?>
      <!--Go back button-->
    <div class="goBackMsgDiscount">
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
</body>
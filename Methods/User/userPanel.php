<?php
declare(strict_types=1);
//Login class to check for available sessions which redistribute users to corresponding panels.
require __DIR__ . "../../../GeneralClasses/LoginClass.php";
require __DIR__ . "../../../config.php";
if (isset($_POST['Logout'])) {
    LoginClass::logOut();
}
session_start();
//Making sure user is redirected to correct panel no matter what (user, normal or super admin)!
if ($_SESSION['status'] == 1) {
    header("Location:../Admin/adminPanel.php");
    die();
} else if ($_SESSION['status'] == 2) {
    header("Location:../Admin/normalAdminPanel.php");
    die();
} else if (empty($_SESSION['status'])){
  header("Location:../../loginPage.php");
  die();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="http://example.com/" />
    <meta name="description" content="overview of user transactions">
    <link rel="stylesheet" href="../../style.css">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Book search page</title>
</head>
<?php
//Login class to check for available sessions which redistribute users to corresponding panels.
LoginClass::userPanelCheck();
require_once "../../DatabaseClasses/Statistics.php";
?>
<!--Function for ajax calls-->

<body class="insertBodyUser" onload="myFunction()">
    <main>
        <?php
        //Render of all purchases made by user (his email)
        Statistics::userPurchase();

        ?>
    </main>
    <div class="goBackMsgUserPanel">
            <a href="../../index"><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
        </div>
</body>

</html>

<?php
declare(strict_types=1);
/***Slider management panel***/
//Login class to check for available sessions which redistribute users to corresponding panels.
require __DIR__ . "../../../GeneralClasses/LoginClass.php";
require __DIR__ . "../../../DatabaseClasses/Slider.php";
require __DIR__ . "../../../config.php";

//Making sure user is redirected to correct panel no matter what (user, normal or super admin)!
session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
}else if ($_SESSION['status'] == 3) {
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
 	<meta name="description" content="first page slider items with option to delete them">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Slider management</title>
</head>
  <?php
  LoginCLass::userPanelCheck();
  ?>
<body class="sliderBody">
    <h1 id="sliderTitle">Books currently in slider (click on trash icon to delete from slider)</h2>
        <?php
        //Showing items currently in slider
        Slider::sliderRender()
        ?>
        <div class="goBackMsgSlider">
            <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
        </div>
</body>

</html>
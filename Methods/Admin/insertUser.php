<?php
declare(strict_types=1);
require __DIR__ . "../../../GeneralClasses/LoginClass.php";
require __DIR__ . "../../../config.php";
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
  	<meta name="description" content="user insert panel">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../validation.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>User upload panel</title>
</head>
  <?php
  LoginCLass::userPanelCheck();
  ?>
<body onload="uploadUser()" class="userInsert">
    <div class="register-wrapper">
        <div class="uploadContainerUser">
            <h2>User upload panel</h2>
            <form action="insertUser" method="POST">
                <!--INPUT FIELDS-->
                <input type="text" name="first_name" placeholder="First name..." value="<?php echo $_POST['first_name'] ?? '' ?>">
            
                <input type="text" name="last_name" placeholder="Last name..." value="<?php echo $_POST['last_name'] ?? '' ?>">
         
                <input type="text" name="user_name" placeholder="User name..." onkeyup="checkUserNameAdmin(this.value);getFocus()">
            	<div id="porukaUser"></div> <!--AJAX CALL RESPONSE MESSAGES-->
                <input type="text" id="mailVal" name="email" placeholder="Email..." onkeyup="checkMail(this.value);checkEmailAdmin(this.value);getFocus()">
                <div id="poruka"></div> <!--AJAX CALL RESPONSE MESSAGES-->
                <div id="porukaMail"></div> <!--AJAX CALL RESPONSE MESSAGES-->
                <!--PASSWORD INPUT WITH JS FUNCTION FOR VALIDATION-->
                <input type="password" id="passVal" name="password" placeholder="User password..." onkeyup="checkPass(this.value);getFocus()">
             	<div id="porukaPassword"></div>  <!--AJAX CALL RESPONSE MESSAGES-->
                <!--SELECT FORM FOR SELECTING USER STATUS(admin, or user)-->
                <label for="users">Choose a user status:</label>
                <select name="userStatus" class="userUpd" id="users">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
              
                <!--SUBMIT BUTTON-->
                <input type="submit" name="insert" value="Submit">
            </form>
            <br>
            <!--GO BACK TO ADMIN PANEL BUTTON-->
            <div class="goBackMsgUser">
                <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
            </div>
            <br>
            <br>
        </div>
    </div>
</body>

</html>
<?php
if (isset($_POST['insert']) || isset($_GET['insert'])) {
/***Variable setting class with user insert logic***/
require_once __DIR__ . "../../../Interfaces/UsersInterface.php";
require_once __DIR__ . "../../../Traits/CleaningLadyTrait.php";
require_once __DIR__ . "../../../Traits/PreventDuplicateTrait.php";
require_once __DIR__ . "../../../Interfaces/UserSelectInterface.php";
require_once __DIR__ . "../../../GeneralClasses/SetAdmin.php";
$setObjekat = new SetAdmin();
$setObjekat->varSettingUsersInsert();
}
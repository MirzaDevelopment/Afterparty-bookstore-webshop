<?php
declare(strict_types=1);
require __DIR__."../../../Interfaces/SelectInterface.php";
require __DIR__."../../../Interfaces/QueryInterface.php";
require __DIR__."../../../DatabaseClasses/SelectDatabase.php";
require __DIR__."../../../DatabaseClasses/Database.php";
require __DIR__."../../../GeneralClasses/LoginClass.php";
require __DIR__."../../../Traits/PreventDuplicateTrait.php";
require __DIR__."../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require __DIR__."../../../GeneralClasses/SetAdmin.php"; //Variable setting class include
require __DIR__."../../../config.php"; //Variable setting class include
//Making sure user is redirected to correct panel no matter what (user or admin)!
session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
}else if ($_SESSION['status'] == 3) {
    header("Location:../User/userPanel.php");
    die();
}

//Logout button which deletes user session
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
  	<meta name="description" content="categories management panel">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <script src="../validation.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Category management</title>
</head>
<?php
  LoginCLass::userPanelCheck();
  ?>
<body class="bodyCat">
    <?php
    /***BOOKS DISTRIBUTED BY CHOSEN KATEGORY***/
    echo "<h2 class='categoryInsert'>Categories in database (click on - box to delete):</h2>";
    echo "<div class='categoryRender'>";
    Selectdatabase::adminSelectCategory();
    echo "</div>";
    ?>
    <div class="insertCategory"> <!--Category upload form -->
        <form action="categories#catAnchor" method="POST">
            <label for="newCategory">Add new category:</label><br>
            <input type="text" id="newCategory" name="newCategory" onkeyup="checkCategory(this.value)" placeholder="ex. Romance..."><br>
            <input class="submitCategory" type="submit" value="+"></input>
            <p id="porukaCategory"></p>
        </form>
    </div>
    <?php
    //Category upload
    $objekatSet = new SetAdmin();
    $objekatSet->varSettingCategoryInsert();
    ?>
    <div class="goBackMsgCategories">
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
</body>
</html>

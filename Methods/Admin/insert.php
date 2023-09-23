<?php
declare(strict_types=1);
  session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
}
require __DIR__."../../../Interfaces/UserBookSelectInterface.php";
require __DIR__. "../../../config.php";
require __DIR__."../../../DatabaseClasses/BooksDatabase.php";
require __DIR__."../../../GeneralClasses/LoginClass.php";
//Checking who is logged in exacly (to prevent empty sesssions or users to see data)
if ($_SESSION['status'] == 3) {
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
    <meta name="description" content="Book insert panel">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <title>Book upload system</title>
</head>
<?php
  LoginCLass::userPanelCheck();
  ?>
<body class="insertBody">
    <main>
        <div class="bookWrapper">
            <div class="uploadContainer">
                <h2>Book upload</h2>
                <!--UPLOAD FORM WITH INPUT FIELDS-->
                <form action="insert#uploadAnchor" method="POST" enctype="multipart/form-data">
                    <p>Type data below to upload it to database</p>
                    <input type="text" name="title" autocomplete="on" placeholder="Book title..."></input><br>
                    <input type="text" name="author" placeholder="Book author..."></input><br>
                    <input type="number" name="price" step="0.01" placeholder="book price...ex:15.45"></input><br>
                    <input type="number" name="year" placeholder="Publish year..."></input><br>
                    <input type="text" name="publisher" placeholder="Publisher..."></input><br>
                    <!--BOOK QUANTITY INPUT-->
                    <input type="number" name="quantity" placeholder="Book pieces available..." min="0"></input>
                    <br>
                    <br>
                    <!--TEXT AREA (book description)-->
                    <textarea name="description" rows="10" cols="80" maxlength="400" placeholder="Write a short book description (max 400 characters)"></textarea>
                    <br>
                    <!-- IMAGE UPLOAD-->
                    <label class="img" for="img">Select book image (allowed extentions: jpg, png, jpeg, webp):</label>
                    <br>
                    <br>
                    <input type="file" id="img" name="img" accept=".jpg, .png, .jpeg, .webp"></input>
                    <br><br>

                    <!--BOOK CATEGORY-->
                    <?php
                    /***BOOKS DISTRIBUTED BY CHOSEN KATEGORY***/
                    BooksDatabase::userSelectCategory();
                    ?>
                    <!--SUBMIT BUTTON-->
                    <input type="submit" value="Submit"></input>
                </form>
            </div>
            <!--End of uploadCOntainer class div-->
            <br>

            <!--GO BACK TO ADMIN PANEL BUTTON-->
            <div class="goBackMsgInsert">
                <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
            </div>
            <!--End of goBackMsg class div-->
        </div>
        <!--End of BookWrapper class div-->
    </main>
</body>

</html>
<?php
/***INCLUDE FILE WITH VARIABLE SETTINGS AND QUERY FINALISATION***/
if (isset($_POST['title']) )  {
echo "<div class='finalMsg' id='uploadAnchor'>";
require __DIR__."../../Controllers/controller.php";
echo " Notice: Make sure all fields are filled in correctly!";
echo "</div>";
}



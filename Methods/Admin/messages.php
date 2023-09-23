<?php
declare(strict_types=1);
  session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
   header("Location:../../loginPage.php");
}
/***Messages panel for admin***/
require_once __DIR__."../../../Interfaces/UserBookSelectInterface.php";
require_once __DIR__."../../../DatabaseClasses/BooksDatabase.php";
require_once __DIR__."../../../GeneralClasses/LoginClass.php";
require __DIR__ . "../../../config.php";
//Checking who is logged in exacly (to prevent empty sesssions or users to see data)
if ($_SESSION['status'] == 3) {
  header("Location:../User/userPanel.php");//Redirecting to first page
  die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="messages management">
    <link rel="stylesheet" href="../../style.css">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Messages</title>
</head>
<?php
  LoginCLass::userPanelCheck();
 ?>
<body onload="selectAllQ()">

<?php
require_once __DIR__."../../../Traits/CleaningLadyTrait.php"; //SANITATION AND VALIDATION TRAIT "CleaningLady"
require_once __DIR__."../../../Traits/PreventDuplicateTrait.php";
require_once __DIR__."../../../GeneralClasses/SetAdmin.php";
require_once __DIR__."../../../Interfaces/QuestionInterface.php";
require_once __DIR__."../../../DatabaseClasses/QuestionDatabase.php";
require __DIR__ . "../../../config.php";
//Delete for checked questions
SetAdmin::delQuestionsAdmin();
//Getting all questions in DB
QuestionDatabase::selectAllQuestions();
?>
      <div class="goBackMessages">
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
</body>
</html>

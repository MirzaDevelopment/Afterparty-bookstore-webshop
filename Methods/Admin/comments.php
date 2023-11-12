<?php
declare(strict_types=1);
require __DIR__."../../../config.php";
session_start();
//Checking who is logged in exacly (to prevent empty sesssions or users to see data)
if ($_SESSION['status']==3 || empty($_SESSION['status'])){
    header("Location:../index.php");//Redirecting to first page
    exit();
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Comments search and delete panel</title>
</head>

<body class="transBody" onload="selectAllComments()">
    <form action="comments" method="POST">
        <br>
        <input type="submit" name="list" id="listTrans" value="Show all posted comments (latest)"></input><br><br>
</form>
        <form action ="comments" method="POST">
        <input type="text" name="commSearch" id="transSearch" placeholder="username/books">
        <div class="iconWrapSearchTrans">
            <input type="image" alt="Submit" src="../img/search.png" width="45" height="45" /></input>
        </div>
        </form>
    </form>
    <div class="goBackMsgDiscount">
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
    <!--Button to select all Customers in DB-->

</body>
</html>
<?php
echo "<div class='mainCommentContainer'>";
require __DIR__."../../Controllers/commentController.php";
echo "<div>";

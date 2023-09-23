<?php
declare(strict_types=1);
session_start();
//Checking who is logged in exacly (to prevent empty sesssions or users to see data)
if ($_SESSION['status'] == 3 || empty($_SESSION['status'])) {
    header("Location:../index.php"); //Redirecting to first page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="deleted books list with restore options">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Deleted Books</title>
</head>
<body class="transBody" onload="restoreAll()">
    <form action="deletedBooks" method="POST">
        <br>
        <input type="submit" name="booksDel" id="listTrans" value="List deleted Books"></input><br><br>
        <!--Button to select all Books in DB-->
    </form>
    <div class="goBackMsgDeletedBooks">
        <!--Go back to admin panel-->
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
</body>
</html>
<?php
//Render all deleted Books
require __DIR__."../../Controllers/controller.php";
?>


<?php
declare(strict_types=1);
require __DIR__ . "../../../Interfaces/CustomerSelectInterface.php";
require __DIR__ . "../../../DatabaseClasses/CustomerSelectDatabase.php";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Deleted Customers</title>
</head>

<body class="transBody" onload="restoreAll()">
    <form action="deletedCustomers" method="POST">
        <br>
        <!--Button to select all customers in DB-->
        <input type="submit" name="listDel" id="listTrans" value="List deleted customers"></input><br><br>
    </form>
    <div class="goBackMsgDiscount">
        <!--Go back to admin panel-->
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
</body>
</html>
<?php
//Render all deleted transactions
require __DIR__."../../Controllers/customerController.php";
?>


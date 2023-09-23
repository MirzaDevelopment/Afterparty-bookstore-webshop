<?php
declare(strict_types=1);
require __DIR__ . "../../../Interfaces/TransactionSelectInterface.php";
require __DIR__ . "../../../DatabaseClasses/TransactionSelectDb.php";
require('../../PDFConverterUTF8/tfpdf.php'); //Required for pdf conversion
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
    <meta name="description" content="transaction review with management options">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Transaction search and modify panel</title>
</head>

<body class="transBody" onload="selectAll()">
    <form action="transactions" method="POST">
        <br>
        <input type="submit" name="list" id="listTrans" value="Show all orders (latest)"></input><br><br>
        <!--Button to select all transactions in DB-->
    </form>
    <form action="transactions" method="POST">
        <input type="text" name="transSearch" id="transSearch" placeholder="Search orders...">
        <!--Button to filter search transactions in db-->
        <div class="iconWrapSearchTrans">
            <input type="image" alt="Submit" src="../img/search.png" width="45" height="45" /></input>
        </div>
    </form>
    <section class="notice">
        <!--Notice regarding removal of transactions-->
        <p><strong>Notice:</strong> Deleting transaction data from this table will NOT result in automatic deletion of corresponding customer that made the transaction. If you want to specifically delete a customer, please refer to the appropriate customers page in admin panel.</p>
    </section>
    <div class="goBackMsgDiscount">
        <!--Go back to admin panel-->
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>

</body>

</html>
<?php
require __DIR__ . "../../Controllers/transactionController.php";


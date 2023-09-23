<?php
declare(strict_types=1);
require __DIR__ . "../../../Interfaces/CustomerSelectInterface.php";
require __DIR__."../../../DatabaseClasses/CustomerSelectDatabase.php";
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
  	<meta name="description" content="customers overview">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Customers Search and delete panel</title>
</head>

<body class="transBody" onload="selectAllCustomers()">
    <form action="customers" method="POST">
        <br>
        <input type="submit" name="list" id="listTrans" value="Show all Customers (latest)"></input><br><br>
</form>
        <form action ="customers" method="POST">
        <input type="text" name="custSearch" id="transSearch" placeholder="Search customers...">
        <div class="iconWrapSearchTrans">
            <input type="image" alt="Submit" src="../img/search.png" width="45" height="45" /></input>
        </div>
        </form>
    </form>
    <section class="notice">
        <p><strong>Notice:</strong> Deleting data from this table will result in empty gaps in mail columns in corresponding transactions made by deleted customer. If you want to also delete a transaction by this customer, please refer to the appropriate transaction page in admin panel.</p>
    </section>
    <div class="goBackMsgDiscount">
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
    <!--Button to select all Customers in DB-->

</body>
</html>
<?php
require __DIR__."../../Controllers/customerController.php";

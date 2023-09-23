<?php
declare(strict_types=1);
session_start();
//Checking who is logged in exacly (to prevent empty sesssions or users to see data)
if ($_SESSION['status']==3 || empty($_SESSION['status'])){
    header("Location:../index.php");//Redirecting to first page
    exit();
} 
require __DIR__."../../../config.php";
require __DIR__."../../../DatabaseClasses/Statistics.php";


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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Customer statistics</title>
    
</head>

<body class="custStats">
    <h1 class="statsTitleCust">Customer statistics</h1>
    <!-- Customer statistics (income per customer mail with other data)-->
    <div class="goBackMsgCustStatistics">
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
    <div class="booksStatsContainer">
        <?php
        echo "<br>";
        echo "<div class='frontMsg'>Top customers (per income):</div>"; //Wrapper for proper style
        echo "<table id='mainTableStats'>";
        echo "<tr>";
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>Email</th>";
        echo "<th>Income</th>";
        echo "</tr>";
        Statistics::showTopBuyers(); //Rendering of most sold books
        echo "</table>";
        ?> 
    </div>
    <br>
    <div id="chartContainer1" style="height: 370px; width: 50%; left: 50%;"></div>
    <br>
    <div id="chartContainer2" style="height: 370px; width: 50%; left: 50%;"></div>
</body>
</html>

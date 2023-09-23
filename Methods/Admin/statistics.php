<?php
declare(strict_types=1);
/***Transaction statistics panel***/
session_start();
//Checking who is logged in exacly (to prevent empty sesssions or users to see data)
if ($_SESSION['status']==3 || empty($_SESSION['status'])){
    header("Location:../index.php");//Redirecting to first page
    exit();
}
require __DIR__."../../../config.php";
require __DIR__."../../../DatabaseClasses/Statistics.php";
//Getting data for charts
Statistics::quantityChart();
Statistics::incomeChart();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="transaction statistics">
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <link rel="stylesheet" href="../../style.css">
    <script src="../script.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Transaction statistics</title>
    <script>
        //Statistical charts
        window.onload = function() {
            var chart1 = new CanvasJS.Chart("chartContainer1", {
                axisX: {
                    title: "Timeline",
                    valueFormatString: "D-MMM",
                    gridThickness: 2

                },
                axisY: {
                    title: "Products sold (quantity)"
                },
                animationEnabled: true,
                exportEnabled: true,
                theme: "light3", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Quantity of books sold"
                },
                data: [{
                    type: "line", //change type to bar, line, area, pie, etc  
                    xValueType: "dateTime",
                    dataPoints: <?php echo json_encode($_SESSION['dPoints'], JSON_NUMERIC_CHECK); ?>
                }]
            });

            chart1.render();

            var chart2 = new CanvasJS.Chart("chartContainer2", {
                axisX: {
                    title: "Timeline",
                    valueFormatString: "D-MMM",
                    gridThickness: 2

                },
                axisY: {
                    title: "Income in $"
                },
                animationEnabled: true,
                exportEnabled: true,
                theme: "light3", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Sales income"
                },
                data: [{
                    type: "line", //change type to bar, line, area, pie, etc  
                    xValueType: "dateTime",
                    dataPoints: <?php echo json_encode($_SESSION['dPointsIncome'], JSON_NUMERIC_CHECK); ?>
                }]
            });

            chart2.render();
        }
    </script>
</head>

<body class="bodyStats">
    <h1 class="statsTitle">Book statistics</h1>
    <!-- General transaction statistics (most sold books in store, number of items sold, and sales income in time span) -->
    <div class="goBackMsgBookStats">
        <a href='adminPanel'><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
    </div>
    <div class="booksStatsContainer">
        <?php
        echo "<br>";
        echo "<div class='frontMsg'>Top selling books:</div>"; //Wrapper for proper style
        echo "<table id='mainTableStats'>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Author</th>";
        echo "<th>Selling price</th>";
        echo "<th>Number of items sold</th>";
        echo "</tr>";
        Statistics::showTopBooks(); //Rendering of most sold books
        echo "</table>";
        ?>
        
    </div>
    <br>
    <div id="chartContainer1" style="height: 370px; width: 50%; left: 50%;"></div>
    <br>
    <div id="chartContainer2" style="height: 370px; width: 50%; left: 50%;"></div>
</body>
</html>

<?php
declare(strict_types=1);
//Login class to check for available sessions which redistribute users to corresponding panels.
require_once __DIR__ . "../../../config.php";
require_once __DIR__ . "../../../GeneralClasses/LoginClass.php";
//Logout button which delets user session
if (isset($_POST['Logout'])) {
    LoginClass::logOut();
}
session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
}
//Making sure user is redirected to correct panel no matter what!
if ($_SESSION['status'] == 1) {
    header("Location:adminPanel.php");
    die();
} else if ($_SESSION['status'] == 3) {
    header("Location:../User/userPanel.php");
    die();
} 
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="content management panel">
    <link rel="stylesheet" href="../../style.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap');
    </style> 
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Admin panel</title>
</head>
  <?php
  LoginCLass::userPanelCheck();
  ?>
<!--Function for ajax calls-->
<body class="adminBody" onload="myFunction()">
    <h1 id="adminMsg">Welcome to admin dashboard</h1>
    <!--Main navigation wrapper-->
    <nav class="mainNav">
        <!--Main links container with mainLinks sub classes-->
        <div class="mainLinksContainer">
            <div class="mainLinks">
                <!--Book management section-->
                <h2>Book Management</h2>
                <!--Book section sublink container classes (which show on hover)-->
                <div class="sublinkContainer">
                    <div class="sublinkContainerMessage1">
                        <!--link to insert.php shown as icon-->
                        <a href="insert"><img src="../img/book-upload.png" alt="book-upload-icon" width="80" height="80"></a>
                        <p class="bookText">Upload new book</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to bookSearch.php shown as icon-->
                        <a href="bookSearch"><img src="../img/manual.png" alt="book-modify-icon" width="80" height="80"></a>
                        <p class="bookText">Modify exiting books</p>
                    </div>
                       <div class="sublinkContainerMessage2">
                        <!--link to deletedBooks.php (render and restore deleted books)-->
                        <a href="deletedBooks"><img src="../img/trash.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Deleted Books</p>
                    </div>
                </div>
            </div>
            <div class="mainLinks">
                <!--Features management section-->
                <h2>Books extra features</h2>
                <!--Book section sublink container classes (which show on hover)-->
                <div class="sublinkContainer">
                    <div class="sublinkContainerMessage3">
                        <!--link to discount.php shown as icon (removing discount from books)-->
                        <a href="discounts"><img src="../img/discounts.png" alt="discount-management-icon" width="80" height="80"></a>
                        <p class="bookText">Discount management</p>
                    </div>
                    <div class="sublinkContainerMessage1">
                        <!--link to categories.php shown as icon (new category upload)-->
                        <a href="categories"><img src="../img/options.png" alt="categories-icon" width="80" height="80"></a>
                        <p class="bookText">Categories</p>
                    </div>
                    <div class="sublinkContainerMessage1">
                        <!--link to slider.php (removing books from front page)-->
                        <a href="slider"><img src="../img/slider.png" alt="slider-icon" width="80" height="80"></a>
                        <p class="bookText">Slider management</p>
                    </div>
                </div>
            </div>
            <!--End of mainLinks div-->
            <div class="mainLinks">
                <!--Order management section-->
                <h2>Orders management</h2>
                <!--Orders section sublink container classes (which show on hover)-->
                <div class="sublinkContainer">
                    <div class="sublinkContainerMessage1">
                        <!--link to transactions.php shown as icon (completed orders)-->
                        <a href="transactions"><img src="../img/order.png" alt="order-cart-icon" width="80" height="80"></a>
                        <p class="bookText">Transactions</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to statistics.php shown as icon (order statistics)-->
                        <a href="statistics"><img src="../img/monitoring.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Statistics</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to deletedTransactions.php shown as icon (render of deleted books)-->
                        <a href="deletedTransactions"><img src="../img/trash.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Deleted transactions</p>
                    </div>

                </div>
            </div>
            <!--End of mainLinks div-->
            <div class="mainLinks">
                <h2>Customer management</h2>
                <!--Customer management section-->
                <div class="sublinkContainer">
                    <div class="sublinkContainerMessage1">
                        <!--link to customers.php shown as icon-->
                        <a href="customers"><img src="../img/rating.png" alt="modify-user-icon" width="80" height="80"></a>
                        <p class="bookText">Customers</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to customerStatistics.php shown as icon-->
                        <a href="customerStatistics"><img src="../img/monitoring.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Statistics</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to deletedCustomers.php-->
                        <a href="deletedCustomers"><img src="../img/trash.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Deleted Customers</p>
                    </div>
                </div>
            </div>

        </div>
        <!--End of mainLinksContainer div-->
    </nav>
    <!--End of mainNav div-->
      <div class="goBackMsg">
            <a href="../../index"><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
        </div>
</body>
</html>

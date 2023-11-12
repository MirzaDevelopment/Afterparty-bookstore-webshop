<?php
declare(strict_types=1);
  session_start();
//Login session check, redirect to login if empty
if (empty($_SESSION['status'])){
    header("Location:../../loginPage.php");
}

require __DIR__ . "../../../GeneralClasses/LoginClass.php";
require __DIR__ . "../../../config.php";
//Logout button which delets user session
if (isset($_POST['Logout'])) {
    LoginClass::logOut();
}

//Making sure user is redirected to correct panel no matter what (user, normal or super admin)!
if ($_SESSION['status'] == 2) {
    header("Location:normalAdminPanel.php");
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
    <link  rel="preload" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500&display=swap">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap" as="style">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap">
    <script src="../script.js"></script>
    <link rel="icon" href="data:;base64,=">
    <title>Super admin panel</title>
</head>
  <?php
  LoginClass::userPanelCheck();
  ?>
<body class="adminBody" onload="myFunction()"><!--Function for ajax calls-->
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
                        <!--link to insert.php shown as icon (upload books)-->
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
                <!--User management section-->
                <h2>User management</h2>
                <!--Userk section sublink container classes (which show on hover)-->
                <div class="sublinkContainer">
                    <div class="sublinkContainerMessage1">
                        <!--link to insertUser.php shown as icon (insert users)-->
                        <a href="insertUser"><img src="../img/new.png" alt="new-user-icon" width="80" height="80"></a>
                        <p class="userText">Upload new users</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to userSearch.php shown as icon (search and modify user data)-->
                        <a href="userSearch"><img src="../img/user-profile.png" alt="modify-user-icon" width="80" height="80"></a>
                        <p class="userText">Modify users</p>
                    </div>
                    <div class="sublinkContainerMessage1">
                        <!--link to comments.php shown as icon (search and modify user data)-->
                        <a href="comments"><img src="../img/commentsAdmin.png" alt="comments-panel" width="80" height="80"></a>
                        <p class="userText">User comments</p>
                    </div>
                </div>
            </div>
            <div class="mainLinks">
                <!--Book management section-->
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
            <div class="mainLinks">
                <!--Orders management section-->
                <h2>Orders management</h2>
                <!--Orders section sublink container classes (which show on hover)-->
                <div class="sublinkContainer">
                    <div class="sublinkContainerMessage1">
                        <!--link to transactions.php shown as icon-->
                        <a href="transactions.php"><img src="../img/order.png" alt="order-cart-icon" width="80" height="80"></a>
                        <p class="bookText">Transactions</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to statistics.php shown as icon (new category upload)-->
                        <a href="statistics.php"><img src="../img/monitoring.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Statistics</p>
                    </div>
                    <div class="sublinkContainerMessage2">
                        <!--link to deletedTransactions.php-->
                        <a href="deletedTransactions"><img src="../img/trash.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Deleted transactions</p>
                    </div>
                </div>
            </div>
            <div class="mainLinks">
                <!--Customer management section-->
                <h2>Customer management</h2>
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
                        <!--link to deletedTransactions.php-->
                        <a href="deletedCustomers"><img src="../img/trash.png" alt="user-monitor-data" width="80" height="80"></a>
                        <p class="bookText">Deleted Customers</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
   <div class="goBackMsg">
                <a href="../../index"><img src="../img/previous.png" alt="back-to-previous-page" width="35" height="35"></a>
            </div>
</body>
</html>

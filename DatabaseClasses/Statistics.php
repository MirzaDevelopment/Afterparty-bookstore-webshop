<?php

/***Class used to render book and user statistics***/
class Statistics
{
    const limitAdmin = 15;

    /***Method to show most sold books of all time***/
    public static function showTopBooks():void
    {

        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT * FROM topbooks");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = Statistics::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.
        //Retrieving active page number
        if (isset($_GET["page"])) {

            $page_number  = $_GET["page"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;

        /**End of pagination preparation******/

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql2 = $connection->query("SELECT transactions.transaction_id, books.book_id, books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, SUM(transactions.book_quantity) AS QUANTITY_TOTAL FROM {$_ENV['DATABASE_NAME']}.transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id GROUP BY books.book_id ORDER BY QUANTITY_TOTAL DESC LIMIT " . $initial_page . ',' . $limit);
            while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo '<td>' . $row['book_title'] . '</td>';
                echo "<td>" . $row['book_author'] . "</td>";
                if ($row['discounted_price'] > 0) {
                    echo "<td>" . $row['discounted_price'] . "</td>";
                } else {
                    echo "<td>" . $row['book_price'] . "</td>";
                }
                echo "<td>" . $row['QUANTITY_TOTAL'] . "</td>";
                echo "</tr>";
            }
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='statistics.php?page=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

            };

            echo "</div>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }

        $connection = null;
    }

    /***Method to show quantity of books sold (with charts)***/
    public static function quantityChart():void
    {
        $_SESSION['dPoints'] = array();
        require "NamespaceAdmin3.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT * FROM quantitychart");
            $result = $sql->fetchAll(\PDO::FETCH_OBJ);
            foreach ($result as $row) {
                $phpDate = date($row->date);
                $phpDate2 = strtotime($phpDate);
                $phpDate3 = $phpDate2 * 1000;
                array_push($_SESSION['dPoints'], array("x" => $phpDate3, "y" => $row->Quantity));
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }

        $connection = null;
    }


    /***Method to show income earned (with charts)***/
    public static function incomeChart():void
    {
        $_SESSION['dPointsIncome'] = array();
        require "NamespaceAdmin4.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT * FROM incomechart");
            $result = $sql->fetchAll(\PDO::FETCH_OBJ);
            foreach ($result as $row) {
                $phpDate = date($row->date);
                $phpDate2 = strtotime($phpDate);
                $phpDate3 = $phpDate2 * 1000;
                array_push($_SESSION['dPointsIncome'], array("x" => $phpDate3, "y" => $row->Income));
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }

        $connection = null;
    }


    /***Method to show Top customers (buyers of all time)***/
    public static function showTopBuyers():void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT * FROM topbuyers");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = Statistics::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.
        //Retrieving active page number
        if (isset($_GET["page"])) {

            $page_number  = $_GET["page"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;

        /**End of pagination preparation******/

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql2 = $connection->query("SELECT GROUP_CONCAT(DISTINCT users_customers.first_name) as first_name, GROUP_CONCAT(DISTINCT users_customers.last_name) as last_name, concat(email) as Customer_Mail, SUM(transaction_price * transactions.book_quantity) as Income FROM {$_ENV['DATABASE_NAME']}.transactions JOIN  users_customers ON transactions.customer_id=users_customers.customer_id GROUP BY Customer_Mail ORDER BY Income DESC LIMIT " . $initial_page . ',' . $limit);
            while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
                if ($row['first_name'] > 0) {
                    echo "<tr>";
                    echo '<td>' . $row['first_name'] . '</td>';
                    echo '<td>' . $row['last_name'] . '</td>';
                    echo '<td>' . $row['Customer_Mail'] . '</td>';
                    echo "<td>" . $row['Income'] . " $</td>";
                    echo "</tr>";
                } else {
                     echo "<p class='customerNotice' style='color:cadetblue'>Notice: deleted customer data is not shown!</p>";
                }
            }
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='customerStatistics.php?page=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

            };

            echo "</div>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }

        $connection = null;
    }

    /***Method to show all purchases made by a specific user (by user emai)***/

    public static function userPurchase():void
    {
        $user_name = $_SESSION['username']; //Getting logged in username
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Selecting general transaction table with required data
            $sql = $connection->query("SELECT * FROM statisticforuser");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = Statistics::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.
        //Retrieving active page number
        if (isset($_GET["page"])) {

            $page_number  = $_GET["page"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;

        /**End of pagination preparation******/

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //First, getting user email from user table.
            $sql2 = $connection->prepare("SELECT users.email FROM {$_ENV['DATABASE_NAME']}.users WHERE users.user_name=:userName");
            $array = array('userName' => $user_name);
            foreach ($array as $key => $param) {
                $sql2->bindParam($key, $param);
            }
            $sql2->execute($array);
            $row = $sql2->fetch(PDO::FETCH_ASSOC);
            $customer_mail = $row['email']; //Putting obtained customer mail in variable
            //Getting data for specific email
            $sql3 = $connection->prepare("SELECT transactions.book_id, books.book_title,  books.book_description, books.book_author, book_pic, users_customers.email,  pricing.book_price, pricing.discounted_price, SUM(transactions.book_quantity) AS QUANTITY_TOTAL, GROUP_CONCAT(DISTINCT transactions.transaction_date) as transaction_time FROM {$_ENV['DATABASE_NAME']}.transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id WHERE users_customers.email=:userMail GROUP BY books.book_id DESC LIMIT " . $initial_page . ',' . $limit);
            $array2 = array('userMail' => $customer_mail);
            foreach ($array2 as $key => $param) {
                $sql3->bindParam($key, $param);
            }
            $sql3->execute($array2);
            echo "<div class='frontMsg'>Your purchased books:</div>";
            echo "<table id='mainTableUser'>";
            while ($row = $sql3->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<th>Title</th>";
             	echo "<th>Synopsis</th>";
                echo "<th>Author</th>";
                echo "<th>Image</th>";
                echo "<th>Your email</th>";
                echo "<th>Price per product</th>";
                echo "<th>Total quantity purchased</th>";
                echo "<th>Dates of purchase</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>" . $row['book_title'] . "</td>";
              	echo "<td>" . substr($row['book_description'], 0, 100) . "..." . "<a href='../../preview.php?id={$row['book_id']}'>Read more</a></td>";
                echo '<td>' . $row['book_author'] . '</td>';
                echo '<td>' . $row['book_pic'] . '</td>';
                echo "<td>" . $row['email'] . "</td>";
                if ($row['discounted_price'] > 0) {
                    echo "<td>" . $row['discounted_price'] . "$" . "</td>";
                } else {
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                }
                echo "<td>" . $row['QUANTITY_TOTAL'] . "</td>";
                echo "<td>" . $row['transaction_time'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='userPanel.php?page=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

            };

            echo "</div>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }

        $connection = null;
    }
}

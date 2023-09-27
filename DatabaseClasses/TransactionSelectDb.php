<?php
declare(strict_types=1);
class TransactionSelectDb implements TransactionSelectInterface //Class for select queries towards transactions
{
    const limitAdmin = 15;
    /***Select and render all transactions in db by date***/
    public function selectAllTransactions():void
    {
        require "ConnectPdoAdmin.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT transactions.transaction_id, books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, transactions.book_quantity, transactions.transaction_date, users_customers.email FROM {$_ENV['DATABASE_NAME']}.transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = TransactionSelectDb::limitAdmin; // variable to store number of books per page
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
            /***Getting transaction details for admins***/

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT transactions.transaction_id, books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, transactions.book_quantity, transactions.transaction_status, transactions.transaction_date, users_customers.email, users_customers.first_name FROM {$_ENV['DATABASE_NAME']}.transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id ORDER BY transactions.transaction_date DESC LIMIT " . $initial_page . ',' . $limit);
            echo "<br>";
            echo "<div class='frontMsg'>Orders in database (latest):</div>";
            echo "<table id='mainTable'>";
            echo "<tr>";
            echo "<th>Unique ID</th>";
            echo "<th>Title</th>";
            echo "<th>Author</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Date</th>";
            echo "<th>Customer mail</th>";
            echo "<th>First name</th>";
            echo "<th>Order status</th>";
            echo "<th>Print details</th>";
            echo "<th id='selectAll'>Select all</th>";
            echo "<th id='changeStatus'>Change status on selected</th>";
            ($_SESSION['status'] == 1) ? print("<th id='deleteSelec'>Delete selected</th>") : ("");
            echo "</tr>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['transaction_id'] . "</td>";
                echo "<td>" . $row['book_title'] . "</td>";
                echo "<td>" . $row['book_author'] . "</td>";
                if ($row['discounted_price'] > 0) {
                    echo "<td>" . $row['discounted_price'] . "</td>";
                } else {
                    echo "<td>" . $row['book_price'] . "</td>";
                }
                echo "<td>" . $row['book_quantity'] . "</td>";
                echo "<td>" . $row['transaction_date'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                if ($row['transaction_status'] == "pending") {
                    echo "<td style='color:crimson';>" . $row['transaction_status'] . "</td>";
                } else if ($row['transaction_status'] == "finished") {
                    echo "<td style='color:green';>" . $row['transaction_status'] . "</td>";
                }
                echo "<td><form id='printPdf' action='../../Methods/Admin/pdf' enctype='multipart/form-data' method='POST'><input form='printPdf' type='image' src='../../Methods/img/pdf-file.png' width='55' height='55' alt='submit' name='{$row['transaction_id']}'value='print'></form></td>";
                echo "<td><form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['transaction_id']}' name='trans[]' value='{$row['transaction_id']}'></form></td>";
                echo "<td><p id='outputTrans'></p></td>";
                echo "<td><p id='outputTransDel'></p></td>";
                echo "</tr>";
            }

            echo "</table>";
            //Showing page number in URL at the bottom!
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='transactions.php?page=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***Select and render deleted transactions***/
    public function selectDeletedTransactions():void
    {

        require "ConnectPdoAdmin.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT deleted_transactions.transaction_id, books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, deleted_transactions.book_quantity, deleted_transactions.transaction_status, deleted_transactions.transaction_date, users_customers.email FROM {$_ENV['DATABASE_NAME']}.deleted_transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=deleted_transactions.book_id JOIN users_customers ON deleted_transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = TransactionSelectDb::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.
        //Retrieving active page number
        if (isset($_GET["pageDeleted"])) {

            $page_number  = $_GET["pageDeleted"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;

        /**End of pagination preparation******/

        try {
            /***Getting deleted transaction details for admins***/

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql2 = $connection->query("SELECT deleted_transactions.transaction_id, books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, deleted_transactions.book_quantity, deleted_transactions.transaction_status, deleted_transactions.transaction_date, users_customers.email FROM {$_ENV['DATABASE_NAME']}.deleted_transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=deleted_transactions.book_id JOIN users_customers ON deleted_transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id ORDER BY deleted_transactions.transaction_end DESC LIMIT " . $initial_page . ',' . $limit);
            echo "<br>";
            echo "<div class='frontMsg'>Deleted transactions in database (latest):</div>";
            echo "<table id='mainTable'>";
            echo "<tr>";
            echo "<th>Unique ID</th>";
            echo "<th>Title</th>";
            echo "<th>Author</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Date</th>";
            echo "<th>Customer mail</th>";
            echo "<th>Order status</th>";
            ($_SESSION['status'] == 1) ? print("<th id='selectAll'>Select all</th>") : ("");
            ($_SESSION['status'] == 1) ? print("<th id='restoreSelecTrans'>Restore selected</th>") : ("");
            echo "</tr>";
            while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['transaction_id'] . "</td>";
                echo "<td>" . $row['book_title'] . "</td>";
                echo "<td>" . $row['book_author'] . "</td>";
                if ($row['discounted_price'] > 0) {
                    echo "<td>" . $row['discounted_price'] . "</td>";
                } else {
                    echo "<td>" . $row['book_price'] . "</td>";
                }
                echo "<td>" . $row['book_quantity'] . "</td>";
                echo "<td>" . $row['transaction_date'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                if ($row['transaction_status'] == "pending") {
                    echo "<td style='color:crimson';>" . $row['transaction_status'] . "</td>";
                } else if ($row['transaction_status'] == "finished") {
                    echo "<td style='color:green';>" . $row['transaction_status'] . "</td>";
                }
                echo "<td><form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['transaction_id']}' name='restore[]' value='{$row['transaction_id']}'></form></td>";
                echo "<td><p id='outputTransDel'></p></td>";
                echo "</tr>";
            }

            echo "</table>";
            //Showing page number in URL at the bottom!
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='deletedTransactions.php?pageDeleted=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

            };

            echo "</div>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }

        $connection = null;
    }


    /***Select filtered transactions in db order by date***/
    public static function selectSearchTransactions($user_input):void
    {
        require "NamespaceAdmin3.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT transactions.transaction_id, books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, transactions.book_quantity, transactions.transaction_status, transactions.transaction_date, users_customers.email, users_customers.first_name FROM {$_ENV['DATABASE_NAME']}.transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id WHERE books.book_title LIKE CONCAT(:input,'%') OR books.book_author LIKE CONCAT (:input,'%') OR users_customers.email LIKE CONCAT (:input,'%') OR users_customers.first_name LIKE CONCAT (:input,'%') OR transactions.transaction_status LIKE CONCAT (:input,'%')");
            $array = array('input' => $user_input);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = TransactionSelectDb::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.
        //Retrieving active page number
        if (isset($_GET["pageSearch"])) {

            $page_number  = $_GET["pageSearch"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;

        /**End of pagination preparation******/

        try {
            /***Getting transaction details for admins***/
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT transactions.transaction_id, books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, transactions.book_quantity, transactions.transaction_status, transactions.transaction_date, users_customers.email, users_customers.first_name FROM {$_ENV['DATABASE_NAME']}.transactions JOIN {$_ENV['DATABASE_NAME']}.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id WHERE books.book_title LIKE CONCAT(:input,'%') OR books.book_author LIKE CONCAT (:input,'%') OR users_customers.email LIKE CONCAT (:input,'%') OR users_customers.first_name LIKE CONCAT (:input,'%') OR transactions.transaction_status LIKE CONCAT (:input,'%') ORDER BY transactions.transaction_date DESC LIMIT " . $initial_page . ',' . $limit);
            $array = array('input' => $user_input);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Orders in database (latest):</div>";
            echo "<table id='mainTable'>";
            echo "<tr>";
            echo "<th>Unique ID</th>";
            echo "<th>Title</th>";
            echo "<th>Author</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Date</th>";
            echo "<th>Customer mail</th>";
            echo "<th>First name</th>";
            echo "<th>Order status</th>";
            echo "<th>Print details</th>";
            echo "<th id='selectAll'>Select all</th>";
            echo "<th id='changeStatus'>Change status on selected</th>";
            ($_SESSION['status'] == 1) ? print("<th id='deleteSelec'>Delete selected</th>") : ("");

            echo "</tr>";

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['transaction_id'] . "</td>";
                echo '<td>' . $row['book_title'] . '</td>';
                echo "<td>" . $row['book_author'] . "</td>";
                if ($row['discounted_price'] > 0) {
                    echo "<td>" . $row['discounted_price'] . "</td>";
                } else {
                    echo "<td>" . $row['book_price'] . "</td>";
                }
                echo "<td>" . $row['book_quantity'] . "</td>";
                echo "<td>" . $row['transaction_date'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                if ($row['transaction_status'] == "pending") {
                    echo "<td style='color:crimson';>" . $row['transaction_status'] . "</td>";
                } else if ($row['transaction_status'] == "finished") {
                    echo "<td style='color:green';>" . $row['transaction_status'] . "</td>";
                }
                echo "<td><form id='printPdf' action='../../Methods/Admin/pdf' enctype='multipart/form-data' method='POST'> <input type='image' form='printPdf' src='../../Methods/img/pdf-file.png' width='55' height='55' alt='submit' name='{$row['transaction_id']}'value='print'></form></td>";
                echo "<td><input class='checked' form='delSelec' type='checkbox' id='{$row['transaction_id']}' name='trans[]' value='{$row['transaction_id']}'></td>";
                echo "<td><p id='outputTrans'></p></td>";
            	echo "<td><p id='outputTransDel'></p></td>";
                echo "<td></td>";
                echo "</tr>";
            }

            echo "</table>";
            //Showing page number in URL at the bottom!
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='transactions.php?pageSearch=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

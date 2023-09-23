<?php
declare(strict_types=1);
/***Class for getting customer data***/
class CustomerSelectDatabase implements CustomerSelectInterface
{

    const limitAdmin = 15;
    /***Select all customers in db by date***/
    public function selectAllCustomers():void
    {
        require "ConnectPdoAdmin.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT users_customers.customer_id, first_name, last_name, email, adress, postal_code, dbs10877614.adm_units.names, city, phone_number FROM dbs10877614.users_customers JOIN dbs10877614.adm_units ON users_customers.adm_unit_id=adm_units.adm_unit_id");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = CustomerSelectDatabase::limitAdmin; // variable to store number of books per page
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
            $sql = $connection->query("SELECT users_customers.customer_id, first_name, last_name, email, adress, postal_code, dbs10877614.adm_units.names, city, phone_number, transaction_registered FROM dbs10877614.users_customers JOIN dbs10877614.adm_units ON users_customers.adm_unit_id=adm_units.adm_unit_id ORDER BY transaction_registered DESC LIMIT " . $initial_page . ',' . $limit);
            echo "<br>";
            echo "<div class='frontMsg'>Customers in database (latest):</div>";
            echo "<table id='mainTable'>";
            echo "<tr>";
            echo "<th>Unique ID</th>";
            echo "<th>First name</th>";
            echo "<th>Last name</th>";
            echo "<th>Email</th>";
            echo "<th>Adress</th>";
            echo "<th>Postal code</th>";
            echo "<th>Adm. unit</th>";
            echo "<th>City</th>";
            echo "<th>Phone</th>";
            echo "<th>Transaction date</th>";
            ($_SESSION['status'] == 1) ? print("<th id='selectAll'>Select all</th>") : ("");
            ($_SESSION['status'] == 1) ? print("<th id='deleteSelec'>Delete selected</th>") : ("");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['customer_id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['adress'] . "</td>";
                echo "<td>" . $row['postal_code'] . "</td>";
                echo "<td>" . $row['names'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['transaction_registered'] . "</td>";
                ($_SESSION['status'] == 1) ? print("<td><form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['customer_id']}' name='cust[]' value='{$row['customer_id']}'></form></td>") : ("");
                echo "<td><p id='outputTransDel'></p></td>";
                echo "</tr>";
            }

            echo "</table>";
            //Showing page number in URL at the bottom!
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='customers.php?page=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***Select filtered customers in db by date***/
    public static function selectSearchCustomers($user_input):void
    {	    
        require "NamespaceAdmin3.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT users_customers.customer_id, first_name, last_name, email, adress, postal_code, dbs10877614.adm_units.names, city, phone_number, transaction_registered FROM dbs10877614.users_customers JOIN dbs10877614.adm_units ON users_customers.adm_unit_id=adm_units.adm_unit_id WHERE first_name LIKE CONCAT(:input,'%') OR last_name LIKE CONCAT (:input,'%') OR email LIKE CONCAT (:input,'%') ORDER BY users_customers.transaction_registered ");
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
        $limit = CustomerSelectDatabase::limitAdmin; // variable to store number of books per page
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
            $sql = $connection->prepare("SELECT users_customers.customer_id, first_name, last_name, email, adress, postal_code, dbs10877614.adm_units.names, city, phone_number, transaction_registered FROM dbs10877614.users_customers JOIN dbs10877614.adm_units ON users_customers.adm_unit_id=adm_units.adm_unit_id WHERE first_name LIKE CONCAT(:input,'%') OR last_name LIKE CONCAT (:input,'%') OR email LIKE CONCAT (:input,'%') ORDER BY users_customers.transaction_registered DESC LIMIT " . $initial_page . ',' . $limit);
            $array = array('input' => $user_input);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Customers in database (latest):</div>";
            echo "<table id='mainTable'>";
            echo "<tr>";
            echo "<th>Unique ID</th>";
            echo "<th>First name</th>";
            echo "<th>Last name</th>";
            echo "<th>Email</th>";
            echo "<th>Adress</th>";
            echo "<th>Postal code</th>";
            echo "<th>Adm. unit</th>";
            echo "<th>City</th>";
            echo "<th>Phone</th>";
            echo "<th>Transaction date</th>";
            ($_SESSION['status'] == 1) ? print("<th id='selectAll'>Select all</th>") : ("");
            ($_SESSION['status'] == 1) ? print("<th id='deleteSelec'>Delete selected</th>") : ("");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['customer_id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['adress'] . "</td>";
                echo "<td>" . $row['postal_code'] . "</td>";
                echo "<td>" . $row['names'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['transaction_registered'] . "</td>";
                ($_SESSION['status'] == 1) ? print("<td><form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['customer_id']}' name='cust[]' value='{$row['customer_id']}'></form></td>") : ("");
                echo "<td><p id='outputTransDel'></p></td>";
                echo "<td><p id='outputTrans'></p></td>";
                echo "</tr>";
            }

            echo "</table>";
            //Showing page number in URL at the bottom!
            echo "<div class='paginationContainer'>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='customers.php?pageSearch=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

            };
            echo "</div>";

            echo "</div>";
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }

        $connection = null;
    }
    /***Select and render deleted customers***/
    public function selectDeletedCustomers():void
    {	 
        require "ConnectPdoAdmin.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT deleted_customers.customer_id, first_name, last_name, email, adress, postal_code, dbs10877614.adm_units.names, city, phone_number FROM dbs10877614.deleted_customers JOIN dbs10877614.adm_units ON deleted_customers.adm_unit_id=adm_units.adm_unit_id");
        } catch (PDOException $e) {
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = CustomerSelectDatabase::limitAdmin; // variable to store number of books per page
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
            $sql = $connection->query("SELECT deleted_customers.customer_id, first_name, last_name, email, adress, postal_code, dbs10877614.adm_units.names, city, phone_number, transaction_registered FROM dbs10877614.deleted_customers JOIN dbs10877614.adm_units ON deleted_customers.adm_unit_id=adm_units.adm_unit_id ORDER BY transaction_registered DESC LIMIT " . $initial_page . ',' . $limit);
            echo "<br>";
            echo "<div class='frontMsg'>Customers in database (latest):</div>";
            echo "<table id='mainTable'>";
            echo "<tr>";
            echo "<th>Unique ID</th>";
            echo "<th>First name</th>";
            echo "<th>Last name</th>";
            echo "<th>Email</th>";
            echo "<th>Adress</th>";
            echo "<th>Postal code</th>";
            echo "<th>Adm. unit</th>";
            echo "<th>City</th>";
            echo "<th>Phone</th>";
            echo "<th>Transaction date</th>";
            ($_SESSION['status'] == 1) ? print("<th id='selectAll'>Select all</th>") : ("");
            ($_SESSION['status'] == 1) ? print("<th id='restoreSelecCust'>Restore selected</th>") : ("");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['customer_id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['adress'] . "</td>";
                echo "<td>" . $row['postal_code'] . "</td>";
                echo "<td>" . $row['names'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['transaction_registered'] . "</td>";
                ($_SESSION['status'] == 1) ? print("<td><form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['customer_id']}' name='restore[]' value='{$row['customer_id']}'></form></td>") : ("");
                echo "<td><p id='outputTransDel'></p></td>";
                echo "<td><p id='outputTrans'></p></td>";
                echo "</tr>";
            }

            echo "</table>";
            //Showing page number in URL at the bottom!
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='customers.php?page=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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


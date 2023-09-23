<?php

declare(strict_types=1);
class SelectDatabase implements SelectInterface //Class that holds SELECT queries with search filters for ADMINS (pagination  is also implemented here)
{
    const limitAdmin = 15;

    /***SELECT WITH FILTER ALL FILLED***/
    public static function select($book_author, $book_title,  $number1, $number2):void
    {

        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') AND book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
            $array = array('author' => $book_author, 'title' => $book_title, 'price1' => $number1, 'price2' => $number2);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageAllFilled"])) {

            $page_number  = $_GET["pageAllFilled"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;

        /**End of pagination preparation******/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') AND book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('author' => $book_author, 'title' => $book_title, 'price1' => $number1, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) { //Do prevent showing deleted books field
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_author'] = $book_author;
                    $_SESSION['book_title'] = $book_title;
                    $_SESSION['price1'] = $number1;
                    $_SESSION['price2'] = $number2;
                }
            }
            echo "</table>";

            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageAllFilled=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

    /***SELECT ALL BOOKS IN DB***/
    public static function selectAll():void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE NULLIF(book_title, '') IS NOT NULL ORDER BY books.import_time ASC");
        } catch (PDOException $e) {
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
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
            $sql = $connection->query("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE NULLIF(book_title, '') IS NOT NULL ORDER BY books.book_quantity ASC LIMIT " . $initial_page . ',' . $limit);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                   echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                
            }
            echo "</table>";

            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?page=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***SELECT WITH FILTER ONLY AUTHOR***/
    public static function select_author($book_author):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC");
            $array = array('author' => $book_author);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageAuthor"])) {

            $page_number  = $_GET["pageAuthor"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;


        /**End of pagination preparation******/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('author' => $book_author);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_author'] = $book_author;
                }
            }

            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageAuthor=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***SELECT WITH FILTER AUTHOR AND MIN PRICE***/
    public static function select_author_number_1($book_author, $number1):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1,'%') ORDER BY book_price ASC");
            $array = array('author' => $book_author, 'price1' => $number1);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageAuthorMinPrice"])) {

            $page_number  = $_GET["pageAuthorMinPrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;


        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1,'%') ORDER BY book_price ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('author' => $book_author, 'price1' => $number1);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_author'] = $book_author;
                    $_SESSION['price1'] = $number1;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageAuthorMinPrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

    /****SELECT WITH FILTER AUTHOR AND MAX PRICE***/
    public static function select_author_number_2($book_author, $number2):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price <= CONCAT(:price2,'%') ORDER BY book_price DESC");
            $array = array('author' => $book_author, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
        } catch (PDOException $e) {
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageAuthorMaxPrice"])) {

            $page_number  = $_GET["pageAuthorMaxPrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;

        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price <= CONCAT(:price2,'%') ORDER BY book_price DESC LIMIT " . $initial_page . ',' . $limit);
            $array = array('author' => $book_author, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_author'] = $book_author;
                    $_SESSION['price2'] = $number2;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageAuthorMaxPrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***SELECT WITH FILTER AUTHOR AND PRICE RANGE***/
    public static function select_author_number_range($book_author, $number1, $number2):void
    {  
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
            $array = array('author' => $book_author, 'price1' => $number1, 'price2' => $number2);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageAuthorRangePrice"])) {

            $page_number  = $_GET["pageAuthorRangePrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;


        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('author' => $book_author, 'price1' => $number1, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_author'] = $book_author;
                    $_SESSION['price1'] = $number1;
                    $_SESSION['price2'] = $number2;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageAuthorMinPrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

    /***SELECT WITH FILTER ONLY TITLE***/
    public static function select_title($book_title):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') ORDER BY book_title ASC");
            $array = array('title' => $book_title);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageTitle"])) {

            $page_number  = $_GET["pageTitle"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') ORDER BY book_title ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('title' => $book_title);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_title'] = $book_title;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageTitle=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

            };
            echo "</div>";

        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../../Methods/Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }
    /***SELECT WITH FILTER TITLE AND MIN PRICE***/
    public static function select_title_number_1($book_title, $number1):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') ORDER BY book_price ASC");
            $array = array('title' => $book_title, 'price1' => $number1);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageTitleMinPrice"])) {

            $page_number  = $_GET["pageTitleMinPrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') ORDER BY book_price ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('title' => $book_title, 'price1' => $number1);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_title'] = $book_title;
                    $_SESSION['price1'] = $number1;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageTitleMinPrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***SELECT WITH FILTER TITLE AND MAX PRICE***/
    public static function select_title_number_2($book_title, $number2):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price AND book_price <= CONCAT(:price2,'%') ORDER BY book_price DESC");
            $array = array('title' => $book_title, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
        } catch (PDOException $e) {
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageTitleMaxPrice"])) {

            $page_number  = $_GET["pageTitleMaxPrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price AND book_price <= CONCAT(:price2,'%') ORDER BY book_price DESC LIMIT " . $initial_page . ',' . $limit);
            $array = array('title' => $book_title, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_title'] = $book_title;
                    $_SESSION['price2'] = $number2;
                }
            }
            echo "</table>";

            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageTitleMaxPrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***SELECT WITH FILTER TITLE AND PRICE RANGE***/
    public static function select_title_number_range($book_title, $number1, $number2):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
            $array = array('title' => $book_title, 'price1' => $number1, 'price2' => $number2);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageTitleRangePrice"])) {

            $page_number  = $_GET["pageTitleRangePrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('title' => $book_title, 'price1' => $number1, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_title'] = $book_title;
                    $_SESSION['price1'] = $number1;
                    $_SESSION['price2'] = $number2;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageTitleRangePrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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
    /***SELECT WITH FILTER ONLY AUTHOR AND TITLE (NO PRICE)***/
    public static function select_title_author($book_title, $book_author):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') AND book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC");
            $array = array('title' => $book_title, 'author' => $book_author);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageAuthorTitle"])) {

            $page_number  = $_GET["pageAuthorTitle"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') AND book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('title' => $book_title, 'author' => $book_author);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['book_title'] = $book_title;
                    $_SESSION['book_author'] = $book_author;
                }
            }
            echo "</table>";

            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageAuthorTitle=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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


    /***SELECT WITH FILTER MIN PRICE***/
    public static function select_number1($number1):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1,'%') ORDER BY book_price ASC");
            $array = array('price1' => $number1);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageMinPrice"])) {

            $page_number  = $_GET["pageMinPrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1,'%') ORDER BY book_price ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('price1' => $number1);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['price1'] = $number1;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageMinPrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

    /***SELECT WITH FILTER MAX PRICE***/

    public static function select_number2($number2):void
    {
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price <= CONCAT(:price2,'%') ORDER BY book_price DESC");
            $array = array('price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
        } catch (PDOException $e) {
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageMaxPrice"])) {

            $page_number  = $_GET["pageMaxPrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price <= CONCAT(:price2,'%') ORDER BY book_price DESC LIMIT " . $initial_page . ',' . $limit);
            $array = array('price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['price2'] = $number2;
                }
            }
            echo "</table>";

            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageMaxPrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

    /***SELECT WITH BOTH PRICES FILTER***/

    public static function select_number_both($number1, $number2):void
    {

        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
            $array = array('price1' => $number1, 'price2' => $number2);
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
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
        $count = $sql->rowCount(); //Getting row count!
        $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

        //Retrieving active page number
        if (isset($_GET["pageRangePrice"])) {

            $page_number  = $_GET["pageRangePrice"];
        } else {

            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        /**End of pagination preparation***/
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC LIMIT " . $initial_page . ',' . $limit);
            $array = array('price1' => $number1, 'price2' => $number2);
            foreach ($array as $key => $param) {
                $sql->bindParam($key, $param);
            }
            $sql->execute($array);
            echo "<br>";
            echo "<div class='frontMsg'>Books in database:</div>";
            echo "<table id='mainTable'>";
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($row['book_title'] > 0) {
                    echo "<tr>";
                    echo "<th>Unique ID</th>";
                    echo "<th>Image</th>";
                    echo "<th>Title (hover below the Title for book description)</th>";
                    echo "<th>Author</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Category</th>";
                    echo "<th>Price</th>";
                    echo "<th>Publish year</th>";
                    echo "<th class='modify'>Delete</th>";
                    echo "<th class='modify'>Modify</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo '<td>' . $row['book_pic'] . '</td>';
                    echo "<td class='desc'>" . $row['book_title'] . "</td>";
                    echo "<td>" . $row['book_author'] . "</td>";
                    echo "<td>" . $row['book_quantity'] . "</td>";
                    echo "<td>" . $row['book_category'] . "</td>";
                    echo "<td>" . $row['book_price'] . "$" . "</td>";
                    echo "<td>" . $row['publish_year'] . "</td>";
                    echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Delete' onclick='delIntersection(this)'></input></td>";
                    echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update'></input></form></td>";
                    echo "</tr>";
                    //Putting values in sessions so class methods can be called in properly
                    $_SESSION['price1'] = $number1;
                    $_SESSION['price2'] = $number2;
                }
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='bookSearch.php?pageRangePrice=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

    /***BOOK CATEGORIES RENDER FOR ADMIN PAGE***/
    public static function adminSelectCategory():void
    {
        require "ConnectPdo.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT book_category_id, book_category FROM dbs10877614.book_category");
            echo "<br>";

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='categoryItem'>" . $row['book_category'] . "<br>";
                echo "<input class='delCategory' type='submit' name='{$row['book_category']}' value='x' onclick='delCategoryIntersection(this)'>";
                echo "</div>";
            }
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        $connection = null;
    }

    /***Select and render all deleted Books***/
    public static function selectDeletedBooks():void
    {
        require "ConnectPdoAdmin.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT deleted_books.book_id, deleted_books.book_pic, deleted_books.book_title, deleted_books.book_author, deleted_books.book_quantity, deleted_books.book_category_id, deleted_books.publish_year, deleted_books.delete_time, book_category.book_category FROM dbs10877614.deleted_books LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=deleted_books.book_category_id ORDER BY deleted_books.delete_time ASC");
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
        /**Pagination preparation***/
        $limit = SelectDatabase::limitAdmin; // variable to store number of books per page
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
            $sql2 = $connection->query("SELECT deleted_books.book_id, deleted_books.book_pic, deleted_books.book_title, deleted_books.book_author, deleted_books.book_quantity, deleted_books.book_category_id, deleted_books.publish_year, deleted_books.delete_time, book_category.book_category FROM dbs10877614.deleted_books LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=deleted_books.book_category_id ORDER BY deleted_books.delete_time ASC LIMIT " . $initial_page . ',' . $limit);
            echo "<br>";
            echo "<div class='frontMsg'>Deleted books in database (latest):</div>";
            echo "<table id='mainTable'>";
            echo "<tr>";
            echo "<th>Unique ID</th>";
            echo "<th>Title</th>";
            echo "<th>Author</th>";
            echo "<th>Quantity</th>";
            echo "<th>Category</th>";
            echo "<th>Publish year</th>";
            echo "<th>Deleted</th>";
            echo "<th id='selectAll'>Select all</th>";
            ($_SESSION['status'] == 1) ? print("<th id='restoreSelec'>Restore selected</th>") : ("");
            echo "</tr>";
            while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['book_id'] . "</td>";
                echo "<td>" . $row['book_title'] . "</td>";
                echo "<td>" . $row['book_author'] . "</td>";
                echo "<td>" . $row['book_quantity'] . "</td>";
                echo "<td>" . $row['book_category'] . "</td>";
                echo "<td>" . $row['publish_year'] . "</td>";
                echo "<td>" . $row['delete_time'] . "</td>";
                echo "<td><form id='delSelec' action='' method='POST'><input class='checked' form='delSelec' type='checkbox' id='{$row['book_id']}' name='restore[]' value='{$row['book_id']}'></form></td>";
                echo "<td><p id='outputTransDel'></p></td>";
                echo "</tr>";
            }
            echo "</table>";
            //Small for loop to render number of pages for user to click on
            echo "<div class='numbDistContainer'>";
            for ($i = 1; $i <= $total_pages; $i++) {

                echo "<div class='numbDist'><a href='deletedBooks.php?pageDeleted=" . $i . "'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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


/***END***/

<?php
declare(strict_types=1);
class Database implements QueryInterface //Class that holds book management queries (upate, insert and delete) for ADMINS together with discount and category management
{
  const limitAdmin = 15;
  /***BOOK INSERT METHOD***/
  public static function insert($book_title, $book_pic, $book_price, $book_author, $book_description, $book_publisher, $book_quantity, $book_category, $publish_year):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction(); //Starting transaction
      //Query 1: Insert general data into book table
      $sql = $connection->prepare("CALL insertBooks(?,?,?,?,?,?,?,?)"); //Calling stored procedure
      $sql->bindParam(1, $book_title, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_pic, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $book_author, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(4, $book_description, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(5, $book_publisher, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(6, $book_quantity, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(7, $book_category, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(8, $publish_year, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      //Query 2: Select last book_id
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->query("SELECT book_id FROM {$_ENV['DATABASE_NAME']}.books ORDER BY book_id DESC LIMIT 1");
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $book_id_last = $row['book_id'];
      }

      //Query 3: insert price in pricing table (where discount will be handled)
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("CALL insertPrice(?,?)");
      $sql->bindParam(1, $book_price, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id_last, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      $connection->commit();
      echo "<br>";
      echo "Book inserted successfully!<br>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      $connection->rollBack();
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
  }

  /***BOOK CATEGORY TABLE INSERT METHOD***/

  public static function insertCategory(string $book_category):void
  {
    
    require "NamespaceAdmin4.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("CALL insertCategory(?)");
      $sql->bindParam(1, $book_category, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "<br>";
      echo "<p id='catAnchor'>Category inserted successfully! Refreshing page...<br></p>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
  }


  /***UPDATE TITLE ONLY ONLY***/
  public static function update_title($book_title, $book_id):void
  {

    require "ConnectPdoAdmin.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $date_modified = date("Y-m-d h:i:s");
      $sql = $connection->prepare("Call updateTitle(?,?,?)");
      $sql->bindParam(1, $book_title, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Title updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Title! Check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE AUTHOR ONLY ONLY***/
  public static function update_author($book_author, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateAuthor(?,?,?)");
      $sql->bindParam(1, $book_author, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Author updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Author! Check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE DESCRIPTION ONLY ONLY***/
  public static function update_description($book_description, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateDesc(?,?,?)");
      $sql->bindParam(1, $book_description, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Description updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Description! Check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE BOOK IMAGE ONLY***/

  public static function update_image($book_pic, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updatePic(?,?,?)");
      $sql->bindParam(1, $book_pic, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Book image updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Book image! Check log for more detail!";
    }
    $connection = null;
  }
  /***UPDATE QUANTITY ONLY ONLY***/
  public static function update_quantity($book_quantity, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateQuantity(?,?,?)");
      $sql->bindParam(1, $book_quantity, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Quantity updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Quantity! Check log for more detail!";
    }
    $connection = null;
  }


  /***UPDATE PUBLISHER ONLY***/
  public static function update_publisher($book_publisher, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updatePublisher(?,?,?)");
      $sql->bindParam(1, $book_publisher, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Book publisher updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Book publisher! Check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE PUBLISH YEAR ONLY***/
  public static function update_year($publish_year, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updatePublishYear(?,?,?)");
      $sql->bindParam(1, $publish_year, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Publish year updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Publish year! Check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE BOOK PRICE ONLY***/
  public static function update_price($book_price, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction();
      //Query 1: Select discount % so price changes can reflect on discounted price correctly
      $sql = $connection->prepare("SELECT discount from {$_ENV['DATABASE_NAME']}.pricing WHERE pricing.book_id=:id;");
      $array = array('id' => $book_id);
      $sql->execute($array);
      foreach ($array as $key => $param) {
        $sql->bindParam($key, $param);
      }
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $discount = $row['discount'];
      }
      if ($discount != null) { //Checking if item does have a discount active
        //Query 2: Update price column with regular price taking into account the active discount on item (if one exists)
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("Call updatePrice(?,?,?)");
        $sql->bindParam(1, $book_price, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
        $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->execute();
        //Query 3: Update discounted price column with changed price after discount is applied
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("Call updateDiscount(?,?)");
        $discount_calc = ($book_price * $discount) / 100; //Calculating price after discount
        $discounted_price = $book_price - $discount_calc;
        $sql->bindParam(1, $discounted_price, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
        $sql->execute();
        echo "Book price updated successfully!";
        //Query 4: Update price column regulary if discount is not present
      } else if ($discount == null) {
        $sql = $connection->prepare("Call updatePrice(?,?,?)");
        $sql->bindParam(1, $book_price, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
        $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->execute();
        echo "Book price updated successfully!";
      }
      $connection->commit();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      $connection->rollBack();
      echo "Failed to update Book price! Check log for more detail!";
    }
    $connection = null;
  }

  /***SET DISCOUNT***/
  public static function set_discount($book_discount, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction();
      //Query 1: Select regular price so discount can be applied
      $sql = $connection->prepare("SELECT book_price FROM {$_ENV['DATABASE_NAME']}.pricing WHERE {$_ENV['DATABASE_NAME']}.pricing.book_id=:id;");
      $array = array('id' => $book_id);
      $sql->execute($array);
      foreach ($array as $key => $param) {
        $sql->bindParam($key, $param);
      }
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $regular_price = $row['book_price'];
      }
      //Query 2: Update discount column with required precentage of discount
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateDiscountPrecentage(?,?,?)");
      $sql->bindParam(1, $book_discount, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      //Query 3: Update discounted price column with price calculated after discount is applied
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateDiscount(?,?)");
      $discount_calc = ($regular_price * $book_discount) / 100;
      $book_price = $regular_price - $discount_calc;
      $sql->bindParam(1, $book_price, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->execute();
      $connection->commit();
      echo "Book discount applied successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      $connection->rollBack();
      echo "Failed to update Book price! Check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE CATEGORY ONLY***/
  public static function update_category($book_category, $book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateCategory(?,?,?)");
      $sql->bindParam(1, $book_category, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Category updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Category! Check log for more detail!";
    }
    $connection = null;
  }

  /****DELETE BOOK ROW***/
  protected static function delete($book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction(); //Starting transaction
      //Getting book id from slider
      $sql = $connection->query("SELECT book_id FROM slider");
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $sliderArray[]=$row["book_id"];
      }
      if (!in_array($book_id, $sliderArray)){//Checking if book we want to delete is present in slider if yes continue...
      //Updating date of book deletion first
      $sql = $connection->prepare("Call updateDelDate(?,?)");
      $sql->bindParam(1, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(2, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      //Inserting "deleted" books in separate table
      $sql = $connection->prepare("Call insertDelBooks(?)");
      $sql->bindParam(1, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->execute();
      //Inserting deleted prices in separate table
      $sql = $connection->prepare("Call insertDelPrices(?)");
      $sql->bindParam(1, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->execute();
      //Updating old book table with "null"
      $sql = $connection->prepare("Call updateBooksNull(?)");
      $sql->bindParam(1, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->execute();
      //Updating old price table with "null"
      $sql = $connection->prepare("Call updatePricesNull(?)");
      $sql->bindParam(1, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->execute();
      echo "Book is deleted successfully!";
      $connection->commit();
    } else {
      echo "Action failed. Please remove book from slider first!";
    }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
    
  }

  /***Restoring "deleted" books in primary table***/
  protected static function restore($book_id):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction(); //Starting transaction
      //Restoring "deleted" books in primary table
      $sql = $connection->prepare("Call restoreBooks(?)");
      for ($i = 0; $i < sizeof($book_id); $i++) {
      $sql->bindParam(1, $book_id[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->execute();
    }
    
      //Restoring "deleted" prices in primary table
      $sql = $connection->prepare("Call restorePrices(?)");
      for ($i = 0; $i < sizeof($book_id); $i++) {
      $sql->bindParam(1, $book_id[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->execute();
    }
    
      //Deleting restored books from deleted table
      $sql = $connection->prepare("Call deleteRestoredBooks(?)");
      for ($i = 0; $i < sizeof($book_id); $i++) {
      $sql->bindParam(1, $book_id[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      
    }
    $sql->execute();
       //Deleting restored prices from deleted table
       $sql = $connection->prepare("Call deleteRestoredPrices(?)");
       for ($i = 0; $i < sizeof($book_id); $i++) {
       $sql->bindParam(1, $book_id[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
       
      }
      $sql->execute();
      echo "<div id='transConfirmRestore'>";
      echo "Restoring deleted Books!<br>";
      echo "Refreshing page...";
      echo "</div>";
      $connection->commit();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
  }

  /***DELETE CATEGORY ROW***/
  public static function deleteCat($book_category):void
  {
    require "ConnectPdoAdmin.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("call deleteCategory(?)");
      $sql->bindParam(1, $book_category, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Category deleted successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
  }

  /***DISCOUNTED BOOKS RENDER FOR ADMIN PAGE***/
  public static function adminSelectDiscounts():void
  {
    require "ConnectPdoAdmin.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, pricing.discount_price_time, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE pricing.discounted_price > 0 ORDER BY books.import_time DESC");

      $sql->execute();
      echo "<br>";
      echo "<div class='frontMsg'>Books in database with active Discount:</div>";
      echo "<table id='mainTable'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>Unique ID</th>";
        echo "<th>Image</th>";
        echo "<th>Title (hover below the Title for book description)</th>";
        echo "<th>Author</th>";
        echo "<th>Quantity</th>";
        echo "<th>Category</th>";
        echo "<th>Original price</th>";
        echo "<th>Discount(%)</th>";
        echo "<th>Discounted price</th>";
        echo "<th>Discount started</th>";
        echo "<th class='modifyDiscount'>Delete discount</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['book_id'] . "</td>";
        echo '<td>' . $row['book_pic'] . '</td>';
        echo "<td class='desc'>" . $row['book_title'] . "</td>";
        echo "<td>" . $row['book_author'] . "</td>";
        echo "<td>" . $row['book_quantity'] . "</td>";
        echo "<td>" . $row['book_category'] . "</td>";
        echo "<td>" . $row['book_price'] . "$" . "</td>";
        echo "<td>" . $row['discount'] . "%" . "</td>";
        echo "<td>" . $row['discounted_price'] . "$" . "</td>";
        echo "<td>" . $row['discount_price_time'] . "</td>";
        echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['book_id']}' value='Update' onclick='delDiscount(this)'></input></td>";
        echo "</tr>";
      }
      echo "</table>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }

  /***BOOK DISCOUNT DELETE/UPDATE WITH NULL***/

  public static function deleteDiscount($book_id):void
  {
    $date_modified = date("Y-m-d h:i:s");
    $nullVar = null;
    require "ConnectPdoAdmin.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("call deleteDiscount(?,?,?,?)");
      $sql->bindParam(1, $nullVar, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $nullVar, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(4, $book_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);

      $sql->execute();
      echo "Discount deleted successfully! Refreshing page...";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update Discount! Check log for more detail!";
    }
    $connection = null;
  }
}

/***END***/

<?php
declare(strict_types=1);
 /***Class that contains SELECT queries towards Books database (for front page/guests) with chosen category books render**/
class BooksDatabase implements UserBookSelectInterface
{
  const limit = 5; //number of books per page (see pagination section below)
  /***SELECT WITH FILTER ALL FILLED***/
  public static function userSelectData($book_author, $book_title, $number1, $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') AND book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('author' => $book_author, 'title' => $book_title, 'price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books similar to your search preferences. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";
        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";//Shopping cart icon on front page
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
      
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }

    $connection = null;
  }
  /***SELECT BOOKS WITH FILTER ONLY AUTHOR***/
  public static function userSelectAuthor($book_author):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC");
      $sql->execute(array('author' => $book_author));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";
        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }

        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }

  /***SELECT BOOKS WITH FILTER AUTHOR AND MIN PRICE***/
  public static function userSelectAuthorNumber1($book_author, $number1):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1'%') ORDER BY book_price ASC");
      $sql->execute(array('author' => $book_author, 'price1' => $number1));
       //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author with that minimum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
        
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }
  /***SELECT BOOKS WITH FILTER AUTHOR AND MAX PRICE***/
  public static function userSelectAuthorNumber2($book_author, $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price <= CONCAT(:price2'%') ORDER BY book_price DESC");
      $sql->execute(array('author' => $book_author, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author with that maximum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }


  /***SELECT BOOKS WITH FILTER AUTHOR AND PRICE RANGE***/
  public static function userSelectAuthorPriceRange($book_author, $number1, $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('author' => $book_author, 'price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author with that price range. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
       
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }


  /***SELECT BOOKS WITH FILTER ONLY TITLE***/
  public static function userSelectTitle($book_title):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') ORDER BY book_title ASC");
      $sql->execute(array('title' => $book_title));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
        
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }

  /***SELECT BOOKS WITH FILTER TITLE AND MIN PRICE***/
  public static function userSelectTitleNumber1($book_title, $number1):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1'%') ORDER BY book_price ASC");
      $sql->execute(array('title' => $book_title, 'price1' => $number1));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title and minimum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
       
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }
  /***SELECT BOOKS WITH FILTER TITLE AND MAX PRICE***/
  public static function userSelectTitleNumber2($book_title, $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') AND book_price AND book_price <= CONCAT(:price2'%') ORDER BY book_price DESC");
      $sql->execute(array('title' => $book_title, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title and maximum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
       
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }
  
  /***SELECT BOOKS WITH FILTER TITLE AND PRICE RANGE***/
  public static function userSelectTitlePriceRange($book_title, $number1, $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('title' => $book_title, 'price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title and price range. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
          echo "<div class='status'> Available</div>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
        
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }
  /***SELECT BOOKS WITH FILTER ONLY AUTHOR AND TITLE (NO PRICE)***/
  public static function userSelectTitleAuthor($book_title, $book_author):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') AND book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC");
      $sql->execute(array('title' => $book_title, 'author' => $book_author));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that author and title. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
          echo "<div class='status'> Available</div>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
       
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }

  /***SELECT BOOKS WITH FILTER MIN PRICE***/
  public static function userSelectNumber1(int $number1):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1'%') ORDER BY book_price ASC");
      $sql->execute(array('price1' => $number1));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that minimum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
        
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }

  /***SELECT BOOKS WITH FILTER MAX PRICE***/

  public static function userSelectNumber2(int $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price <= CONCAT(:price2'%') ORDER BY book_price DESC");
      $sql->execute(array('price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that maximum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
        
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }

  /***SELECT BOOKS WITHIN PRICE RANGE***/

  public static function userSelectNumberBoth($number1, $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).png' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books in that price range. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
       
        echo "</div>";
      }
      }
      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }


  /***First page book render (latest editions) with pagination***/
  public static function selectAllFront():void
  {
    require "NamespaceUser.php";
    try { //Getting total amount of rows
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->query("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title >'0'");
    } catch (PDOException $e) {
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }

    /**Pagination preparation***/
    $limit = BooksDatabase::limit; // variable to store number of books per page
    $count = $sql->rowCount(); //Getting row count!
    $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

    //Retrieving active page number
    if (isset($_GET["page"])) {

      $page_number  = $_GET["page"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;

    echo "<p id='generalAnchor'></p>";
    echo "<h2 class='latestEdition' >Latest Editions:</h2>";
    echo "<hr class='hrClass'>";
    echo "<h3 class='latestEditionNotice' >(Hover over title for description)</h3>";
   

    /**End of pagination preparation******/
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql2 = $connection->query("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM dbs10877614.books INNER JOIN dbs10877614.pricing ON books.book_id=pricing.book_id LEFT JOIN dbs10877614.book_category ON book_category.book_category_id=books.book_category_id ORDER BY publish_year DESC LIMIT " . $initial_page . ',' . $limit); //starting point, num of rows to return after starting point; 
      echo "<div class='bookContainer'>";
      while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo $newPic;
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' width='65' height='65' alt='discount-icon'>";
          echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
          echo "</div>";
          echo "<span class='oldPrice'>" . $row['book_price'] . "$" . "<br></span>";
          echo "<span class='newPrice'>" . $row['discounted_price'] . "$" . "<br></span>";
        } else {
          echo $row['book_price'] . "$" . "<br>";
        }
        echo $row['publish_year'] . "<br>";

        //Checking if book quantity is positive or 0, and rendering corresponding message to user
        if ($row['book_quantity'] > 0) {
          echo "<div class='status'> Available</div>";
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.png' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
        

        echo "</div>";
      }
      }
      echo "</div>";
    //Small for loop to render number of pages for user to click on
    echo "<div class='numbDistContainer'>";
    for ($i = 1; $i <= $total_pages; $i++) {

      echo "<div class='numbDist'><a href='index.php?page=" . $i . "#generalAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on


    };
    echo "</div>";
      //Showing page number in URL
      echo "<div class='paginationContainer'>";
      if ($page_number >= 2) { //Since "prev" is obviously unavailable on page 1 or 0.
        echo "<div class='prev'><a href='index.php?page=" . ($page_number - 1) . "#generalAnchor'> < </a></div>";
      }
      $pageURL = "";
      for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page_number) {

          $pageURL .= "<a href='index.php?page=" . $i . "#generalAnchor'>" . $i . " </a>";
        }
      };
      echo "<span class='pageNumb'>$pageURL</span>";


      if ($page_number < $total_pages) {

        echo "<div class='next'><a href='index.php?page=" . ($page_number + 1) . "#generalAnchor'> > </a></div>";
      }


      echo "</div>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }

    $connection = null;
  }

  /***BOOK CATEGORIES RENDER FOR FIRST PAGE AND BOOK UPDATE***/
  public static function userSelectCategory():void
  {
    require "NamespaceUser2.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->query("SELECT book_category_id, book_category FROM dbs10877614.book_category");
       echo"<label id='catLabel'>";
      echo "Pick a book category";
      echo "<select id='mySelect' name='category'>";
      echo "<option value='' selected>Categories</option>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['book_category_id']}'>" . $row['book_category'] . "</option>";
      }
      echo "</select>";
      echo"</label>";
    } catch (PDOException $e) {
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }
  /***BOOK CATEGORIES WITH DISCOUNT RENDER FOR FIRST PAGE ***/
  public static function userSelectDiscount()
  {
    require "NamespaceUser3.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->query("SELECT book_category_id, book_category FROM dbs10877614.book_category");
      echo"<label>";
      echo "Available discounts";
      echo "<select id='mySelectDiscount' name='category'>";
      echo "<option value='' selected>Discounts</option>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['book_category_id']}'>" . $row['book_category'] . "</option>";
      }
      echo "</select>";
      echo"<label>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }
}

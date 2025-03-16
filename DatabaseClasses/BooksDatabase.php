<?php
declare(strict_types=1);
 /***Class that contains SELECT queries towards Books database (what front page/guests see regarding books) with chosen category books render ***/
class BooksDatabase implements UserBookSelectInterface
{
  const limit = 10; //number of books per page (see pagination section below)
  /***SELECT WITH FILTER ALL FILLED***/
  public static function userSelectData($book_author, $book_title, $number1, $number2):void
  {
    require "ConnectPdoUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') AND book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1,'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('author' => $book_author, 'title' => $book_title, 'price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books similar to your search preferences. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
         echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";//Shopping cart icon on front page
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC");
      $sql->execute(array('author' => $book_author));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}' aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1'%') ORDER BY book_price ASC");
      $sql->execute(array('author' => $book_author, 'price1' => $number1));
       //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author with that minimum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}' aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price <= CONCAT(:price2'%') ORDER BY book_price DESC");
      $sql->execute(array('author' => $book_author, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author with that maximum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_author LIKE CONCAT('%',:author,'%') AND book_price >= CONCAT(:price1'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('author' => $book_author, 'price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books written by that author with that price range. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') ORDER BY book_title ASC");
      $sql->execute(array('title' => $book_title));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1'%') ORDER BY book_price ASC");
      $sql->execute(array('title' => $book_title, 'price1' => $number1));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title and minimum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') AND book_price AND book_price <= CONCAT(:price2'%') ORDER BY book_price DESC");
      $sql->execute(array('title' => $book_title, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title and maximum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE  book_title LIKE CONCAT('%',:title,'%') AND book_price >= CONCAT(:price1'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('title' => $book_title, 'price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that title and price range. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title LIKE CONCAT('%',:title,'%') AND book_author LIKE CONCAT('%',:author,'%') ORDER BY book_author ASC");
      $sql->execute(array('title' => $book_title, 'author' => $book_author));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that author and title. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1'%') ORDER BY book_price ASC");
      $sql->execute(array('price1' => $number1));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that minimum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price <= CONCAT(:price2'%') ORDER BY book_price DESC");
      $sql->execute(array('price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books with that maximum price. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        
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
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_price >= CONCAT(:price1'%') AND book_price <= CONCAT (:price2,'%') ORDER BY book_price ASC");
      $sql->execute(array('price1' => $number1, 'price2' => $number2));
      //Message to users if no record is found in database
      if ($sql->rowCount()==0) {
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...we don't seem to have any books in that price range. Please try again.<p>";
      }
      echo "<div class='bookContainerSearch'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
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
      $sql = $connection->query("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE book_title >'0'");
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
    if (isset($_GET["page"]) && $_GET["page"] <= $total_pages) {

      $page_number  = $_GET["page"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;

    
    echo "<h2 class='latestEdition' >Latest Editions:</h2>";
    echo "<hr class='hrClass'>";
    echo "<h3 class='latestEditionNotice' >(Hover over title for description)</h3>";
    echo "<p id='generalAnchor'></p>";

    /**End of pagination preparation******/
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql2 = $connection->query("SELECT books.book_id, books.book_pic, books.book_title, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id ORDER BY publish_year DESC LIMIT " . $initial_page . ',' . $limit); //starting point, num of rows to return after starting point; 
      echo "<div class='bookContainer'>";
      while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
        if ($row['book_title']>0){
        echo "<div class='grid-item'>";
        echo "<div class='categoryFront'>".$row['book_category']."</div>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        $newPic = str_replace("alt='book image'", "alt='book image' loading='lazy'", $newPic);
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'><div class='shroudCont'><div class='shroud'><p class='inception'>Preview</p></div></div>$newPic </a>";
        echo "<div class='descFront'>";
        echo $row['book_title'];
        echo  "</div>";
        echo $row['book_author'] . "<br>";
        //Logic to properly discounted price
        if ($row['discounted_price'] > 0) {
          echo "<div class='discountContainerFront'>";
          echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
          echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' value='Add-to-cart'>";
        } else if ($row['book_quantity'] == 0) {
          echo "<div class='notStatus'> Not available </div>";
        }
        

        echo "</div>";
      }
      }
      echo "</div>";
    //Small for loop to render number of pages for user to click on
    echo "<div class='numbDistContainer'>";
      $length=$total_pages/4;
      $chunk=$total_pages-2;
      $switch=true;
      for ($i = 1; $i <= $total_pages; $i++) {
        if($i<=round($length)){
        echo "<div class='numbDist'><a href='index.php?page=" . $i . "#generalAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on
      } else if($i>round($length) && ($i<=$chunk)){
        if($page_number>=round($length)&&($page_number<$chunk) && $switch==true){
          $switch=false;
          echo"<p>...</p>";
          echo "<div class='numbDist'><a href='index.php?page=" . $page_number+1 . "#generalAnchor'>" . $page_number+1 . "</a></div>"; 
         
        }else if($page_number==$chunk  && $switch==true){
             $switch=false;
            echo "<div class='numbDist'><a href='index.php?page=" . $page_number-1 . "#generalAnchor'>" . $page_number-1 . "</a></div>";
         echo"<p>...</p>";
        }else if($switch==true) {
          $switch=false;
          echo"<p>...</p>"; 
        }

    } else{
      echo "<div class='numbDist'><a href='index.php?page=" . $i . "#generalAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on
    }

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

  
  /***Book details rendered for book preview***/
  public static function bookPreview($book_id):void{
  require "ConnectPdoUser.php";
  try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql=$connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, books.book_description, books.book_author, books.book_quantity, book_category.book_category, pricing.book_price, pricing.discount, pricing.discounted_price, books.book_publisher, books.publish_year FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE books.book_id=:book_id");
    $sql->execute(array('book_id' => $book_id));
    if($sql->rowCount()>0){
    echo "<div class='prevContainer'>";
    echo "<div class='bookContainer'>";
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
      if ($row['book_title'] == null) {
       echo"<meta http-equiv='refresh' content='4;url=https://www.afterparty-bookstore.com/index'>";
        echo "<div class='smallContainer'>";
        echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
        echo "<p id='empty'>Ooops...don't have books with that id sir. Returning to webshop...<p>";
        echo "</div>";
        unset($_SESSION['category']);
        die();
      }
      $_SESSION['category'] = $row['book_category'];
      $_SESSION['book_title'] = $row['book_title'];
      $_SESSION['book_author'] = $row['book_title'];
      $description=$row['book_description'];
      $publisher=$row['book_publisher'];
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
        echo "<img class='discountIcon' src='Methods/img/Bez_naslova.webp' width='65' height='65' alt='discount-icon'>";
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
        echo "<input class='cartFront' type='image' src='Methods/img/shopping-cart.webp' width='35' height='35' alt='submit' name='{$row['book_id']}' onclick='cartInsertManual(this)' value='Add-to-cart'>";//Shopping cart icon on front page
      } else if ($row['book_quantity'] == 0) {
        echo "<div class='notStatus'> Not available </div>";
      }
      echo "</div>";
    echo "<div class='smallPreviewCont'>";
    echo "<i class='fa fa-paperclip' style='padding:unset;' aria-hidden='true'></i>
    <span id='publisher' style='color:cadetblue;'>Published by ".$publisher."</span>";
    echo "<span class=previewDesc><p>".$description."</p></span>";//For better stylisation.
    //To hide comment button
   if (isset($_SESSION['id'])&& isset($_SESSION['status'])) {
     $book_id=$_SESSION['id'];
    $user_name=$_SESSION['username'];
   //Selecing rating for logged in user.
    Rating::selectUserBookRating($book_id, $user_name);
    if(!empty($_SESSION['average_rating'])){
      $mark=$_SESSION['average_rating'];
      $counter=0;
      echo "<div id='ratingContId' class='ratingContainer'>";
      echo "<p class='ratingLabel'>Your rating:</p>";
      while($counter<$mark){
        $counter++;
       //Showing how many stars logged in user has given to the product
        echo"<span id='1' class='fa fa-star faChecked'value='1' disabled></span>";
      }
      echo "</div>";
    } else {
      echo "<div id='ratingContId' class='ratingContainer'>";
      echo"<span id='1' class='fa fa-star'value='1' onmouseover='starsChecked(this)' onclick='insertRating(this)'></span>";
      echo"<span id='2' class='fa fa-star'value='2' onmouseover='starsChecked(this)'onclick='insertRating(this)'></span>";
      echo"<span id='3' class='fa fa-star'value='3' onmouseover='starsChecked(this)'onclick='insertRating(this)'></span>";
      echo"<span id='4' class='fa fa-star'value='4' onmouseover='starsChecked(this)'onclick='insertRating(this)'></span>";
      echo"<span id='5' class='fa fa-star'value='5' onmouseover='starsChecked(this)'onclick='insertRating(this)'></span>";
  
      echo "</div>";
    }
    
    //Rating stars
    echo "<p class='ratingLabel'>Average user rating:</p>";
    //Rendering AVERAGE book rating logged in user
    Rating::selectRating($book_id);
    $formObject=new Form;
    $formObject->commentFormRender();
  } else {
    echo "<p class='ratingLabel'>Average user rating:</p>";
    //Rendering AVERAGE book rating logged out user
    Rating::selectRating($book_id);
    echo "<a class='loginComment' href='loginPage.php?id={$_GET['id']}'>Leave a comment</a>";
  }
    echo "</div>";
    echo "</div>";
    echo "</div>";
  } 
  }else{
  echo "<img id='emptyIcon' src='Methods/img/sorry(2).webp' width='100' alt='sorry-icon'>";
  echo "<p id='empty'>Ooops...don't have books with that id sir.<p>";
  unset($_SESSION['category']);

}
  }catch (PDOException $e) {
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
      $sql = $connection->query("SELECT book_category_id, book_category FROM {$_ENV['DATABASE_NAME']}.book_category");
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
      $sql = $connection->query("SELECT book_category_id, book_category FROM {$_ENV['DATABASE_NAME']}.book_category");
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
   /***"Similiar like this Carousel***/
  public static function selectCarousel():void
  {
    if(isset($_SESSION['category'])){
    $book_category= $_SESSION['category'];
    $book_author = $_SESSION['book_author'];
    $book_title=$_SESSION['book_title'];
    require "NamespaceAdmin4.php";
    try { //Getting total amount of rows
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_id, books.book_pic, books.book_title, book_category.book_category FROM {$_ENV['DATABASE_NAME']}.books INNER JOIN {$_ENV['DATABASE_NAME']}.pricing ON books.book_id=pricing.book_id LEFT JOIN {$_ENV['DATABASE_NAME']}.book_category ON book_category.book_category_id=books.book_category_id WHERE NOT book_title=:bookTitle AND (book_category=:bookCategory OR books.book_author=:bookAuthor)");
      $sql->execute(array('bookTitle'=>$book_title, 'bookCategory' => $book_category, 'bookAuthor' => $book_author));
      if ($sql->rowCount()==0) {
        return;
      }else if ($sql->rowCount()>=1 && $sql->rowCount()<=3){
        echo "<div class='containerSmall'>";
        echo "<h2>More like this:</h2>";
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        $newPic = str_replace("class='shroudImg'", "class='shroudImgSmall'", $newPic );
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'>$newPic</a>";
      }
      echo "</div>";
      }else {
      echo "<div class='container'>";
      // Similiar like this slider 
      echo "<h2>More like this:</h2>";
      echo "<div class='slider-container bg-red' id='featured-products'>";
      echo "<div class='slides-wrapper'>";
      echo "<div class='slides-container'>";
      echo "<ul class='slider-list'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<li class='slider-item'>";
        $newPic = str_replace("../", "Methods/", $row['book_pic']);
        $newPic = str_replace("width='200' height='300'", "", $newPic);
        
        echo "<a href='#' aria-label='book-details'>";
        echo "<a href='preview.php?id={$row['book_id']}'aria-label='book-details'>$newPic</a>";
        echo "</a>";
        echo "</li>";
        
      } 
     
      echo "</ul>";
      echo "</div>";
      echo "</div>";
     
      echo "<div class='slider-arrows'>";
      echo"<button type='button' class='slider-arrow-prev'>Prev</button>";
       echo"<button type='button' class='slider-arrow-next'>Next</button>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "<script src='assets/js/slider.js' defer></script>";
    }
    } catch (PDOException $e) {
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
  }
}
}

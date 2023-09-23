<?php
declare(strict_types=1);
class CartUser extends AbstractCart
{
  /***Rendering items that user picked from Session in CART page***/
  static function showCart()
  {
    require "DatabaseClasses/ConnectPdoUser.php";
    $total_price = null;
    if (!empty($_SESSION['cart'])) { //Removing unidentified index notification
      $array = $_SESSION['cart'];
    } else {
      return;
    }
    foreach ($array as $value) {
      try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT books.book_id, book_pic, book_title, book_author, book_quantity, publish_year, pricing.book_price, pricing.discount, pricing.discounted_price FROM dbs10877614.pricing JOIN dbs10877614.books ON dbs10877614.pricing.book_id=books.book_id WHERE books.book_id=:value");
        $queryArray = array('value' => $value);
        foreach ($queryArray as $keyQuery => $param) {
          $sql->bindParam($keyQuery, $param);
        }
        $sql->execute($queryArray);
        echo "<div class='bookContainerCart'>";
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
          echo "<div class='grid-item'>";
          $newPic = str_replace("../", "Methods/", $row['book_pic']);
          echo $newPic;
          echo "<div class='descFront'>";
          echo $row['book_title'];
          echo  "</div>";
          echo $row['book_author'] . "<br>";
          //Logic to properly discounted price
          if ($row['discounted_price'] > 0) {
            echo "<div class='discountContainerFront'>";
            echo "<img class='discountIcon' src='Methods/img/Bez_naslova.png' alt='discount-icon'>";
            echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
            echo "</div>";
            echo "<div class='oldPrice'>" . $row['book_price'] . "$" ."<br></div>";
            echo "<span class='newPrice'>" . $row['discounted_price'] . "$"."<br></span>";
            $total_price += $row['discounted_price']; //Adding discounted prices in variable
          } else {
            echo "<span class='originalPrice'>".$row['book_price'] . "$" . "<br></span>";
            $total_price += $row['book_price']; //Adding normal prices in variable
          }
          echo $row['publish_year'] . "<br>";

          //Checking if book quantity is positive or 0, and rendering corresponding message to user
          if ($row['book_quantity'] > 0) {
            echo "<div class='status'> Available</div>";
          } else if ($row['book_quantity'] == 0) {
            echo "<div class='notStatus'> Not available </div>";
          }

          echo "</div>";
          echo "<div class='cartContainer'>";
          echo "<input id='cartDel' class='cartDel' type='image' src='Methods/img/delete-cart.png' width='45' height='45' alt='submit' name='{$value}' value='CartDelete'>";
          echo '<label for="cartQuantity">Quantity:</label>';
          echo '<div class="quantityDown">-</div>';
          echo '<input class="cartQuantity" type="number" id="cartQuantity" name="cartQuantity" min="1" value="1" onKeyDown="return false" disabled>';
          echo '<div class="quantityUp">+</div>';
          echo "</div>";
        }
        echo "</div>";
      } catch (PDOException $e) {
        date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
      }
    }
    $_SESSION['total_price'] = $total_price;
    $connection = null;
  }

  /***Rendering items that user picked from Session in CONFIRMATION page***/

  static function showCartConfirmation()
  {
    require "../DatabaseClasses/ConnectPdoUser.php";
    $_SESSION['usedPrices'] = array(); //Creating container to store prices used in puhrchase, which will be rendered in statistics page.
    $quantityArray = $_SESSION['quantity'];
    $total_price = null;
    $array = $_SESSION['cart'];
    foreach ($array as $key => $value) {
      try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("SELECT books.book_id, book_pic, book_title, book_author, book_quantity, publish_year, pricing.book_price, pricing.discount, pricing.discounted_price FROM dbs10877614.pricing JOIN dbs10877614.books ON dbs10877614.pricing.book_id=books.book_id WHERE books.book_id=:value");
        $queryArray = array('value' => $value);
        foreach ($queryArray as $keyQuery => $param) {
          $sql->bindParam($keyQuery, $param);
        }
        $sql->execute($queryArray);
        echo "<div class='bookContainerCheckout'>";
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
          echo "<div class='grid-item'>";
          $newPic = str_replace("../", "", $row['book_pic']);
          echo $newPic;
          echo "<div class='descFront'>";
          echo $row['book_title'];
          echo  "</div>";
          echo $row['book_author'] . "<br>";
          //Logic to properly discounted price
          if ($row['discounted_price'] > 0) {
            echo "<div class='discountContainerFront'>";
            array_push($_SESSION['usedPrices'], $row['discounted_price']);
            echo "<img class='discountIcon' src='img/Bez_naslova.png' alt='discount-icon'>";
            echo "<div class='discount'>" . $row['discount'] . "%" . "</div>";
            echo "</div>";
           echo "<div class='oldPrice'>" . $row['book_price'] . "$" ."<br></div>";
            echo "<span class='newPrice'>" . $row['discounted_price'] . "$"."<br></span>";
            $total_price += $row['discounted_price']; //Adding discounted prices in variable
          } else {
            echo "<span class='originalPrice'>" . $row['book_price'] . "</span>$<br>";
            array_push($_SESSION['usedPrices'], $row['book_price']);
            $total_price += $row['book_price']; //Adding normal prices in variable
          }

          echo $row['publish_year'] . "<br>";
          if ($row['book_quantity'] < $quantityArray[$key]) {
            echo "<div class='notStatusCheckout'> Not available! </div>";
            echo "<div class='notStatusCheckout'>Books in stock: " . $row['book_quantity'] . "</div>";
          } else if ($row['book_quantity'] >= $quantityArray[$key]) {
            echo '<span class="quantityFinal">x ' . ($quantityArray[$key]) . '</span>';
          }
          echo "</div>";
          echo "</div>";
      
        }
      } catch (PDOException $e) {
        date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
        echo "Failed to comply. Check log for more detail!";
      }
    }
    $_SESSION['total_price'] = $total_price;
    $connection = null;
  }
}

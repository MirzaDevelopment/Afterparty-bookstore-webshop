<?php
declare(strict_types=1);
/***Class for transaction management***/
class TransactionDatabase implements TransactionInterface 
{
  public $status = "pending";

  public function completeTransaction():void
  {

    require "NamespaceAdmin4.php";
    /***Declaring necessary data in variables***/
    $arrayPrice = $_SESSION['usedPrices']; //...also insert of prices mainly for statistical charts
    $array = $_SESSION['cart'];
    $quantityArrayFinal = $_SESSION['quantity'];
    $customer_id = $_SESSION['customer_id'];
    /***Iterating through cart array***/
    foreach ($array as $key => $value) {
      try {
        //Query1: Select current book quantity for books in cart
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->beginTransaction(); //Starting transaction
        $sql = $connection->prepare("SELECT book_quantity FROM books WHERE books.book_id=:book_id");
        $arraySelect = array('book_id' => $value);
        $sql->execute($arraySelect);
        foreach ($arraySelect as $keySelect => $param) {
          $sql->bindParam($keySelect, $param);
        }
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
          //Quantity manipulation
          $oldQuantity = $row['book_quantity'];
          if ($oldQuantity < $quantityArrayFinal[$key]) { //Checking if book quantity in DB is enough to fulfill user order.
            echo "<span class='noticeFail'>Notice: some orders could not be completed - item out of stock!<br></span>"; //Notice if there are not enough books in database on chosen product
            $newQuantity = $oldQuantity; //Leavin quantity intact.
          } else if ($oldQuantity >= $quantityArrayFinal[$key]) {
            //If Book quantity is enought to fulfill order...
            $newQuantity = $oldQuantity - $quantityArrayFinal[$key]; //Calculate remaining book quantity and update table accordingly!
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Sub-query: Insert transaction into transaction table after valid quantity calculation
            $sql = $connection->prepare("Call insertTransaction(?,?,?,?,?)");
            $status = $this->status;
            $sql->bindParam(1, $value, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(2, $customer_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(3, $quantityArrayFinal[$key], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(4, $status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(5, $arrayPrice[$key], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->execute();
          }
        }
        //Query3: Update quantity on book table
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("Call updateQuantityTransaction(?,?,?)");
        $date_modified = date("Y-m-d h:i:s");
        $sql->bindParam(1, $value, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(2, $newQuantity, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
        $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->execute();
        //Query 4: Precusion query to prevent user to continue with order even if all items are out of stock (customer data would be deleted if no transaction has been made).
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql2 = $connection->query("SELECT customer_id FROM dbs10877614.transactions order by customer_id DESC LIMIT 1"); //Selecting last customer id in transaction table
        while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
          if ($row['customer_id'] !== $customer_id) { //if last made customer id is not the same as transaction customer id (transaction does not exsist)...
            $sql2 = $connection->prepare("Call deleteCustomerFailed(?)"); //Delete the corresponding customer (because such customer exists in customer DB without a corresponding transaction made by him)
            $sql2->bindParam(1, $customer_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
            $sql2->execute();
            $connection->commit(); //Commit transaction if above event took place
            header("Refresh:4; url=index.php");
            die();
          }
        }

        $connection->commit();
      } catch (PDOException $e) {
        date_default_timezone_set('Europe/Sarajevo');
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "../Methods/Logs/logs.txt");
        $connection->rollBack();
        echo "Failed to complete action, check log for more detail!";
      }
    }


    $connection = null;
  }
  
  /***Sending transaction details to customer mail***/
  public function renderTransaction():void
  {
    $customer_email = $_SESSION['email'];
    $customer_id = $_SESSION['customer_id'];
    $message = "";

    require "NamespaceAdmin3.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT books.book_title, books.book_author, pricing.book_price, pricing.discounted_price, transactions.book_quantity, users_customers.email FROM dbs10877614.transactions JOIN dbs10877614.books ON books.book_id=transactions.book_id JOIN users_customers ON transactions.customer_id=users_customers.customer_id JOIN pricing ON books.book_id=pricing.book_id WHERE users_customers.email=:email AND transactions.customer_id=:customer_id");
      $arrayEmail = array('email' => $customer_email, 'customer_id' => $customer_id);
      $sql->execute($arrayEmail);
      foreach ($arrayEmail as $keyEmail => $param) {
        $sql->bindParam($keyEmail, $param);
      }
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        //Creating details that would be send via mail
        $message .=
          '<table style="text-align:center; width: min-content;"><tbody style="display: inline-flex;">
        <tr><th>Title:</th></tr><tr><td style="color:cornflowerblue;"> ' . $row['book_title'] . ' </td></tr>' .
          '<tr><th>Author:</th></tr><tr><td  style="color:cornflowerblue; "> ' . $row['book_author'] . ' </td></tr>' .
          '<tr><th>Quantity:</th></tr><tr><td  style="color:cornflowerblue;"> ' . $row['book_quantity'] . ' </td></tr>';
        if (!empty($row['discounted_price'])) { //Showing discounted price if one exsists
          $message .= ' <tr><th>Price:</th></tr><tr><td  style="color:cornflowerblue;"> ' . $row['discounted_price'] . "$" . ' </td></tr></tbody></table>';
        } else {
          $message .=
            '<tr><th>Price:</th></tr><tr><td  style="color:cornflowerblue;"> ' . $row['book_price'] . "$" . ' </td></tr></tbody></table>';
           
        }
      }

      //Including phpmailer class
      require "../Methods/Mail/transactionMail.php";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Methods/Logs/logs.txt");
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
  }



  /***SELECT transactions with status pending***/
  public static function pendingTransactionsRender($transactionData):void
  {
    $pendingArray = array();
    require "NamespaceAdmin3.php";

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT transactions.transaction_id, transactions.transaction_status FROM dbs10877614.transactions WHERE transactions.transaction_id=:transId AND transactions.transaction_status='pending'");
      for ($i = 0; $i < sizeof($transactionData); $i++) {
        $array = array('transId' => $transactionData[$i]);
        foreach ($array as $key => $param) {
          $sql->bindParam($key, $param);
        }
      }

      $sql->execute($array);
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

        array_push($pendingArray, $row['transaction_id']);
      }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }

    $_SESSION['pending'] = $pendingArray; //Getting data for update section
  }



  /***SELECT transactions with status Finished***/
  public static function finishedTransactionsRender($transactionData):void
  {
    $finishedArray = array();
    require "ConnectPdoAdmin.php";

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT transactions.transaction_id, transactions.transaction_status FROM dbs10877614.transactions WHERE transactions.transaction_id=:transId AND transactions.transaction_status='finished'");
      for ($i = 0; $i < sizeof($transactionData); $i++) {

        $array = array('transId' => $transactionData[$i]);
        foreach ($array as $key => $param) {
          $sql->bindParam($key, $param);
        }
      }
      $sql->execute($array);
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

        array_push($finishedArray, $row['transaction_id']);
      }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }

    $_SESSION['finished'] = $finishedArray; //Getting data for update section
  }




  /***Updating transaction status  pending -> finished***/
  public static function updateTransactionStatusFinished():void
  {
    $updateArray = $_SESSION['pending'];
    $status = "finished";
    require "NamespaceAdmin5.php";

    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql4 = $connection->prepare("Call updateTransFinished (?,?,?)");

      for ($i = 0; $i < sizeof($updateArray); $i++) {
        $sql4->bindParam(1, $updateArray[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql4->bindParam(2, $status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql4->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      }

      $sql4->execute();
      $_SESSION['rowCount'] = $sql4->rowCount();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
  }


  /***Updating transaction status  finished->pending***/
  public static function updateTransactionStatusPending():void
  {
    $updateArray = $_SESSION['finished'];
    $status = "pending";
    require "NamespaceAdmin4.php";

    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql4 = $connection->prepare("Call updateTransPending (?,?,?)");
      for ($i = 0; $i < sizeof($updateArray); $i++) {

        $sql4->bindParam(1, $updateArray[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql4->bindParam(2, $status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql4->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      }

      $sql4->execute();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
  }



  /***DELETE transactions with status Finished ***/
  /***Transactions are actually stored in separate table, which leaves admin with possibility to restore them if they are deleted by accident***/
  public static function finishedTransactionsDelete($transactionData):void
  {
    $status = "finished";
    require "ConnectPdo.php";

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction(); //Starting transaction
      //Inserting "deleted" transactions in special table
      $sql=$connection->prepare("Call insertDelTrans(?,?)");
      for ($i = 0; $i < sizeof($transactionData); $i++) {
        $sql->bindParam(1, $transactionData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(2, $status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      }
      $sql->execute();
      //Updating old table with "null"
      $sql=$connection->prepare("Call updateTransNull(?,?)");
      for ($i = 0; $i < sizeof($transactionData); $i++) {
        $sql->bindParam(1, $transactionData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(2, $status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      }
      $sql->execute();
      echo "<div id='transConfirmDel'>";
      echo "Deleting transaction!<br>";
      echo "Notice: only 'finished' transactions can be deleted!<br>";
      echo "Refreshing page...";
      echo "</div>";
      $connection->commit();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
  }
/***Restoring "deleted" transactions in primary table***/
  public static function deletedTransactionRestore($transactionData):void
  {
    require "ConnectPdo.php";
    try {
     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction(); //Starting transaction
      //Restoring "deleted" transactions in primary table
      $sql=$connection->prepare("Call restoreTrans(?)");
      for ($i = 0; $i < sizeof($transactionData); $i++) {
        $sql->bindParam(1, $transactionData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->execute();
      }
     
      //Deleting restored transactions from deleted table
    $sql=$connection->prepare("Call deleteRestored(?)");
      for ($i = 0; $i < sizeof($transactionData); $i++) {
        $sql->bindParam(1, $transactionData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        
      }
      $sql->execute();
      echo "<div id='transConfirmRestore'>";
      echo "Restoring transactions!<br>";
      echo "Refreshing page...";
      echo "</div>";
      $connection->commit();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
  }
}

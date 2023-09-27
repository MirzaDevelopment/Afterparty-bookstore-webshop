<?php
declare(strict_types=1);
/***Class that holds methods for insert and delete customers from DB***/
class CustomerDatabase implements CustomersInterface
{
    //Insert customers in db that happens after checkout confirmation
    function insertUserCustomer(string $first_name, string $last_name, string $email, string $adress, string $postal_code, string $city, int $adm_unit_id, string $phone_number):void
    {   
        require "ConnectPdoAdmin.php";
        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->beginTransaction(); //Starting transaction
            //Query 1: Insert customer in data table
            $sql = $connection->prepare("Call insertCustomer(?,?,?,?,?,?,?,?)");
            $sql->bindParam(1, $first_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(2, $last_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6000);
            $sql->bindParam(3, $email, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(4, $adress, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(5, $postal_code, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(6, $city, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(7, $adm_unit_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->bindParam(8, $phone_number, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            $sql->execute();
            //Query 2: Select last customer_id
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $connection->query("SELECT customer_id FROM {$_ENV['DATABASE_NAME']}.users_customers ORDER BY customer_id DESC LIMIT 1");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['customer_id'] = $row['customer_id'];
            }
            echo "<br>";
            //Committing transaction finaly
            $connection->commit();
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "Logs/logs.txt");
            $connection->rollBack();
            echo "Failed to insert data into Database check log for more detail!";
        }
        $connection = null;
    }

    /***DELETE Customers***/
    /***Customers are actually stored in separate table, which leaves admin with possibility to restore them if they are deleted by accident***/
    protected static function customerDelete($customerData)
    {
        require "ConnectPdo.php";

        try {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->beginTransaction(); //Starting transaction
            //Inserting "deleted" customer in special table
            $sql = $connection->prepare("Call insertDelCust(?)");
            for ($i = 0; $i < sizeof($customerData); $i++) {
                $sql->bindParam(1, $customerData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            }
            $sql->execute();
            //Updating old table with "null"
            $sql = $connection->prepare("Call updateCustNull(?)");
            for ($i = 0; $i < sizeof($customerData); $i++) {
                $sql->bindParam(1, $customerData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            }
            $sql->execute();

            echo "<div id='transConfirmDel'>";
            echo "Customers deleted successfully!<br>";
            echo "Refresning page...";
            echo "</div>";
            //Committing transaction finaly
            $connection->commit();
        } catch (PDOException $e) {
          date_default_timezone_set('Europe/Sarajevo');
            $error = $e->getMessage() . " " . date("F j, Y, g:i a");
            error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
            echo "Failed to comply. Check log for more detail!";
        }
    }

    /***Restoring "deleted" transactions in primary table***/
    public static function deletedCustomersRestore($customerData)
  {
    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->beginTransaction(); //Starting transaction
      //Restoring "deleted" Customers in primary table
      $sql=$connection->prepare("Call restoreCust(?)");
      for ($i = 0; $i < sizeof($customerData); $i++) {
        $sql->bindParam(1, $customerData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->execute();
      }
      //Deleting restored Customers from deleted table
      $sql=$connection->prepare("Call deleteRestoredCust(?)");
      for ($i = 0; $i < sizeof($customerData); $i++) {
        $sql->bindParam(1, $customerData[$i], PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      }
      $sql->execute();
      echo "<div id='transConfirmRestore'>";
      echo "Restoring customers!<br>";
      echo "Refreshing page...";
      echo "</div>";
      //Committing transaction finally
      $connection->commit();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
  }
}

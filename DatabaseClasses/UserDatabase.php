<?php
declare(strict_types=1);
/*
multipurpose Class for DB queries towards users by admin
Includes user registration (insertUser method)
Includes select query for user data required for login
Includes securtiy implementation of failed login attempts (insert in ip database)
*/
class UserDatabase implements UsersInterface, UserSelectInterface
{
  const limitUser = 15;
  /***Methods used by admin***/
  /***INSERT USER***/
  protected static function insertUser($first_name, $last_name, $user_name, $email, $password,  $user_status):void
  {

    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call insertUser(?,?,?,?,?,?)");
      $sql->bindParam(1, $first_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $last_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $user_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(4, $email, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(5, $password, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(6, $user_status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
  }

  /***DELETE USERS FROM DATABASE***/
  protected static function deleteUser($user_id):void
  {

    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call deleteUser(?)");
      $sql->bindParam(1, $user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "User deleted successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to insert data into Database check log for more detail!";
    }
    $connection = null;
  }
    /***Update user all inputs filled***/
  protected static function updateUser($user_id, $first_name, $last_name, $email, $user_status):void
  {
    require "ConnectPdo.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateUser(?,?,?,?,?,?)");
      $sql->bindParam(1, $user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $first_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $last_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(4, $email, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(5, $user_status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(6, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update data in Database, check log for more detail!";
    }
    $connection = null;
  }

  /***Update user first name***/
  public static function  updateFirstName($user_id, $first_name):void
  {
    require "ConnectPdo.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateFirstName(?,?,?)");
      $sql->bindParam(1, $first_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "First name successfully updated!<br>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update data in Database, check log for more detail!";
    }
    $connection = null;
  }

  /***Update user last name***/
  public static function  updateLastName($user_id, $last_name):void
  {
    require "ConnectPdo.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateLastName(?,?,?)");
      $sql->bindParam(1, $last_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Last name successfully updated!<br>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update data in Database, check log for more detail!";
    }
    $connection = null;
  }

  /***Update user Status***/
  public static function updateUserStatus($user_id, $user_status):void
  {

    require "ConnectPdo.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateUserStatus(?,?,?)");
      $sql->bindParam(1, $user_status, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "User status successfully updated!<br>";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update data in Database, check log for more detail!";
    }
    $connection = null;
  }
   /***Update user email**/
    public static function  updateUserEmail($user_id, $email):void
    {
      require "ConnectPdo.php";
      try {
        $date_modified = date("Y-m-d h:i:s");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $connection->prepare("Call updateUserEmail(?,?,?)");
        $sql->bindParam(1, $email, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(2, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->bindParam(3, $user_id, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
        $sql->execute();
        echo "User email successfully updated!<br>";
      } catch (PDOException $e) {
        $error = $e->getMessage() . " " . date("F j, Y, g:i a");
        error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
        echo "Failed to update data in Database, check log for more detail!";
      }
      $connection = null;
    }
  /***Methods implemented by user himself***/
  /***UPDATE FIRST NAME BY USER***/
  public static function updateFirstNameByUser($first_name, $user_name):void
  {
    require "ConnectPdo.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateFirstNameByUser(?,?,?)");
      $sql->bindParam(1, $first_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $user_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "First name updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update data in Database, check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE LAST NAME BY USER***/
  public static function updateLastNameByUser($last_name, $user_name):void
  {

    require "ConnectPdo.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateLastNameByUser(?,?,?)");
      $sql->bindParam(1, $last_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $user_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
      echo "Last name updated successfully!";
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update data in Database, check log for more detail!";
    }
    $connection = null;
  }

  /***UPDATE BOTH FIRST AND LAST NAME BY USER***/
  public static function updateUserByUser($first_name, $last_name, $user_name):void
  {
    require "ConnectPdo.php";
    try {
      $date_modified = date("Y-m-d h:i:s");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("Call updateAllByUser(?,?,?,?)");
      $sql->bindParam(1, $first_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(2, $last_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(3, $date_modified, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->bindParam(4, $user_name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
      $sql->execute();
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to update data in Database, check log for more detail!";
    }
    $connection = null;
  }

  /***USER SEARCH QUERIES FOR SUPER ADMIN (DELETE, AND UPDATE OF USERS INCLUDED)***/
  /***SELECT WITH FILTER ALL FILLED***/
  public static function selectAllFilledUsers($first_name, $last_name,  $user_name):void
  {

    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE first_name LIKE CONCAT(:first_name,'%') AND last_name LIKE CONCAT(:last_name,'%') AND user_name LIKE CONCAT(:user_name,'%') ORDER BY first_name ASC");
      $sql->execute(array('first_name' => $first_name, 'last_name' => $last_name, 'user_name' => $user_name));
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    /**Pagination preparation***/
    $limit = UserDatabase::limitUser; // variable to store number of books per page
    $count = $sql->rowCount(); //Getting row count!
    $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

    //Retrieving active page number
    if (isset($_GET["userAllFilled"])) {

      $page_number  = $_GET["userAllFilled"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE first_name LIKE CONCAT(:first_name,'%') AND last_name LIKE CONCAT(:last_name,'%') AND user_name LIKE CONCAT(:user_name,'%') ORDER BY first_name ASC LIMIT " . $initial_page . ',' . $limit);
      $sql->execute(array('first_name' => $first_name, 'last_name' => $last_name, 'user_name' => $user_name));
      /**End of pagination preparation******/
      echo "<br>";
      echo "<div class='frontMsg'>Users in database:</div>";
      echo "<hr>";
      echo "<table id='userMainTable'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>Unique ID</th>";
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>User name</th>";
        echo "<th>Email</th>";
        echo "<th>Status</th>";
        echo "<th class='modify'>Delete</th>";
        echo "<th class='modify'>Modify</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo '<td>' . $row['first_name'] . '</td>';
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td><input <input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Delete' onclick='delIntersectionUsers(this)'></td>";
        echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input></form></td>";
        echo "</tr>";
        //Putting values in sessions so class methods can be called in properly
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['user_name'] = $user_name;
      }
      echo "</table>";
      //Showing page number in URL at the bottom!
      //Small for loop to render number of pages for user to click on
      echo "<div class='numbDistContainer'>";
      for ($i = 1; $i <= $total_pages; $i++) {

        echo "<div class='numbDist'><a href='userSearch.php?userAllFilled=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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


  /***SELECT ALL USERS***/
  protected static function selectAllUsers():void
  {
    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->query("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users ORDER BY first_name ASC");
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    /**Pagination preparation***/
    $limit = UserDatabase::limitUser; // variable to store number of books per page
    $count = $sql->rowCount(); //Getting row count!
    $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

    //Retrieving active page number
    if (isset($_GET["user"])) {

      $page_number  = $_GET["user"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;
    /**End of pagination preparation******/
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->query("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users ORDER BY first_name ASC LIMIT " . $initial_page . ',' . $limit);
      echo "<br>";
      echo "<div class='frontMsg'>Users in database:</div>";
      echo "<table id='userMainTable'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>Unique ID</th>";
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>User name</th>";
        echo "<th>Email</th>";
        echo "<th>Status</th>";
        echo "<th class='modify'>Delete</th>";
        echo "<th class='modify'>Modify</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Delete' onclick='delIntersectionUsers(this)'></td>";
        echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input></form></td>";
        echo "</tr>";
      }
      echo "</table>";
      //Showing page number in URL at the bottom!
      //Small for loop to render number of pages for user to click on
      echo "<div class='numbDistContainer'>";
      for ($i = 1; $i <= $total_pages; $i++) {

        echo "<div class='numbDist'><a href='userSearch.php?user=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

  /***SELECT WITH FILTER ONLY FIRST NAME***/
  public static function selectFirstName($first_name):void
  {
    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE first_name LIKE CONCAT(:first_name,'%') ORDER BY first_name ASC");
      $sql->execute(array('first_name' => $first_name));
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    /**Pagination preparation***/
    $limit = UserDatabase::limitUser; // variable to store number of books per page
    $count = $sql->rowCount(); //Getting row count!
    $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

    //Retrieving active page number
    if (isset($_GET["userFirstName"])) {

      $page_number  = $_GET["userFirstName"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE first_name LIKE CONCAT(:first_name,'%') ORDER BY first_name ASC LIMIT " . $initial_page . ',' . $limit);
      $sql->execute(array('first_name' => $first_name));
      echo "<br>";
      echo "<div class='frontMsg'>Users in database:</div>";
      echo "<table id='userMainTable'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>Unique ID</th>";
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>User name</th>";
        echo "<th>Email</th>";
        echo "<th>Status</th>";
        echo "<th class='modify'>Delete</th>";
        echo "<th class='modify'>Modify</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo '<td>' . $row['first_name'] . '</td>';
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Delete' onclick='delIntersectionUsers(this)'></td>";
        echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input></form></td>";
        echo "</tr>";
        //Putting values in sessions so class methods can be called in properly
        $_SESSION['first_name'] = $first_name;
      }
      echo "</table>";
      //Showing page number in URL at the bottom!
      //Small for loop to render number of pages for user to click on
      echo "<div class='numbDistContainer'>";
      for ($i = 1; $i <= $total_pages; $i++) {

        echo "<div class='numbDist'><a href='userSearch.php?userFirstName=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

  /***SELECT WITH FILTER ONLY LAST NAME***/
  public static function selectLastName($last_name):void
  {
    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE last_name LIKE CONCAT(:last_name,'%') ORDER BY last_name ASC");
      $sql->execute(array('last_name' => $last_name));
    } catch (PDOException $e) {
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    /**Pagination preparation***/
    $limit = UserDatabase::limitUser; // variable to store number of books per page
    $count = $sql->rowCount(); //Getting row count!
    $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

    //Retrieving active page number
    if (isset($_GET["userLastName"])) {

      $page_number  = $_GET["userLastName"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE last_name LIKE CONCAT(:last_name,'%') ORDER BY last_name ASC LIMIT " . $initial_page . ',' . $limit);
      $sql->execute(array('last_name' => $last_name));
      echo "<br>";
      echo "<div class='frontMsg'>Users in database:</div>";
      echo "<table id='userMainTable'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>Unique ID</th>";
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>User name</th>";
        echo "<th>Email</th>";
        echo "<th>Status</th>";
        echo "<th class='modify'>Delete</th>";
        echo "<th class='modify'>Modify</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo '<td>' . $row['first_name'] . '</td>';
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Delete' onclick='delIntersectionUsers(this)'></td>";
        echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input></form></td>";
        echo "</tr>";
        //Putting values in sessions so class methods can be called in properly
        $_SESSION['last_name'] = $last_name;
      }
      echo "</table>";
      //Showing page number in URL at the bottom!
      //Small for loop to render number of pages for user to click on
      echo "<div class='numbDistContainer'>";
      for ($i = 1; $i <= $total_pages; $i++) {

        echo "<div class='numbDist'><a href='userSearch.php?userLastName=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

  /***SELECT WITH FILTER ONLY USER NAME***/
  public static function selectUserName($user_name):void
  {
    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE user_name LIKE CONCAT(:user_name,'%') ORDER BY user_name ASC");
      $sql->execute(array('user_name' => $user_name));
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    /**Pagination preparation***/
    $limit = UserDatabase::limitUser; // variable to store number of books per page
    $count = $sql->rowCount(); //Getting row count!
    $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

    //Retrieving active page number
    if (isset($_GET["userUserName"])) {

      $page_number  = $_GET["userUserName"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE user_name LIKE CONCAT(:user_name,'%') ORDER BY user_name ASC LIMIT " . $initial_page . ',' . $limit);
      $sql->execute(array('user_name' => $user_name));
      echo "<br>";
      echo "<div class='frontMsg'>Users in database:</div>";
      echo "<table id='userMainTable'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>Unique ID</th>";
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>User name</th>";
        echo "<th>Email</th>";
        echo "<th>Status</th>";
        echo "<th class='modify'>Delete</th>";
        echo "<th class='modify'>Modify</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo '<td>' . $row['first_name'] . '</td>';
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Delete' onclick='delIntersectionUsers(this)'></td>";
        echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input></form></td>";
        echo "</tr>";
        //Putting values in sessions so class methods can be called in properly
        $_SESSION['user_name'] = $user_name;
      }
      echo "</table>";
      //Showing page number in URL at the bottom!
      //Small for loop to render number of pages for user to click on
      echo "<div class='numbDistContainer'>";
      for ($i = 1; $i <= $total_pages; $i++) {

        echo "<div class='numbDist'><a href='userSearch.php?userUserName=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

  /***SELECT WITH BOTH FIRST NAME LAST NAME***/
  public static function selectFirstNameLastName($first_name, $last_name):void
  {
    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE first_name LIKE CONCAT(:first_name,'%') AND last_name LIKE CONCAT(:last_name,'%') ORDER BY first_name ASC");
      $sql->execute(array('first_name' => $first_name, 'last_name' => $last_name));
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    /**Pagination preparation***/
    $limit = UserDatabase::limitUser; // variable to store number of books per page
    $count = $sql->rowCount(); //Getting row count!
    $total_pages = ceil($count / $limit); //Number of total pages required to show query results.

    //Retrieving active page number
    if (isset($_GET["userFirstLastName"])) {

      $page_number  = $_GET["userFirstLastName"];
    } else {

      $page_number = 1;
    }
    $initial_page = ($page_number - 1) * $limit;

    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_id, first_name, last_name, user_name, status, email FROM {$_ENV['DATABASE_NAME']}.users WHERE first_name LIKE CONCAT(:first_name,'%') AND last_name LIKE CONCAT(:last_name,'%') ORDER BY first_name ASC LIMIT " . $initial_page . ',' . $limit);
      $sql->execute(array('first_name' => $first_name, 'last_name' => $last_name));
      echo "<br>";
      echo "<div class='frontMsg'>Users in database:</div>";
      echo "<table id='userMainTable'>";
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>Unique ID</th>";
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>User name</th>";
        echo "<th>Email</th>";
        echo "<th>Status</th>";
        echo "<th class='modify'>Delete</th>";
        echo "<th class='modify'>Modify</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo '<td>' . $row['first_name'] . '</td>';
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td><input class='submitDel' type='image'  src='../../Methods/img/delete.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Delete' onclick='delIntersectionUsers(this)'></td>";
        echo "<td class='submit'><form action='../Controllers/updateControllerSmall' method='POST'><input type='hidden' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input><input type='image' src='../../Methods/img/refresh-button.png' width='55' height='55' alt='submit' name='{$row['user_id']}' value='Change'></input></form></td>";
        echo "</tr>";
        //Putting values in sessions so class methods can be called in properly
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
      }

      echo "</table>";
      //Showing page number in URL at the bottom!
      //Small for loop to render number of pages for user to click on
      echo "<div class='numbDistContainer'>";
      for ($i = 1; $i <= $total_pages; $i++) {

        echo "<div class='numbDist'><a href='userSearch.php?userFirstLastName=" . $i . "#searchAnchor'>" . $i . "</a></div>"; //Render of total nubmer of pages user can click on

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

  /***SELECT USER DATA REQUIRED FOR LOGIN (to compare with user input)***/
  public static function selectUser($user_name):void
  {
    require "ConnectPdo.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT user_name, password, status FROM {$_ENV['DATABASE_NAME']}.users WHERE user_name =:userName");
      $sql->execute(array('userName' => $user_name));
      echo "<br>";

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['password'] = $row['password'];
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['status'] = $row['status'];
      }
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }
    $connection = null;
  }

  
}
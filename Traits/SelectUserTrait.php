<?php
declare(strict_types=1);
trait SelectUserTrait{ //Small DB query to fetch user id required for comments

public function getUser($username){
require "DatabaseClasses/Namespace.php";
try {
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->prepare("SELECT users.user_id FROM users WHERE users.user_name=:username");
    $sql->execute(array('username'=> $username));
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
     
     return $row['user_id'];
    }
    
  } catch (PDOException $e) {
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "../Methods/Logs/logs.txt");
    echo "Failed to comply. Check log for more detail!";
  }

  $connection = null;
}



}
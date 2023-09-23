<?php
declare(strict_types=1);
/***Class that deals with limitation of login attempts***/
class IpSecurity {

/***Insert into ip database (to limit number of logins)***/
public static function insertIp($ip)
{
  require "ConnectPdoAdmin.php";
  try {
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->prepare("Call insertIp(?)");
    $sql->bindParam(1, $ip, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
    $sql->execute();
  } catch (PDOException $e) {
    date_default_timezone_set('Europe/Sarajevo');
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
    echo "Failed to insert data into Database check log for more detail!";
  }
  $connection = null;
}
/***Getting ip to check for number of logins***/
public static function selectIp($ip)
{

  require "NamespaceAdmin3.php";
  try {
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $connection->prepare("SELECT COUNT(*) as Attempts FROM ip_security WHERE ip_adress LIKE CONCAT('%',:ip,'%') AND timestamp > (now() - interval 10 minute)");
    $array = array('ip' => $ip);
    foreach ($array as $key => $param) {
      $sql->bindParam($key, $param);
    }
    $sql->execute($array);
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $_SESSION['Attempts']=$row['Attempts'];
  } 
  } catch (PDOException $e) {
    date_default_timezone_set('Europe/Sarajevo');
    $error = $e->getMessage() . " " . date("F j, Y, g:i a");
    error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
    echo "Failed to insert data into Database check log for more detail!";
  }
  $connection = null;
}
 /***Deleting ips after successfull login***/
 public static function deleteIp($ip)
 {

 require "NamespaceAdmin3.php";
 try {
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = $connection->prepare("Call delIp(?)");
  $sql->bindParam(1, $ip, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
  $sql->execute();
}catch (PDOException $e) {
date_default_timezone_set('Europe/Sarajevo');
$error = $e->getMessage() . " " . date("F j, Y, g:i a");
error_log($error . PHP_EOL, 3, "../Logs/logs.txt");
echo "Failed to insert data into Database check log for more detail!";
}
$connection = null;
}

}
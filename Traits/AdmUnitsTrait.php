<?php
declare(strict_types=1);
trait AdmUnitsTrait{//Small DB query to get adm units for user to display in checkout
public function getAdmUnits($adm_unit):string{
    require "../DatabaseClasses/NamespaceUser.php";
    try {
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $connection->prepare("SELECT adm_units.names FROM dbs10877614.adm_units WHERE adm_units.adm_unit_id=:adm_unit_id");
      $sql->execute(array('adm_unit_id'=> $adm_unit));
      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
       
       return $row['names'];
      }
      
    } catch (PDOException $e) {
      date_default_timezone_set('Europe/Sarajevo');
      $error = $e->getMessage() . " " . date("F j, Y, g:i a");
      error_log($error . PHP_EOL, 3, "../Methods/Logs/logs.txt");
      echo "Failed to comply. Check log for more detail!";
    }

    $connection = null;
  }
}

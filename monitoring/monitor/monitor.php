<?php

/**
*
*/
//
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

include('../connection/connection.php');
include('../relay/relay.php');

class Monitor
{

  public function dbConn() {
    $db = new Conn();
    $conn = $db->DatabaseConn();
    return $conn;
  }

  public function getRelayData() {
    $relay = new Relay();
    $a = $relay->prepareLogContents();
    return $a;
  }

  private function utcNow() {
    $date = new DateTime('now');
    $date->setTimezone(new DateTimeZone('UTC'));
    $utcNow = $date->format('Y-m-d H:i:s');

    return $utcNow;
  }

  public function checkForDuplicate($id) {
    $pdo = $this->dbConn();
    $stmt2 = $pdo->prepare("SELECT * FROM data WHERE id='$id'");
    $stmt2->execute();
    $num_rows = $stmt2->fetchAll();

    return $num_rows;
  }

  public function insertRelayData() {
    $pdo = $this->dbConn();
    $bigData = $this->getRelayData();
    $date = $this->utcNow();


    $stmt = $pdo->prepare('INSERT INTO data (id, applicatie_naam, applicatie_instantie, applicatie_versie, datum_gecreeerd, datum_aangekomen, niveau, beschrijving_kort, beschrijving_lang)
    VALUES (:id, :applicatie_naam, :applicatie_instantie, :applicatie_versie, :datum_gecreeerd, :datum_aangekomen, :niveau, :beschrijving_kort, :beschrijving_lang)');
    $successList = array();

    foreach($bigData as $data => $value) {

      $num_rows = $this->checkForDuplicate($value->id);

      if ($num_rows) {
        echo "Already Inserted = $value->id <br>";
        $successList[] .= $value->id;
        continue;
      }
      $stmt->bindParam(':id', $value->id);
      $stmt->bindParam(':applicatie_naam', $value->applicatie_naam);
      $stmt->bindParam(':applicatie_instantie', $value->applicatie_versie);
      $stmt->bindParam(':applicatie_versie', $value->applicatie_versie);
      $stmt->bindParam(':datum_gecreeerd', $value->datum_gecreeerd);
      $stmt->bindParam(':datum_aangekomen', $date);
      $stmt->bindParam(':niveau', $value->niveau);
      $stmt->bindParam(':beschrijving_kort', $value->beschrijving_kort);
      $stmt->bindParam(':beschrijving_lang', $value->beschrijving_lang);
      $stmt->execute();
      $successList[] .= $value->id;
    }
      var_dump($successList);
  }
}
echo '<pre>';
$monitor = new Monitor();
$monitor->insertRelayData();
echo '</pre>';
?>

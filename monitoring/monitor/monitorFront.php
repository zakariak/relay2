<?php

/**
*
*/

// include 'monitor.php';
include '../connection/connection.php';
include '../style/theme/header.php';

class FrontEndMonitor
{

  public function dbConn() {
    $db = new Conn();
    $con = $db->DatabaseConn();

    return $con;
  }

  public function getData() {
    $pdo = $this->dbConn();
    $stmt = $pdo->prepare("SELECT * FROM data LIMIT 10");
    $stmt->execute();
    $data = $stmt->fetchAll();
    
    return $data;
  }


  public function createTable(){
    $data = $this->getData();
    //     echo '<pre>';
    //      var_dump($data);
    //     echo '</pre>';
    echo '<table>';

    foreach ($data as $dataDump) {
      echo '<tr>';
      foreach($dataDump as $singleData => $value) {
        echo '<th>' . $singleData . '</th>';
      }
      echo '</tr>';
      break;
    }

    foreach ($data as $dataDump) {
      echo '<tr>';
      foreach($dataDump as $singleData => $value) {
        echo '<td>' . $value . '</td>';
      }
      echo '</tr>';
    }
    echo '</table>';
  }
}

// $frontend = new frontEndMonitor();
// $frontend->createTable();

$mon = new FrontEndMonitor();
$mon->createTable();

?>

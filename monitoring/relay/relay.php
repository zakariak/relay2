<?php
/**
*
*/
class Relay
{
  const MAX_DATA_LENGTH = 2000;

  // Gets all the log json files from a certain directory.
  public function getDirectoryFromLogFiles() {
    $files = glob('..' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . '*.json');
    return $files;
  }
  // gets the content of all the log files strips them of unnecessary bits and checks them out for preparation.
  public function prepareLogContents() {
    $files = $this->getDirectoryFromLogFiles();
    $contentlength = 2;
    $arrayOfLogs = array();

    foreach($files as $file => $value) {
      $content = file_get_contents($value);
      $elementLength = strlen($value);

      if( $elementLength >= self::MAX_DATA_LENGTH - 2 ) {
        throw new Exception("Element too long {$value}");
      }
      if( $file > 0 ) {
        $elementLength++;
      }
      if($contentlength + $elementLength >= self::MAX_DATA_LENGTH) {
        break;
      }
      $contentlength += $elementLength;
      $obj = json_decode($content);
      $arrayOfLogs[] = $obj;
      $array[] = $content;
    }
    echo '<pre>';
    var_dump($arrayOfLogs);
    echo '</pre>';
    return $arrayOfLogs;
  }

  // Sends contents to the monitor server
  // public function sendContentsToMonitor($array) {
  //   $this->monitorResponse();
  // }
  // gets the response from the monitor
  // public function monitorResponse($returnedLogs) {
  //   $this->deleteSendLogs($returnedLogs);
  // }

  // deletes the the logs that are send to monitor and succesfully inserted from the log foldeer.
  public  function deleteSendLogs($returnedLogs) {
    $logsFromDirectory = array();
    foreach ($this->getDirectoryFromLogFiles() as $file => $value) {
      $base = pathinfo($value, PATHINFO_FILENAME);
      $logsFromDirectory[] = $base;
    }
    $intersectedLogs = array_intersect($logsFromDirectory, $returnedLogs);
    if(count($intersectedLogs) >= 0) {
      foreach($intersectedLogs as $log => $value) {
        unlink('..' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . $value . '.json');
      }
    }
  }
}

$relay = new Relay;
$relay->prepareLogContents();


?>

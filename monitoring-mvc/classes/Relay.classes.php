<?php
/**
*
*/
class Relay
{
  const MAX_DATA_LENGTH = 2000;

  // Gets all the log json files from a certain directory.
  public function getDirectoryFromLogFiles() {
    $files = glob('classes' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . '*.json');
        // var_dump($files);
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
    }
    // var_dump($arrayOfLogs);
    $this->sendContentsToMonitor($arrayOfLogs);
  }
  // deletes the the logs that are send to monitor and succesfully inserted from the log folder.
  public  function deleteSendLogs($returnedLogs) {
    $logsFromDirectory = array();
    foreach ($this->getDirectoryFromLogFiles() as $file => $value) {
      $base = pathinfo($value, PATHINFO_FILENAME);
      $logsFromDirectory[] = $base;
    }
    // checks if for matches and those matches
    $intersectedLogs = array_intersect($logsFromDirectory, $returnedLogs);
    if(count($intersectedLogs) >= 0) {
      foreach($intersectedLogs as $log => $value) {
        unlink('log' . DIRECTORY_SEPARATOR . $value . '.json');
      }
    }
  }
//  Sends contents to the monitor server
  public function sendContentsToMonitor($array) {
    $ch = curl_init('localhost/monitoring-mvc/index2.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array));
    // execute!
    $response = curl_exec($ch);
    // close the connection, release resources used
    curl_close($ch);
    // do anything you want with your response
    var_dump($response);
        var_dump($array);
    $this->monitorResponse($reponse);
  }
  //
  // // gets the response from the monitor
  // public function monitorResponse($returnedLogs) {
  //   $this->deleteSendLogs($returnedLogs);
  // }
}

?>

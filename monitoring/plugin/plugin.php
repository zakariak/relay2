<?php

/**
*
*/
class Plugin
{
  public $applicationName;
  public $applicationInstance;
  public $applicationVersion;
  private $level;
  private $descShort;
  private $descLong;

  function __construct($applicationName, $applicationInstance, $applicationVersion)
  {
    $this->applicationName = $applicationName;
    $this->applicationInstance = $applicationInstance;
    $this->applicationVersion = $applicationVersion;
  }

  private function utcNow() {
    $date = new DateTime('now');
    $date->setTimezone(new DateTimeZone('UTC'));
    $utcNow = $date->format('Y-m-d H:i:s');

    return $utcNow;
  }

  public function createLogLocation() {
    if (!file_exists($this->getLogDirectory() ) ) {
      mkdir($this->getLogDirectory(), 0777, true);
    }
  }

  private function getLogDirectory() {
    return __DIR__.DIRECTORY_SEPARATOR.'log';
  }

  private static function GenerateLogId() {
    return uniqid('', true);
  }

  public function log($level, $descShort, $descLong) {
    $logId = self::GenerateLogId();
    $array = array(
      'id' => $logId,
      'applicatie_naam' => $this->applicationName,
      'applicatie_instantie' => $this->applicationInstance,
      'applicatie_versie' => $this->applicationVersion,
      'datum_gecreeerd' => $this->utcNow(),
      'niveau' => $level,
      'beschrijving_kort' => $descShort,
      'beschrijving_lang' => $descLong
    );

    $this->createLogLocation();
    $content = json_encode($array);
    $filePath = $this->getLogDirectory();
    $fileName = $filePath . DIRECTORY_SEPARATOR . $logId . '.json';
    $fileLocation = fopen($fileName, 'w+');
    fwrite($fileLocation, $content);
    fclose($fileLocation);
  }
}

// $plugin = new Plugin('testapp', 'dev', '1.1');
// $plugin->log('5', 'short', 'long');
// echo 'succ';

?>

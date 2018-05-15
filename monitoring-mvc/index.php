<?php

// file to test code

require 'inc/zakaria_init.inc.php';

echo '<pre>';
$plugin = new Plugin('testapp', 'dev', '1.1');
$plugin->log('5', 'short', 'long');


$relay = new Relay();
$relay->prepareLogContents();
echo '</pre>';

 ?>

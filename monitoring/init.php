<?php

spl_autoload_register('myAutoloader');

function myAutoloader($className)
{
    $path = 'relay/';

    include $path.$className.'.php';
}

//-------------------------------------
$relay = new Relay();

 ?>

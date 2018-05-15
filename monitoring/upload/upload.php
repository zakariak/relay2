<?php
include 'handler.php';

  if(isset($_POST["submit"])) {
    $handler = new Handler;
    $successList = $handler->insertDataFromZipfile($_FILES["receivedFile"]["tmp_name"]);
    echo json_encode($successList);
    die();
  }
 ?>

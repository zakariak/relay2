<?php
// requesting end
$file_name_with_full_path = __DIR__.'/log.zip';

// receiving end
$target_url = 'http://localhost/monitoring/upload/recieveUpload.php';

$cFile = curl_file_create($file_name_with_full_path);
$post = array('file_contents'=> $cFile);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$result = curl_exec($ch);
curl_close ($ch);
var_dump($result);

?>

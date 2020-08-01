<?php
  // create sercurity parameters for the URL, if none remove these vars //
  $sercurity_parameter = 'security_measure';
  $sercurity_parameter_two = 'security_measure2';
  // file path of the attachement to be uploaded //
  $fname = 'file_path_here';
  // URL (example with false secuirty parameters) //
  $target_url = 'https://testing.testwebservice.com/Webservice/api/secureone='.$sercurity_parameter.'&fileName='.$fname.'&securetwo='.$sercurity_parameter_two;
  // setup cURL connection with the file and url above //
  $cfile = new CURLFile(realpath($fname));
  $post = array (
            'file' => $cfile
            );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $target_url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
  curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
  curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
  curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 100);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  // The output //
  $result = curl_exec ($ch);
  // Create a log file(.txt) with nothing in and put the path in this var - delete if not needed//
  $connection_detail_log = 'path_to_log_file.txt';
  // Error uploading, crash and close connection //
  if ($result === FALSE) {
    curl_close ($ch);
  }
  // Connected successfully, save upload details to a log //
  else {
    $info = curl_getinfo($ch);
    date_default_timezone_set('Europe/London');
    $time = date("H:i:s");
    $date = date("Y-m-d");
    $httpCode = $info['http_code'];
    // create log - http code incase web service has specific codes for different outcomes //
    $outputSend = $user_register_xml . ' Uploaded at '.$time.' on '.$date. ' http code = '.$httpCode."\n";
    // Append rather than overwrite to see all connections - delete if not needed //
    file_put_contents($connection_detail_log, $outputSend, FILE_APPEND);
    curl_close ($ch);
  }
?>

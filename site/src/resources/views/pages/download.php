<?php

if (isset($args['filename'])) {
  $file = $_SERVER['DOCUMENT_ROOT'] . storage($args['filename']);

  // check the file exists or not
  if (file_exists($file)) {
    // define header information
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    header('Pragma: public');

    // clear system output buffer
    flush();

    // read the size of the file
    readfile($file);

    die();
  } else {
    echo "File does not exist.";
  }
} else {
  echo "File is not defined.";
}

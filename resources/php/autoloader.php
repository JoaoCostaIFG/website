<?php
spl_autoload_register(
  function ($className) {
    $fileName = '';
    $namespace = '';

    // Sets the include path
    $includePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'App';

    if (false !== ($lastNsPos = strripos($className, '\\'))) {
      $namespace = substr($className, 0, $lastNsPos);
      $className = substr($className, $lastNsPos + 1);
      $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;

    if (file_exists($fullFileName)) {
      require $fullFileName;
      echo $fullFileName;
    } else {
      echo 'Class "' . $className . '" does not exist.';
    }
  }
);

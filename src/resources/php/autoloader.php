<?php

spl_autoload_register(
  function ($className) {
    $fileName = '';
    $namespace = '';

    // Sets the include path
    $includePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'App';

    if (false !== ($lastNsPos = strripos($className, '\\'))) {
      # we do this to ensure we only load classes belonging to the App namespace (and its sub-namespaces)
      $base_end = stripos($className, '\\');

      $namespace = substr($className, $base_end + 1, $lastNsPos - $base_end);
      $className = substr($className, $lastNsPos + 1);
      $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;

    if (file_exists($fullFileName)) {
      require $fullFileName;
    } else {
      echo 'Class "' . $className . '" does not exist in ' . $fullFileName . '.';
    }
  }
);

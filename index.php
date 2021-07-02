<?php
require_once './vendor/autoload.php';
require_once './resources/php/autoloader.php';

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
  $fileLocator = new FileLocator(array(__DIR__));

  $requestContext = new RequestContext();
  $requestContext->fromRequest(Request::createFromGlobals());

  $router = new Router(
    new YamlFileLoader($fileLocator),
    'routes.yaml',
    array('cache_dir' => __DIR__ . '/cache'),
    $requestContext
  );

  // Find the current route
  $parameters = $router->match($requestContext->getPathInfo());

  // call route class method
  $target = explode('::', $parameters['_controller']);
  call_user_func_array($target, array());

  exit;
} catch (ResourceNotFoundException $e) {
  // route not found
  echo $e->getMessage();
}

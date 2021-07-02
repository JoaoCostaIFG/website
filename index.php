<?php
require_once './vendor/autoload.php';
require_once './controllers/HomeController.php';

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use controllers;

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

  // How to generate a SEO URL
  $routes = $router->getRouteCollection();
  $generator = new UrlGenerator($routes, $requestContext);
  $url = $generator->generate('foo_placeholder_route', array(
    'id' => 123,
  ));

  // print_r($parameters);

  $target = explode('::', $parameters['controller']);
  $target[0] = 'controllers\\' . $target[0];
  // print_r($target);
  call_user_func_array($target, array());

  // echo 'Generated URL: ' . $url;
  exit;
} catch (ResourceNotFoundException $e) {
  // route not found
  echo $e->getMessage();
}

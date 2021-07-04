<?php
require_once './vendor/autoload.php';
require_once './resources/php/autoloader.php';
require_once './resources/php/resource_utils.php';
include './resources/php/session.php';

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;

function route_args($name, $args)
{
  global $generator;
  return $generator->generate($name, $args);
}

function route($name)
{
  return route_args($name, array());
}

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

  // create generator for use by scripts to redirect to routes
  $generator = new UrlGenerator($router->getRouteCollection(), $requestContext);

  // Find the current route
  $parameters = $router->match($requestContext->getPathInfo());

  // call route class method
  $parameters_args = $parameters;
  unset($parameters_args['_route']);
  unset($parameters_args['_controller']);
  call_user_func_array(
    explode('::', $parameters['_controller']),
    $parameters_args
  );

  exit;
} catch (ResourceNotFoundException $e) {
  // route not found, use fallback route
  redirect(route('fallback_route'));
}

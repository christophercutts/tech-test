<?php
namespace TechTest;

use FastRoute\RouteCollector;
use Http\HttpRequest;
use Http\HttpResponse;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

define('ROOT_DIR', __DIR__);

/**
 * Register error handler
 */
$whoops = new Run();
if($environment !== 'production') {
	$whoops->pushHandler(new PrettyPageHandler());
} else {
	$whoops->pushHandler(function($e) {
		echo 'Friendly error page and send an email to the dev.';
	});
}
$whoops->register();

$injector = include('Dependencies.php');
$request = $injector->make('Http\HttpRequest');
$response = $injector->make('Http\HttpResponse');

$routesDefinitionCallback = function (RouteCollector $r) {
	$routes = include('config/Routes.php');
	foreach($routes as $route) {
		$r->addRoute($route[0], $route[1], $route[2]);
	}
};

$dispatcher = \FastRoute\simpleDispatcher($routesDefinitionCallback);
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());
switch ($routeInfo[0]) {
	case \FastRoute\Dispatcher::NOT_FOUND:
		$response->setContent('404 - Page not found');
		$response->setStatusCode(404);
		break;
	case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$response->setContent('405 - Method not allowed');
		$response->setStatusCode(405);
		break;
	case \FastRoute\Dispatcher::FOUND:
		$className = $routeInfo[1][0];
		$method = $routeInfo[1][1];
		$vars = $routeInfo[2];

		$class = $injector->make($className);
		$class->$method($vars);
		break;
}
foreach ($response->getHeaders() as $header) {
	header($header, false);
}

echo $response->getContent();
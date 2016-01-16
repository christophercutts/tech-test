<?php

$injector = new \Auryn\Injector;

$injector->alias('Http\Response', 'Http\HttpResponse');
$injector->share('Http\HttpResponse');

$injector->alias('Http\Request', 'Http\HttpRequest');
$injector->share('Http\HttpRequest');
$injector->define('Http\HttpRequest', [
	':get' => $_GET,
	':post' => $_POST,
	':cookies' => $_COOKIE,
	':files' => $_FILES,
	':server' => $_SERVER,
]);

$injector->alias('TechTest\People\People', 'TechTest\People\JsonPeople');
$injector->share('TechTest\People\JsonPeople');

$injector->alias('TechTest\Template\Renderer', 'TechTest\Template\PhpRenderer');

return $injector;
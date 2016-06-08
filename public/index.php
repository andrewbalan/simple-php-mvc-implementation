<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Подключение загрузчика сгенерированного композером
require_once __DIR__.'/../vendor/autoload.php';

// Подключение файла с роутами
require_once __DIR__.'/../app/routes.php';


use Dev\Interfaces\Exception as ExceptionInterface;
use Dev\Implementations\Router;
use Dev\Implementations\Config;

$router = Router::instance();

try 
{
	session_start();
	$router->execute();	
} 
catch (ExceptionInterface $e) 
{
	$e->handle(Config::instance());
}



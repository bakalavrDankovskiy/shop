<?php

//Errors
error_reporting(E_ALL);
ini_set('display_errors', true);

//ПОДКЛЮЧЕНИЕ СЕССИИ
ini_set('session.name', 'session_id');
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
//СТАРТ СЕССИИ
session_start();
session_regenerate_id();

use App\Router;
use App\Application;

require_once 'bootstrap.php';

$router = new Router();

$router->includeRoutes(getRoutes());

$application = new Application($router);

$application->run();




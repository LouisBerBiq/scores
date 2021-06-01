<?php
session_start();

require('./vendor/autoload.php');
require('./configs/config.php');
require('./utils/standings.php');

$route = require('./utils/router.php');
if (!$route) {
	header('location: ./index.php');
	exit();
}

$controllerName = 'Controllers\\' . $route['controller'];
$controller = new $controllerName();

$data = call_user_func([$controller, $route['callback']]);
extract($data, EXTR_OVERWRITE);
include($view);

$_SESSION['errors'] = [];
$_SESSION['old'] = [];

/*
* A REQUEST IS:
* - a method
* - an action (append, delete)
* - resources (team, match)
* manually writing validation branches is "deprecated" in this day and ages,
* frameworks like Laravel and such leverage this important process.
*/
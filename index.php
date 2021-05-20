<?php
require('./vendor/autoload.php');
require('./configs/dbconnection.php');
require('./configs/config.php');
require('./utils/standings.php');
require('./models/team.php');
require('./models/match.php');
require('./controllers/match.php');
require('./controllers/team.php');
require('./controllers/page.php');

$route = require('./utils/router.php');
if (!$route) {
	header('location: ./index.php');
	exit();
}
$data = call_user_func($route['callback'], $connection);
extract($data, EXTR_OVERWRITE);
include($view);

/*
* A REQUEST IS:
* - a method
* - an action (append, delete)
* - resources (team, match)
* manually writing validation branches is "deprecated" in this day and ages,
* frameworks like Laravel and such leverage this important process.
*/
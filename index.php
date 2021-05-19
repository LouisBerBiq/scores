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

use function Controllers\Match\store as storeMatch;
use function Controllers\Team\store as storeTeam;
use function Controllers\Page\dashboard as dashboard;

/*
* A REQUEST IS:
* - a method
* - an action (append, delete)
* - resources (team, match)
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['action']) && isset($_POST['resource'])) {
		if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {
			storeMatch($connection);
		} elseif ($_POST['action'] === 'store' && $_POST['resource'] === 'team') {
			storeTeam($connection);
		}
	};
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (!isset($_GET['action']) && !isset($_GET['resource'])) {
		$boardData = dashboard($connection);
	}
} else {
	header('locattion: ./index.php');
	exit();
}

extract($boardData, EXTR_OVERWRITE);
include($view);

/*
* manually writing validation branches is "deprecated" in this day and ages,
* frameworks like Laravel and such leverage this important process.
*/
<?php

require('./configs/config.php');
require('./configs/dbconnection.php');

require('./models/team.php');
require('./models/match.php');

use function Match\all as allMatches;
use function Team\all as allTeams;

define('MATCH_DATE', (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('F jS, Y'));

$connection = getConnection();
$teams = allTeams($connection);
$matches = allMatches($connection);

function initEmptyStatsArray()
{
	return [
		'games' => 0,
		'score' => 0,
		'wins' => 0,
		'losses' => 0,
		'draws' => 0,
		'GF' => 0,
		'GA' => 0,
		'GD' => 0,
	];
};

include('./views/vue.php');

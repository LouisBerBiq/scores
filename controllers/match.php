<?php
namespace Controllers\Match;

require('./models/match.php');
require('./models/team.php');

use function Models\Team\findByName as findTeamByName;
use function Models\Team\all as allTeams;
use function Models\Match\saveToDb as saveMatchToDb;

function store(\PDO $connection)
{
	$homeTeam = findTeamByName($connection, $_POST['home-team']);
	$awayTeam = findTeamByName($connection, $_POST['away-team']);
	$homeTeamGoals = $_POST['home-team-goals'];
	$awayTeamGoals = $_POST['away-team-goals'];

	$match = [
		'date' => $_POST['match-date'],
		'home-team' => $homeTeam->id,
		'home-team-goals' => $homeTeamGoals,
		'away-team-goals' => $awayTeam->id,
		'away-team' => $awayTeamGoals
	];
	saveMatchToDb($connection, $match);
	header('location: ./index.php');
	exit();
}

function create(\PDO $connection): array
{
	$teams = allTeams($connection);
	$view = './views/match/view.php';
	return compact('view', 'teams');
}
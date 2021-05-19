<?php
namespace Controllers\Team;

use function Models\Team\saveToDb as saveTeamToDb;

function store(\PDO $connection)
{
	//TODO turn home-team and away-team into generic team-name var
	$name = $_POST['team-name'];
	$slug = $_POST['team-slug'];

	$team = compact('name', 'slug');
	// var_dump($team); exit();

	saveTeamToDb($connection, $team);
	header('location: ./index.php');
	exit();
}
<?php
namespace Controllers;

use Models\Team;

class MatchClass
{
	function store(\PDO $connection)
	{
		$matchModel = new \Models\MatchClass();
		$teamModel = new Team();
		$homeTeam = $teamModel->findByName($connection, $_POST['home-team']);
		$awayTeam = $teamModel->findByName($connection, $_POST['away-team']);
		$homeTeamGoals = $_POST['home-team-goals'];
		$awayTeamGoals = $_POST['away-team-goals'];
	
		$match = [
			'date' => $_POST['match-date'],
			'home-team' => $homeTeam->id,
			'home-team-goals' => $homeTeamGoals,
			'away-team-goals' => $awayTeam->id,
			'away-team' => $awayTeamGoals
		];
		$matchModel->saveToDb($connection, $match);
		header('location: ./index.php');
		exit();
	}
	
	function create(\PDO $connection): array
	{
		$teamModel = new Team();
		$teams = $teamModel->all($connection);
		$view = './views/match/view.php';
		return compact('view', 'teams');
	}
}

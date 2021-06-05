<?php
namespace Controllers;

use Models\Team;

class MatchClass
{
	function store()
	{
		$matchModel = new \Models\MatchClass();
		$teamModel = new Team();
		$homeTeam = $teamModel->find('teams', 'name', $_POST['home-team']);
		$awayTeam = $teamModel->find('teams', 'name', $_POST['away-team']);
		$homeTeamGoals = $_POST['home-team-goals'];
		$awayTeamGoals = $_POST['away-team-goals'];
	
		$match = [
			'date' => $_POST['match-date'],
			'home-team' => $homeTeam->id,
			'home-team-goals' => $homeTeamGoals,
			'away-team-goals' => $awayTeam->id,
			'away-team' => $awayTeamGoals
		];
		$matchModel->saveToDb($match);
		header('location: ./index.php');
		exit();
	}
	
	function create(): array
	{
		$teamModel = new Team();
		$teams = $teamModel->all('teams');
		$view = './views/match/view.php';
		return compact('view', 'teams');
	}
}

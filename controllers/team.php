<?php
namespace Controllers;

class Team
{
	function store()
	{
		$teamModel = new \Models\Team();
	
		// validation
		$_SESSION['errors'] = [];
		$_SESSION['old'] = [];
	
		// I don't know if this is some stupid recent changed but '' is not considered empty anymore and it's annoying
		if (empty($_POST['team-name']) || trim(isset($_POST['team-name'])) === '') {
			$_SESSION['errors']['team-name'] = 'You have not provided a team name';
		}
		if (empty($_POST['team-slug']) || trim(isset($_POST['team-slug'])) === '') {
			$_SESSION['errors']['team-slug'] = 'You have not provided a slug';
		}
		// end of validation
		
		if (!$_SESSION['errors']) {
			$name = $_POST['team-name'];
			$slug = $_POST['team-slug'];
			$team = compact('name', 'slug');
			$teamModel->saveToDb($team);
			header('location: ./index.php');
			exit();
		}
		$_SESSION['old']['team-name'] = $_POST['team-name'];
		$_SESSION['old']['team-slug'] = $_POST['team-slug'];
		header('location: ./index.php?action=create&resource=team');
		exit();
	}
	
	function create()
	{
		$view = './views/team/view.php';
		return compact('view');
	}
}
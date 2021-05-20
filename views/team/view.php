<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>
	  Create a team
	</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
  </head>
  <body>
	<?php include('./views/parts/banner.php') ?>
	<h1>Create a team</h1>
	<form action="index.php" method="POST">
	<div>
		<label for="name">New team name</label>
		<input type="text" id="name" name="team-name" required></input>
	</div>
	<div>
		<label for="slug">New team slug (3 chars)</label>
		<input type="text" id="slug" name="team-slug"></input>
	</div>
		<input type="hidden" name="action" value="store"></input>
		<input type="hidden" name="resource" value="team"></input>
		<input type="submit" value="Register a new team"></input>
	</form>
  </body>
</html>
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
	<h1>Encodage d’un nouveau match</h1>
	<form action="index.php" method="post">
		<label for="match-date">Date du match</label>
		<input type="text" id="match-date" name="match-date" placeholder="2020-04-27">
		<br>
		<label for="home-team">Équipe à domicile</label>
		<select name="home-team" id="home-team">
			<?php foreach($teams as $team): ?>
				<option value=<?= $team->name?>><?= $team->name ?></option>
			<?php endforeach; ?>
		</select>
		<br>
		<label for="home-team-goals">Goals de l’équipe à domicile</label>
		<input type="text" id="home-team-goals" name="home-team-goals">
		<br>
		<label for="away-team">Équipe visiteuse</label>
		<select name="away-team" id="away-team">
			<?php foreach($teams as $team): ?>
				<option value=<?= $team->name?>><?= $team->name ?></option>
			<?php endforeach; ?>
		</select>
		<br>
		<label for="away-team-goals">Goals de l’équipe visiteuse</label>
		<input type="text" id="away-team-goals" name="away-team-goals">
		<br>
		<input type="hidden" name="action" value="store">
		<input type="hidden" name="resource" value="match">
		<input type="submit" value="Ajouter ce match">
	</form>
  </body>
</html>

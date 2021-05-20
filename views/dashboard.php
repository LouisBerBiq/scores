<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Premier League 2020</title>
</head>

<body>
	<?php include('./views/parts/banner.php') ?>
	<?php include('./views/parts/navigation.php') ?>
	<?php if($standing): ?>
	<section>
		<h2>Standings</h2>
		<table>
			<thead>
				<tr>
					<td></td>
					<th scope="col">Team</th>
					<th scope="col">Games</th>
					<th scope="col">Points</th>
					<th scope="col">Wins</th>
					<th scope="col">Losses</th>
					<th scope="col">Draws</th>
					<th scope="col">GF</th>
					<th scope="col">GA</th>
					<th scope="col">GD</th>
				</tr>
			</thead>
			<tbody>
			<?php $i = 1 ?>
			<?php foreach($standing as $team => $teamStats): ?>
				<tr>
					<td><?php $i++ ?></td>
					<th scope="row"><?= $team ?></th>
					<td><?= $teamStats['games'] ?></td>
					<td><?= $teamStats['score'] ?></td>
					<td><?= $teamStats['wins'] ?></td>
					<td><?= $teamStats['losses'] ?></td>
					<td><?= $teamStats['draws'] ?></td>
					<td><?= $teamStats['GF'] ?></td>
					<td><?= $teamStats['GA'] ?></td>
					<td><?= $teamStats['GD'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</section>
	<?php endif; ?>
	<?php if($matches): ?>
</body>
<section>
		<h2>Games played as of <?= MATCH_DATE ?></h2>
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Home Team</th>
					<th>Home Team Goals</th>
					<th>Away Team Goals</th>
					<th>Away Team</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($matches as $match) : ?>
					<tr>
						<td><?= (new DateTime($match->match_date, new DateTimeZone('Europe/Brussels')))->format('F jS, Y') ?></td>
						<td><?= $match->home_team ?></td>
						<td><?= $match->home_team_goals ?></td>
						<td><?= $match->away_team_goals ?></td>
						<td><?= $match->away_team ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</section>
	<?php else: ?>
		<p>There's nothing to display yet.</p>
	<?php endif; ?>
</html>
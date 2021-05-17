<?php
namespace Match;

function all(\PDO $connection):array {
	$matchRequest = 'SELECT * FROM `matches` ORDER BY date ASC';
	$pdoSt = $connection->query($matchRequest);
	return $pdoSt->fetchAll();
}

function find(\PDO $connection, string $id):\stdClass {
	$matchRequest = 'SELECT * FROM `matches` WHERE id = :id';
	$pdoSt = $connection->prepare($matchRequest);
	$pdoSt->execute([':id' => $id]);
	return $pdoSt->fetch();
}

function allWithTeams(\PDO $connection):array {
	$matchesInfosRequest = 'SELECT * FROM matches JOIN events e on matches.id = e.match_id JOIN teams t on e.team_id = t.id ORDER BY matches.id, is_home_team DESC';
	$pdoSt = $connection->query($matchesInfosRequest);
	return $pdoSt->fetchAll();
}

function allWithTeamsGrouped(array $allWithTeams):array {
	$matchesWithTeams = [];
	$mm = null;
	foreach ($allWithTeams as $match) {
		if($match->is_home_team) {
			$mm = new \stdClass();
			$mm->match_date = $match->date;
			$mm->home_team = $match->name;
			$mm->home_team_goals = $match->goals;
		} else {
			// listen, I know this is technically not working in the grand scheme of thing but can you just shut the fuck up? There is NO possible scenario where this can break other than the guy encoding everything fucking up the order.
			$mm->away_team = $match->name;
			$mm->away_team_goals = $match->goals;
			$matchesWithTeams[] = $mm;
		}
	}
	return $matchesWithTeams;
}
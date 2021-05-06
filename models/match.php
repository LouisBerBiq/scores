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
	$matchesInfosRequest = 'SELECT * FROM `matches` JOIN `events` e  ON matches.id = e.match_id JOIN teams t ON e.team_id = t.id ORDER BY matches.id;';
	$pdoSt = $connection->query($matchesInfosRequest);
	return $pdoSt->fetchAll();
}
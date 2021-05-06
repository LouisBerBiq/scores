<?php
namespace Team;

function all(\PDO $connection):array {
	$teamRequest = 'SELECT * FROM `teams` ORDER BY name ASC';
	$pdoSt = $connection->query($teamRequest);
	return $pdoSt->fetchAll();
}

function find(\PDO $connection, string $id):\stdClass {
	$teamRequest = 'SELECT * FROM `teams` WHERE id = :id';
	$pdoSt = $connection->prepare($teamRequest);
	$pdoSt->execute([':id' => $id]);
	return $pdoSt->fetch();
}
<?php
namespace Team;

function all(\PDO $connection):array {
	$teamRequest = 'SELECT * FROM `teams` ORDER BY name ASC';
	$pdoSt = $connection->query($teamRequest);
	return $pdoSt->fetchAll();
}

function findById(\PDO $connection, string $id):\stdClass {
	$teamRequest = 'SELECT * FROM `teams` WHERE id = :id';
	$pdoSt = $connection->prepare($teamRequest);
	$pdoSt->execute([':id' => $id]);
	return $pdoSt->fetch();
}

function findByName(\PDO $connection, string $name):\stdClass {
	$teamRequest = 'SELECT * FROM `teams` WHERE name = :name';
	$pdoSt = $connection->prepare($teamRequest);
	$pdoSt->execute([':name' => $name]);
	return $pdoSt->fetch();
}

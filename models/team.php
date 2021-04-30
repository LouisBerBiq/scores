<?php
function allTeams(PDO $connection):array {
	$teamRequest = 'SELECT * FROM teams ORDER BY name ASC';
	$pdoSt = $connection->query($teamRequest); 
	//this is a "PDO statement"
 
	return $pdoSt->fetchAll(); //$users
}

function findTeam(PDO $connection, string $id):stdClass {
	$teamRequest = 'SELECT * FROM teams WHERE id = :id';
	$pdoSt = $connection->prepare($teamRequest);
	$pdoSt->execute([':id' => $id]);

	return $pdoSt->fetch(); //$user
}
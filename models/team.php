<?php
namespace Models;

class Team extends Model
{
	function all(): array
	{
		$teamRequest = 'SELECT * FROM `teams` ORDER BY name ASC';
		$pdoSt = $this->connection->query($teamRequest);
		return $pdoSt->fetchAll();
	}
	
	function findById(string $id): \stdClass
	{
		$teamRequest = 'SELECT * FROM `teams` WHERE id = :id';
		$pdoSt = $this->connection->prepare($teamRequest);
		$pdoSt->execute([':id' => $id]);
		return $pdoSt->fetch();
	}
	
	function findByName(string $name): \stdClass
	{
		$teamRequest = 'SELECT * FROM `teams` WHERE name = :name';
		$pdoSt = $this->connection->prepare($teamRequest);
		$pdoSt->execute([':name' => $name]);
		return $pdoSt->fetch();
	}
	
	function saveToDb(array $team)
	{
		$teamRequestToInsert = 'INSERT INTO teams(`name`, `slug`) VALUES (:team_name, :team_slug)';
		$pdoSt = $this->connection->prepare($teamRequestToInsert);
		$pdoSt->execute([
			':team_name' => $team['name'],
			':team_slug' => $team['slug'],
		]);
	}
}

<?php
namespace Models;

class Model
{
	protected $connection;
	
	public function __construct()
	{
		try {
			$pdo = new \PDO('mysql:host=localhost; dbname=scores', 'root', '');

			$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			exit($e->getMessage());
		}

		$this->connection = $pdo;
	}
}
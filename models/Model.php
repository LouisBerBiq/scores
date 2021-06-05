<?php
namespace Models;

$table = null;
$key = null;

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

	public function find(string $table, string $key, string $value): \stdClass
	{
		// string ... $keys
		// foreach ($keys as $key ) {
		// 	$key = $key . ' = :' . $key;
		// 	var_dump($key);
		// }
		// exit();
		$request = 'SELECT * FROM ' . $table .' WHERE ' . $key . ' = :' . $key;
		$pdoSt = $this->connection->prepare($request);
		$pdoSt->execute([':' . $key => $value]);
		return $pdoSt->fetch();
	}

	public function all(string $table): array
	{
		$request = 'SELECT * FROM ' . $table . ' ORDER BY name ASC';
		$pdoSt = $this->connection->query($request);
		return $pdoSt->fetchAll();
	}

	public function saveToDb(string $table, array $values)
	{
		$keys = array_keys($values);

		$request = 'INSERT INTO ' . $table . '(`';
		foreach ($keys as $key) {
			$request = $request . $key . '`, `';
		}
		$request = substr($request, 0, -3);
		$request = $request . ') VALUES (';
		foreach ($keys as $key) {
			$request = $request . ':' . $key . ', ';
		}
		$request = substr($request, 0, -2);
		$request = $request . ');';

		$pdoSt = $this->connection->prepare($request);
		foreach ($keys as $key) {
			$requestKeys[]	= ':' . $key;
		}
		$execute = array_combine($requestKeys, $values);
		$pdoSt->execute($execute);
	}
}
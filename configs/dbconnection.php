<?php

function getConnection():PDO {
	try {
		$connection = new PDO('mysql:host=SERVER_NAME; dbname=scores', 'root', 'admin');

		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	} catch (PDOException $e) {
		exit($e->getMessage());
	}

	return $connection;
}
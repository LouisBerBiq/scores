<?php
namespace Models;

class User extends Model
{
	public function findByEmail(string $email): \stdClass
	{
		$userRequest = 'SELECT * FROM `users` WHERE email = :email';
		$pdoSt = $this->connection->prepare($userRequest);
		$pdoSt->execute([':email' => $email]);
		return $pdoSt->fetch();
	}
}
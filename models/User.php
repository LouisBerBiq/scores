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
	public function saveToDb(array $user)
	{
		$userRequestToInsert = 'INSERT INTO users(`email`, `name`, `password`) VALUES (:user_email, :user_name, :user_password)';
		$pdoSt = $this->connection->prepare($userRequestToInsert);
		$pdoSt->execute([
			':user_email' => $user['email'],
			':user_name' => $user['name'],
			':user_password' => $user['password'],
		]);
	}
}
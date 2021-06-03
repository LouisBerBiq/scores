<?php
namespace controllers;

class Login
{
	public function create() 
	{
		$view = './views/login/create.php';
		return compact('view');
	}
	public function check()
	{
		//TODO: validation

		$userModel = new \Models\User();

		$email = $_POST['user-email'];
		$password = $_POST['user-password'];

		$user = $userModel->findByEmail($email);
		if (password_verify($password, $user->password)) {
			header('location: ./index.php');
		} else {
			header('location: ./index.php?action=show&resource=login');
		}
		exit();
	}
}
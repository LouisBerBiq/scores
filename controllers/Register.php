<?php
namespace Controllers;

class Register
{
	public function create() 
	{
		$view = './views/register/create.php';
		return compact('view');
	}
	public function store()
	{
		$userModel = new \Models\User();
		
		$email = $_POST['user-email'];
		$name = $_POST['user-name'];
		$password = $_POST['user-password'];
		
		$this->validation($email, $name, $password);

		if (!$_SESSION['errors']) {
			$password = password_hash($password, PASSWORD_BCRYPT);
			$user = compact('email', 'name', 'password');
			$userModel->saveToDb('users', $user);
			header('location: ./index.php');
			exit();
		} else {
			header('location: ./index.php?action=show&resource=register');
		}
		$_SESSION['old']['user-email'] = $_POST['user-email'];
		$_SESSION['old']['user-name'] = $_POST['user-name'];
		$_SESSION['old']['user-password'] = $_POST['user-password'];
		exit();
	}
	private function validation($email, $name, $password)
	{
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['errors']['user-email'] = 'your email is not correct';
		}
		if (!($password == $_POST['user-comfirm_password'])) {
			$_SESSION['errors']['user-password'] = 'your password doesn\'t match up';
		}
	}
}
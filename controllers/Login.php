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
		$userModel = new \Models\User();
		
		$email = $_POST['user-email'];
		$password = $_POST['user-password'];

		$this->filterEmail($email);

		if (!$_SESSION['errors']) {
			$user = $userModel->findByEmail($email);
			if (password_verify($password, $user->password)) {
				$_SESSION['user'] = $user;
				header('location: ./index.php');
			} else {
				header('location: ./index.php?action=show&resource=login');
			}
		} 
		exit();
	}
	public function delete()
	{
		// will use this if there are more data to the session than errors and user
		// unset($_SESSION['user']);
		// otherwise, we're just using this written exemple from https://www.php.net/manual/en/function.session-destroy.php
		
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		// Finally, destroy the session.
		session_destroy();

		header('location: ./index.php');
		exit();
	}
	private function filterEmail($var)
	{
		if (filter_var($var, FILTER_SANITIZE_EMAIL)) {
			if (filter_var($var, FILTER_VALIDATE_EMAIL)) {
				return;
			} 
		}
		$_SESSION['errors']['user-email'] = 'your email is not correct';
	}
}
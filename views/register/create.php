<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>
	  Create an account
	</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
  </head>
  <body>
	<?php include('./views/parts/banner.php') ?>
	<h1>Create an account</h1>
	<form action="index.php" method="POST">
	<div>
		<label for="email">your e-mail</label>
		<input type="text" id="email" email="user-email" value="<?= !empty($_SESSION['old'])?$_SESSION['old']['user-email']:'' ?>"></input>
	</div>
	<div>
		<label for="name">your username</label>
		<input type="text" id="name" name="user-name" value="<?= !empty($_SESSION['old'])?$_SESSION['old']['user-name']:'' ?>"></input>
	</div>
	<div>
		<label for="password">password (8 characters, 1 capital and 1 number)</label>
		<input type="password" id="password" name="user-password" value="<?= !empty($_SESSION['old'])?$_SESSION['old']['user-password']:'' ?>"></input>
	</div>
	<div>
		<label for="comfirm_password">comfirm password</label>
		<input type="password" id="comfirm_password" name="user-comfirm_password" value="<?= !empty($_SESSION['old'])?$_SESSION['old']['user-comfirm_password']:'' ?>"></input>
	</div>
		<input type="hidden" name="action" value="store"></input>
		<input type="hidden" name="resource" value="user"></input>
		<input type="submit" value="Register"></input>
	</form>
	<?php include('./views/parts/errors.php') ?>
  </body>
</html>
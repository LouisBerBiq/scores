<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>
	  Authentificate yourself
	</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
  </head>
  <body>
	<?php include('./views/parts/banner.php') ?>
	<h1>Authentificate yourself</h1>
	<form action="index.php" method="POST">
	<div>
		<label for="email">your e-mail</label>
		<input type="text" id="email" name="user-email" value="<?= !empty($_SESSION['old'])?$_SESSION['old']['user-email']:'' ?>"></input>
	</div>
	<div>
		<label for="password">password</label>
		<input type="text" id="password" name="user-password" value="<?= !empty($_SESSION['old'])?$_SESSION['old']['user-password']:'' ?>"></input>
	</div>
		<input type="hidden" name="action" value="check"></input>
		<input type="hidden" name="resource" value="login"></input>
		<input type="submit" value="Authentify"></input>
	</form>
	<?php include('./views/parts/errors.php') ?>
  </body>
</html>
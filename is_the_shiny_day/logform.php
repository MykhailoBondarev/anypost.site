<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Авторизація</title>
</head>
<body>
	<form action="" method="POST">
		<label for="login">Логін:</label><br>
		<input type="text" name="login"><br>
		<label for="pass">Пароль:</label><br>
		<input type="password" name="pass"><br>
		<input type="hidden" name="action" value="login"> 
		<button type="submit">Вхід</button>
	</form>
	<?php 
		echo $loginError; 
		echo $error;
	?>
</body>
</html>
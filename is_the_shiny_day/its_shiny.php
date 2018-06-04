<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Адмін панель</title>
</head>
<body>
	<h3>Адмін панель</h3>
	<div>
		<div><form action="" method="POST"><input type="hidden" name="action" value="logout"><button type="submit">Вийти</button></form></div>
		<?php var_dump($_SESSION) ?>
	</div>
</body>
</html>
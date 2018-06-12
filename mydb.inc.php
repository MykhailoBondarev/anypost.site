<?php 
try
{
	$GLOBALS['pdo'] = new PDO('mysql:host=localhost;dbname=poststream', 'poststream',
 'k6PUeSw0FUMzCc9g');
	$GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$GLOBALS['pdo']->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
	$error = 'Неможливо під\'єднатися до сервера баз даних'.$e -> getMessage();
	include 'error.php';
	exit();
}
?>
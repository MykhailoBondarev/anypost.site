<?php 
try
{
	$GLOBALS['pdo'] = new PDO('mysql:host=localhost;dbname=wp_mysite.ua', 'wp',
 '123');
	$GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$GLOBALS['pdo']->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
	$error = 'Неможливо під\'єднатися до сервера баз даних';
	include 'error.php';
	exit();
}
?>
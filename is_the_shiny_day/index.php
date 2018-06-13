<?php 
$GLOBALS['pageTitle']='Авторизація';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';

if (isset($_SESSION['LogedIn']))
{	
 	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/your_welcome.php';
}
else
{	
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/logform.php';	
	LogIn($_POST['login'], $_POST['pass'], $_POST['action']);
}

?>
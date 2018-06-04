<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/myfunctions.inc.php';
session_start();
LogIn($_POST['login'], $_POST['pass'], $_POST['action']);
if (isset($_POST['action'])&&$_POST['action']=='logout')
{
	LogOut();
}

// if (isset($_COOKIE))
// {
// 	$sessAuth=$_COOKIE['PHPSESSID'];	
// }

if (isset($_SESSION['LogedIn'])&&$_SESSION['LogedIn']=TRUE)
{	
 	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/your_welcome.php';
}
else
{		
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/logform.php';	
}

?>
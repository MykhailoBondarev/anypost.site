<?php 
include '../db.php';

if(!isset($_SESSION))
{	
	if ($_POST['login']!='' && $_POST['pass']!='')
	{
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		// SELECT FROM wp_user WHERE login=$login AND password=$pass;		
		// session_start();
		// then $_SESSION['loggedIn'] = TRUE;
	}
	else
	{
		echo 'Поля логін та пароль мають бути заповнені!';
	}
    include '/logform.php';
}
else
{


}

?>
<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/myfunctions.inc.php';
if(isset($_GET['delpost'])|| isset($_POST['method-type'])||isset($_POST['action']))
{
	redirectHeader();
}
session_start(); 
if (isset($_POST['action'])&&$_POST['action']=='logout')
{
	LogOut();
}
if (isset($_SESSION['LogedIn']))
{
	$adminTitle='Адмін панель';
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $pageTitle.'::'.$adminTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="/styles.css"> 
</head>
<body>
	<?php 
		if ($_SESSION['LogedIn'])
		{ 
	 ?>
	<div class="admin-panel">		
		<h3><a href="<?php echo '/is_the_shiny_day' ?>">Адмін панель</a></h3>	
		<div><?php echo 'Привіт, '.$_SESSION['Login'].'!'; ?></div>
		<div>
			<form action="" method="POST"><input type="hidden" name="action" value="logout"><button type="submit">Вийти</button></form>
		</div>	
	</div>
<?php 
		}
?>
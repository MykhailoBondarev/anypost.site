<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Адмін панель</title>
	<link rel="stylesheet" type="text/css" href="<?php $_SERVER['DOCUMENT_ROOT'] ?> /styles.css"> 
</head>
<body>
	<div class="admin-panel">		
		<h3><a href="<?php echo '/is_the_shiny_day' ?>">Адмін панель</a></h3>	
		<div><?php echo 'Привіт, '.$_SESSION['Login'].'!'; ?></div>
		<div>
			<form action="" method="POST"><input type="hidden" name="action" value="logout"><button type="submit">Вийти</button></form>
		</div>	
	</div>
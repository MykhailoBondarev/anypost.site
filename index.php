<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/myfunctions.inc.php';

if (isset($_GET['delpost']))
{
	$post_id=$_POST['delpost'];	
	// To continue cookie`s life for 1 year
	$expiryTime = time() + 3600 * 24 * 365;
	// To delete cookie set expiryTime to -1 year
	// $expiryTime = time() - 3600 * 24 * 365;
	setcookie('delpost', $post_id, $expiryTime);
}

if (isset($_GET['addpost'])) 
{
	include  $_SERVER['DOCUMENT_ROOT'].'/addpost.php';
	exit;
}

include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php';

if(isset($post_id))
{
	try
	{
		$sql = 'DELETE FROM wp_posts WHERE ID=:post_id';
		$delete_sql = $pdo -> prepare($sql);
		$delete_sql->bindValue(':post_id', $post_id);
		$delete_sql->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Помилка при видаленні поста: ' . $e->getMessage();
		include 'error.php';
		exit;
	}
	header('Location: .');
	exit;
}

if (isset($_POST['post-title'])&&isset($_POST['post-text']))
{
	try
	{
		$sql = 'INSERT INTO wp_posts SET
		post_date = NOW(),
		post_title = :post_title,
		post_text = :post_text';
		$insert_sql = $pdo -> prepare($sql);
		$insert_sql->bindValue(':post_title', $_POST['post-title']);
		$insert_sql->bindValue(':post_text', $_POST['post-text']);
		$insert_sql->execute();		
	}
	catch (PDOException $e)
	{
		$error = 'Помилка при додаванні поста: '. $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/error.php';
		exit;
	}
	header('Location: .');
	exit;
}

try
{
 	$sql = 'SELECT * FROM wp_posts ORDER BY post_date DESC';
 	$result = $pdo->query($sql);
 	
}
catch (PDOException $e)
{
	$error = 'Помилка при отриманні даних: ' . $e->getMessage();
	echo $error;
	include 'error.php';
 	exit();
}

	$title_id=0;
	while ($row = $result->fetch())
	{		
 	 	$posts_data[] = $row; 
 		++$title_id; 	
	}

 include $_SERVER['DOCUMENT_ROOT'].'/postspage.php';
 // var_dump($_SERVER);
 // echo $_SERVER['DOCUMENT_ROOT'];  
 $qwer=array();
 var_dump($qwer);
 $qwe='3213';
 echo "От і число: {$qwe}";
 $qwer= array('qa' => '12', 'ew' => 'qad', 'ewr' => '34.5');
 foreach($qwer as $qwe)
 {  
 	echo "<p>this {$qwe}</p>";
 }

 echo 'Post id='.$_COOKIE['delpost'].' has been deleted ';
 echo $_SERVER['HTTP_REFERER'];
 
 // var_dump($_SERVER);
 ?>


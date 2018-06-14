<?php
$GLOBALS['pageTitle']='Головна сторінка';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';
// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';

if (isset($_GET['delpost']))
{
	$post_id=$_POST['delpost'];	
	// To continue cookie`s life for 1 year
	$expiryTime = time() + 3600 * 24 * 365;
	// To delete cookie set expiryTime to -1 year
	// $expiryTime = time() - 3600 * 24 * 365;
	setcookie('delpost', $post_id, $expiryTime);
}

if (isset($_GET['addpost'])||isset($_GET['editpost'])) 
{	
	if(isset($_GET['editpost']))
	{
		$CurrentPost = ObjectSelect($_POST['editpost'],'posts');		
	}
	include  $_SERVER['DOCUMENT_ROOT'].'/addpost.php';
	exit;
}	

include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php';

if(isset($post_id))
{
	try
	{
		$sql = 'DELETE FROM posts WHERE id=:post_id';
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
	exit;
}

if (isset($_POST['method-type'])&&isset($_POST['post-title'])&&isset($_POST['post-text'])
&&$_POST['post-title']!=''&&$_POST['post-text']!=''&&$_POST['cancel']!=1) 
{
	if ($_POST['method-type']==0)
	{
		try
		{
			$sql = 'INSERT INTO posts SET
			post_date = NOW(),
			title = :post_title,
			text = :post_text,
			author = :authorid';
			$insert_sql = $pdo -> prepare($sql);
			$insert_sql->bindValue(':post_title', $_POST['post-title']);
			$insert_sql->bindValue(':post_text', $_POST['post-text']);
			$insert_sql->bindValue(':authorid', $_SESSION['LogedIn']);
			$insert_sql->execute();		
		}
		catch (PDOException $e)
		{
			$error = 'Помилка при додаванні поста: '. $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/error.php';
			exit;
		}
		exit;
	} 
	elseif($_POST['method-type']==1)	
	{
		try
		{
			$sql = 'UPDATE posts SET 
			post_date = NOW(), 
			title = :post_title,
			text = :post_text WHERE id=:post_id';
			$requestObj = $pdo -> prepare($sql);
			$requestObj -> bindValue(':post_id', $_POST['post-id']);
			$requestObj -> bindValue(':post_title', $_POST['post-title']);
			$requestObj -> bindValue(':post_text', $_POST['post-text']);
			$requestObj -> execute();
		}
		catch (PDOException $e)
		{
			$error = 'Помилка при оновленні поста: '. $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/error.php';
			exit;		
		}	
		exit;
	}
}

try
{
 	$sql = 'SELECT posts.*, users.name, users.email FROM posts LEFT JOIN users
 	ON posts.author=users.id ORDER BY post_date DESC';
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

 echo "<details>
 	<summary>От воно що!</summary><pre>";
var_dump($qwer); 
 echo "От і число: {$qwe}";
 $qwer= array('qa' => '12', 'ew' => 'qad', 'ewr' => '34.5');
 foreach($qwer as $qwe)
 {  
 	echo "<p>this {$qwe}</p>";
 }
 echo "</pre></details>";
 if (isset($_COOKIE['delpost'])) {
 	echo 'Post id='.$_COOKIE['delpost'].' has been deleted ';
	echo $_SERVER['HTTP_REFERER'];
}
include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
 ?>
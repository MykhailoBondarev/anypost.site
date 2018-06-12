<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Додати пост</title>
</head>
<?php 
		$postTitle='';
		$postText='';
		if (isset($_GET['addpost'])) 
		{
			$buttonCaption = 'Додати пост';	
			$methodType = 0;		
		}
		else
		{
			$buttonCaption = 'Зберегти зміни';
			$postTitle=$CurrentPost['post_title'];
			$postText=$CurrentPost['post_text'];
			$post_id=$_POST['editpost'];
			$methodType = 1;	
		}	
?>  
<body>
	<form action="?" method="post">
		<input type="hidden" name="post-id" value="<?php echo $post_id; ?>">
		<input type="hidden" name="method-type" value="<?php echo $methodType; ?>">
		<div>
			<label for="post-title">Введіть назву поста:</label>
			<input type="text" name="post-title" value="<?php echo $postTitle ?>">
		</div>
		<div>
			<label for="post-text">Введіть текст поста:</label>
			<textarea name="post-text" id="p-text" style="width: 40%; height: 200px;" ><?php echo $postText; ?></textarea>
		</div>		
		 <button> <?php echo $buttonCaption; ?> </button>
		 <button name="cancel" value="1">Скасувати</button>
	</form>
	NO type="submit"
	type="reset" 
</body>
</html>
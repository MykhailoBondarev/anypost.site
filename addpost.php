<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Додати пост</title>
</head>
<?php 
		$postTitle='';
		$postText='';
		$Categories = ObjectList('categories');		
		if (isset($_POST['addpost'])) 
		{
			$buttonCaption = 'Додати пост';	
			$post_id=$_POST['addpost'];			
		}
		else
		{
			$CurrentPost = ObjectSelect($_POST['editpost'], 'posts');
			$buttonCaption = 'Зберегти зміни';
			$postTitle=$CurrentPost['title'];
			$postText=$CurrentPost['text'];
			$postCategory=$CurrentPost['category'];
			$post_id=$_POST['editpost'];			
		}	
?>  
	<form action="?" method="post">
		<input type="hidden" name="method-type" value="<?php echo $post_id; ?>">
		<div>
			<!-- <label for="post-title">Введіть назву поста:</label> -->
			<input type="text" name="post-title" placeholder="Введіть назву поста:" value="<?php echo $postTitle ?>">
		</div>
		<div>
			<!-- <label for="post-text">Введіть текст поста:</label> -->
			<textarea name="post-text" placeholder="Введіть текст поста:" id="p-text"><?php echo $postText; ?></textarea>
		</div>
		<div>
			<label for="category">Оберіть категорію, до якої належить пост:</label>
			<select name="category">	<!-- multiple size="3" -->					
						<option value="0">Без категорії</option>
						<?php 
							if ($Categories!='')
							{
								foreach ($Categories as $Category)
								{ 
									if ($Category['id'] == $CurrentPost['category'])
									{
										$isSelected='selected';	
									}	
									else
									{
										$isSelected='';
									}
									?>
									<option value="<?php echo $Category['id']; ?>" <?php echo $isSelected; ?>><?php echo $Category['name']; ?></option>
					<?php
								}
							}
						 ?>
			</select>
		</div>	
		<div>
		 <button> <?php echo $buttonCaption; ?> </button>
		 <button name="cancel" value="1">Скасувати</button>				
		</div>	
	</form>
	NO type="submit"
	type="reset" 
<!-- </body>
</html>
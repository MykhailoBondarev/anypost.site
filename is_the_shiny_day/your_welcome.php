<?php 
if ($_SESSION['LogedIn']!='')
{ 
 include $_SERVER['DOCUMENT_ROOT'].'/header.php';
	?>
		<div class="main-block">
			<input type="radio" checked="checked" id="users" name="lists">
			<label for="users">Користувачі</label>		
			<input type="radio" id="posts" name="lists">	
			<label for="posts">Пости</label>
			<input type="radio" id="category" name="lists">
			<label for="category">Категорії</label>			
			<div class="users-box"><?php include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/users.php'; ?></div>
			<div><?php //include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/posts.php'; ?></div>
			<div><?php  //include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/category.php'; ?></div>
		</div>		
	</div>
</body>
</html>
<?php 
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';
}
 ?>
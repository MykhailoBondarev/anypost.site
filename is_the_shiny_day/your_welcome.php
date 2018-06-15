<?php 
if ($_SESSION['LogedIn'])
{ 
	?>
		<div class="main-block">
			<input type="radio" checked="checked" id="users" name="lists">			
			<label for="users" id="users">
			<input type="hidden" name="users-tab" value="1">
			<span>Користувачі</span>
			<span><?php echo CountObjects('users'); ?></span>	
			</label>			
			<input type="radio" id="posts" name="lists">			
			<label for="posts" id="posts">
			<input type="hidden" name="posts-tab" value="">	
			<span>Пости</span>	
			<span><?php echo CountObjects('posts'); ?></span>	
			</label>
			<input type="radio" id="category" name="lists">
			<input type="hidden" name="categories-tab" value="">
			<label for="category" id="categories">
			<span>Категорії</span>
			<span><?php echo CountObjects('categories'); ?></span>	
			</label>			
			<div class="objects-box"><?php include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/users.php'; ?></div>
			<div class="objects-box"><?php include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/posts.php'; ?></div>
			<div class="objects-box"><?php  //include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/category.php'; ?></div>
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
include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
 ?>
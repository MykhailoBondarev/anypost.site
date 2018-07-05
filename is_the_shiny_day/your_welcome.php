<?php 
if ($_SESSION['LogedIn'])
{ 
	$quantityUsers = CountObjects('users');
	$quantityPosts = CountObjects('posts');
	$quantityCategories = CountObjects('categories');
	if (isset($_POST['tab']))
	{
		$_SESSION['tab'] = $_POST['tab'];
	}
	if (isset($_SESSION['tab']))
	{
		$activeTab=array();
		$countTab=0;
		while ($countTab <= $_SESSION['tab'])
		{
			if ($_SESSION['tab']==$countTab)
			{
				$activeTab[$countTab]='active-tab';	
				break;			 	
			} 
			$countTab++;
		}	
	}
	?>
		<form class="main-block" action="" method="post">
			<button class="<?php echo $activeTab[1]; ?>" type="radio" name="tab" value="1">	
			<span>Користувачі</span>
			<span><?php echo $quantityUsers; ?></span>	
			</button>
			<button class="<?php echo $activeTab[2]; ?>" type="radio" name="tab" value="2">	
			<span>Пости</span>	
			<span><?php echo $quantityPosts; ?></span>	
			</button>
			<button class="<?php echo $activeTab[3]; ?>" type="radio" name="tab" value="3">
			<span>Категорії</span>
			<span><?php echo $quantityCategories; ?></span>	
			</button>
		</form>				
				<?php 
					if ($_SESSION['tab']==1)
					{ ?>
						<div class="objects-box">
							<?php include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/users.php';  ?>
						</div>
				<?php 	}
					if ($_SESSION['tab']==2)
					{ ?>	
						<div class="objects-box">
						<?php include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/posts.php';  ?>
						</div>	
					<?php } 
					if ($_SESSION['tab']==3)
					{	?>
						<div class="objects-box">
						<?php include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/category.php';  ?>
						</div>
				<?php	}
				?>					
			
		
	<!-- </div> -->
<!-- </body>
</html> -->
<?php 
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';
}
include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
 ?>
<?php 
if ($_SESSION['LogedIn'])
{ 	
 ?>
 <form action="" method="post">
 	<button name="add-category" value="true">Додати категорію</button>
 </form>
 <div class="<?php echo $errorClass; ?>"><?php echo $error; ?></div>
<div class="object-box">
	<?php 
		if (isset($_POST['cancel'])&&$_POST['cancel']==1)
		{
			$_POST['add-category']=false;
		}
		if (isset($_POST['method']))	
		{
			if(isset($_POST['category-name'])&&isset($_POST['category-description'])&&isset($_POST['method'])&&$_POST['category-name']!=''&&$_POST['category-description']!=''&&$_POST['parent-category']!=''&&$_POST['cancel']!=1)
			{
				if ($_POST['method']==0)
				{
					AddCategory($_POST['category-name'], $_POST['parent-category'], $_POST['category-description']);											
				}
				if ($_POST['method']==1)
				{
					EditCategory($_POST['category-id'], $_POST['category-name'], $_POST['parent-category'], $_POST['category-description']);					
				}	
				if (!$GLOBALS['ok'])
				{
					$GLOBALS['errorClass'] = 'error';	
				}					
			} 
			else
			{	if ($_POST['method']==0)
				{
					$_POST['add-category']=true;
				}
				else
				{
					$_POST['edit-category']=true;
				}				
				$GLOBALS['error'] = 'Не всі обов\'язкові поля заповнені!';
				$GLOBALS['errorClass'] = 'error';						
			}
		}
		if ($_POST['add-category']||$_POST['edit-category'])
		{
			include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/addcategory.php';
		}
		else
		{   
			echo '<pre>';
			print_r(MakeCategoriesArray());
			echo '</pre>'; 
			ViewCategories(MakeCategoriesArray());
			if ($noneCat!='')
			{
				echo $noneCat;
			}			
		}
	 ?>
</div>
<?php 
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';
}
 ?>
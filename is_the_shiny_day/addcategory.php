<?php 
$methodType='';
$categoryName='';
$categoryDescription='';
$parentCategory='';
if (isset($_POST['add-category'])) 
{
	$methodType=0;
	$submitButton='Створити категорію';

}
else
{
	$methodType=1;
	$submitButton='Зберегти категорію';
	$categoryName=$_POST['category-name'];
	$categoryDescription=$_POST['category-description'];
	$parentId=$_POST['parent-Id'];
	$CurrentCategoryId=$_POST['edit-category'];
}

 ?>
	<form action="?" method="post">	
		<div class="<?php echo $errorClass; ?>"><?php echo $error; ?></div>
		<div>		
			<input type="hidden" name="method" value="<?php echo $methodType; ?>">
			<input type="hidden" name="category-id" value="<?php echo $CurrentCategoryId; ?>">
			<input type="text" name="category-name" placeholder="Введіть назву категорії" value="<?php echo $categoryName; ?>">
		</div>
		<div>
			<textarea name="category-description" placeholder="Опишіть детальніше категорію"><?php echo $categoryDescription;  ?></textarea>
		</div>
		<div>
			<label for="parent-category">Оберіть батьківську категорію:</label>
			<select name="parent-category">				
				<option value="0">Немає</option>
				<?php
				 $CategoriesList=ObjectList('categories');
				 if ($CategoriesList!='')
				 {
					 	foreach ($CategoriesList as $Category) 
						{ 
							if ($Category['id']!=$CurrentCategoryId)
							{	
							?>
							<option <?php echo $selectedCategory; ?> value="<?php echo $Category['id']; ?>"><?php echo $Category['name']; ?></option>					
						<?php 						

								if ($Category['parentId']==$parentId)
								{ 
									$selectedCategory='selected';
								}
								else
								{
									$selectedCategory='';
								}
							}	
						} 
					}
					?>
			</select>			
		</div>
		<div>
			<button><?php echo $submitButton; ?></button>
			<button name="cancel" value="1">Скасувати</button>			
		</div>
	</form>

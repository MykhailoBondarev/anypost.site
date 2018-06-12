<?php 
if (isset($sessAuth)&&$sessAuth!=''||$_SESSION['LogedIn'])
{	
	$Caption = '<div class="column">Дії</div>';
	$btnCaption1='Редагувати';
	$btnCaption2='Видалити';
	$btnFunc1='edit-id';
	$btnFunc2='delete-id';
	$btnAction1=$btnAction2='';
	$hiddenStyle='style="display: none;"';

	if (isset($_POST['edit-id']))
	{
		$SelectedUser = UserSelect($_POST['edit-id']);
		$RolesList = ObjectList('roles');			
		$hiddenStyle='style="display: block;"'; 
	}	
	if (isset($_POST['save']))
	{
		if ($_POST['password']==$_POST['password-confirm'])
		{
			UpdateUserPassword($_POST['save'], $_POST['password']);
		}
		else
		{				
			// $Caption = '<div class="column">Пароль</div><div class="column">Підтвердження паролю</div>';		
			$hiddenStyle='style="display: block;"'; 
			$error = 'Пароль та підтвердження не сходяться!';			
			echo $error;
		}
		if (isset($_POST['username'])&&$_POST['username']!=''&&isset($_POST['email'])&&$_POST['email']!=''&&isset($_POST['login'])&&$_POST['login']!=''&&isset($_POST['role'])&&
			$_POST['role']!=''&&$_POST['role']!=0)
		{
			UpdateUser($_POST['save'], $_POST['username'], $_POST['email'], $_POST['login'], $_POST['role']);		
		}
		elseif ($_POST['cancel']==1)
		{
			$error='';
			$hiddenStyle='style="display: none;"';	
		}
		else
		{
			// $Caption = '<div class="column">Пароль</div><div class="column">Підтвердження паролю</div>';		
			$hiddenStyle='style="display: block;"'; 
			$changePassStyle = 'style="display: none;"';
			$error = 'Будь ласка заповніть всі поля для вводу!';
			// $SelectedUser = UserSelect($_POST['save']);
			echo $error;
		}
		// $SelectedUser['id'] = $_POST['save'];
		// $SelectedUser['name'] = $_POST['username'];
		// $SelectedUser['email'] = $_POST['email'];
		// $SelectedUser['login'] = $_POST['login'];
		// $SelectedUser['role'] = $_POST['role'];
	}	
	?>
<!-- 	<pre>
		<?php //print_r($RolesList); ?>
	</pre> -->
		<form action="" method="POST"><button submit value="add-user">Додати користувача</button></form>
		<form class="row" method="POST" action="" <?php echo $hiddenStyle; ?>>
				<input type="hidden" name="save" value="<?php echo htmlout($_POST['edit-id']); ?>">
				<input type="text" class="column" name="username" value="<?php echo htmlout($SelectedUser['name']); ?>">
				<input type="text" class="column" name="email" value="<?php echo htmlout($SelectedUser['email']); ?>">
				<input type="text" class="column" name="login" value="<?php echo htmlout($SelectedUser['login']); ?>">
				<select class="" name="role">
					<option value="0">Не обрана</option>	
					<?php foreach ($RolesList as $Role) { 
						if (htmlout($SelectedUser['role']) == htmlout($Role['id'])) {
							$selectedRole='selected';
						} else {
							$selectedRole='';
						}
					?>	
						<option <?php echo $selectedRole ?> value="<?php echo htmlout($Role['id']); ?>"><?php echo htmlout($Role['description']); ?></option>
					<?php } ?>							
				</select>				
				<button type="submit">Зберегти</button>
				<button name="cancel" value="1">Скасувати</button>
		</form>
	<?php  	
	$countId=0;
    foreach (UsersList() as $user)
    {   ?>
		<div class="box">
			<div class="avatar-box">
				<img src="" alt="avatar" class="avatar">
			</div>
			<div class="text-box">
				<p class="text-prop">
					<span>Ім'я:</span>
					<span><?php echo htmlout($user['name']); ?></span>					
				</p>
				<p class="text-prop">
					<span>Поштова адреса:</span>
					<span><?php echo htmlout($user['email']); ?></span>					
				</p>
				<p class="text-prop">				
					<span>Логін:</span>
					<span><?php echo htmlout($user['login']); ?></span>
				</p>
				<p class="text-prop">				
					<span>Роль:</span>
					<span><?php echo htmlout($user['description']); ?></span>	
				</p>			
			</div>
			<div class="button-box">
				<form method="POST" action="">
					<input type="hidden" name="<?php echo $btnFunc1; ?>" value="<?php echo htmlout($user['id']); ?>"></input>
					<button type="submit"><?php echo $btnCaption1; ?></button>
				</form>
				<form method="POST" action="">
					<input type="hidden" name="<?php echo $btnFunc2; ?>" value="<?php echo htmlout($user['id']); ?>"></input>
					<button type="submit"><?php echo $btnCaption2; ?></button>
				</form>		
			<?php 
				if ($_POST['change-pass']==0)
				{
			  ?> 
			<form class="" method="POST" action="">	
				<input type="hidden" name="user-id" value="<?php echo htmlout($user['id']); ?>">
				<button name="change-pass" value="1" >Зміна паролю</button>
			</form>			
			<?php } 
			elseif ($_POST['change-pass']==1&&$_POST['user-id']==$countId) 
				{  ?>
			<form class="" method="POST" action="">
				<input type="hidden" name="user-id" value="<?php echo htmlout($user['id']); ?>">
				<input type="password" class="column" name="password" value="<?php echo htmlout($user['password']); ?>">
				<input type="password" class="column" name="password-confirm" value="">				
				<button type="submit">Зберегти</button>
				<button  name="change-pass" value="0">Скасувати</button>
			</form>
		<?php } ?>

			</div>
		</div>

   <?php $countId++; 
    }    
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';	
}
 ?>
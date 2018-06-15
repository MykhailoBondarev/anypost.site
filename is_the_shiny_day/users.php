<?php 
if ($_SESSION['LogedIn'])
{	
	$formClass;
	$errorClass;
	$userFields;
	$WindowStatus;	
	$BtnType='Зберегти';
	if (isset($_POST['edit']) || $formClass=='modal-edit') 
	{
		$SelectedUser = UserSelect($_POST['user-id']);					
		$_SESSION['modalHeader']='Редагувати користувача '.htmlout($SelectedUser['name']);
		$formClass='modal-edit';		
	}
	elseif (isset($_POST['add']) || $formClass=='modal-add')	
	{			 
		$_SESSION['modalHeader']='Додати користувача';	
		$formClass='modal-add';
		$passwordFields='password';
	}

	if ($_POST['change-pass']==1 || $formClass=='modal-pass') 
	{	
		$SelectedUser = UserSelect($_POST['user-id']);
		$_SESSION['modalHeader']='Змінити пароль користувача '.htmlout($SelectedUser['name']);	
		$formClass='modal-pass';
		$userFields='user-fields';
		$passwordFields='password';		
	}
	if (isset($_POST['delete']) || $formClass=='modal-delete')
	{
		$SelectedUser = UserSelect($_POST['user-id']);	
		$_SESSION['modalHeader']='Ви наполягаєте на видаленні користувача '.htmlout($SelectedUser['name']).'?';
		$formClass='modal-delete';
		$userFields='user-fields';
		$passwordFields='';
		$BtnType='Видалити';
	}

	if (isset($_POST['save'])) 
	{
		if ($_POST['window-type']=='modal-pass'&&$_POST['cancel']!=1)
		{	
			ChangePassword($_POST['save'], $_POST['pass-field'], $_POST['confirm-pass-field']);	
			ModalError($_POST['window-type'],'');
		}
		if ($_POST['window-type']=='modal-add')
		{
			if ($_POST['username']!=''&&$_POST['email']!=''&&$_POST['login']!=''&&$_POST['role']!=''&&$_POST['role']!='0'
				&&$_POST['pass-field']!=''&&$_POST['confirm-pass-field']!=''&&$_POST['cancel']!=1)
			{
				if ($_POST['pass-field']==$_POST['confirm-pass-field'])
				{
					if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
					{
						AddUser($_POST['username'], $_POST['email'], $_POST['login'], $_POST['role'], $_POST['password']);								
					}
					else
					{
						$errorClass = 'error';
						$error = 'Не вірний формат електронної пошти!';
					}			
					ModalError($_POST['window-type'],'');					
				}
				else
				{				
					ModalError($_POST['window-type'],'mis');			
				}
			}
			else
			{	
				ModalError($_POST['window-type'],'blank');
			}	
		}
		if ($_POST['window-type']=='modal-edit')
		{
			if ($_POST['username']!=''&&$_POST['email']!=''&&$_POST['login']!=''&&$_POST['role']!=''&&$_POST['role']!='0'&&$_POST['cancel']!=1)
			{
				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				{	
					UpdateUser($_POST['save'], $_POST['username'], $_POST['email'], $_POST['login'], $_POST['role']);
				}
				else 
				{
					$errorClass = 'error';
					$error = 'Не вірний формат електронної пошти!';
				}

				ModalError($_POST['window-type'],'');
			}
			else
			{	
				ModalError($_POST['window-type'],'blank');								
			}
		}
		if ($_POST['window-type']=='modal-delete'&&$_POST['cancel']!=1)
		{
			DeleteUser($_POST['save']);
			ModalError($_POST['window-type'],'');
		}
		if (!is_null($_FILES['avatar-img'])&&$_POST['cancel']!=1)
		{
			var_dump($avatarArr);
			var_dump($_FILES['avatar-img']['error']);	
			$avatarArr = $_FILES['avatar-img'];
			// if ($avatarArr['size']<=$_POST['MAX_FILE_SIZE'])
			// {
			// 	if (preg_match('/^image\/p?.jpeg$/i', $_FILES['upload']['type']) or
 		// 			preg_match('/^image\/.gif$/i', $_FILES['upload']['type']) or
 		// 			preg_match('/^image\/(x-)?.png$/i', $_FILES['upload']['type']) or
 		// 			preg_match('/^image\/p?.jpg$/i', $_FILES['upload']['type']))
 		// 			{
 		// 				// відправка в бд
 		// 			}
 		// 			else
 		// 			{
 		// 				$errorClass = 'error';
			// 			$error = 'Недопустиме розширення файлу. Підтримуються лише: JPEG, JPG, PNG, GIF';
			// 			// exit;						
 		// 			}
			// }
			// else
			// {
			// 	$errorClass = 'error';
			// 	$error = 'Картинка перевищує допустимий розмір: '. $_POST['MAX_FILE_SIZE'];
			// 	// exit;
			// }
		}
	}	

	if ($_POST['cancel']==1 or $ok)
	{
			$error='';
			$errorClass='';
			$formClass='';				
	}

	if ($formClass=='modal-edit'|| $formClass=='modal-add')
	{
		$RolesList = ObjectList('roles');
	}		
	?>	
	<pre>
		<?php var_dump($_FILES['avatar-img']); 
		echo $error;
		?>
	</pre>
		<form action="" method="POST"> 
			<input type="hidden" name="add">
			<button class="add-id" submit name="user-id"  value="<?php echo htmlout($user['id']); ?>">Додати користувача</button>
		</form>
		<div class="modal-window <?php echo ' '.$formClass; ?>" reload="<?php echo $ok; ?>">			
		<form enctype="multipart/form-data" class="add-edit-form" method="POST" action="">
				<?php var_dump($_FILES['avatar-img']['tmp_name']); ?>
				<p class="<?php echo $errorClass; ?>"><?php echo $error; ?></p> 
				<h4><?php echo $_SESSION['modalHeader']; ?></h4>
				<input type="hidden" name="save" value="<?php echo htmlout($_POST['user-id']); ?>">
				<input type="hidden" name="window-type" value="<?php echo $formClass; ?>">
				<div class="<?php echo $userFields; ?>">
					<img src="<?php echo htmlout($SelectedUser['avatar']); ?>" alt="">
					<input type="hidden" name="MAX_FILE_SIZE" value="400k">					
					<input type="file" name="avatar-img" value="<?php //echo htmlout($SelectedUser['avatar']); ?>">
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="username">Ім'я:</label>
				<input type="text" class="" name="username" value="<?php echo htmlout($SelectedUser['name']); ?>">				
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="email">Поштова адреса:</label>
				<input type="text" class="" name="email" value="<?php echo htmlout($SelectedUser['email']); ?>">				
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="login">Логін:</label>
				<input type="text" class="" name="login" value="<?php echo htmlout($SelectedUser['login']); ?>">				
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="role">Роль:</label>
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
				</div>
				<div class="password">
					<label for="pass-field">Пароль:</label>
					<input type="password" name="pass-field">
				</div>
				<div class="password">
					<label for="confirm-pass-field">Підтвердження пароля:</label>
					<input type="password" name="confirm-pass-field">					
				</div>	
				<div>				
				<button type="submit"><?php echo $BtnType; ?></button>
				<button name="cancel" value="1">Скасувати</button>
				<button class="close" name="cancel" value="1">X</button>						
				</div>
		</form>
		</div>
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
					<input type="hidden" name="edit"></input>
					<button type="submit" name="user-id"  value="<?php echo htmlout($user['id']); ?>">Редагувати</button>
				</form>
				<form method="POST" action="">
					<input type="hidden" name="delete" value="<?php echo htmlout($user['id']); ?>"></input>
					<button type="submit" name="user-id"  value="<?php echo htmlout($user['id']); ?>">Видалити</button>
				</form>		

			<form class="" method="POST" action="">	
				<input type="hidden" name="user-id" value="<?php echo htmlout($user['id']); ?>">
				<button name="change-pass" value="1" >Зміна паролю</button>
			</form>	
			</div>
		</div>

   <?php
    }    
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';	
}?>
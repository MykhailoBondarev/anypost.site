<?php 
if (isset($sessAuth)&&$sessAuth!=''||$_SESSION['LogedIn'])
{	
	$btnCaption1='Редагувати';
	$btnCaption2='Видалити';
	$btnFunc1='edit';
	$btnFunc2='delete-id';
	$btnAction1=$btnAction2='';
	$formClass;
	$errorClass;
	$userFields;
	$WindowStatus;
	if (isset($_POST['edit'])||isset($_POST['add']))
	{
		if (isset($_POST['edit']))
		{
			$SelectedUser = UserSelect($_POST['user-id']);					
			$modalHeader='Редагувати користувача';
			$formClass='modal-edit';
		}
		elseif (isset($_POST['add']))		
		{			 
			$modalHeader='Додати користувача';	
			$formClass='modal-add';
			$passwordFields='password';
		}
		$RolesList = ObjectList('roles');
	}

	if ($_POST['change-pass']==1)
	{	
			$SelectedUser = UserSelect($_POST['user-id']);
			$modalHeader='Змінити пароль користувача '.htmlout($SelectedUser['name']);	
			$formClass='modal-pass';
			$userFields='user-fields';
			$passwordFields='password';		
	}
	// var_dump($formClass);
	// var_dump($_POST['save']);
	// var_dump($error);
	

	if (isset($_POST['save'])&&$_POST['window-type']=='modal-pass')
	{	
		ChangePassword($_POST['save'], $_POST['password'], $_POST['password-confirm']);	
		if (isset($GLOBALS['error'])&&$GLOBALS['error']!='')
		{		
			 $errorClass='error';
			 $formClass='modal-pass';
			 $userFields='user-fields';
			 // exit;
		}
	}
	if ($_POST['cancel']==1)
	{
			$error='';
			$errorClass='';
			$formClass='';					
	}
			 		
		// $error = 'Будь ласка заповніть всі поля для вводу!';			
				// exit;	

		// $SelectedUser['id'] = $_POST['save'];
		// $SelectedUser['name'] = $_POST['username'];
		// $SelectedUser['email'] = $_POST['email'];
		// $SelectedUser['login'] = $_POST['login'];
		// $SelectedUser['role'] = $_POST['role'];	
	?>
<!-- 	<pre>
		<?php //print_r($RolesList); ?>
	</pre> -->
		<p class="error"><?php //echo $GLOBALS['error']; ?></p>
		<form action="" method="POST">
			<input type="hidden" name="add">
			<button class="add-id" submit name="user-id"  value="<?php echo htmlout($user['id']); ?>">Додати користувача</button>
		</form>
		<div class="modal-window <?php echo ' '.$formClass; ?>">			
		<form class="add-edit-form" method="POST" action="" >
				<p class="<?php echo $errorClass; ?>"><?php echo $error; ?></p> 
				<h4><?php echo $modalHeader; ?></h4>
				<input type="hidden" name="save" value="<?php echo htmlout($_POST['user-id']); ?>">
				<input type="hidden" name="window-type" value="<?php echo $formClass; ?>">
				<div class="<?php echo $userFields; ?>">
					<img src="" alt="">
					<input type="file">
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="username">Ім'я</label>
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
					<input type="password" name="password">
				</div>
				<div class="password">
					<label for="confirm-pass-field">Підтвердження пароля:</label>
					<input type="password" name="password-confirm">					
				</div>	
				<div>				
				<button type="submit">Зберегти</button>
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
					<input type="hidden" name="<?php echo $btnFunc1; ?>"></input>
					<button type="submit" name="user-id"  value="<?php echo htmlout($user['id']); ?>"><?php echo $btnCaption1; ?></button>
				</form>
				<form method="POST" action="">
					<input type="hidden" name="<?php echo $btnFunc2; ?>" value="<?php echo htmlout($user['id']); ?>"></input>
					<button type="submit" name="user-id"  value="<?php echo htmlout($user['id']); ?>"><?php echo $btnCaption2; ?></button>
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
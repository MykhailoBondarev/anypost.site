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
		$_SESSION['SelectedUser'] = UserSelect($_POST['user-id']);					
		$_SESSION['modalHeader']='Редагувати користувача '.htmlout($_SESSION['SelectedUser']['name']);
		$formClass='modal-edit';		
	}
	elseif (isset($_POST['add']) || $formClass=='modal-add')	
	{			 
		$_SESSION['modalHeader']='Додати користувача';	
		$formClass='modal-add';
		$passwordFields='password';
		unsetSessionVars('userEdit');
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
			ChangePassword($_POST['user-id'], $_POST['pass-field'], $_POST['confirm-pass-field']);	
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
						if (isset($_FILES['avatar-img']) and $_FILES['avatar-img']['name']!='' and $_FILES['avatar-img']['error']==0)
						{
							UploadImg($_POST['user-id'], $_FILES['avatar-img'], $_POST['window-type'], $_POST['img-max-size']);
						} 
						else
						{
							$upImgOk=true;
						}							
					}
					else
					{
						ModalError($_POST['window-type'],'unknown-email-format');
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
				if (isset($_FILES['avatar-img']) and $_FILES['avatar-img']['name']!='' and $_FILES['avatar-img']['error']==0)
				{
					UploadImg($_POST['user-id'], $_FILES['avatar-img'], $_POST['window-type'], $_POST['img-max-size']);
				}
				else
				{
					$upImgOk=true;
				}				

				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				{	
					UpdateUser($_POST['user-id'], $_POST['username'], $_POST['email'], $_POST['login'], $_POST['role']);								
				}
				else 
				{
					ModalError($_POST['window-type'],'unknown-email-format');					
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
			DeleteUser($_POST['user-id']);
			ModalError($_POST['window-type'],'');
		}
	}	
	if (($ok&&$upImgOk) or ($_POST['cancel']==1) or $delOk or $pasOk)
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
		<form action="" method="POST"> 
			<input type="hidden" name="add">
			<button class="add-id" submit name="user-id"  value="<?php echo htmlout($user['id']); ?>">Додати користувача</button>
		</form>
		<div class="modal-window <?php echo ' '.$formClass; ?>" reload="<?php echo $ok; ?>">			
		<form enctype="multipart/form-data" class="add-edit-form" method="POST" action="">							
				<p class="<?php echo $errorClass; ?>"><?php echo $error; ?></p> 
				<h4><?php echo $_SESSION['modalHeader']; ?></h4>
				<input type="hidden" name="save" value="1">
				<input type="hidden" name="user-id" value="<?php echo htmlout($_POST['user-id']); ?>">
				<input type="hidden" name="window-type" value="<?php echo $formClass; ?>">
				<div class="<?php echo $userFields; ?>">				
					<img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['SelectedUser']['avatar']); ?>" alt=""> 
					<input type="hidden" name="img-max-size" value="400000">					
					<input type="file" name="avatar-img">
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="username">Ім'я:</label>
				<input type="text" class="" name="username" value="<?php echo htmlout($_SESSION['SelectedUser']['name']); ?>">				
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="email">Поштова адреса:</label>
				<input type="text" class="" name="email" value="<?php echo htmlout($_SESSION['SelectedUser']['email']); ?>">				
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="login">Логін:</label>
				<input type="text" class="" name="login" value="<?php echo htmlout($_SESSION['SelectedUser']['login']); ?>">				
				</div>
				<div class="<?php echo $userFields; ?>">
				<label for="role">Роль:</label>
				<select class="" name="role">
					<option value="0">Не обрана</option>	
					<?php foreach ($RolesList as $Role) { 
						if (htmlout($_SESSION['SelectedUser']['role']) == htmlout($Role['id'])) {
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
	$UsersArray=UsersList();
	if ($UsersArray!='')
	{
	    foreach ($UsersArray as $user)
	    {   ?>
			<div class="box">
				<div class="avatar-box">			
					<img src="data:image/jpeg;base64,<?php echo base64_encode($user['avatar']); ?>" alt="avatar" class="avatar">
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
						<input type="hidden" name="delete"></input>
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
		echo '<h4>Поки що немає жодного користувача</h4>';		
	}  
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';	
}

?>
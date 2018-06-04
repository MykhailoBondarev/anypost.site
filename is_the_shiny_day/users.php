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
		$SelectedUser = ObjectSelect($_POST['edit-id'], 'wp_user');
		$Caption = '<div class="column">Пароль</div><div class="column">Підтвердження паролю</div>';		
		$hiddenStyle='style="display: block;"'; 
	}	
	if (isset($_POST['save']))
	{
		if (isset($_POST['username'])&&$_POST['username']!=''&&isset($_POST['email'])&&$_POST['email']!=''&&isset($_POST['login'])&&$_POST['login']!=''&&isset($_POST['password'])&&$_POST['password']!=''&&isset($_POST['password-confirm'])&&$_POST['password-confirm']!='')
		{
			if ($_POST['password']==$_POST['password-confirm'])
			{
				UpdateUser($_POST['save'], $_POST['username'], $_POST['email'], $_POST['login'], $_POST['password']);
			}
			else
			{				
				$Caption = '<div class="column">Пароль</div><div class="column">Підтвердження паролю</div>';		
				$hiddenStyle='style="display: block;"'; 
				$error = 'Пароль та підтвердження не сходяться!';			
				echo $error;
			}
		}
		elseif ($_POST['cancel']==1)
		{
			$error='';
			$hiddenStyle='style="display: none;"';
			$Caption = '<div class="column">Дії</div>';
		}
		elseif ($_POST['change-pass']==1)
		{
			$changePassStyle = 'style="display: block;"';
		}
		else
		{
			$Caption = '<div class="column">Пароль</div><div class="column">Підтвердження паролю</div>';		
			$hiddenStyle='style="display: block;"'; 
			$changePassStyle = 'style="display: none;"';
			$error = 'Будь ласка заповніть всі поля для вводу!';
			// $SelectedUser = UserSelect($_POST['save']);
			echo $error;
		}
		$SelectedUser['name'] = $_POST['username'];
		$SelectedUser['email'] = $_POST['email'];
		$SelectedUser['login'] = $_POST['login'];
	}
	?>	
		<div class="row">
			<div class="column">Ім'я</div>
			<div class="column">Поштова адреса</div>
			<div class="column">Логін</div>
			<?php echo $Caption; ?>
		</div>
		<form class="row" method="POST" action="" <?php echo $hiddenStyle; ?>>
				<input type="hidden" name="save" value="<?php echo htmlout($SelectedUser['id']); ?>">
				<input type="text" class="column" name="username" value="<?php echo htmlout($SelectedUser['name']); ?>">
				<input type="text" class="column" name="email" value="<?php echo htmlout($SelectedUser['email']); ?>">
				<input type="text" class="column" name="login" value="<?php echo htmlout($SelectedUser['login']); ?>">				
				<button type="submit">Зберегти</button>
				<button name="cancel" value="1">Скасувати</button>
		</form>
	<?php  	
    foreach (ObjectList('wp_user') as $user)
    {   ?>
		<div class="row">
			<div class="column"><?php echo htmlout($user['name']); ?></div>
			<div class="column"><?php echo htmlout($user['email']); ?></div>
			<div class="column"><?php echo htmlout($user['login']); ?></div>
			<div class="column">
				<form method="POST" action="">
					<input type="hidden" name="<?php echo $btnFunc1; ?>" value="<?php echo htmlout($user['id']); ?>"></input>
					<button type="submit"><?php echo $btnCaption1; ?></button>
				</form>
			</div>
			<div class="column">
				<form method="POST" action="">
					<input type="hidden" name="<?php echo $btnFunc2; ?>" value="<?php echo htmlout($user['id']); ?>"></input>
					<button type="submit"><?php echo $btnCaption2; ?></button>
				</form>				
			</div>
			<?php 
				if ($_POST['change-pass']==0)
				{
			  ?> 
			<form class="column" method="POST" action="">	
				<input type="hidden" name="user-id" value="">
				<button name="change-pass" value="1" >Зміна паролю</button>
			</form>			
			<?php } 
			else 
				{  ?>
			<form class="column" method="POST" action="" <?php echo $changePassStyle  ?>>
				<input type="hidden">
				<input type="password" class="column" name="password" value="<?php echo htmlout($SelectedUser['password']); ?>">
				<input type="password" class="column" name="password-confirm" value="">
				<button type="submit">Зберегти</button>
				<button  name="change-pass" value="0">Скасувати</button>
			</form>
		<?php } ?>
		</div>

   <?php }    
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';	
}
 ?>
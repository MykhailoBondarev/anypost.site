<?php 
 ?>
	<form action="" method="POST">
		<label for="login">Логін:</label><br>
		<input type="text" name="login"><br>
		<label for="pass">Пароль:</label><br>
		<input type="password" name="pass"><br>		
		<button type="submit" name="action" value="login">Вхід</button>
	</form>
	<p class="error">
	<?php 
		var_dump( $_POST['action']);
		echo $GLOBALS['loginError']; 
		echo $GLOBALS['error'];	
	?>		
	</p>


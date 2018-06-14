<div class="center-box">
	<form action="" method="POST" class="login-form">
		<p class="error">
		<?php 	
			echo $_SESSION['loginError']; 
			echo $_SESSION['error'];			
		?>		
		</p>
		<div>
		<label for="login">Логін:</label>
		<input type="text" name="login">			
		</div>
		<div>
		<label for="pass">Пароль:</label>
		<input type="password" name="pass">				
		</div>
		<div>
		<button type="submit" name="action" value="login">Вхід</button> 			
		</div>	
	</form>
</div>


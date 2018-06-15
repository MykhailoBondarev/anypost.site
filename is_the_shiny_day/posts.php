<?php 
if ($_SESSION['LogedIn'])
{


 ?>

<form action="/addpost.php" method="POST">
	<button type="submit">Додати запис</button>
</form>

<div class="posts-box">
	<div class="post">		
		<h4 class="post-title"></h4>
		<div class="info-block">
			<p class="post-author"><a href="mailto:joe@example.com?subject=feedback" "email me">email me</a></p>
			<p class="post-date"></p>
		</div>
		<div class="text-preview">
			
		</div>
	</div>
</div>
 <?php 
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';	
}
?>

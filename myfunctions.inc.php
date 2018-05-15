<?php 

function htmlout($text)
{
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

 ?>
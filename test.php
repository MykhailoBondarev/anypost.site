<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test page</title>
	<?php include '/db.php'; ?>
</head>
<body>
	<form method="post" action="">
		<label for="pattern-field">Pattern:</label>
		<input type="text" name="pattern-field" value="#^(https://)?(www\.)?youtube\.com/(watch\?v=)|(embed/)*$#">
		<label for="text-field">URL:</label>
		<input type="text" name="text-field" value="https://www.youtube.com/watch?v=4sAbnxZE9mU">
		<button action="submit">OK</button>		
	</form>	
	<?php 	
        $textfield = $_POST['text-field'];
        $youtube_pattern = $_POST['pattern-field'];
        if ($youtube_pattern != '') 
        {
        	preg_match( $youtube_pattern, $textfield, $my_match);
	        	echo 'your match: '.$my_match['match'];		
		} 
		else
		{
			echo 'Enter your pattern and url <br>';
		}    

    // выбираем все значения из таблицы "wp_posts"
    $qr_result = mysql_query("select * from " . $db_table_to_show)
		or die(mysql_error()); 

    // выводим на страницу сайта заголовки HTML-таблицы
    echo '<table border="1">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>id</th>';
	echo '<th>post_date</th>';
	echo '<th>post_title</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

	
   // выводим в HTML-таблицу все данные клиентов из таблицы MySQL 
	while($data = mysql_fetch_array($qr_result)){ 
		echo '<tr>';
		echo '<td>' . $data['ID'] . '</td>';
		echo '<td>' . $data['post_date'] . '</td>';
		echo '<td>' . $data['post_title'] . '</td>';
		echo '</tr>';
	}
	
    echo '</tbody>';
	echo '</table>';

	$db_title='';
	unset($db_title); 
    // закрываем соединение с сервером  базы данных
    mysql_close($connect_to_db); 

	echo date('H:i:s l, F jS Y.');	
	$myfamily = array('мама' => 'Оля', 'брат' => 'Рома', 'батько' => 'Юра', 'сестра' => 'Олена');
	echo '<br>';
	echo $myfamily['брат'];	
	echo '<br>';
	print_r($myfamily);
	echo '<br>';
	$myfamily['батько']='Василь';
	print_r($myfamily); 
	$myname=$_REQUEST['me'];
	if (isset($_REQUEST['me'])) 
	{
		echo 'Привіт, '. $myname.'! <br> Як твої справи?';
	}
?>
<a href="http://localhost?me=Міха">Зайти на localhost</a>

</body>
</html>	
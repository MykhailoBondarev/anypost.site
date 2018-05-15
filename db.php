<?php 
// определяем начальные данные
    $db_host = 'localhost';
    $db_name = 'wp_mysite.ua';
    $db_username = 'root';
    $db_password = '123456789';
    $db_table_to_show = 'wp_posts';
   // соединяемся с сервером базы данных
    $connect_to_db = mysql_connect($db_host, $db_username, $db_password)
		or die("Could not connect: " . mysql_error());

    // подключаемся к базе данных
    mysql_select_db($db_name, $connect_to_db)
		or die("Could not select DB: " . mysql_error());

    // закрываем соединение с сервером  базы данных
    // mysql_close($connect_to_db); 
 ?>
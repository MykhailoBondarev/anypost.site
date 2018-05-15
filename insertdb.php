<?php include '/db.php'; 
	 
  $db_title = $_POST['db_title'];  

   if (isset($db_title)|| $db_title!='') 
   {
    	mysql_query("INSERT INTO `wp_posts` (`ID`, `post_date`, `post_title`) VALUES (NULL, CURRENT_DATE(),'".$db_title."')")
    		or die(mysql_error());    		
    }
    else
    {
    	echo "Your title is NULL!";
    }

	$db_title='';
	unset($db_title); 
    // закрываем соединение с сервером  базы данных
    mysql_close($connect_to_db); 
    require('/test.php');
?> 
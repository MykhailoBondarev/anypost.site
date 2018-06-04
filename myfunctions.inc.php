<?php 

function htmlout($text)
{
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function LogIn($log,$pass,$action) 
{
	if (($log=='' || $pass=='' || !isset($log) || !isset($pass)) && $action=='login')
	{
		$GLOBALS['loginError'] = 'Поля логін та пароль мусять бути заповнені!';			
	}
	else
	{
		$m_pass=md5($pass);

		try{
			include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 		
			$sqlStr = 'SELECT * FROM wp_user WHERE login=:log AND password=:pass';
	        $sqlExp = $GLOBALS['pdo'] -> prepare($sqlStr);
	        $sqlExp -> bindValue(':log', $log);
	        $sqlExp -> bindValue(':pass', $m_pass);
	        $sqlExp -> execute();
	        $resultArr = $sqlExp -> fetch();	 
	        if ($resultArr[0] != '')
	        {
	        	session_start();
	        	$_SESSION['LogedIn']=$resultArr[0];
	        	$_SESSION['Login']=$log;
	        	$_SESSION['Ip']=$_SERVER['REMOTE_ADDR'];	                	
	        	session_write_close();	        
	        	// return $_COOKIE['PHPSESSID'];	      	
	        }
	        elseif ($action=='login' && $resultArr[0]!='')
	        {	        	
	        	unset($_SESSION['LogedIn']);
	        	unset($_SESSION['Login']);
	        	unset($_SESSION['Ip']);
	        	$GLOBALS['loginError'] = 'Невірний логін або пароль';
	            setcookie(session_name,'',time() - 3600, '/');		        	       
	        }	    	       
	    }
	    catch(PDOexception $e)
	    {
            $GLOBALS['error'] = 'Сталася помилка при виконанні запиту '. $e -> getMessage();
        }

	}

}

function LogOut()
{
	if (isset($_SESSION))
	{
		unset($_SESSION['LogedIn']);
		unset($_SESSION['Login']);
		unset($_SESSION['Ip']);
		session_destroy();	
	}
		setcookie('PHPSESSID','', time() - 6000, '/'); 	
		header('Location: .');		
}


function ObjectList($objectTable)
{
		try
		{
			include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
			$sqlStr = 'SELECT * FROM '.$objectTable;		
			$resultArr = $GLOBALS['pdo'] -> query($sqlStr);	
			while ($object = $resultArr -> fetch())
			{
 			  $objects[] = $object;
			}
			return $objects;			
		}
		catch (PDOexception $e)
		{
			$GLOBALS['error'] = 'Сталася помилка при виконанні запиту '. $e -> getMessage();
			return $error;
		}	
}

function ObjectSelect($ObjectId, $objectTable)
{
	try
	{
		include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
		$selectStr = 'SELECT * FROM '.$objectTable.' WHERE id=:Id';
		$sqlExec = $GLOBALS['pdo'] -> prepare($selectStr);
		$sqlExec -> bindValue(':Id',$ObjectId);
		$sqlExec -> execute();
		$resultArr = $sqlExec -> fetch();	
		return $resultArr;			
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при виконанні запиту '. $e -> getMessage();
		return $error;		
	}
}

function UpdateUser($userId, $userName, $userEmail, $userLogin)
{
	try
	{
		include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 		
		$sqlStr = 'UPDATE wp_user SET name=:userName, email=:userEmail, 
		login=:userLogin WHERE id=:userId';
		$sqlExp = $GLOBALS['pdo'] -> prepare($sqlStr);
		$sqlExp -> bindValue(':userName', $userName);
		$sqlExp -> bindValue(':userEmail', $userEmail);
		$sqlExp -> bindValue(':userLogin', $userLogin);
		$sqlExp -> bindValue(':userPassword', $md5Pass);
		$sqlExp -> bindValue(':userId', $userId);
		$sqlExp -> execute();
		$resultArr = $sqlExp -> fetch();
		var_dump($resultArr);
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при оновленні даних користувача'. $e -> getMessage();
		return $error;		
	}
}

function UpdateUserPassword($userId,$userPassword)
{
	$md5Pass=md5($userPassword);
	try
	{
		include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
		$sqlStr='UPDATE wp_user SET password=:userPassword WHERE id=:userId';
		$sqlDo = $GLOBALS['pdo'] -> prepare($sqlStr);
		$sqlDo -> bindValue(':id', $userId);
		$sqlDo -> bindValue(':userPassword', $userPassword);
		$sqlDo -> execute();		
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Cталася помилка при зміні пароля користувача '. $e -> getMessage();
		return $error;
	}
}
 ?>
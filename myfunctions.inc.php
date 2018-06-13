<?php 
function redirectHeader()
{
	header('Location: .');	
}

function htmlout($text)
{
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function LogIn($log,$pass) 
{		
		if ($log=='' || $pass=='' || is_null($log) || is_null($pass)) 
		{
			$_SESSION['loginError'] = 'Поля логін та пароль мусять бути заповнені!';	
			return $_SESSION['loginError'];			
			exit;	
		}
		else
		{
			$m_pass=md5($pass);

			try{
				include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 		
				$sqlStr = 'SELECT * FROM users WHERE login=:log AND password=:pass';
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
		        	$_SESSION['Role']=$resultArr['role'];	                	
		        	session_write_close();		        	
		        }
		        elseif ($resultArr[0]=='')
		        {			        	
		        	if(isset($_SESSION)) 
		        	{       	
		        		unset($_SESSION['LogedIn']);
		        		unset($_SESSION['Login']);
		        		unset($_SESSION['Ip']);
		        		unset($_SESSION['Role']);	        	
		            	setcookie('PHPSESSID','',time() - 3600, '/');
		        	}
		            $_SESSION['loginError'] = 'Невірний логін або пароль';		         
		            return $_SESSION['loginError'];
		            exit;	            	   		        	       
		        }	         	       
		    }
		    catch(PDOexception $e)
		    {
	            $_SESSION['loginError'] = 'Сталася помилка при виконанні запиту '. $e -> getMessage();
	            return  $_SESSION['loginError'];
	            exit;
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
		unset($_SESSION['Role']);
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
	
function UpdateUser($userId, $userName, $userEmail, $userLogin, $userRole)
{
	try
	{
		include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 

		$sqlStr = 'UPDATE users SET name=:userName, email=:userEmail, 
		login=:userLogin, role=:userRole WHERE id=:userId';
		$sqlExp = $GLOBALS['pdo'] -> prepare($sqlStr);
		$sqlExp -> bindValue(':userRole', $userRole);
		$sqlExp -> bindValue(':userName', $userName);
		$sqlExp -> bindValue(':userEmail', $userEmail);
		$sqlExp -> bindValue(':userLogin', $userLogin);	
		$sqlExp -> bindValue(':userId', $userId);
		$sqlExp -> execute();
		$resultArr = $sqlExp -> fetch();	
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при оновленні даних користувача'. $e -> getMessage();
		return $error;		
	}
}

function UpdateUserPassword($userId, $userPassword)
{
	$md5Pass=md5($userPassword);
	try
	{
		include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
		$sqlStr = 'UPDATE users SET password=:userPassword WHERE id=:userId';		
		$sqlDo = $GLOBALS['pdo'] -> prepare($sqlStr);		
		$sqlDo -> bindValue(':userId', $userId);
		$sqlDo -> bindValue(':userPassword', $md5Pass);	
		$sqlDo -> execute();			
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Cталася помилка при зміні пароля користувача '. $e -> getMessage();
		return $error;
		exit;
	}
}

function ChangePassword($UserId, $Password, $PasswordConfirm)
{
	if ($Password!=''&&$PasswordConfirm!='')
	{
		if ($Password==$PasswordConfirm)
		{
			UpdateUserPassword($UserId, $Password);			
		}
		else
		{				
			$GLOBALS['error'] = 'Пароль та підтвердження не сходяться!';			
			return $error;	
			exit;					
		}		
	}
	else
	{
		$GLOBALS['error'] = 'Пароль не може бути порожнім!';			
		return $error;
		exit;			
	}

}

function UserSelect($UserId)
{
	try
	{
		include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
		$selectStr = 'SELECT users.*, roles.* FROM users 
		LEFT JOIN roles ON
		users.role=roles.id	
		WHERE users.id=:Id';
		$sqlExec = $GLOBALS['pdo'] -> prepare($selectStr);
		$sqlExec -> bindValue(':Id',$UserId);
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

function UsersList()
{
		try
		{
			include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
			$sqlStr = 'SELECT users.*, roles.description FROM users 
			LEFT JOIN roles ON 
			users.role=roles.id';		
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

function AddUser($userName, $userEmail, $userLogin, $userRole, $userPass)
{
	$md5Pass = md5($userPass);
	try
	{
		include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 

		$sqlStr = 'INSERT users SET name=:userName, email=:userEmail, 
		login=:userLogin, role=:userRole, password=:userPassword';
		$sqlExp = $GLOBALS['pdo'] -> prepare($sqlStr);
		$sqlExp -> bindValue(':userRole', $userRole);
		$sqlExp -> bindValue(':userName', $userName);
		$sqlExp -> bindValue(':userEmail', $userEmail);
		$sqlExp -> bindValue(':userLogin', $userLogin);
		$sqlExp -> bindValue(':userPassword', $md5Pass);	
		$sqlExp -> execute();
		$resultArr = $sqlExp -> fetch();	
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при оновленні даних користувача'. $e -> getMessage();
		return $error;		
	}
}
?>
<?php 
include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
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
		        	$_SESSION['Name']=$resultArr['name'];
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
		// setcookie('PHPSESSID','', time() - 6000, '/'); 	
}


function ObjectList($objectTable)
{
		try
		{
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
		$sqlStr = 'UPDATE users SET name=:userName, email=:userEmail, 
		login=:userLogin, role=:userRole WHERE id=:userId';
		$sqlExp = $GLOBALS['pdo'] -> prepare($sqlStr);
		$sqlExp -> bindValue(':userRole', $userRole);
		$sqlExp -> bindValue(':userName', $userName);
		$sqlExp -> bindValue(':userEmail', $userEmail);
		$sqlExp -> bindValue(':userLogin', $userLogin);	
		$sqlExp -> bindValue(':userId', $userId);
		$sqlExp -> execute();
		$GLOBALS['ok'] = true;
		return $ok;
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при оновленні даних користувача '. $e -> getMessage();
		return $error;		
	}
}

function UpdateUserPassword($userId, $userPassword)
{
	$md5Pass=md5($userPassword);
	try
	{
		$sqlStr = 'UPDATE users SET password=:userPassword WHERE id=:userId';		
		$sqlDo = $GLOBALS['pdo'] -> prepare($sqlStr);		
		$sqlDo -> bindValue(':userId', $userId);
		$sqlDo -> bindValue(':userPassword', $md5Pass);	
		$sqlDo -> execute();	
		$GLOBALS['ok'] = true;
		return $ok;			
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
			if ($_SESSION['LogedIn']==$UserId)
			{
				LogOut();
			}						
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
		$sqlStr = 'INSERT users SET name=:userName, email=:userEmail, 
		login=:userLogin, role=:userRole, password=:userPassword';
		$sqlExp = $GLOBALS['pdo'] -> prepare($sqlStr);
		$sqlExp -> bindValue(':userRole', $userRole);
		$sqlExp -> bindValue(':userName', $userName);
		$sqlExp -> bindValue(':userEmail', $userEmail);
		$sqlExp -> bindValue(':userLogin', $userLogin);
		$sqlExp -> bindValue(':userPassword', $md5Pass);	
		$sqlExp -> execute();	
		$GLOBALS['ok'] = true;
		return $ok;
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при додаванні даних користувача '. $e -> getMessage();
		return $error;		
	}
}

function DeleteUser($UserId)
{
	try
	{
		$SqlStrPosts = 'UPDATE posts SET author=0 WHERE author=:UserId';
		$SqlExe = $GLOBALS['pdo'] -> prepare($SqlStrPosts);
		$SqlExe -> bindValue(':UserId', $UserId);
		$SqlExe -> execute();
		$SqlStr = 'DELETE FROM users WHERE id=:UserId';
		$SqlExe = $GLOBALS['pdo'] -> prepare($SqlStr);
		$SqlExe -> bindValue(':UserId', $UserId);
		$SqlExe -> execute();
		$GLOBALS['ok'] = true;
		return $ok;
		if ($_SESSION['LogedIn']==$UserId)
		{
			LogOut();
		}		
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при видаленні користувача '.$e->getMessage();
	}
}

function ModalError($windowType, $errorType)
{
	$GLOBALS['errorClass']='error';			
	$GLOBALS['formClass']=$windowType;	

	if (isset($GLOBALS['error'])&&$GLOBALS['error']!='')
	{
		$GLOBALS['errorClass']='error';
		$GLOBALS['formClass']=$windowType;									
	}	
	if ($errorType=='blank')
	{
		$GLOBALS['error']='Будь ласка заповніть всі поля для вводу!';
	}
	if ($errorType=='mis')
	{
		$GLOBALS['error']='Пароль та підтвердження не сходяться!';
	}

	if ($windowType=='modal-pass'||$windowType=='modal-delete')
	{
		$GLOBALS['userFields']='user-fields';
	}

	if ($windowType=='modal-delete'||$windowType=='modal-edit')
	{
		$GLOBALS['passwordFields']='';
	}

	if ($windowType=='modal-add'||$windowType=='modal-pass')
	{
		$GLOBALS['passwordFields']='password';
	}

	return $passwordFields;
	return $userFields;	
	return $errorClass;
	return $formClass;
	return $error;	
}

function CountObjects($ObjectTable)
{		
	try
	{
		$sqlString = 'SELECT COUNT(*) FROM '.$ObjectTable;
		$SqlDo = $GLOBALS['pdo'] -> prepare($sqlString);
		$SqlDo -> execute();
		$resultStr = $SqlDo -> fetch();
		$GLOBALS['result'] = $resultStr[0];
		return $result;
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Сталася помилка при отриманні кількості записів в таблиці: '.$ObjectTable.' '.$e->getMessage();
		return $error;
	}
}

function GetAllPosts()
{
	try
	{
 		$sql = 'SELECT posts.*, users.name, users.email FROM posts LEFT JOIN users
 		ON posts.author=users.id ORDER BY post_date DESC';
 		$sqlPrep= $GLOBALS['pdo'] -> prepare($sql);
 		$sqlPrep -> execute();
 		$Allposts = $sqlPrep -> fetch();
 		$GLOBALS['$Allposts'];
 		return $Allposts; 	
	}
	catch (PDOException $e)
	{
		$error = 'Помилка при отриманні списку постів ' . $e->getMessage();
		echo $error;
		include 'error.php';
 		exit();
	}

	$title_id=0;
	while ($row = $result->fetch())
	{		
 	 	$posts_data[] = $row; 
 		++$title_id; 	
	}
	
}
?>
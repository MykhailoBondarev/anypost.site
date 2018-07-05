<?php 
include $_SERVER['DOCUMENT_ROOT'].'/mydb.inc.php'; 
function redirectHeader()
{
	if ($_SESSION['error']=='' or $_SESSION['errorClass']=='')
	{
		header('Location: .');	
	}
	// header('Cache-Control: no-store,no-cache,mustrevalidate');
	// header('Location: http://anypost.site/');	
	  // header("Location: ".$_SERVER['REQUEST_URI']);	
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
		        	$_SESSION['tab']=1;	                	
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
		        		unset($_SESSION['tab']);	        	
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

function LogOut($userId=0)
{
	if (isset($_SESSION))
	{
		unset($_SESSION['LogedIn']);
		unset($_SESSION['Login']);
		unset($_SESSION['Ip']);
		unset($_SESSION['Role']);
		unset($_SESSION['tab']);
		session_destroy();	
	}
		// setcookie('PHPSESSID','', time() - 6000, '/'); 	
}


function ObjectList($objectTable)
{
		try
		{
			$sqlStr = 'SELECT * FROM '.$objectTable;		
			$resultArr = $GLOBALS['pdo'] -> prepare($sqlStr);
			$resultArr -> execute();	
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
		$GLOBALS['pasOk'] = true;
		return $pasOk;			
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
			users.role=roles.id ORDER BY users.login ASC';		
			$resultArr = $GLOBALS['pdo'] -> prepare($sqlStr);
			$resultArr -> execute();	
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
		$GLOBALS['delOk']=true;
		return $delOk;
		if ($_SESSION['LogedIn']==$UserId)
		{
			LogOut($UserId);
		}		
	}
	catch (PDOException $e)
	{
		$_SESSION['error'] = 'Сталася помилка при видаленні користувача '.$e->getMessage();
	}
}

function ModalError($windowType, $errorType)
{
	$GLOBALS['errorClass']='error';			
	$GLOBALS['formClass']=$windowType;	

	if (isset($GLOBALS['error'])&&$GLOBALS['error']!='')
	{		
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
	if ($errorType=='unknown-email-format')
	{
		$GLOBALS['error']='Не вірний формат електронної пошти!';
	}

	if ($errorType=='unknown-file')
	{
		$GLOBALS['error']='Недопустимий тип файлу. Підтримуються лише: JPEG, JPG, PNG, GIF';	
	}

	if ($errorType=='max-file-size')
	{
		$GLOBALS['error']='Картинка перевищує допустимий розмір: 400kB';
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
		$GLOBALS['quantity'] = $resultStr[0];
		return $GLOBALS['quantity'];
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
 		$sql = 'SELECT posts.*, users.name AS "user_name", users.email, categories.name AS "category_name" FROM posts LEFT JOIN users
 		ON posts.author=users.id LEFT JOIN categories ON posts.category=categories.id ORDER BY post_date DESC';
 		$sqlPrep= $GLOBALS['pdo'] -> prepare($sql);
 		$sqlPrep -> execute(); 		
		while ($postsRow = $sqlPrep->fetch())
		{		
 	 		$posts_data[] = $postsRow; 		
		}
		return $posts_data; 		
	}
	catch (PDOException $e)
	{
		$error = 'Помилка при отриманні списку постів ' . $e->getMessage();
		echo $error;
		include 'error.php';
 		exit();
	}
}

function DeletePost($postId)
{
	try
	{
		$sqlCat = 'DELETE FROM postcategory WHERE postid=:id';
		$sqlCatQuery= $GLOBALS['pdo'] -> prepare($sqlCat);
		$sqlCatQuery -> bindValue(':id', $postId);
		$sqlCatQuery -> execute();
		$sqlPost = 'DELETE FROM posts WHERE id=:id';
		$sqlPostQuery = $GLOBALS['pdo'] -> prepare($sqlPost);
		$sqlPostQuery -> bindValue(':id', $postId);
		$sqlPostQuery -> execute();
		$_SESSION['delOk']=true;
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Відбулася помилка при видаленні '. $e->getMessage();
		return $error;
	}
}


function UploadAvatar($userId, $imgPath)
{	
	$imgData = file_get_contents($imgPath);
	if ($userId!=0)
	{
		try
		{
			$sqlStr = 'UPDATE users SET avatar=:imgData WHERE id=:Id';
			$sqlMake = $GLOBALS['pdo'] -> prepare($sqlStr);
			$sqlMake -> bindValue(':imgData', $imgData);
			$sqlMake -> bindValue(':Id', $userId);
			$sqlMake -> execute();
			$GLOBALS['upImgOk']=true;
			return $GLOBALS['upImgOk'];
		}
		catch (PDOException $e)
		{
			$GLOBALS['error'] = 'Відбулася помилка при оновленні аватару '. $e->getMessage();
			return $error;			
		}
	}
	else
	{
		try
		{
			$sqlStr = 'UPDATE users SET avatar=:imgData ORDER BY id DESC LIMIT 1';  
			$sqlMake = $GLOBALS['pdo'] -> prepare($sqlStr);
			$sqlMake -> bindValue(':imgData', $imgData);
			$sqlMake -> execute();
			$GLOBALS['upImgOk']=true;
			return $GLOBALS['upImgOk'];
		}
		catch (PDOException $e)
		{
			$GLOBALS['error'] = 'Відбулася помилка при додаванні аватару '. $e->getMessage();
			return $error;			
		}
	}	

}

function UploadImg($userId, $avatarArray, $windowType, $imgMaxSize)
{
	if ($avatarArray['name']!='')
	{		
		var_dump($avatarArray['size']);
		if ($avatarArray['size'] <= $imgMaxSize and $avatarArr['error']==0) //MAX_FILE_SIZE 
		{

			if (preg_match('/^image\/jpeg$/i', $avatarArray['type']) or
				preg_match('/^image\/gif$/i', $avatarArray['type']) or
				preg_match('/^image\/png/', $avatarArray['type']))
				{

					// відправка в бд
					//UploadAvatar($userId, $imgPath);				
					UploadAvatar($userId, $avatarArray['tmp_name']);
				}
				else
				{					
					ModalError($windowType,'unknown-file');											
				}
		}
		else
		{
			ModalError($windowType,'max-file-size');								
		}
	} 
	else
	{
		$GLOBALS['imgOk'] = true;
		return $imgOk;
	}		
}

function AddCategory($name, $parentId, $description)
{
	try
	{
		$SqlStr = 'INSERT categories SET name=:name, parentId=:parentId, description=:description';
		$SqlDo = $GLOBALS['pdo'] -> prepare($SqlStr);
		$SqlDo -> bindValue(':name', $name);
		$SqlDo -> bindValue(':parentId', $parentId);
		$SqlDo -> bindValue(':description', $description);
		$SqlDo -> execute();
		$GLOBALS['ok'] = true;
		return $ok;		
	}
	catch (PDOException $e)
	{
		$GLOBALS['error'] = 'Помилка при додаванні нової категорії '.$e -> getMessage();
		return $error;		
	}
}

function EditCategory($categoryId, $categoryName, $categoryParentId, $categoryDescription)
{
	try
	{
		$SqlStr = 'UPDATE categories SET name=:name, parentId=:parentId, description=:description WHERE id=:id';
		$SqlDo = $GLOBALS['pdo'] ->prepare($SqlStr);
		$SqlDo -> bindValue(':id', $categoryId);
		$SqlDo -> bindValue(':name', $categoryName);
		$SqlDo -> bindValue(':parentId', $categoryParentId);
		$SqlDo -> bindValue(':description', $categoryDescription);
		$SqlDo -> execute();
		$GLOBALS['ok'] = true;
		return $ok;
	}
	catch(PDOException $e)
	{
		$GLOBALS['error'] = 'Помилка при оновленні категорії '.$e -> getMessage();
		return $error;		
	}
}

function AddPost($postTitle, $postText, $Author, $postCategory)
{
	try
	{
		$SqlStr = 'INSERT posts SET post_date=NOW(), title=:postTitle, text=:postText, author=:Author, category=:postCategory';
		$SqlDo = $GLOBALS['pdo'] -> prepare($SqlStr);
		$SqlDo -> bindValue(':postTitle', $postTitle);
		$SqlDo -> bindValue(':postText', $postText);
		$SqlDo -> bindValue(':Author', $Author);
		$SqlDo -> bindValue(':postCategory', $postCategory);
		$SqlDo -> execute();	
	}
	catch (PDOException $e)
	{
		$_SESSION['error'] = 'Помилка при додаванні нового запису '.$e -> getMessage();			
	}
}

function EditPost($postId, $postTitle, $postText, $Author, $postCategory)
{
	try
	{
		$SqlStr = 'UPDATE posts SET title=:postTitle, text=:postText, author=:Author, category=:postCategory WHERE id=:postId';
		$SqlDo = $GLOBALS['pdo'] ->prepare($SqlStr);
		$SqlDo -> bindValue(':postId', $postId);
		$SqlDo -> bindValue(':postTitle', $postTitle);
		$SqlDo -> bindValue(':postText', $postText);
		$SqlDo -> bindValue(':Author', $Author);
		$SqlDo -> bindValue(':postCategory', $postCategory);
		$SqlDo -> execute();
	}
	catch(PDOException $e)
	{
		$_SESSION['error'] = 'Помилка при оновленні категорії '.$e -> getMessage();	
	}
}

	function MakeCategoriesArray()
	{
	 	$Categories = ObjectList('categories');
		if ($Categories!='')
		{
			foreach ($Categories as $Category) 
			{ 	
				$CategoriesArr[$Category['parentId']][] = $Category;				
			}			
			return $CategoriesArr;	
		}
		else
		{
			$GLOBALS['noneCat'] = '<h4>Поки що немає жодної категорії</h4>';
		}		
	}

	function ViewCategories($categoryArray, $parentId=0)
	{
		$i =count($categoryArray, COUNT_RECURSIVE);
		echo $i;
		for ($item=0; $item < count($categoryArray[$parentId]); $item++)
		{
			echo '<div class="box"><h4>'. $categoryArray[$parentId][$item]['name'].'</h4>';
			echo '<p>'. $categoryArray[$parentId][$item]['description'].'</p>';
			// ViewCategories($categoryArray,$categoryArray[$parentId][$item][$item]);
			echo '</div>';
		}
	} 

	function unsetSessionVars($paramType)
	{
		if ($paramType=='postCancel')
		{
			unset($_SESSION['addpost']);
			unset($_SESSION['editpost']);	
			unset($_SESSION['modalDelete']);
			unset($_SESSION['thisPost']);	
		}
		if ($paramType=='error')
		{
			unset($_SESSION['errorClass']);
			unset($_SESSION['error']);	
		}
		if ($paramType='userEdit')
		{
			unset($_SESSION['SelectedUser']);
		}
	}
?>
<?php 
if ($_SESSION['LogedIn'])
{
	if (isset($_POST['delpost']))
	{
		$_SESSION['modalDelete']='modal-delete';
		$_SESSION['thisPost']=$_POST['delpost'];
	}

	if (isset($_POST['delete'])&&$_POST['cancel']!=1) 
	{
		DeletePost($_POST['delete']);		
	}
	if ($_POST['cancel']==1)
	{
		$modalDelete='';
		unsetSessionVars('postCancel');		
	}
	if (isset($_POST['method-type']))
	{
		if ($_POST['post-title']!='' and $_POST['post-text']!='' and $_POST['cancel']!=1)
		{
			if ($_POST['method-type']==-1)
			{
				AddPost($_POST['post-title'], $_POST['post-text'], $_SESSION['LogedIn'], $_POST['category']);
				unsetSessionVars('error');				
			}
			if ($_POST['method-type']>0)
			{				
				EditPost($_POST['method-type'], $_POST['post-title'], $_POST['post-text'], $_SESSION['LogedIn'], $_POST['category']);
				unsetSessionVars('error');
			}
			if ($_SESSION['error']!='')
			{
				$_SESSION['errorClass'] = 'error';	
			}
		}
		else
		{
			if ($_POST['cancel']!=1) 
			{
				if ($_POST['method-type']==-1)
				{
					$_SESSION['addpost'] = -1;	
				}
				else
				{
					$_SESSION['editpost'] = $_POST['post-id'];	
				}			
				$_SESSION['error'] = 'Не всі обов\'язкові поля заповнені!';
				$_SESSION['errorClass'] = 'error';	
			}
			else
			{
				unsetSessionVars('error');			
			}				
		}
	}

 ?>
<div class="<?php echo $_SESSION['errorClass']; ?>"><?php echo $_SESSION['error']; ?></div>
<form action="" method="POST">
	<button type="submit" name="addpost" value="-1">Додати запис</button>
</form>
<?php 
	if (isset($_SESSION['addpost']) or isset($_SESSION['editpost']) or isset($_POST['addpost']) or isset($_POST['editpost']))
	{
		include $_SERVER['DOCUMENT_ROOT'].'/addpost.php';
	}
	else
	{
		$PostsList = GetAllPosts();
		if ($PostsList!='')
		{			
			foreach ($PostsList as $postRow) 
			{
				if ($postRow['category']!=0)
				{
					$CategoryName='<span>'. htmlout($postRow['category_name']).'</span>';			
				}
				else
				{
					$CategoryName='';
				}
			 ?>
			<div class="posts-box">
				<div class="post">		
					<h4 class="post-title"><?php echo htmlout($postRow['title']).$CategoryName; ?></h4>
					<div class="info-block">
						<div class="control-button">
							<form action="" method="post">
								<button name="editpost" value="<?php echo htmlout($postRow['id']); ?>">Редагувати</button>
							</form>
						</div>
						<div class="control-button">
							<form action="" method="post">
								<button name="delpost" value="<?php echo htmlout($postRow['id']); ?>">Видалити</button>
							</form>
						</div>
						<p class="post-author"><a href="mailto:<?php echo htmlout($postRow['email']); ?>" title="email me"><?php echo htmlout($postRow['user_name']); ?></a></p>
						<p class="post-date"><?php echo htmlout($postRow['post_date']); ?></p>
					</div>
					<div class="text-preview">
						<?php echo htmlout($postRow['text']); ?>
					</div>
				</div>
			</div>
		<?php } 
		} 
		else
		{
			echo '<h4>Поки що немає жодного запису</h4>';
		}
	} ?>
	<div class="modal-window <?php echo $_SESSION['modalDelete']; ?>">
		<form class="add-edit-form" action="" method="post">
			<h4>Ви впевнені у видаленні запису?</h4>
			<button name="delete" value="<?php echo $_SESSION['thisPost']; ?>">Видалити</button>
			<button name="cancel" value="1">Скасувати</button>
			<button class="close" name="cancel" value="1">X</button>
		</form>
	</div>
<?php
}
else
{
	include $_SERVER['DOCUMENT_ROOT'].'/is_the_shiny_day/denied.php';	
}
?>

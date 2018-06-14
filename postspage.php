	<?php if ($_SESSION['LogedIn']) { ?>
	<p><a href="?addpost">Додайте власний пост</a></p>
	<?php } ?>
	<p>Всього записів в БД: <?php echo $title_id; ?></p>
	<p>Ось весь список постів:</p>
	<table>
		<tr>
			<td>POST DATE</td>
			<td>POST TITLE</td>
			<td>POST TEXT</td>
<?php  			if ($_SESSION['LogedIn'])
 			{ ?>
			<td>TO EDIT POST</td>
			<td>TO DELETE</td>
<?php  } ?>
		</tr>	
	<div><?php 
		foreach ($posts_data as $post) 
		{	
			if ($post['author']==0)
			{
				$post['email']='@';
				$post['name']='Невідомий';
			}			
			echo '<tr>';
			echo '<td>'.htmlout($post['post_date']).'</td>';
			echo '<td>'.htmlout($post['title']). '<p>Автор: <a href="mailto:'.htmlout($post['email']).'">'.htmlout($post['name']).'</a></p></td>';	
 			echo '<td><pre>'.htmlout($post['text']).'</pre></td>';
 			if ($_SESSION['LogedIn'])
 			{
 			echo '<td><form action="?editpost" method="post"><input name="editpost" hidden value="'.$post['ID'].'"><button>Редагувати пост</button></form></td>';
 			echo '<td><form action="?delpost" method="post"><input name="delpost" hidden value="'.$post['ID'].'"><button>Видалити пост</button></form></td>';
 			}
 			echo '</tr>'; 			
		}		
	 ?>	 
	 </table>
	 </div>
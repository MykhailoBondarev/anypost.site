<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Posts list</title>
</head>
<body>		
	<p><a href="?addpost">Додайте власний пост</a></p>
	<p>Всього записів в БД: <?php echo $title_id; ?></p>
	<p>Ось весь список постів:</p>
	<table>
		<tr>
			<td>POST DATE</td>
			<td>POST TITLE</td>
			<td>POST TEXT</td>
			<td>TO EDIT POST</td>
			<td>TO DELETE</td>
		</tr>	
	<div><?php 
		foreach ($posts_data as $post) 
		{				
			echo '<tr>';
			echo '<td>'.htmlout($post['post_date']).'</td>';
			echo '<td>'.htmlout($post['post_title']).'</td>';	
 			echo '<td>'.htmlout($post['post_text']).'</td>';
 			echo '<td><form action="?editpost" method="post"><input name="editpost" hidden value="'.$post['ID'].'"><button>Редагувати пост</button></form></td>';
 			echo '<td><form action="?delpost" method="post"><input name="delpost" hidden value="'.$post['ID'].'"><button>Видалити пост</button></form></td>';
 			echo '</tr>';
		}
	 ?>	 
	 </table>
	 </div>
</body>
</html>
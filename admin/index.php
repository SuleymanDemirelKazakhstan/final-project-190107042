<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];
	
	include '../toon.php';
	$model = new Toon();
	$toons = $model->fetch();
	$genres = $model->getGenres();

	include '../partials/header.php';
?>
<!DOCTYPE html>
	<table class="admin-table">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		<?php
		$i = 1; 
		foreach ($toons as $toon): ?>
		<tr>
			<td><?php echo $i++ ?></td>
			<td><a href="/toons/<?php echo $toon['id'] ?>"><?php echo $toon['name'] ?></a></td>
			<td><a href="/toons/update.php?id=<?php echo $toon['id']?>" class="btn edit">EDIT</a></td>
			<td><a href="/toons/delete.php?id=<?php echo $toon['id']?>" class="btn delete">DELETE</a></td>
		</tr>	
		<?php endforeach ?>
	</table>
<?php include '../partials/footer.php'; ?>
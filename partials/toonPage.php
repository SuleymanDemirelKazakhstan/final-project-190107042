<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];
	$id = basename(getcwd());

	include $dir.'/toon.php';
	$model = new Toon();
	$toon = $model->getToonById($id);
	$genres = $model->getGenres();



	$chapters = explode(";", $toon['chapters']);
	if(count($chapters) > 0 && ($chapters[0] != '')){
		$first_ch = $chapters[0];
		$last_ch = $chapters[count($chapters)-1];
	}
	include $dir.'/partials/header.php';
?>
<div>
	<div class="d-flex">
	<h1><?php echo $toon['name'] ?></h1>

	<a href="../update.php?id=<?php echo $id ?>" class="btn edit" style="margin: auto; margin-right: 10px">EDIT</a>
	<a href="../delete.php?id=<?php echo $id ?>" class="btn delete" style="margin: auto 0;">DELETE</a>
	</div>
	<div class="d-flex">
		<img src="<?php echo $toon['img_dir'] ? "img.".strtolower(pathinfo($toon['img_dir'],PATHINFO_EXTENSION)) : "../../partials/no-img.jpg"?>">
		<div class="right">
			<table>
				<tr>
					<td>Alternative</td>
					<td><?php echo $toon['altname'] ?></td>
				</tr>
				<tr>
					<td>Author</td>
					<td><?php echo $toon['author'] ?></td>
				</tr>
				<tr>
					<td>Genre</td>
					<td>
						<?php  
							$toonGeners = explode(" ", $toon['genre']);
							foreach ($toonGeners as $toonGener): 
								$genName = $model->getGenName($toonGener);
								?>
							<a href="/webtoon-genres.php?genre=<?php echo $toonGener?>"><?php echo $genName?></a>
							<!-- <span class="toon-genre"><?php echo $toon['genre'] ?></span> -->
						<?php endforeach  ?>
					</td>

				</tr>
				<tr>
					<td>Release</td>
					<td><?php echo $toon['year'] ?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><?php echo $toon['status'] ?></td>
				</tr>
				<tr>
					<td><br></td>
				</tr>
				<tr>
					<?php if(count($chapters) > 0 && ($chapters[0] != '')):

					 ?>

						<td><a href="<?php echo $first_ch?>/" class="btn">READ FIRST</a></td>
						<td><a href="<?php echo $last_ch?>/" class="btn">READ LAST</a></td>	
					<?php else: ?>
						<td style="white-space:nowrap;">No Chapters yet</td>
					<?php endif ?>
				</tr>
			</table>
		</div>
	</div>	
	<p><?php echo $toon['description'] ?></p>	
	<div class="chapter-list">
		<div class="d-flex">
			<h2>Latest releases</h2>
			<a href="../add-chapter.php?id=<?php echo $id ?>" class="btn edit" style="margin: auto; margin-right: 10px">ADD CHAPTER</a>
		</div>
		<ul>
			<?php for ($j=count($chapters)-1; $j >= 0 && ($chapters[0] != '') ; $j--):?>
				<a href="<?php echo $chapters[$j] ?>/">
					<li class="d-flex">Chapter <?php echo $chapters[$j] ?>
					<a href="../update-chapter.php?id=<?php echo $id ?>&chapter=<?php echo $id ?>" class="btn-sml edit" style="margin: auto; margin-right: 10px">EDIT</a>
					<a href="../delete-chapter.php?id=<?php echo $id ?>&chapter=<?php echo $id ?>" class="btn-sml delete" style="margin: auto 0;">DELETE</a></li></a>
			<?php endfor ?>
		</ul>
	</div>	
</div>
<?php include $dir.'/partials/footer.php'; ?>
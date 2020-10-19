<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];

	$id = basename(dirname(getcwd(),1));

	include $dir.'/toon.php';
	$model = new Toon();
	$toon = $model->getToonById($id);
	$genres = $model->getGenres();

	$chapter = json_decode(file_get_contents('chapter.json'), true);
	$images = $chapter['images'];
	
	include $dir.'/partials/header.php';
?>
<div class="reader">
	<h2><a href=".."><?php echo $toon['name'] ?></a></h2>
	<div>
		<div class="ch-nav">
			<?php if (isset($chapter['prev']) && (!empty($chapter['prev']) || $chapter['prev']=='0')): ?>
				<a class="btn left" href="../<?php echo $chapter['prev']?>">PREV</a>
			<?php endif ?>
			<?php if (isset($chapter['next']) && (!empty($chapter['next']) || $chapter['next']=='0')): ?>
				<a class="btn right" href="../<?php echo $chapter['next']?>">NEXT</a>	
			<?php else: ?>
				<a class="btn right" href="..">Webtoon info</a>
			<?php endif ?>
		</div>
		<div class="ch-reader">
			<?php foreach ((array)$images as $img):?>
				<img src="<?php echo $img ?>">
			<?php endforeach ?>
		</div>
	</div>	
</div>
<?php include $dir.'/partials/footer.php'; ?>
<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];
	
	include 'toon.php';
	$model = new Toon();
	$toons = $model->fetch();
	$genres = $model->getGenres();


	if (isset($_POST['fav'])) {
		$toonid = $_POST['toonid'];
		$model->bookmarkToon($toonid);
	}

	

	include 'partials/header.php';
?>
<?php include 'partials/toonContainer.php'; ?>

<?php include 'partials/footer.php'; ?>
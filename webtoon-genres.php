<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];
	
	if (!isset($_GET['genre'])) {
		include '../partials/not_found.php';
		exit;
	}
	$toonGenre = $_GET['genre'];

	include 'toon.php';
	$model = new Toon();
	$toons = $model->fetchByGenre($toonGenre);
	$genres = $model->getGenres();

	if (isset($_POST['fav'])) {
		$toonid = $_POST['toonid'];
		$model->bookmarkToon($toonid);
	}

	include 'partials/header.php';
?>
<?php include 'partials/toonContainer.php'; ?>
<?php include 'partials/footer.php'; ?>
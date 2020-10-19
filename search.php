<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];
	
	if (!isset($_GET['word'])) {
		include '../partials/not_found.php';
		exit;
	}
	$searchWord = $_GET['word'];

	include 'toon.php';
	$model = new Toon();
	$toons = $model->search($searchWord);
	$genres = $model->getGenres();

	if (isset($_POST['fav'])) {
		$toonid = $_POST['toonid'];
		$model->bookmarkToon($toonid);
	}

	include 'partials/header.php';
?>
<h3>RESULTS FOR "<?php echo $searchWord?>"</h3>
<?php include 'partials/toonContainer.php'; ?>
<?php include 'partials/footer.php'; ?>
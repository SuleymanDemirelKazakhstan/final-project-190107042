<?php
	include '../partials/header.php';

	if (!isset($_GET['id'])) {
		include '../partials/not_found.php';
		exit;
	}
	$toonId = $_GET['id'];

	include '../toon.php';
	$model = new Toon();
	$toon = $model->getToonById($toonId);

	if (!$toon) {
		include '../partials/not_found.php';
		exit;
	}

	$errors = [
		'name' => "",
		'author' => "",
		'genre' => "",
		'description' => "",
		'release' => "",
		'status' => ""	
	];

	$isValid = true;

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$toon = array_merge($toon, $_POST);
		
		$isValid = validateToon($toon, $errors);

		if ($isValid) {
			$toon = updateToon($_POST, $toonId);
			

			if (isset($_POST['picture']) && $_POST['picture']['name']) 
				uploadImage($_POST['picture'], $toon, "/toons/${toon['id']}");	

			header("Location: $toonId");
		}
	}
?>
	<?php include '../partials/_form.php'; ?>
<?php include '../partials/footer.php'; ?>
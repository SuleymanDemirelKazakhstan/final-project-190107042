<?php 
	$dir = $_SERVER['DOCUMENT_ROOT'];

	include $dir.'/toon.php';
	$model = new Toon();
	
	if (!isset($_GET['id'])) {
		include '../partials/not_found.php';
		exit;
	}
	$toonId = $_GET['id'];
	$toon = $model->delete($toonId);

	header("Location: ../index.php");
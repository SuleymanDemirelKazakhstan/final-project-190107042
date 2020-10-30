<?php 
	include 'toon.php';
	$model = new Toon();
	$toons = $model->fetch();

	exit(json_encode($toons));
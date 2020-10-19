<?php
	if (!isset($_GET['id'])) {
		include '../partials/not_found.php';
		exit;
	}
	$toonId = $_GET['id'];

	include '../toon.php';
	$model = new Toon();
	$toon = $model->getToonById($toonId);
	$genres = $model->getGenres();

	if (!$toon) {
		include '../partials/not_found.php';
		exit;
	}

	$errors = [
		'name' => "",
		'author' => "",
		'genre' => "",
		'description' => "",
		'year' => "",
		'status' => ""	
	];


	$model->updateToon($toonId);

	include '../partials/header.php';
?>
<h2>Edit Webtoon - <?php echo $toon['name'] ?></h2>

<form method="POST" enctype="multipart/form-data" action="" autocomplete="off" class="create-form">
	<div class="d-flex">
		<div>
			<div class="form-group">
				<img src="<?php echo (isset($toon['img_dir'])) ?  "/${toon['img_dir']}" : "../../partials/no-img.jpg" ?>" id="output">
				<label for="picture" style="cursor: pointer;" class="picture-label">Upload Image</label>
				<input name="picture" id="picture" accept="image/*" onchange="loadFile(event)" type="file" class="form-control-file" >
			</div>
		</div>
		<div>
			<div class="form-group">
				<label>Name</label>
				<input name="name" value="<?php echo $toon['name'] ?>" class="form-control <?php echo $errors['name'] ? 'is-invalid' : '' ?>">
				<div class="invalid_form"><?php echo $errors['name'] ?></div>
			</div>
			<div class="form-group">
				<label>Alternative</label>
				<input name="altname" value="<?php echo $toon['altname'] ?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Author</label>
				<input name="author" value="<?php echo $toon['author'] ?>" class="form-control <?php echo $errors['author'] ? 'is-invalid' : '' ?>">
				<div class="invalid_form"><?php echo $errors['author'] ?></div>
			</div>
			<div class="form-group">
				<label>Genres</label>
				<?php foreach ($genres as $genre):
					if (strpos($toon['genre'], $genre['altname']) !== false):?>
					    <input name="genre[]" id="<?php echo $genre['altname'] ?>" type="checkbox" value="<?php echo $genre['altname'] ?>" checked> 
						<label for="<?php echo $genre['altname'] ?>" ><?php echo $genre['name'] ?></label>
					<?php else: ?>
						<input name="genre[]" id="<?php echo $genre['altname'] ?>" type="checkbox" value="<?php echo $genre['altname'] ?>">
						<label for="<?php echo $genre['altname'] ?>" ><?php echo $genre['name'] ?></label>
					<?php endif  ?>
				<?php endforeach?>
				<div class="invalid_form"></div>
			</div>
			<div class="form-group">
				<label>Release</label>
				<input name="year" type="number" min="1900" max="2020" value="<?php echo $toon['year'] ?>" class="form-control <?php echo $errors['year'] ? 'is-invalid' : '' ?>">
				<div class="invalid_form"><?php echo $errors['year'] ?></div>
			</div>
			<div class="form-group">
				<label>Status</label>
				<select name="status"  class="form-control <?php echo $errors['status'] ? 'is-invalid' : '' ?>" value="<?php echo $toon['status'] ?>">
					<?php if ($toon['status'] == "Completed"):?>
						<option value="Completed" selected>Completed</option>
					    <option value="Ongoing">Ongoing</option>
					    <option value="Canceled">Canceled</option>
					    <option value="On Hold">On Hold</option>
					<?php elseif ($toon['status'] == "Ongoing"):?>
						<option value="Completed" >Completed</option>
					    <option value="Ongoing" selected>Ongoing</option>
					    <option value="Canceled">Canceled</option>
					    <option value="On Hold">On Hold</option>
				    <?php elseif ($toon['status'] == "Canceled"):?>
						<option value="Completed">Completed</option>
					    <option value="Ongoing">Ongoing</option>
					    <option value="Canceled" selected>Canceled</option>
					    <option value="On Hold">On Hold</option>
					<?php elseif ($toon['status'] == "On Hold"):?>
						<option value="Completed" >Completed</option>
					    <option value="Ongoing">Ongoing</option>
					    <option value="Canceled">Canceled</option>
					    <option value="On Hold" selected>On Hold</option>
					<?php endif?>
				</select>	
				<div class="invalid_form"><?php echo $errors['status'] ?></div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea name="description" rows="5" cols="50" value="<?php echo $toon['description'] ?> " class="form-control <?php echo $errors['description'] ? 'is-invalid' : '' ?>"><?php echo $toon['description'] ?></textarea>
		<div class="invalid_form"><?php echo $errors['description'] ?></div>
	</div>
	<button type="submit" name="submit">Submit</button>
</form>
<script>
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
<?php include '../partials/footer.php'; ?>
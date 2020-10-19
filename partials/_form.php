<h2>Add new Webtoon</h2>

<form method="POST" enctype="multipart/form-data" action="" autocomplete="off" class="create-form">
	<div class="d-flex">
		<div>
			<div class="form-group">
				
				<img src="<?php echo (isset($toon['img_dir'])) ?  "${toon['img_dir']}" : "../../partials/no-img.jpg" ?>" id="output">
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
				<input name="altName" value="<?php echo $toon['altName'] ?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Author</label>
				<input name="author" value="<?php echo $toon['author'] ?>" class="form-control <?php echo $errors['author'] ? 'is-invalid' : '' ?>">
				<div class="invalid_form"><?php echo $errors['author'] ?></div>
			</div>
			<div class="form-group">
				<label>Genre</label>
				<input name="genre" value="<?php echo $toon['genre'] ?>" class="form-control <?php echo $errors['genre'] ? 'is-invalid' : '' ?>">
				<div class="invalid_form"><?php echo $errors['genre'] ?></div>
			</div>
			<div class="form-group">
				<label>Release</label>
				<input name="release" type="number" min="1900" max="2020" value="<?php echo $toon['release'] ?>" class="form-control <?php echo $errors['release'] ? 'is-invalid' : '' ?>">
				<div class="invalid_form"><?php echo $errors['release'] ?></div>
			</div>
			<div class="form-group">
				<label>Status</label>
				<select name="status"  class="form-control <?php echo $errors['status'] ? 'is-invalid' : '' ?>" value="<?php echo $ton['status'] ?>">
				  	<option value="Completed">Completed</option>
				    <option value="Ongoing">Ongoing</option>
				    <option value="Canceled">Canceled</option>
				    <option value="On Hold">On Hold</option>
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
	<button>Submit</button>
</form>
<script>
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
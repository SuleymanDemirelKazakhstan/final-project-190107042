<?php
	include 'toon.php';
    $toon = new Toon();
    $genres = $toon->getGenres();
    $insert = $toon->insert();

    
    include 'partials/header.php';
?>

<h2>Add New Webtoon</h2>

<form method="post" enctype="multipart/form-data" action="" autocomplete="off" class="create-form">
	<div class="d-flex sm-col" style="padding: 0">
	 	<div>
			<div class="form-group" >
				
				<img src="../../partials/no-img.jpg" id="output">
				<label for="picture" style="cursor: pointer;" class="picture-label">Upload Image</label>
				<input name="picture" id="picture" accept="image/*" onchange="loadFile(event)" type="file" class="form-control-file" >
			</div>
		</div> 
		<div>
			<div class="form-group">
				<label>Name</label>
				<input name="name" class="form-control">
				<div class="invalid_form"></div>
			</div>
			<div class="form-group">
				<label>Alternative</label>
				<input name="altname" class="form-control">
				<div class="invalid_form"></div>
			</div>
			<div class="form-group">
				<label>Author</label>
				<input name="author" class="form-control">
				<div class="invalid_form"></div>
			</div>
			<div class="form-group">
				<label>Genres</label>
				<?php foreach ($genres as $genre):?>
					
					<input name="genre[]" id="<?php echo $genre['altname'] ?>" type="checkbox" value="<?php echo $genre['altname'] ?>">
					<label for="<?php echo $genre['altname'] ?>" ><?php echo $genre['name'] ?></label>
					
				<?php endforeach?>
				<div class="invalid_form"></div>
			</div>
			<div class="form-group">
				<label>Release</label>
				<input name="year" type="number" min="1970" max="2020"class="form-control ">
				<div class="invalid_form"></div>
			</div>
			<div class="form-group">
				<label>Status</label>
				<select name="status"  class="form-control" >
				  	<option value="Completed">Completed</option>
				    <option value="Ongoing">Ongoing</option>
				    <option value="Canceled">Canceled</option>
				    <option value="On Hold">On Hold</option>
				</select>	
				<div class="invalid_form"></div>
			</div>
		</div>
	</div>
	<div class="form-group" >
		<label>Description</label>
		<textarea name="description" rows="5"   class="form-control"></textarea>
		<div class="invalid_form"></div>
	</div>
	<button type="submit" class="btn" name="submit" >Submit</button>
</form>
<script>
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};
</script> 

<?php include 'partials/footer.php'; ?>

	
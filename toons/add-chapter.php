<?php
	$dir = $_SERVER['DOCUMENT_ROOT'];
	

	if (!isset($_GET['id'])) {
		include '../partials/not_found.php';
		exit;
	}
	$toonId = $_GET['id'];

	include '../toon.php';
	$model = new Toon();
	$toon = $model->getToonById($toonId);
	$genres = $model->getGenres();

	$model->addChapter($toonId);

	if (!$toon) {
		include '../partials/not_found.php';
		exit;
	}
	include '../partials/header.php';

?>

<style>
#image-container{
	display: flex;
	flex-wrap: wrap;
}	
#image-container div{
	padding: 10px;
}	
#image-container img{
	width: 100px;
	height: 150px;
	object-fit: cover;
}

</style>

<h2>Add new Chapter for webtoon <?php echo $toon['name']?></h2>

<form method="post" enctype="multipart/form-data" action="" autocomplete="off" class="create-form">
	<div>
		<div class="form-group">
			<label>Chapter Name</label>
			<input name="name" class="form-control">
			<div class="invalid_form"></div>
		</div>
		<div class="form-group">
			<label for="pictures[]"  style="cursor: pointer;" class="picture-label">Upload Chaper Images</label>
			<input type="file" style="display: none" id="pictures[]" name="pictures[]" onchange="loadFile(event)" multiple="" accept="image/*">
		</div>
	</div>
	<button type="submit" class="btn" name="submit" >Submit</button>
</form>

<div id="image-container">
	
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
var loadFile = function(event) {
	var images = [];
	var count = event.target.files.length;
	var imageContainer = document.getElementById('image-container');
	imageContainer.innerHTML = '';

	for (var i = 0; i <count; i++) {


		images[i] = document.createElement("img");
		images[i].src = URL.createObjectURL(event.target.files[i]);
		console.log(event.target.files[i]);
		var name = document.createElement("p");
		name.innerHTML = event.target.files[i]['name'];
		
		var imageCon = document.createElement("div");
		imageCon.appendChild(images[i]);
		imageCon.appendChild(name);
		imageContainer.appendChild(imageCon);
		
	}

	
	
};
</script> 
<?php include '../partials/footer.php'; ?>
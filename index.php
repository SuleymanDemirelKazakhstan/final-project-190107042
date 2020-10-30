<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];
	
	$toonGenre = null;
	if (isset($_GET['genre'])) 
		$toonGenre = $_GET['genre'];
	
	include 'toon.php';
	$model = new Toon();
	$genres = $model->getGenres();

	if (isset($_POST['fav'])) {
		$toonid = $_POST['toonid'];
		$model->bookmarkToon($toonid);
	}
	include 'partials/header.php';
?>
<?php include 'partials/toonContainer.php'; ?>
<script>
	var toonGenre = `<?php echo $toonGenre?>`;

	fetch("/fetch.php")
	.then((res) => res.json())
	.then(data => {  
		let output = '';
		let k = 0;
		for(let i in data){
			k++;
			let bookmark = 'fa-bookmark-o';
			if(data[i].fav == 1)
				bookmark = `fa-bookmark`;
			let img = `/partials/no-img.jpg`; 
			if(data[i].img_dir)
				img = data[i].img_dir;
			output += `<div class="toon">
					<i class="toon-bookmark fa ${bookmark}" aria-hidden="true" data-id="${data[i].id}"></i>
					<a href="/toons/${data[i].id}/">
						<div class="toon-img" style="background-image: url('${img}')">
							<div class="toon-hover">
								<p>${data[i].description}</p>
							</div>
						</div>
					</a>

					<h3 class="toon-title"><a href="toons/${data[i].id}/">${data[i].name}</a></h3>
				</div>`; 
		}
		if(k > 0)
			document.querySelector('#toons').innerHTML = output;
	})
	.catch(error => console.log(error));
</script>
<?php include 'partials/footer.php'; ?>
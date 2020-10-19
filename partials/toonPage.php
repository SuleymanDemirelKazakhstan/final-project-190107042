<?php  
	$dir = $_SERVER['DOCUMENT_ROOT'];
	$id = basename(getcwd());

	include $dir.'/toon.php';
	$model = new Toon();
	$toon = $model->getToonById($id);
	$genres = $model->getGenres();



	$chapters = explode(";", $toon['chapters']);
	if(count($chapters) > 0 && ($chapters[0] != '')){
		$first_ch = $chapters[0];
		$last_ch = $chapters[count($chapters)-1];
	}
	include $dir.'/partials/header.php';
?>
	
<style>
* {box-sizing: border-box}
.modal button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}
.modal .cancelbtn, .modal .deletebtn {
  float: left;
  width: 50%;
}
.modal .cancelbtn {
  background-color: #ccc;
  color: black;
}
.modal .deletebtn {
  background-color: #f44336;
}
.modal .container {
  padding: 16px;
  text-align: center;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #474e5d;
  padding-top: 50px;
}
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}
.modal hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}
.modal .close {
  position: absolute;
  right: 35px;
  top: 15px;
  font-size: 40px;
  font-weight: bold;
  color: #f1f1f1;
}

.modal .close:hover,
.modal .close:focus {
  color: #f44336;
  cursor: pointer;
}
.modal .clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for cancel button and delete button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .deletebtn {
    width: 100%;
  }
}
</style>

<div>
	<div class="d-flex">
	<h1><?php echo $toon['name'] ?></h1>

	<a href="../update.php?id=<?php echo $id ?>" class="btn edit" style="margin: auto; margin-right: 10px">EDIT</a>
	
	<a onclick="document.getElementById('id01').style.display='block'" style="margin: auto 0; cursor: pointer;" class="btn delete">DELETE</a>

	<div id="id01" class="modal">
	  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
	  <form class="modal-content" action="/action_page.php">
	    <div class="container">
	      <h1>Delete Webtoon</h1>
	      <p>Are you sure you want to delete this webtoon?</p>
	      <div class="clearfix">
	        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
	        <button type="button" href="../delete.php?id=<?php echo $id ?>" onclick="deleteToon()" class="deletebtn">DELETE</button>
	      </div>
	    </div>
	  </form>
	</div>

	</div>

	<script>
	// Get the modal
	var modal = document.getElementById('id01');

	function deleteToon(){
		console.log('mda');
		document.getElementById('id01').style.display='none';
		window.location.href = "/toons/delete.php?id=" + <?php echo $id?>;
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}
	</script>

	<div class="d-flex">
		<img src="<?php echo $toon['img_dir'] ? "img.".strtolower(pathinfo($toon['img_dir'],PATHINFO_EXTENSION)) : "../../partials/no-img.jpg"?>">
		<div class="right">
			<table>
				<tr>
					<td>Alternative</td>
					<td><?php echo $toon['altname'] ?></td>
				</tr>
				<tr>
					<td>Author</td>
					<td><?php echo $toon['author'] ?></td>
				</tr>
				<tr>
					<td>Genre</td>
					<td>
						<?php  
							$toonGeners = explode(" ", $toon['genre']);
							foreach ($toonGeners as $toonGener): 
								$genName = $model->getGenName($toonGener);
								?>
							<a href="/webtoon-genres.php?genre=<?php echo $toonGener?>"><?php echo $genName?></a>
							<!-- <span class="toon-genre"><?php echo $toon['genre'] ?></span> -->
						<?php endforeach  ?>
					</td>

				</tr>
				<tr>
					<td>Release</td>
					<td><?php echo $toon['year'] ?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><?php echo $toon['status'] ?></td>
				</tr>
				<tr>
					<td><br></td>
				</tr>
				<tr>
					<?php if(count($chapters) > 0 && ($chapters[0] != '')):

					 ?>

						<td><a href="<?php echo $first_ch?>/" class="btn">READ FIRST</a></td>
						<td><a href="<?php echo $last_ch?>/" class="btn">READ LAST</a></td>	
					<?php else: ?>
						<td style="white-space:nowrap;">No Chapters yet</td>
					<?php endif ?>
				</tr>
			</table>
		</div>
	</div>	
	<p><?php echo $toon['description'] ?></p>	
	<div class="chapter-list">
		<div class="d-flex">
			<h2>Latest releases</h2>
			<a href="../add-chapter.php?id=<?php echo $id ?>" class="btn edit" style="margin: auto; margin-right: 10px">ADD CHAPTER</a>
		</div>
		<ul>
			<?php for ($j=count($chapters)-1; $j >= 0 && ($chapters[0] != '') ; $j--):?>
				<a href="<?php echo $chapters[$j] ?>/">
					<li class="d-flex">Chapter <?php echo $chapters[$j] ?>
					<a href="../delete-chapter.php?id=<?php echo $id ?>&chapter=<?php echo $id ?>" class="btn-sml delete" style="margin: auto; margin-right: 0">DELETE</a></li></a>
			<?php endfor ?>
		</ul>
	</div>	
</div>
<?php include $dir.'/partials/footer.php'; ?>
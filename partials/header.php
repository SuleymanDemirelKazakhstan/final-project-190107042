<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>WEBTOON KZ</title>

	<link rel="stylesheet" type="text/css" href="../../../css/main.css">
	<!-- FontAwesome -->
	<script src="https://kit.fontawesome.com/ccc2f42dff.js" crossorigin="anonymous"></script>
</head>
<body>
	<header>
		<nav>
			<div>
				<a href="/"><span>HOME</span></a>
				<div class="dropdown">
					<a class="dropbtn"><span>GENRES <i class="fa fa-caret-down"></i></span></a>
					<div class="drop-content">
						<?php foreach ($genres as $genre):?>
						<a href="/webtoon-genres.php?genre=<?php echo $genre['altname'] ?>"><?php echo $genre['name'] ?></a>
						<?php endforeach?>
					</div>
				</div>
				<a href="/favorite.php"><span>FAVORITE</span></a>
			</div>
			<div>
				<p>
					<a href="create.php" class="btn" style="height: initial; margin-right: 20px;">Add Webtoon</a>
				</p>
			
			<div id="search" >
				<div>
					<input type="text" autocomplete="off" class="searchTerm" placeholder="Search" name="search">
	      			<button type="submit" class="searchButton" onclick="search()"><i class="fa fa-search"></i></button>
        		</div>
			</div>
			</div>


		</nav>
	</header>
	<script>
		function search() {

			var word = document.querySelector("input[name=search]").value;
			console.log(word);
			window.location.href = "/search.php?word="+word;
		}
	</script>
	
	<main>
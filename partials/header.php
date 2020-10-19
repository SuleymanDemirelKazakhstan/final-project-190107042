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
		<div class="container">
		<nav >
			<div id="nav">
				<a href="/"><span>HOME</span></a>
				<div class="dropdown">
					<a class="dropbtn" onclick="dropBtn()"><span>GENRES <i class="fa fa-caret-down"></i></span></a>
					<div class="drop-content" id="drop">
						<?php foreach ($genres as $genre):?>
						<a href="/webtoon-genres.php?genre=<?php echo $genre['altname'] ?>"><?php echo $genre['name'] ?></a>
						<?php endforeach?>
					</div>
				</div>
				<a href="/favorite.php"><span>FAVORITE</span></a>
				<a href="/admin"><span>ADMIN</span></a>
				<p>
					<a href="create.php"  style="height: initial;"><span class="btn">Add Webtoon</span></a>
				</p>
			</div>
			<div>
				
			
			<div id="search" >
				<div>
					<input type="text" autocomplete="off" class="searchTerm" placeholder="Search" name="search">
	      			<button type="submit" class="searchButton" onclick="search()"><i class="fa fa-search"></i></button>
        		</div>
			</div>
			</div>
			<a class="bars" onclick="menuBtn()">
			   <i class="fa fa-bars"></i>
			</a>
		</nav>
		</div>
	</header>
	<script>
		function menuBtn() {
			var x = document.getElementById("nav");
		  	x.classList.toggle("show");
		}
		function dropBtn() {
			var x = document.getElementById("drop");
		  	x.classList.toggle("show");
		}
		function search() {
			var word = document.querySelector("input[name=search]").value;
			console.log(word);
			window.location.href = "/search.php?word="+word;
		}
	</script>
	
	<main>
		<div class="container">
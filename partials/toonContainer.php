<div class="toon-container">
		<div class="toons" id="toons">	
			<h2 style="text-align: center;">NO DATA</h2>
		</div>
</div>
<script src="jquery-3.5.1.min.js"></script>
<script>
	//bookmark
	document.querySelectorAll('.toon-bookmark').forEach(item => {
		var id = item.getAttribute('data-id');
		var classList = item.classList;
		item.addEventListener('click', event => {
		 	fetch('index.php', {  
				method: 'post',  
				headers: {  
			      	"Content-type": "application/x-www-form-urlencoded; charset=UTF-8"  
			    },  
				body: 'fav=1&toonid='+id
			})
			.then(function (data) {  
				if(classList.contains('fa-bookmark')){
					classList.remove('fa-bookmark');
					classList.add('fa-bookmark-o');	
				}else{
					classList.remove('fa-bookmark-o');
					classList.add('fa-bookmark');
				} 
			})  
			.catch(function (error) {  
				console.log('Request failed', error);  
			});
		});
	});
</script>
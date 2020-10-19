<div class="toon-container">
		<div class="toons">	
			<?php if($toons):
			 foreach ($toons as $toon):?>
			<div class="toon-block">
				<div class="toon">
					<i class="toon-bookmark fa <?php echo $toon['fav'] ? "fa-bookmark" : "fa-bookmark-o" ; ?>" aria-hidden="true" data-id="<?php echo $toon['id']; ?>"></i>
					<a href="/toons/<?php echo $toon['id'] ?>/">
						<div class="toon-img" style="background-image: <?php echo $toon['img_dir'] ? "url('${toon['img_dir']}" : "url('../../partials/no-img.jpg')"?>">
							<div class="toon-hover">
								<p><?php echo $toon['description'] ?></p>
								<?php  
									$toonGener = explode(" ", $toon['genre'])[0];
									$genName = $model->getGenName($toonGener);
										?>
									<a class="toon-genre" href="/webtoon-genres.php?genre=<?php echo $toonGener?>"><?php echo $genName?></a>
							</div>
						</div>
					</a>

					<h3 class="toon-title"><a href="toons/<?php echo $toon['id'] ?>/"><?php echo $toon['name'] ?></a></h3>
				</div>
			</div>
			<?php endforeach;
			else: ?>
				<h2 style="text-align: center;">NO DATA</h2>
			<?php endif  ?>
		</div>

</div>
<script src="jquery-3.5.1.min.js"></script>
<script>
	$(document).ready(function(){
		$('.toon-bookmark').on('click', function(){
			var toonid = $(this).data('id');
			    $toon = $(this);

			$.ajax({
				url: 'index.php',
				type: 'post',
				data: {
					'fav': 1,
					'toonid': toonid
				},
				success: function(response){

					if($toon.hasClass('fa-bookmark')){
						$toon.removeClass('fa-bookmark');
						$toon.addClass('fa-bookmark-o');	
					}
					else{
						$toon.removeClass('fa-bookmark-o');
						$toon.addClass('fa-bookmark');
					}
				}
			});
		});
	});
</script>
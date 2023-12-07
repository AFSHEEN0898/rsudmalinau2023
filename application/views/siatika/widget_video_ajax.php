<div id="<?php echo $target; ?>">

<?php
	if ($dt_widget->num_rows() > 0) {
	foreach ($dt_widget->result() as $n) {
		// if ($n->huruf == 11) $te = 'font-size: 10px';
		// else if ($n->huruf == 14) $te = 'font-size: 12px';
		// else if ($n->huruf == 24)$te = 'font-size: 14px'; 
		
		?>
		<div class="pengumuman pengumuman-<?php echo $n->id_video ?>">
			
			<?php 
			if($n->video_source == 1){
				?>
					<video src="<?php echo base_url().'uploads/sitika/galeri/video/'.$n->video.'"'; ?>" autoplay preload id="video1" style="width: 100%; height: <?php echo (@$height_kolom)?(@$height_kolom):'260';?>px;  object-fit: fill;">Your browser does not support HTML5 Audio!</video>
			<?php }else{ ?>
					<iframe width="100%" height="<?php echo (@$height_kolom)?(@$height_kolom):'260';?>px;" src="<?php echo $n->youtube_link; ?>?autoplay=1&controls=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

			<?php }?>
		</div>
	<?php
	echo $paging_sub;
	 }
	} else {
		echo '<div class="alert">Belum ada video ...</div>';
		echo $paging_sub;
	} ?>

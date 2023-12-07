<?php

	if ($pengumuman->num_rows() > 0) {
	foreach ($pengumuman->result() as $n) {
		$huruf = strlen($n->title);
		if ($huruf <= 20) $te = 'font-size: 14px';
		else if ($huruf <= 40) $te = 'font-size: 12px';
		else if ($huruf > 40) $te = 'font-size: 10px'; 
		
		?>
		<div class="informasi informasi-<?php echo $n->id_article ?>">
			<div class="informasi-title" style="border-bottom: 1px dashed #f8c300;">
				<div class="row">
					<div class="col-lg-12" style="font-size: 14px;"><?php echo $n->title ?></div>
					
				</div>
			</div>
			<div class="luar" style="min-height:220px; margin-top:10px;text-align:justify;line-height:1.42857143;word-spacing:3px;">
				<div class="dalam" style="<?php echo $te ?>;">
					<?php echo $n->content; ?>
				</div>
			</div>
			
		</div>
	<?php
	echo $paging;
	 }
	} else {
	echo '<div class="alert alert-warning alert-dismissible">Belum ada pengumuman !</div>';
		echo $paging;
	} ?>

	<script>
			$(document).ready(function() {
				$('.luar').height($('.box-penxg').height()-130);
				$('.dalam').each(function() {
						set_peng($(this));
				});
				
				function set_peng(from) {
					setTimeout(function() {
						setInterval(function() {
							if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
								var posnow = $(from).css('top');
								if (parseInt(posnow) > (-1)*parseInt($(from).css('height'))) {
									$(from).css('top',(parseInt(posnow)-20)+'px')
								} else {
									$(from).animate({ 'top': 10});
								}
							}
						},3000);
					},1000);
				}
			});
		</script>
<style type="text/css">
	
		.luar-info { 
			overflow: hidden; 
			position: relative; 
			min-height: 210px; 
			} 
		.dalam-info{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}

</style>
<div id="<?php echo $target; ?>">
<?php
	if ($dtduk->num_rows() > 0) {
	foreach ($dtduk->result() as $n) {
		// if ($n->huruf == 11) $te = 'font-size: 10px';
		// else if ($n->huruf == 14) $te = 'font-size: 12px';
		// else if ($n->huruf == 24)$te = 'font-size: 14px'; 
		
		?>
		<div class="informasi informasi-<?php echo $n->id_article ?>" style="margin:5px;font-size: <?php echo $font_size;?>px !important">
			<div class="informasi-title" style="border-bottom: 1px dashed <?php echo ((@$par['box_line_color'])?:'#f8c300')?>;">
				<div class="row">
					<div class="col-lg-12" style="font-size: <?php echo $font_size;?>px !important;font-weight:bold !important"><?php echo $n->title ?></div>
					<div class="col-lg-12" style="font-size: <?php echo $font_size;?>px !important"><?php echo tanggal_indo(substr($n->date_start,0,10)); ?> <?php echo substr($n->date_start,11,5); ?></div>
				</div>
			</div>
			<div class="luar-info" style="min-height:<?php echo (@$height_kolom)?((@$height_kolom - 60)):'250';?>px; margin-top:10px;text-align:justify;line-height:20px;word-spacing:3px;">
				<div class="dalam-info" style="font-size: <?php echo $font_size;?>px !important;">
					
					<?php echo $n->content; ?>
				</div>
			</div>
			
		</div>
	<?php
		echo $paging_sub;
	 }
	} else {
		echo '<div class="alert">Belum ada Informasi ...</div>';
		echo $paging_sub;
	} ?>
	<script>
			$(document).ready(function() {
				//$('.luar-info').height($('.box-penxg').height()-130);
				var ombox = $('.luar-info').height()-35;
				$('.dalam-info').each(function() {
						set_peng($(this));
				});
				//alert(ombox);
				// alert(ombox);
				function set_peng(from) {
					setTimeout(function() {
						setInterval(function() {
							if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
								var posnow = $(from).css('top');
								if (parseInt(posnow) > (-0.5)*parseInt($(from).css('height'))) {
									// $(from).css('top',(parseInt(posnow)-190)+'px')
									$(from).css('top',(parseInt(posnow)-ombox)+'px')
								} else {
									$(from).animate({ 'top': 0});
								}
							}
						},9000);
					},20);
				}
			});
		</script>
</div>
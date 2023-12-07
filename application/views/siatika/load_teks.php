<style type="text/css">
.stipper_berita { 
	overflow: hidden;
	position: relative
	} 
.stip_berita{ 
	position:absolute; 
	left: 0; 
	top: 0; 
}
.stip_berita img{ 
	width: 10% !important;
	text-align: center;
	margin: 0px auto !important;
}

		.striper_mingni { 
			overflow: hidden; 
			position: relative; 
			height: 25px; 
		} 
		.strip-mingni { 
			position:absolute; 
			left: 0;
			right:0;
			top: 0; 
		}
		#postEnam .luar_mingni_kir<?php echo @$id_kontent;?> { 
			overflow: hidden; 
			position: relative; 
			min-height: <?php $total=(@$set_widget_6->tinggi)-90; echo $total?>px;
		}


		#postEnam .dalam-mingni_kir<?php echo @$id_kontent;?> { 
			position:absolute; 
			left: 0;
			right: 0;
			top: 0;
			padding: 5px;
		}

		.news-content p{ text-align: justify;}
		.runningtext {
			width: 30%;
			float: left;
			margin-right: 10px;
		}
</style>	
<div id="<?php echo $target; ?>">
			<?php 
		$arr_run = array();
		foreach($dt_widget->result() as $art){
			array_push($arr_run, $art->teks_bergerak);
		}

		echo '<marquee>'.implode(" | ", $arr_run).'</marquee>';
		
					?>

<?php echo $paging_sub; ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.luar_mingni_kir<?php echo @$id_kontent;?>').height($('.box-mingguini<?php echo @$id_kontent;?>'));
										$('.dalam-mingni_kir<?php echo @$id_kontent;?>').each(function() {
												set_peng($(this));
										});
										
										function set_peng(from) {
											setTimeout(function() {
												setInterval(function() {
													if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
														var posnow = $(from).css('top');
														if (parseInt(posnow) > (-1)*parseInt($(from).css('height'))) {
															$(from).css('top',(parseInt(posnow)-10)+'px')
														} else {
															$(from).animate({ 'top': 10});
														}
													}
												},1000);
											},1000);
										}

		$('.striper_mingni').width($('.box-mingguini<?php echo @$id_kontent;?>').width()-0);

										$('.strip-mingni<?php echo @$id_kontent;?>').each(function() {
											
											set_move($(this));
											
										});
										
										function set_move(from) {
										setInterval(function() {
											var posnow = $(from).css('left');
											if (parseInt(posnow) > (-1)*parseInt($(from).css('width'))) {
												$(from).css('left',(parseInt(posnow)-10)+'px')
											} else {
												$(from).animate({ 'left': 30});
											}
										},200)
										}


		$('.stipper_berita').height($('.box-gbr').height()-210);
		$('.stip_berita').each(function() {
				set_gbr($(this));
		});
		
		function set_gbr(from) {
			setTimeout(function() {
				setInterval(function() {
					if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
						var posnow = $(from).css('top');
						if (parseInt(posnow) > (-1)*parseInt($(from).css('height'))) {
							$(from).css('top',(parseInt(posnow)-10)+'px')
						} else {
							$(from).animate({ 'top': 30});
						}
					}
				},1000);
			},1000);
		}
	});
</script>
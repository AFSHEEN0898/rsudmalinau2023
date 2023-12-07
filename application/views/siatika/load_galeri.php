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

		#postSatu .luar_mingni_kir<?php echo @$id_kontent;?> { 
			overflow: hidden; 
			position: relative; 
			min-height: <?php $total=(@$set_widget_1->tinggi)-90; echo $total?>px;
		} 
		#postDua .luar_mingni_kir<?php echo @$id_kontent;?> { 
			overflow: hidden; 
			position: relative; 
			min-height: <?php $total=(@$set_widget_2->tinggi)-90; echo $total?>px;
		} 
		#postTiga .luar_mingni_kir<?php echo @$id_kontent;?> { 
			overflow: hidden; 
			position: relative; 
			min-height: <?php $total=(@$set_widget_3->tinggi)-90; echo $total?>px;
		} 
		#postEmpat .luar_mingni_kir<?php echo @$id_kontent;?> { 
			overflow: hidden; 
			position: relative; 
			min-height: <?php $total=(@$set_widget_4->tinggi)-90; echo $total?>px;
		} 
		#postLima .luar_mingni_kir<?php echo @$id_kontent;?> { 
			overflow: hidden; 
			position: relative; 
			min-height: <?php $total=(@$set_widget_5->tinggi)-90; echo $total?>px;
		} 
		#postEnam .luar_mingni_kir<?php echo @$id_kontent;?> { 
			overflow: hidden; 
			position: relative; 
			min-height: <?php $total=(@$set_widget_6->tinggi)-90; echo $total?>px;
		} 
		/*desc style*/
		#postSatu .desc<?php echo @$id_kontent;?> { 
		color: <?php echo @$set_widget_1->color_title;?> !important;
		}

		#postDua .desc<?php echo @$id_kontent;?> { 
		color: <?php echo @$set_widget_2->color_title;?> !important;
		} 
		#postTiga .desc<?php echo @$id_kontent;?> { 
			color: <?php echo @$set_widget_3->color_title;?> !important;
		} 
		#postEmpat .desc<?php echo @$id_kontent;?> { 
			color: <?php echo @$set_widget_4->color_title;?> !important;
		} 
		#postLima .desc<?php echo @$id_kontent;?> { 
			color: <?php echo @$set_widget_5->color_title;?> !important;
		} 
		#postEnam .desc<?php echo @$id_kontent;?> { 
			color: <?php echo @$set_widget_6->color_title;?> !important;
		} 
		/*./desc style*/

		#postSatu .dalam-mingni_kir<?php echo @$id_kontent;?> { 
			position:absolute; 
			left: 0;
			top: 0;
			padding: 5px;
		}
		#postDua .dalam-mingni_kir<?php echo @$id_kontent;?> { 
			position:absolute; 
			left: 0;
			top: 0;
			padding: 5px;
		}
		#postTiga .dalam-mingni_kir<?php echo @$id_kontent;?> { 
			position:absolute; 
			left: 0;
			right: 0;
			top: 0;
			padding: 5px;
		}
		#postEmpat .dalam-mingni_kir<?php echo @$id_kontent;?> { 
			position:absolute; 
			left: 0;
			right: 0;
			top: 0;
			padding: 5px;
		}
		#postLima .dalam-mingni_kir<?php echo @$id_kontent;?> { 
			position:absolute; 
			left: 0;
			right: 0;
			top: 0;
			padding: 5px;
		}
		#postEnam .dalam-mingni_kir<?php echo @$id_kontent;?> { 
			position:absolute; 
			left: 0;
			right: 0;
			top: 0;
			padding: 5px;
		}

		.news-content p{ text-align: justify;}
		.striper_mingni<?php echo @$id_kontent;?>{
			position: relative;
			overflow: hidden;
			height: 25px;
			margin-left: 6px;
		}

		.strip-mingni<?php echo @$id_kontent;?>{
			position: absolute;
			left: 0;
			top: 0;
			right: 0;
		}
</style>	
<div id="<?php echo $target; ?>">

<?php 
	if (!empty($dt_widget)) {
					$nox = 1+$offset;
					foreach($dt_widget->result() as $row){
						$galleri = base_url('uploads/siatika/galeri/foto/'.@$row->foto);
					 ?>


<div class="row box-mingguini<?php echo @$id_kontent;?>">
											<!-- <div class="col-lg-12 no-padding">
											
												<div class="blink_me badge" style="color:#fff !important;margin-top:-38px; font-size:22px;position:absolute;right:5%;padding:5px;background: none !important;color:black;"> <?php echo $total_rows; ?> </div>
											</div> -->


											<div class="col-lg-12" style="font-size: 18px;">
												
												
														<div class="col-lg-12 no-padding">
															<?php 
																if(strlen($row->judul) > 34){
																	$judul = '<marquee scrolldelay="100">'.$row->judul.'</marquee>';
																}else{
																	$judul = $row->judul;
																}
															?>
													
														<div class="foto-title" style="color: black;"><?php echo @strtoupper($judul); ?></div>
													</div>
													<div class="col-lg-12 news-content" style="font-size: 12px;border: 1px solid <?php echo @$set_widget_1->color_title;?>;">
														<div class="row">
															<!-- <div class="col-lg-12"> -->
																<img style="border:1px solid white; width:100%;height: <?php echo @$set->tinggi-54; ?>px;" src="<?php echo $galleri?>"  >
															<!-- </div> -->
																
														</div>
													</div>
											</div>

						</div>
					<?php 
					$nox++;
					}?>
				<?php  }else{
					echo " Tidak ada agenda bulan ini";
				} ?>

<?php
echo $paging_sub;
?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.luar_mingni_kir<?php echo @$id_kontent;?>').height($('.box-mingguini<?php echo @$id_kontent;?>'));
										$('.dalam-mingni_kir<?php echo @$id_kontent;?>').each(function() {
												// set_peng($(this));
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

	$(document).ready(function(){
		$('.striper_mingni<?php echo @$id_kontent;?>').width($('.box-mingguini<?php echo @$id_kontent;?>'));

										$('.strip-mingni<?php echo @$id_kontent;?>').each(function() {
											set_movexx($(this));
											
										});
										
										function set_movexx(from) {
										setInterval(function() {
											var posnow = $(from).css('left');
											if (parseInt(posnow) > (-1)*parseInt($(from).css('width'))) {
												$(from).css('left',(parseInt(posnow)-5)+'px')
											} else {
												$(from).animate({ 'left': 250});
											}
										},800)
										}
	});
</script>
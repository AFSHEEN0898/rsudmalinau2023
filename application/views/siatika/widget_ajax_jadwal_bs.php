<style>.blink_me {
						  animation: blinker 1s linear infinite;
							}

							@keyframes blinker {  
							  50% { opacity: 0.0; }
							}
						</style>

<div id="<?php echo $target; ?>">

<?php 
if (!empty($detail_kegiatan_mi)) {
	$nox=1;
	foreach($detail_kegiatan_mi->result() as $row){ ?>
		<div class="row">
			<div class="col-lg-12 no-padding" style="text-align:right;position:relative !important;">
			
				<div class="blink_me badge" style="color:#fff;margin-top:-36px; font-size:20px;position:absolute;left:20px;padding:5px;background: none !important;"> <?php echo @$total_rows; ?> </div>
			
				<!-- <div class="badge" id="blinkx" style="background:#fff;margin-top:-33px;display: inline;font-size:14px;position:absolute;top:0px;right:20px; padding:5px;color:<?php echo $row->color; ?> !important;"> <?php echo tanggal($row->tgl_mulai).'  s.d '.tanggal($row->tgl_selesai); ?> </div>
				 -->
				 <div class="badge" id="blin" style="background:#fff;margin-top:-33px;display: block;font-size:14.5px;position:absolute;right:20px;padding:5px;color:<?php echo $row->color; ?> !important;"> <?php echo tanggal($row->tgl_mulai).'  s.d '.tanggal($row->tgl_selesai); ?> </div>
			</div>

			<div class="col-lg-12" style="font-size: 18px;">
				<div class="col-lg-1" style="background:<?php echo $row->color;?> !important; color:#fff;"><b><?php echo (@$page+1);?></b></div>
				<?php 
					if(strlen($row->nama_rincian) >= 40){ ?>
					<div class="col-lg-11 no-padding">
						<div class="striper_mingni" style="width:400px;">
							<div class="strip-mingni" style="width:<?php echo (strlen($row->nama_rincian)*9); ?>px">
								<?php echo $row->nama_rincian; ?>
							</div>
						</div>
					</div>
					<?php }else{ ?>
						 <div class="col-lg-11 no-padding"><?php echo $row->nama_rincian;?></div>
					<?php } ?>
			</div>
		</div>
		<?php if($row->id_jenis_program == 1) { ?>
		<div class="luar_mingni_kir" style="min-height:150px;">
			<div class="col-lg-12 news-content" style="font-size: 12px;border-top: 1px solid <?php echo $row->color; ?>;">
				<div class="dalam-mingni_kir" style="<?php echo @$te ?>;">
					<?php echo $row->content; ?>
					<div class="col-lg-6">		
						<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Lokasi</label>
						<p style="margin-bottom:2px;"><?php echo $row->lokasi; ?></p>
						<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Indikator</label>
						<p style="margin-bottom:2px;"><?php echo $row->indikator; ?></p>
					</div>
					<div class="col-lg-6">
						<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Sasaran</label>
						<p style="margin-bottom:2px;"><?php echo $row->sasaran; ?></p>
						<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Pagu</label>
						<p style="margin-bottom:2px;"><?php echo rupiah($row->pagu); ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php }else{ ?>
			<div class="col-lg-12 news-content" style="font-size: 12px;border-top: 1px solid <?php echo $row->color; ?>;">
				<div class="luar_mingni_kir" style="min-height:150px;">
					<div class="dalam-mingni_kir" style="<?php echo @$te ?>;">
						<?php echo $row->content; ?>
					</div>
				</div>
			</div>
		<?php } ?>
	<div class="clear"></div>
	<?php if($row->status == 2) { ?>											
		<div class="status_agenda" style="position:absolute;bottom:0px;">
			<div class="col-lg-12 no-padding" style="background:<?php echo $row->color;?> !important;">										
				<div class="col-lg-12 no-padding">
					<div class="col-lg-2 no-padding" style="padding-left:3px !important;text-align:center;">
						<label style="padding-top:3px;color:#fff;"> BATAL </label></div>
					<div class="col-lg-10" style="padding-right:3px !important;"> 
						<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
							<span>kegiatan tgl</span>
							<span><?php echo tanggal($row->tgl_mulai).' s.d '.tanggal($row->tgl_selesai); ?></span>
						</marquee>
					</div>
				</div>
			</div>
		</div>
	<?php }else{
	if($row->tgl_mulai_ubah != NULL and $row->tgl_selesai_ubah != NULL) { ?>
			<div class="status_agenda" style="background:<?php echo $row->color;?> !important;">
				<div class="col-lg-12 no-padding" style="background:<?php echo $row->color;?> !important;">										
					<div class="col-lg-6 no-padding">
						<div class="col-lg-3 no-padding" style="padding-left:3px !important;">
							<label style="padding-top:3px;color:#fff;"> Perubahan </label></div>
						<div class="col-lg-9" style="padding-right:3px !important;"> 
							<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
								<span>tanggal mulai : </span>
								<span><?php echo tanggal($row->tgl_mulai_ubah); ?></span>
							</marquee>
						</div>
					</div>										
					<div class="col-lg-6 no-padding">
						<div class="col-lg-3 no-padding" style="padding-left:3px !important;text-align:right;">
							<label style="padding-top:3px;color:#fff;">Terlambat </label></div>
						<div class="col-lg-9" style="padding-right:3px !important;"> 
							<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
								<span>tanggal selesai : </span>
								<span><?php echo tanggal($row->tgl_selesai_ubah); ?></span>
							</marquee>
						</div>
					</div>
				</div>
			</div>
	<?php }elseif($row->tgl_mulai_ubah != NULL){ ?>
			<div class="status_agenda" style="background:<?php echo $row->color;?> !important;">
				<div class="col-lg-12 no-padding" style="background:<?php echo $row->color;?> !important;">										
					<div class="col-lg-12 no-padding">
						<div class="col-lg-2 no-padding" style="padding-left:3px !important;">
							<label style="padding-top:3px;color:#fff;">Perubahan </label></div>
						<div class="col-lg-10" style="padding-right:3px !important;"> 
							<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
								<span>tanggal mulai : </span>
								<span><?php echo tanggal($row->tgl_mulai_ubah); ?></span>
							</marquee>
						</div>
					</div>
				</div>
			</div>

	<?php }elseif($row->tgl_selesai_ubah != NULL){ ?>
			<div class="status_agenda" style="background:<?php echo $row->color;?> !important;">
				<div class="col-lg-12 no-padding" style="background:<?php echo $row->color;?> !important;">										
					<div class="col-lg-12 no-padding">
						<div class="col-lg-2 no-padding" style="padding-left:3px !important;">
							<label style="padding-top:3px;color:#fff;">Terlambat </label></div>
						<div class="col-lg-10" style="padding-right:3px !important;"> 
							<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
								<span>tanggal selesai : </span>
								<span><?php echo tanggal($row->tgl_selesai_ubah); ?></span>
							</marquee>
						</div>
					</div>
				</div>
			</div>
	<?php }else{ ?>
	<?php } ?>
<?php $nox+=1; }
		
	}
}else{
	echo " Tidak ada agenda bulan ini";
} ?>
</div>
<?php
echo $paging_sub;
?>

	<script>					
		$(document).ready(function() {
			$('.luar_mingni_kir').height($('.box-mingguini').height()-140);
			$('.dalam-mingni_kir').each(function() {
					set_peng($(this));
			});
			
			function set_peng(from) {
				setTimeout(function() {
					setInterval(function() {
						if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
							var posnow = $(from).css('top');
							if (parseInt(posnow) > (-1)*parseInt($(from).css('height'))) {
								$(from).css('top',(parseInt(posnow)-18)+'px')
							} else {
								$(from).animate({ 'top': 10});
							}
						}
					},5000);
				},1500);
			}
		});

		$(document).ready(function() {
			$('.striper_mingni').width($('.box-mingguini'));
			$('.strip-mingni').each(function() {					
				set_movex($(this));					
			});					
		
			function set_movex(from) {
			setInterval(function() {
				var posnow = $(from).css('left');
				if ((parseInt(posnow)-parseInt($(from).css('width'))+150) > (-1)*parseInt($(from).css('width'))) {
					$(from).css('left',(parseInt(posnow)-10)+'px')
				} else {
					$(from).animate({ 'left': 30})
				}
			},800)
			}
		});
	</script>

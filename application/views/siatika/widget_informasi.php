<style type="text/css">
.striper-gbr { 
	overflow: hidden;
	position: relative
	} 
.strip-gbr{ 
	position:absolute; 
	left: 0; 
	top: 0; 
}
.box-header h5{
	margin-bottom:0px;
	font-weight:bold;
	text-align:center;
	font-size: 18px;
}
</style>

<div id="<?php echo $target;?>">
	<div class="box-header box-gbr">
		<?php
		$jdl = strlen(@$judul);
		if($jdl > 60){
			$jd = '<marquee><h5>'.$judul.'</h5></marquee>';
		}else{
			$jd = '<h5>'.$judul.'</h5>';
		}
		$i = 0;
		?>
		<h5><?php echo @$jd ?></h5>
	</div>
	<div class="<?php echo $target_sub_ids; ?>"></div>
	<?php echo @$paging; ?>
	<?php echo @$script; ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		// get data widget pegawai
			var target_sub = "<?php echo $target_sub; ?>";
			var post_sub = "<?php echo $post_sub; ?>";
			var id_konten = "<?php echo @$id_konten;?>";
			var jeda_dalam = "<?php echo @$jeda_dalam;?>";
			var target_sub_ids = "<?php echo @$target_sub_ids;?>";
			var link_func = "<?php echo @$link_func;?>";
			$.ajax({
				url : "<?php echo site_url($this->folder.'/data_ajax/lap_informasi');?>/"+target_sub+"/"+post_sub+"/"+id_konten+"/"+jeda_dalam+"/"+link_func,
				method : "POST",
				success : function(data){
					$('.'+target_sub_ids).html(data);
				}
			});
		});
</script>
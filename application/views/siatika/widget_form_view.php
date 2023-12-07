<link href="<?php echo base_url().'assets/plugins/iCheck/all.css';?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/tasktimer/dist/tasktimer.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
<?php echo 
	form_open_multipart('siatika/list_ids/save_data/'.$code.'/'.$pos.'/'.$id,'id="form_widget"').
	form_hidden('id_konten',@$def->id_konten);
	form_hidden('id_data',@$def->id_data);
	 ?>
<div class="row">
	<div class="col-lg-5">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Pilih Jenis Unit Bingkai</h3>
			</div>
			<div class="box-body">
				<p><label>Konten</label>
				<?php echo form_dropdown('id_data',$cb_dt,@$def->id_data,'class="combo-box form-control" id="pilih" style="width: 100%"') ?></p>
				

				<p><label>Judul</label>
					<?php echo form_input('judul',@$def->judul,'class="form-control" required') ?></p>
				<div class="box-form"></div>
				<p><label>Durasi (Detik)</label><?php echo form_input('durasi',@$def->durasi,'class="form-control" required') ?></p>
				
			</div>
			<div class="box-footer">
				<?php echo anchor('siatika/list_ids/widget/'.$code,'<i class="fa fa-arrow-left"></i> Kembali','class="btn btn-default"') ?>
				<span class="pull-right btn btn-save btn-success"><i class="fa fa-btn fa-save"></i> Simpan</span>
			</div>
		</div>
	</div>
	<div class="col-lg-7 konten on-hide">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Pilih Jenis Unit Bingkai</h3>
			</div>
			<div class="box-body">
				<div class="col-lg-12">
					<div class="col-lg-12" style="padding:5px !important">
						<div class="box box-default box-konten">
							<div id="postSatu">
								<div class="wid-kolom-satu"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			

		</div>
	</div>
</div>
<?php echo form_close(); ?>



<script type="text/javascript">
	var id_ids = "<?php echo $id_ids;?>";

	function get_ids(posisi, target, post, target_ids, link_func, target_luar, konten){
		// concole.log(konten);
				$.ajax({
					url : "<?php echo site_url('siatika/view/load_data_form/');?>/"+posisi+"/"+target+"/"+post+"/"+id_ids+"/"+target_ids+"/"+link_func+"/"+target_luar+"/"+konten+"/1",
					mthod : "POST",
					success : function(data){
						$('.'+target_ids).html(data);
						// $('.'+target_ids).find('.box-body').html(data);
					}
				});
			}

	$(document).ready(function() {
		$('select').select2();
		$(".datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

		$('#pilih').change(function() {
			if ($(this).val()) {
			$('.konten').show();
			$('.box-form,.konten .box-body').html('<i class="fa fa-refresh fa-spin fa-btn"></i> Memuat ...');	
			$.ajax({
			url: '<?php echo site_url('siatika/list_ids/load_form') ?>/'+$(this).val(),
			dataType: "json",
			success: function(msg){
				$('.box-form').html(msg.form);
				$('.konten').find('.box-title').html(msg.judul);
			}
			});
			
			// $.ajax({
			// url: '<?php echo site_url('siatika/list_ids/unit') ?>/'+$(this).val(),
			// success: function(msg){
			// 	$('.konten').find('.box-body').html(msg);
			// }
			// });

				get_ids(1, 'postWidSatu', 'page_satu', 'konten', 'getDataIDSSatu', 'postSatu', $('#pilih').val());
				 

			
			}
		});
		
		$('.btn-save').click(function() {
			$('#form_widget').submit();
		});
		
		<?php if (!empty($def)) { ?>
			$('.konten').show();
			$('.box-form,.konten .box-body').html('<i class="fa fa-refresh fa-spin fa-btn"></i> Memuat ...');	
			$.ajax({
			url: '<?php echo site_url('siatika/list_ids/load_form/'.$def->id_data.'/'.$def->id_konten) ?>',
			dataType: "json",
			success: function(msg){
				$('.box-form').html(msg.form);
				$('.konten').find('.box-title').html(msg.judul);
			}
			});
			var id_konten = "<?php echo $def->id_konten;?>";
			var posisi = "<?php echo $def->posisi;?>";
			// $.ajax({
			// url: '<?php echo site_url('siatika/list_ids/unit/'.$def->id_data.'/'.$def->id_konten) ?>',
			// success: function(msg){
			// 	$('.konten').find('.box-body').html(msg);
			// }
			// });
			// console.log('<?php echo $def->id_konten;?>')
			get_ids(posisi, 'postWidSatu', 'page_satu', 'konten', 'getDataIDSSatu', 'postSatu', id_konten);
		
		<?php } ?>
		
	});
	
	$('#id_tipe_konten').change(function(){
		var id_tipe_konten = $('#id_tipe_konten').val();
		$.ajax({
			url  	: '<?php echo site_url($this->folder.'/get_konten/');?>',
			type 	: 'POST',
			data 	: 'id_tipe_konten='+id_tipe_konten,
			datatype: 'JSON',
			success	: function(data){
				$('#pilih').html(data);
			}
		});
	});

$(function(){
	// iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
});
	
</script>

<style>
	
	.judul {
		font-size: 1.1em; font-weight: bold; font-family: arial; padding-bottom: 10px; margin-bottom: 10px;
		border-bottom: 1px dashed #ccc;
	}
	
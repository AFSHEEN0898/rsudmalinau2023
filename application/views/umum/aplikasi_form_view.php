<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'; ?>"></script>
<link href="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css' ?>" rel="stylesheet" type="text/css" />

<div class="card-header">
	<h3 class="card-title"><i class="fas fa-paper-plane"></i> &nbsp; <?php echo @$title; ?></h3>
</div>
<?php
echo form_open_multipart($form_link, 'id="form_data" role="form"');

echo '<div class="card-body">' . $form_data . '</div>';

if (!empty($tombol_form)) {
	echo $tombol_form;
} else {
?>
	<div class="card-footer"><button class="btn btn-danger btn-md btn-form-cancel" type="button">Batal</button>
		<button href="#" class="btn btn-success btn-md float-right">Simpan</button>
	</div>
<?php } ?>
<?php echo  form_close() ?>

<script type="text/javascript">
	<?php echo  @$out_script; ?>
	$(document).ready(function() {
		$('select').select2();
		$('.btn-form-cancel').click(function() {
			$('#form-content,#form-title').html('');
			$('#form-box').slideUp();
			$('#box-main').show();
		});
		$('.my-colorpicker2').colorpicker();
		$('.my-colorpicker2').on('colorpickerChange', function(event) {
			$('.my-colorpicker2 .fa-square').css('color', event.color.toString());
		});
		$('#form-title').html('<?php echo $title; ?>');
		bsCustomFileInput.init();

		$('#frm_file').change(function() {
			$('#form_foto').submit();
		});
		$('#form-title').html('<?php echo $title; ?>');
		<?php echo  @$script; ?>
	});
</script>
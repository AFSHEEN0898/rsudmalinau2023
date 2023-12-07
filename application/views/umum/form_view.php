<link href="<?php echo base_url() . 'assets/plugins/summernote/summernote-bs4.css' ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/summernote/summernote-bs4.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'; ?>"></script>
<?php echo !empty($load_script) ? $load_script : null; ?>
<div class="card-header">
	<h3 class="card-title"><i class="fas fa-paper-plane"></i> &nbsp; <?php echo @$title; ?></h3>
</div>
<?php
if (!empty($multi)) echo form_open_multipart($form_link, 'id="form_data" role="form"');
else echo form_open($form_link, 'id="form_data" role="form"');
echo '<div id="alert-form"></div>';
echo '<div class="card-body">' . $form_data . '</div>';

if (!empty($tombol_form)) {
	echo $tombol_form;
} else { ?>
	<div class="card-footer">
		<button class="btn btn-danger btn-md  btn-form-cancel" type="button"><i class="fas fa-arrow-left"></i> &nbsp; Batal</button>
		<button href="#" class="btn btn-success btn-md  float-right"><i class="fas fa-save"></i> &nbsp; Simpan</button>
	</div>
<?php
} ?>

<?php echo  form_close() ?>
<script type="text/javascript">
	<?php echo  @$out_script; ?>
	$(function() {
		//Initialize Select2 Elements
		$('.textarea').summernote({
			height: 150,
		});
		$('.combo-box').select2();
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 1901,
			maxYear: parseInt(moment().format('YYYY'), 10),
			autoApply: false,
			locale: {
				format: 'DD/MM/YYYY'
			}
		});
		bsCustomFileInput.init();

	});
	$(document).ready(function() {

		$('.btn-form-cancel').click(function() {
			$('#form-content,#form-title').html('');
			$('#form-box').hide();
			$('#box-main').show();
		});
		$('#form-title').html('<?php echo $title; ?>');
		<?php echo @$script; ?>
	});
</script>
<?php
echo @$css_load;
echo @$include_script;

$box_cls = !empty($tabs) ? 'nav-tabs-custom' : 'card';
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.heading').parent().find('td').addClass('headings');
	});
	<?php echo  @$script ?>
</script>
<!-- <link href="<?php echo base_url() . 'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js' ?>"></script> -->

<!-- <div class="<?php echo $box_cls ?>" id="box-main"> -->
<div class="card" id="box-main">
	<?php if (!empty($tabs)) { ?>

	<?php } ?>

	<?php if (!empty($tombol) or !empty($extra_tombol)) { ?>

		<div class="card-header with-border">
			<div class="row">
				<div class="col-md-7" style="margin-bottom: 10px"><?php echo @$tombol ?></div>
				<?php if (!empty($extra_tombol)) echo '<div class="col-md-5">' . $extra_tombol . '</div>'; ?>
			</div>
		</div><!-- /.box-header -->
	<?php } ?>

	<div class="card-body table-responsive<?php if (!empty($overflow)) echo " over-width" ?>">
		<div id="alert"></div>

		<?php echo form_open_multipart($this->dir . '/save_header', 'role="form" id="form_parameter"'); ?>
		<div class="card">
			<div class="card-body">

				<div class="col-lg-6">
					<!-- kolom kiri -->
					<?php if (!empty($vals['header_image'])) { ?>
						<img src="<?php echo base_url('uploads/brands/' . $vals['header_image']); ?>" style="width:50%;">
					<?php } ?>
					<br>
					<br>
					<label>Upload Poster <code>*</code></label>
					<?php echo
					form_hidden('keys', 'header_image');
					// form_upload('vals', !empty($vals['header_image']) ? $vals['header_image'] : null, '
					// 		id="header_on" class="form-control inp_reload" placeHolder="Judul Utama ..." required')
					?>
					<!-- <span>* Rekomendasi ukuran header : 750 x 100 pixel</span> -->


					<div class="form-group">
						<div class="custom-file">
							<input type="file" name="vals" class="custom-file-input inp_reload" id="header_on" accept=".jpeg,.jpg,.png" required>
							<label class="custom-file-label" for="sotk">Pilih file</label>
						</div>
						<span>* Rekomendasi ukuran header : 750 x 80 pixel.</span>
					</div>
					<!-- kolom kiri -->

				</div>

				<div class="col-lg-12 card-footer">
					<span class="btn btn-success btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan Pengaturan</span>

				</div>

			</div>
			<?php echo form_close(); ?>
		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				bsCustomFileInput.init();
				// $(".colorize").colorpicker();
				$('.btn-simpan').click(function() {
					$('#form_parameter').submit();
				});

				$('#form_parameter').submit(function() {

					/*if (!$('.inp_menit').val()) {
						$('#alert').addClass('alert alert-danger').html('Isian tidak boleh kosong!');
						return false;	
					}*/
					if (!$('.inp_reload').val()) {

						$('#alert').addClass('alert alert-danger').html('File tidak boleh kosong !');
						return false;
					}

				});

			});
		</script>
	</div>
	<?php if (!empty($links) or !empty($total) or !empty($box_footer)) { ?>

		<div class="card-footer">
			<div class="stat-info">
				<?php if (!empty($links)) { ?><div class="pull-left" style="margin-right: 10px"><?php echo $links ?></div><?php } ?>
				<?php if (!empty($total)) { ?><div class="pull-left">
						<ul class="pagination">
							<li><a>Total</a></li>
							<li><a><strong><?php echo $total ?></strong></a></li>
						</ul>
					</div><?php } ?>
			</div>
			<?php if (!empty($box_footer)) echo $box_footer; ?>
			<div class="clear"></div>
			<?php if (!empty($filter)) $this->load->view($filter); ?>

		</div>

	<?php } ?>
</div>
<?php if (!empty($load_view)) $this->load->view($load_view); ?>
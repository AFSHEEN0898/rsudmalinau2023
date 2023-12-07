<link href="<?php echo base_url() . 'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<style>
	.hide {
		display: none !important;
	}
</style>
<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<div class="card-header">
	<h3 class="card-title"><i class="fas fa-paper-plane"></i> &nbsp; <?php echo @$title; ?></h3>
</div>

<?php echo
form_open($link_save, 'id="form_role"') .
	form_hidden('id_role', @$def->id_role); ?>
<div class="card-body">
	<div class="form-group"><?php echo form_label('Nama Kewenangan') . form_input('nama_role', @$def->nama_role, 'class="form-control" required'); ?></div>
	<?php
	if (!empty($def)) {
		$sel = 'disabled="disabled"';
		echo form_hidden('id_aplikasi', $def->id_aplikasi);
	}
	?>
	<p>

		<?php if (!empty($combo_aplikasi)) { ?>
			<label>Aplikasi</label><br><?php echo form_dropdown('id_aplikasi', $combo_aplikasi, @$def->id_aplikasi, 'class="combo-box form-control" style="width: 100%" id="pilih" ' . @$sel); ?>
	</p>
<?php  } else {
			echo form_hidden('id_aplikasi', $aplikasi->row()->id_aplikasi);
		}

		$codes = !empty($def->role) ? unserialize($def->role) : null;
?>
<div class="row">
	<div class="col-lg-12 akses-box">
		<?php
		foreach ($aplikasi->result() as $app) {

			if (!empty($app_data[$app->id_aplikasi])) {

				if ($app->folder == "referensi") { ?>

					<div class="card card-primary card-outline card-outline-tabs <?php echo ((!empty($def) and $def->id_aplikasi == $app->id_aplikasi) or $aplikasi->num_rows() == 1) ? null : "hide" ?> roled" id="aplikasi<?php echo  $app->id_aplikasi ?>">
						<div class="card-header p-0 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
								<?php
								$n = 1;
								foreach ($app_data[$app->id_aplikasi] as $k => $v) {
									if ($v != NULL) { ?>
										<li class="nav-item">
											<a class="nav-link <?php if ($n == 1) echo 'active' ?>" id="custom-tabs-four-<?php echo $n ?>-tab" data-toggle="pill" href="#custom-tabs-four-<?php echo $n ?>" role="tab" aria-controls="custom-tabs-four-<?php echo $n ?>" aria-selected="true"><?php echo $k ?></a>
										</li>
								<?php
									}
									$n += 1;
								} ?>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-four-tabContent">
								<?php
								$m = 1;
								foreach ($app_data[$app->id_aplikasi] as $k => $v) { ?>
									<div class="tab-pane fade <?php if ($m == 1) echo 'show active' ?>" id="custom-tabs-four-<?php echo $m ?>" role="tabpanel" aria-labelledby="custom-tabs-four-<?php echo $m ?>-tab">

										<?php echo $v;
										$m += 1; ?>
									</div><!-- /.tab-pane -->
								<?php } ?>
							</div>
						</div>
					</div>

				<?php } else { ?>
					<div class="<?php echo ((!empty($def) and $def->id_aplikasi == $app->id_aplikasi) or $aplikasi->num_rows() == 1) ? null : "hide" ?> roled roled-box" id="aplikasi<?php echo  $app->id_aplikasi ?>">

						<?php echo $app_data[$app->id_aplikasi]; ?>

					</div>

		<?php }
			}
		} ?>
	</div>

</div>
<div class="card-footer">
	<button class="btn btn-danger btn-md btn-form-cancel" type="button">Batal</button>
	<button href="#" class="btn btn-success btn-md float-right"> Simpan</button>
</div>
<?php echo  form_close() ?>


<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2();
		$('.btn-form-cancel').click(function() {
			$('#form-content,#form-title').html('');
			$('#form-box').slideUp();
			$('#box-main').show();
		});

		$('#pilih').change(function() {
			$('.roled').hide();
			$('#aplikasi' + $(this).val()).removeClass('hide').show();
			$('.incheck').each(function() {
				$(this).removeAttr('checked');
			});
		});

		$('input[type="checkbox"].incheck').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});

		$('#form-title').html('<?php echo $title; ?>');
	});
</script>
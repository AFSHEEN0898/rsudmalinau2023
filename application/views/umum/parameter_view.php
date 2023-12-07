<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js' ?>"></script>
<link href="<?php echo base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css' ?>" rel="stylesheet" type="text/css" />

<?php
$cnf = @$this->config->config['root'];
echo form_open('inti/pengaturan/save_aturan', 'id="form_save" enctype="multipart/form-data"')
?>

<div class="col-12 col-sm-12">
	<div class="card card-primary card-outline card-outline-tabs">
		<div class="card-header p-0 border-bottom-0">

			<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="custom-tabs-four-redaksi-tab" data-toggle="pill" href="#custom-tabs-four-redaksi" role="tab" aria-controls="custom-tabs-four-redaksi" aria-selected="true">Home</a>
				</li>
				<?php if (!empty($cnf) and $cnf == 1) { ?>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-four-sistem-tab" data-toggle="pill" href="#custom-tabs-four-sistem" role="tab" aria-controls="custom-tabs-four-sistem" aria-selected="false">Profile</a>
					</li>
				<?php } ?>
			</ul>

		</div>
		<div class="card-body">
			<div class="tab-content" id="custom-tabs-four-tabContent">

				<div class="tab-pane fade show active" id="custom-tabs-four-redaksi" role="tabpanel" aria-labelledby="custom-tabs-four-redaksi-tab">
					<div class="row">
						<div class="col-md-5">
							<div class="alert text-center" style="min-height: 130px; background: <?php echo $got['main_color'] ?>; color: #fff">
								<h4><strong>Logo Aplikasi</strong></h4><br />
								<p>
									<?php
									$path_logo = !empty($got['aplikasi_logo']) ? FCPATH . 'uploads/logo/' . $got['aplikasi_logo'] : null;
									$logos = (file_exists($path_logo) and !empty($got['aplikasi_logo'])) ? base_url() . 'uploads/logo/' . $got['aplikasi_logo'] : base_url() . 'assets/logo/logo.png';
									?>

									<img src="<?php echo $logos ?>" style="width: 100px;">
								<div class="col-12 text-center"><?php echo form_upload('logo_app'); ?></div>
								</p>
							</div>
							<?php echo
							form_hidden('param[]', 'aplikasi_logo') . 
							form_hidden('vale[]', !empty($got['aplikasi_logo']) ? $got['aplikasi_logo'] : null); ?>

							<div class="custom-control custom-checkbox">
								<?php echo form_checkbox('reset_logo', 1, FALSE, 'class="custom-control-input" id="customCheckbox1" ') ?>
								<label for="customCheckbox1" class="custom-control-label">Reset Logo</label>
							</div>
							<br>
							<div class="form-group">
								<?php echo
								form_label('Aplikasi (Kepanjangan)') . form_hidden('param[]', 'aplikasi') . form_input('vale[]', $got['aplikasi'], 'class="form-control"'); ?>
							</div>
							<div class="form-group">
								<?php echo
								form_label('Aplikasi (Kode HTML)') . form_hidden('param[]', 'aplikasi_code') . form_input('vale[]', $got['aplikasi_code'], 'class="form-control"') ?>
							</div>
							<div class="form-group">
								<?php echo
								form_label('Singkatan Aplikasi') . form_hidden('param[]', 'aplikasi_s') . form_input('vale[]', $got['aplikasi_s'], 'class="form-control"'); ?>
							</div>
							<div class="form-group">
								<?php 
								$color = !empty($got['main_color']) ? $got['main_color'] : null ;
								echo
								form_label('Warna Dasar') . form_hidden('param[]', 'main_color') . '<div class="input-group my-colorpicker2 colorpicker-element">
								<input name="vale[]" type="text" class="form-control" value="' . (!empty($got['main_color']) ? $got['main_color'] : null) . '" data-original-title title />
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-square" style="color: '.$color.' "></i></span>
								</div>
							</div>'; ?>
							</div>
						</div>
						<div class="col-md-7">
							<div class="alert text-center" style="min-height: 130px; background: <?php echo $got['main_color'] ?>; color: #fff">
								<div class="row">
									<div class="col-lg-6 col-6">
										<h4><strong>Logo Daerah</strong></h4><br />
										<p>
											<?php
											$path_inst_logo = !empty($got['pemerintah_logo']) ? FCPATH . 'uploads/logo/' . $got['pemerintah_logo'] : null;
											$logo_instansi = (file_exists($path_inst_logo) and !empty($got['pemerintah_logo'])) ? base_url() . 'uploads/logo/' . $got['pemerintah_logo'] : base_url() . 'assets/logo/brand.png';
											?>
											<img src="<?php echo $logo_instansi ?>" style="width: 100px; min-hight: 100px;">
										<div class="col-12 text-center"><?php echo form_upload('logo_pemerintah'); ?></div>
										</p>
									</div>
									<div class="col-lg-6 col-6">
										<h4><strong>Logo Daerah Cetak</strong></h4><br />
										<p><?php
											$std_brand_bw = file_exists(FCPATH . 'assets/logo/brand_bw.png') ? base_url() . 'assets/logo/brand_bw.png' : base_url() . 'assets/logo/brand.png';
											$path_inst_logo_bw = !empty($got['pemerintah_logo_bw']) ? FCPATH . 'uploads/logo/' . $got['pemerintah_logo_bw'] : null;
											$logo_instansi_bw = (file_exists($path_inst_logo_bw) and !empty($got['pemerintah_logo_bw'])) ? base_url() . 'uploads/logo/' . $got['pemerintah_logo_bw'] : $std_brand_bw; ?>

											<img src="<?php echo $logo_instansi_bw ?>" style="width: 100px; min-hight: 100px;">
										<div class="col-12 text-center"><?php echo form_upload('logo_pemerintah_bw'); ?></div>
										</p>
									</div>
								</div>
							</div>
							<div class="custom-control custom-checkbox">
								<?php echo form_checkbox('reset_logo_pemerintah', 1, FALSE, 'class="custom-control-input" id="customCheckbox2" ') ?>
								<label for="customCheckbox2" class="custom-control-label">Reset Logo Pemerintah</label>
							</div>
							<br>
							<?php echo
							form_hidden('param[]', 'pemerintah_logo') .
								form_hidden('vale[]', !empty($got['pemerintah_logo']) ? $got['pemerintah_logo'] : null) .
								form_hidden('param[]', 'pemerintah_logo_bw') .
								form_hidden('vale[]', !empty($got['pemerintah_logo_bw']) ? $got['pemerintah_logo_bw'] : null); ?>

							<div class="row">
								<div class="col-lg-8">
									<div class="form-group"><?php echo
															form_label('Naungan Instansi (Kepemerintahan)') . form_hidden('param[]', 'pemerintah') .
																form_input('vale[]', $got['pemerintah'], 'class="form-control"'); ?>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group"><?php echo
															form_label('Singkatan Naungan') . form_hidden('param[]', 'pemerintah_s') .
																form_input('vale[]', $got['pemerintah_s'], 'class="form-control"'); ?>
									</div>
								</div>
								<div class="col-lg-8">
									<div class="form-group"><?php echo
															form_label('Instansi') . form_hidden('param[]', 'instansi') .
																form_input('vale[]', $got['instansi'], 'class="form-control"'); ?>
									</div>
								</div>

								<div class="col-lg-4">
									<div class="form-group"><?php echo
															form_label('Singkatan Instansi') . form_hidden('param[]', 'instansi_s') .
																form_input('vale[]', $got['instansi_s'], 'class="form-control"'); ?>
									</div>
								</div>
							</div>

							<div class="form-group"><?php echo
													form_label('Instansi (Kode HTML)') . form_hidden('param[]', 'instansi_code') .
														form_input('vale[]', $got['instansi_code'], 'class="form-control"'); ?>
							</div>
							<div class="form-group"><?php echo
													form_label('Ibukota') . form_hidden('param[]', 'ibukota') .
														form_input('vale[]', $got['ibukota'], 'class="form-control"') ?>
							</div>
							<div class="form-group"><?php echo
													form_label('Alamat') . form_hidden('param[]', 'alamat') .
														form_textarea('vale[]', @$got['alamat'], 'class="form-control" style="height: 80px"') ?>
							</div>

						</div>
					</div>
				</div>

				<?php if (!empty($cnf) and $cnf == 1) { ?>
					<div class="tab-pane fade" id="custom-tabs-four-sistem" role="tabpanel" aria-labelledby="custom-tabs-four-sistem-tab">
						<div class="row">
							<div class="col-lg-6">
								<table class="table table-striped">
									<tbody>
										<tr>
											<td>Multi Unit Kerja</td>
											<td>
												<?php
												$d1 = (!empty($got['multi_unit']) and $got['multi_unit'] == 1) ? 'checked' : null;
												$d2 = (!empty($got['multi_unit']) and $got['multi_unit'] == 2) ? 'checked' : null; ?>
												<div class="form-group" style="margin: 0; padding: 0">
													<label>
														<input type="radio" value="1" name="multi_unit" class="flat-blue" <?php echo $d1 ?> /> &nbsp; Multi
													</label> &nbsp; &nbsp; &nbsp; &nbsp;
													<label>
														<input type="radio" value="2" name="multi_unit" class="flat-blue" <?php echo $d2 ?> /> &nbsp; Satu
													</label>
												</div>

											</td>

										</tr>
										<tr>
											<td>Demo</td>
											<td>
												<?php
												$c1 = (!empty($got['demo']) and $got['demo'] == 1) ? 'checked' : null;
												$c2 = (!empty($got['demo']) and $got['demo'] == 2) ? 'checked' : null; ?>
												<div class="form-group" style="margin: 0; padding: 0">
													<label>
														<input type="radio" value="1" name="demo" class="flat-blue" <?php echo $c1 ?> /> &nbsp; Demo
													</label> &nbsp; &nbsp; &nbsp; &nbsp;
													<label>
														<input type="radio" value="2" name="demo" class="flat-blue" <?php echo $c2 ?> /> &nbsp; Standar
													</label>
												</div>

											</td>

										</tr>
										<tr>
											<td>Login Captcha</td>
											<td>
												<?php
												$c1 = (!empty($got['login_captcha']) and $got['login_captcha'] == 1) ? 'checked' : null;
												$c2 = (!empty($got['login_captcha']) and $got['login_captcha'] == 2) ? 'checked' : null; ?>
												<div class="form-group" style="margin: 0; padding: 0">
													<label>
														<input type="radio" value="1" name="login_captcha" class="flat-blue" <?php echo $c1 ?> /> &nbsp; Captcha
													</label> &nbsp; &nbsp; &nbsp; &nbsp;
													<label>
														<input type="radio" value="2" name="login_captcha" class="flat-blue" <?php echo $c2 ?> /> &nbsp; Biasa
													</label>
												</div>

											</td>

										</tr>

										<tr>
											<td>Copyright</td>
											<td>
												<?php echo
												form_hidden('param[]', 'copyright') .
													form_input('vale[]', $got['copyright'], 'class="form-control" style="width: 160px"'); ?>
											</td>
										</tr>
										<tr>
											<td>Default Password</td>
											<td>
												<?php echo
												form_hidden('param[]', 'default_pass') .
													form_input('vale[]', @$got['default_pass'], 'class="form-control"'); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
		<div class="card-footer">
			<button class="btn btn-success btn-save">Simpan</button>
			<button class="btn btn-danger btn-reset float-right" act="<?php echo site_url('inti/pengaturan/reset_pengaturan') ?>">Reset</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".btn-save").click(function() {
			$("#form_save").submit();
		});
		$('.my-colorpicker2').colorpicker();
		$('.my-colorpicker2').on('colorpickerChange', function(event) {
			$('.my-colorpicker2 .fa-square').css('color', event.color.toString());
		});
		//$("select").select2();
		// $("input[type=\'radio\'].flat-blue, input[type=\'checkbox\'].flat-blue").iCheck({
		// 	checkboxClass: "icheckbox_minimal-blue",
		// 	radioClass: "iradio_minimal-blue"
		// });
		$(".btn-reset").click(function() {
			$(".form-delete-msg").html("Apakah anda yakin mereset pengaturan?");
			$(".form-title").html("Konfirmasi Reset Pengaturan");
			$(".form-delete-url").attr("href", $(this).attr("act")).children().html("Reset !");
			$("#modal-delete").modal("show");
			return false;
		});
	});
</script>
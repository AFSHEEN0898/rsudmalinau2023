<style>
.pasfotos-border { width: 200px; height: 300px; margin: 0 auto; overflow: hidden; padding: 30px 0; }
.pasfotos img { max-width: 150px; padding: 0; }
</style>
<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'; ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#btn-simpan-psw').click(function() {
			$('#form_password').submit();
		});
		$("#form_password").submit(function() {
			$('.loading').show();
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: "json",
				success: function(msg) {
					if (parseInt(msg.sign) == 404) {
						$(document).Toasts('create', {
							class: 'bg-danger',
							title: 'Pesan',
							subtitle: '',
							body: msg.teks,
							icon: 'fas fa-exclamation-triangle',
							autohide: true,
							delay: 3000,
							position: 'topRight',
						});
					} else {
						$(document).Toasts('create', {
							class: 'bg-success',
							title: 'Pesan',
							subtitle: '',
							body: msg.teks,
							icon: 'fas fa-check fa-lg',
							autohide: true,
							delay: 3000,
							position: 'topRight',
						});
					}
					$('.loading').hide();
				}
			});
			return false;
		});


		$('#btn-simpan-akun').click(function() {
			$('#form_akun').submit();
		});
		$("#form_akun").submit(function() {
			$('.loading').show();
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: "json",
				success: function(msg) {
					if (parseInt(msg.sign) == 404) {
						$(document).Toasts('create', {
							class: 'bg-danger',
							title: 'Pesan',
							subtitle: '',
							body: msg.teks,
							icon: 'fas fa-exclamation-triangle',
							autohide: true,
							delay: 3000,
							position: 'topRight',
						});
					} else {
						$(document).Toasts('create', {
							class: 'bg-success',
							title: 'Pesan',
							subtitle: '',
							body: msg.teks,
							icon: 'fas fa-check fa-lg',
							autohide: true,
							delay: 3000,
							position: 'topRight',
						});
					}
					$('.loading').hide();
				}
			});
			return false;
		});

		$('#btn-tutup-profil').click(function() {
			$('.profil').modal('hide');
		});
		$('#form-title').html('<?php echo $title; ?>');
		bsCustomFileInput.init();
		$('#frm_file').change(function() {
			$('#form_foto').submit();
		});
	});
</script>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Akun & Password</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body">
		<?php
		if (!empty($row)) { ?>
			<div class="alert alert-confirm" style="display: none"> <i class="fa fa-refresh fa-spin"></i> Proses ...</div>
			<div id="box_message" style="display: none"></div>
			<div id="box_message2" style="display: none"></div>
			<div class="card card-primary card-outline card-outline-tabs">
				<div class="card-header p-0 border-bottom-0">
					<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="custom-tabs-four-password-tab" data-toggle="pill" href="#custom-tabs-four-password" role="tab" aria-controls="custom-tabs-four-password" aria-selected="true">Password</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-four-photo-tab" data-toggle="pill" href="#custom-tabs-four-photo" role="tab" aria-controls="custom-tabs-four-photo" aria-selected="false">Photo</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content" id="custom-tabs-four-tabContent">
						<div class="tab-pane fade show active" id="custom-tabs-four-password" role="tabpanel" aria-labelledby="custom-tabs-four-password-tab">
							<?php echo form_open("/Home/update_akun", 'id="form_password"'); ?>
							<?php
							echo form_hidden('id_pegawai', $row->id_pegawai);
							echo form_hidden('username_asli', $row->username); ?>
							<div class="form-group"><?php echo form_label('Password Lama') . form_password('pwd_lama', '', 'class="form-control"'); ?></div>
							<div class="form-group"><?php echo form_label('Password Baru') . form_password('pwd_baru', '', 'class="form-control"'); ?></div>
							<div class="form-group"><?php echo form_label('Ulang Pass Baru') . form_password('pwd_baru2', '', 'class="form-control"'); ?></div>
							<div class="form-group"><button href="#" class="btn btn-success btn-simpan-psw"><i class="fa fa-lock"></i> &nbsp; Ubah Password</button></div>
							<?php echo form_close(); ?>
						</div>
						<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
							<?php echo form_open("/Home/update_akun", 'id="form_akun"'); ?>
							<?php
							echo form_hidden('id_pegawai', $row->id_pegawai);
							echo form_hidden('username_asli', $row->username);     ?>
							<div class="form-group"><?php echo form_label('Akun') . form_input('username', $row->username, 'class="form-control"'); ?></div>
							<div class="form-group"><?php echo form_label('Password Lama') . form_password('pwd_lama', '', 'class="form-control"'); ?></div>
							<div class="form-group"><button href="#" class="btn btn-success btn-simpan-akun"><i class="fa fa-user"></i> &nbsp; Ubah Akun</button></div>
							<?php echo form_close() ?>
						</div>
						<div class="tab-pane fade" id="custom-tabs-four-photo" role="tabpanel" aria-labelledby="custom-tabs-four-photo-tab">
							<?php echo
							form_open_multipart($link_foto . '/save_foto', 'id="form_foto"') .
								form_hidden('id_pegawai', $row->id_pegawai) .
								form_hidden('link_base', $link_base);
							if (!empty($offs)) echo form_hidden('offs', $offs);
							$pasfoto = !empty($row->photo) ? base_url() . 'uploads/kepegawaian/pasfoto/' . $row->photo : base_url() . 'assets/images/avatar.gif'; ?>
							<div class="pasfotos-border">
								<div class="pasfotos"><img src="<?php echo $pasfoto ?>" /></div>
							</div>
							<?php if (!empty($row->photo)) {
								echo form_hidden('foto_prev', $row->photo);
								$lbl = 'Ganti Foto';
							} else {
								$lbl = 'Unggah Foto';
							} ?>
							<div class="form-group">Unggah foto melalui tombol <i>browse</i><br>di bawah ini.</div>
							<div class="form-group">
								<label for="frm_file"><?php echo $lbl ?></label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="frm_file" name="foto">
										<label class="custom-file-label" for="frm_file">Pilih file</label>
									</div>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<!-- /.card -->
			</div>
		<?php } else { ?>
			<div class="alert">Anda tidak memiliki kewenangan mengubah akun ...</div>
		<?php } ?>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-default text-left" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</a>
		</div>
	</div>
</div>
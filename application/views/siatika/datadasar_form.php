<style>
	.pasfoto-border {
		width: 200px;
		height: 250px;
		overload: hidden;
		margin: 20px auto
	}

	.clearfix:after {
		content: " ";
		display: block;
		height: 0;
		clear: both;
	}
</style>

<style>
	/*.input-group { margin: -10px 0 0 0; }*/
	.mn-unit,
	.mn-bidang,
	.mn-jabatan {
		display: none;
	}

	.low {
		margin-top: -10px;
	}

	.title-form {
		margin: 10px -10px;
		background: #97B9C4;
		color: #fff;
		padding: 10px 20px;
		border-top: 1px solid #ddd;
		border-bottom: 1px solid #ccc;
		font-weight: 600;
		font-size: 16px;
	}

	.btn-footer {
		margin: 20px -10px 0 -10px;
		border-top: 1px solid #ddd;
		padding: 10px 10px 0 10px;
	}


	/*select2 readonly*/
	.select[readonly].select2-hidden-accessible+.select2-container {
		pointer-events: none;
		touch-action: none;
	}

	select[readonly].select2-hidden-accessible+.select2-container .select2-selection {
		background: #eee;
		box-shadow: none;
	}

	select[readonly].select2-hidden-accessible+.select2-container .select2-selection__arrow,
	select[readonly].select2-hidden-accessible+.select2-container .select2-selection__clear {
		display: none;
	}

	/*./select2 readonly*/
</style>


<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/typeahead/typeahead.min.js' ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		cek_tipe();
		$(".datemask").inputmask("dd/mm/yyyy", {
			"placeholder": "dd/mm/yyyy"
		});
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



		<?php if ($extended) { ?>

			$('#pilih_propinsi').change(function() {
				var id_bid = $(this).val();
				$('#pilih_kabupaten').html(null);
				$('#select2-pilih_kabupaten-container').html(' -- Pilih Kabupaten/Kota -- ');
				contentloader('<?php echo site_url($this->folder . '/pegawai/combo_kab/') ?>/' + id_bid, '#pilih_kabupaten');
			});

			$('#tipe').change(function() {
				cek_tipe();
			});
		<?php } ?>

		$('.typeahead').typeahead({
			ajax: '<?php echo site_url($this->folder . '/pegawai/auto_lokasi') ?>',
			displayField: 'lokasi',
			valueField: 'lokasi',
		});

	});

	function cek_tipe() {
		var id_tipe = $('#tipe').val();
		if (id_tipe) {
			$('#boxload').html('<i class="fa fa-spinner"></i> Memuat tipe pegawai ...').show();
			$.ajax({
				url: '<?php echo site_url($this->folder . '/pegawai/tipe/') ?>/' + id_tipe,
				dataType: "json",
				success: function(e) {
					if (e.tipe == "1") {
						$('#nip').children('label').text('NIP');
						$('#nip_lama').show();
						// $('input[name=mkg_tahun]').show();
						// $('input[name=mkg_bulan]').show();
						// $('input[name=cpns_tmt]').show();
						$('.dt-tmt').show();
						$('.tmt-cp-div').show();
					} else {
						$('#nip').children('label').text('No ID');
						$('#nip_lama').hide();
						// $('input[name=mkg_tahun]').hide();
						// $('input[name=mkg_bulan]').hide();
						// $('input[name=cpns_tmt]').hide();
						$('.dt-tmt').hide();
						$('.tmt-cp-div').hide();
					}
					$('#boxload').hide();
				}
			});
		}
	}

	function set_nomor() {
		s = '-';
		x_ruang = (!$('#sel_ruang').val()) ? '' : $('#sel_ruang').val();
		x_lemari = (!$('#sel_lemari').val()) ? '' : s + $('#sel_lemari').val();
		x_rak = (!$('#sel_rak').val()) ? '' : s + $('#sel_rak').val();
		x_map = (!$('#sel_map').val()) ? '' : s + $('#sel_map').val();
		$('#noberkas').val(x_ruang + x_lemari + x_rak + x_map);
	}

	function set_form_pns(e) {

		if (e == "1") {
			$('#nip').children('label').text('NIP');
			$('#nip_lama').show();
		} else {
			$('#nip').children('label').text('No ID');
			$('#nip_lama').hide();
		}

	}

	function nipFormat(a) {
		var c = a.value.replace(/[^\d\,\-]/g, '');
		return a.value = c;
	}


	<?php if (!empty($row->jenis_pegawai)) { ?>

		set_form_pns(<?php echo $row->jenis_pegawai; ?>);

	<?php } ?>

	// auto nip + (tidak termasuk 3 digit terakhir)
	// function tipeToNIP(){
	// 	var ttl = $('#tanggal_lahir').val();
	// 	var cpns = $('#cpns_tmt').val();
	// 	var jk = $('#id_jeniskelamin').val();

	// 	$.ajax({
	// 		url: "<?php echo site_url('kepegawaian/pegawai/store_nip'); ?>",
	// 		dataType : "JSON",
	// 		method : "POST",
	// 		data : {
	// 			ttl:ttl, cpns:cpns, jk:jk
	// 		},
	// 		success : function(data){
	// 			$('#nip_peg').attr('value', data);
	// 		}
	// 	});
	// }
	function tipeToNIP() {
		var ttl = $('#tanggal_lahir').val();
		var cpns = $('#cpns_tmt').val();
		var jk = $('#id_jeniskelamin').val();
		var last_nip = "<?php echo @$row->nip; ?>";
		$.ajax({
			url: "<?php echo site_url('kepegawaian/pegawai/store_nip'); ?>",
			dataType: "JSON",
			method: "POST",
			data: {
				ttl: ttl,
				cpns: cpns,
				jk: jk,
				ln: last_nip
			},
			success: function(data) {
				$('#nip_peg').attr('value', data);
			}
		});
	}

	// ./auto nip + (tidak termasuk 3 digit terakhir)

	$(document).ready(function() {
		$('#tanggal_lahir, #cpns_tmt, #id_jeniskelamin').change(function() {
			tipeToNIP();
		});
	});
</script>
<style>
	p {
		margin: 10px 0;
	}
</style>
<?php echo form_open_multipart($this->folder . "/pegawai/save_pegawai", 'id="form_pegawai"') ?>
<div id="alert"></div>
<div class="row">
	<div class="col-md-8">

		<div class="row">
			<div class="col-sm-12">

				<div class="card" id="box-main">
					<div class="card-header with-border">
						<h3 class="card-title"><i class="fa fa-user fa-btn"></i> &nbsp; Data Pribadi</h3>
						<button href="#" class="btn btn-success float-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
						<?php echo anchor($this->folder . '/pegawai', '<i class="fa fa-chevron-left"></i> Kembali', 'class="btn btn-default float-right" style="margin-right: 10px"') ?>
					</div>
					<div class="card-body">
						<div class="alert pull-left hide" id="boxload"><i class="fa fa-spinner"></i> &nbsp; Pemeriksaan form</div>
						<div class="clear"></div>
						<div class="row">
							<div class="col-lg-6">
								<?php
								echo form_hidden('id_pegawai', @$row->id_pegawai);
								//form_hidden('id_agama',1); 
								if (!empty($row)) {
									$sp = '-';
									$x = @explode($sp, $row->cpns_berkas);
								}
								// if ($extended) echo form_label('Tipe Pegawai').form_dropdown('id_tipe_pegawai',$combo_tipe,@$row->id_tipe_pegawai,'class="input-xlarge combo-box" id="tipe" required'); 
								// else echo '<input type="hidden" name="id_tipe_pegawai" id="tipe" value="1" />'; 

								echo '<input type="hidden" name="id_tipe_pegawai" id="tipe" value="1" />';
								?>

								<p><?php echo form_label('Nama Lengkap') . form_input('nama', (!empty($row->nama) ? $row->nama : null), 'class="form-control" required') ?></p>

								<?php if (in_array('gelar', $basis)) { ?>
									<p>
									<div class="row">
										<div class="col-lg-6 col-xs-6"><?php echo form_label('Gelar Depan') . form_input('gelar_depan', (!empty($row->gelar_depan) ? $row->gelar_depan : null), 'class="form-control" placeholder="G.Depan"') ?></div>
										<div class="col-lg-6 col-xs-6"><?php echo form_Label('Gelar Belakang') . form_input('gelar_belakang', @$row->gelar_belakang, 'class="form-control" placeholder="Belakang"') ?></div>
									</div>
									</p>
								<?php }
								if (in_array('jenis_kelamin', $basis)) { ?>
									<p><?php echo form_label('Jenis Kelamin') . form_dropdown('id_jeniskelamin', $combo_gender, @$row->id_jeniskelamin, 'required id="id_jeniskelamin" class="form-control combo-box"') ?></p>
									<p><?php echo form_label('Agama') . form_dropdown('id_agama', $combo_agama, @$row->id_agama, 'class="form-control combo-box"') ?></p>
								<?php } ?>
							</div>
							<div class="col-lg-6">
								<p><?php echo form_label('Tempat Lahir') . form_input('tempat_lahir', @$row->tempat_lahir, 'id="tempat_lahir" class="typeahead form-control" autocomplete="off"') ?></p>
								<p><?php echo form_label('Tanggal Lahir') . form_input('tanggal_lahir', (!empty($row->tanggal_lahir) ? tanggal($row->tanggal_lahir) : null), 'id="tanggal_lahir" class="datepicker form-control" required') ?></p>

								<p><?php echo form_label('Alamat') . form_textarea('alamat', @$row->alamat, 'class="form-control" style="height: 80px"') ?></p>
							</div>
						</div>
					</div>
				</div> <!-- end box identitas -->
			</div>


			<div class="col-sm-12">


				<div class="card" id="box-main">
					<div class="card-header with-border">
						<h3 class="card-title"><i class="fa fa-btn fa-file-alt"></i> &nbsp; Data Kepegawaian</h3>
					</div>
					<div class="card-body">
						<div class="row">


							<div class="col-lg-6">
								<!-- NIP -->
								<p id="nip"><?php echo
											form_label('NIP') .
												form_hidden('nip_sebelum', (!empty($row->nip) ? $row->nip : null)) .
												form_input('nip', (!empty($row->nip) ? $row->nip : null), 'id="nip_peg" class="form-control" onkeyup="return nipFormat(this)" maxlength="18" required') ?></p>

								<!-- ./NIP -->
								<p><?php echo form_label('Unit Kerja') . form_dropdown('id_unit', @$combo_unit, @$row->id_unit, 'class="form-control combo-box" id="pilih_propinsi"') ?></p>


								<?php echo form_label('Bidang', 'id_bidang', array('style' => '')); ?>
								<div class="box-kab">
									<?php echo form_dropdown(
										'id_bidang',
										!empty(@$combo_bidang) ? @$combo_bidang : array('' => ' -- Pilih Bidang --'),
										@$row->id_bidang,
										'class="form-control combo-box" style="width: 100%" id="pilih_kabupaten"'
									);
									?>
								</div>
							</div>

							<div class="col-lg-6">
								<p><?php echo form_label('Jabatan') . form_dropdown('id_jabatan', @$combo_jabatan, @$row->id_jabatan, 'class="form-control combo-box"') ?></p>
								<p><?php echo form_label('Eselon') . form_dropdown('id_eselon', @$combo_eselon, @$row->id_eselon, 'class="form-control combo-box"') ?></p>
								<p><?php echo form_label('Status Pegawai') . form_dropdown('id_status_pegawai', @$combo_status_pegawai, @$row->id_status_pegawai, 'class="form-control combo-box" id="peg_status"') ?></p>
								<p>
								<div id="golru_pns"><?php echo form_label('Golongan/Ruang') . form_dropdown('id_golru', @$combo_golru, @$row->id_golru, 'class="form-control combo-box"') ?></div>
								</p>

							</div>


						</div>
					</div>
				</div>
			</div> <!-- end box-body -->
		</div>
	</div>
	<?php if (in_array('foto', $basis)) { ?>
		<div class="col-md-4">
			<div class="card" id="box-main">
				<div class="card-header with-border">
					<h3 class="card-title"><i class="fa  fa-image"></i> &nbsp; Foto</h3>
				</div>
				<div class="card-body">
					<?php if (!empty($row->photo) and file_exists('./uploads/kepegawaian/pasfoto/' . $row->photo)) { ?>
						<div class="pasfoto-border">
							<div class="pasfoto">
								<center><img src="<?php echo base_url() . 'uploads/kepegawaian/pasfoto/' . $row->photo ?>" id="foto_pas" /></center>
							</div>
						</div>
						<input type="hidden" name="foto_prev" value="<?php echo $row->photo ?>" />
						<label>Ganti Foto</label><br><input type="file" name="foto">
					<?php } else { ?>
						<div class="pasfoto-border text-center">
							<div class="pasfoto">
								<center><img src="<?php echo base_url() . 'assets/images/avatar.gif' ?>" id="foto_pas" /></center>
							</div>
						</div>
						<label>Upload Foto</label><br>
						<input type="file" name="foto">

					<?php } ?>
				</div>
			</div>
		</div>
</div>
<?php } ?>

<div class="col-md-12">

</div>
</div>
</div>


<?php echo form_close() ?>

<?php
if (!empty(@$row->id_pegawai)) {
	$golru = "$('#golru_pns').show();";
} else {
	$golru = "$('#golru_pns').hide();";
}

?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.combo-box').css('width', '100%').select2();
		$('#foto_pas').css('width', $('.pasfoto-border').width() + 20 + 'px');
		<?php echo $golru;?>
		$('#peg_status').change(function() {
			console.log($(this).val());
			$.ajax({
				url: '<?php echo base_url('siatika/pegawai/cek_status/'); ?>' + $(this).val(),
				type: 'get',
				success: function(data) {
					console.log(data);
					var json = data;
					obj = JSON.parse(json);
					console.log(obj);
					if (obj.text == 'PNS') {
						$('#golru_pns').show();
					} else {
						$('#golru_pns').hide();
					}
				}
			});

		});

		$('.btn-suku-sw-mn').click(function() {
			$('.cb-suku').val(null);
			$('.box-suku').hide();
			$('.box-suku-mn').show();
		});
		$('.btn-suku-sw-oto').click(function() {
			$('.inp-suku').val(null);
			$('.box-suku-mn').hide();
			$('.box-suku').show();
		});

		$('.btn-wildat-sw-mn').click(function() {
			$('.cb-wildat').val(null);
			$('.box-wildat').hide();
			$('.box-wildat-mn').show();
		});
		$('.btn-wildat-sw-oto').click(function() {
			$('.inp-wildat').val(null);
			$('.box-wildat-mn').hide();
			$('.box-wildat').show();
		});

		$('.btn-pemdat-sw-mn').click(function() {
			$('.cb-pemdat').val(null);
			$('.box-pemdat').hide();
			$('.box-pemdat-mn').show();
		});
		$('.btn-pemdat-sw-oto').click(function() {
			$('.inp-pemdat').val(null);
			$('.box-pemdat-mn').hide();
			$('.box-pemdat').show();
		});

		$('#form_pegawai').submit(function() {
			// alert($('#tipe').val());
			// return false;
			if (
				$('#pilih_kabupaten').val() ||
				$('#pilih_propinsi').val()) {

				if (
					!$('#pilih_kabupaten').val() ||
					!$('#pilih_propinsi').val()) {

					$('#alert').addClass('alert alert-danger').html('Unit, Bidang harus diisi lengkap<br>atau dikosongkan sementara ...');
					return false;
				}

			}

			// if ($('#tipe').val() === 1) {
			if ($('#nip_peg').val().length != 18 && $('#tipe').val() === '1') {
				$('#alert').addClass('alert alert-danger').html('NIP tidak valid, harus 18 digit ...');
				return false
			}
			// }



		});

	});
</script>
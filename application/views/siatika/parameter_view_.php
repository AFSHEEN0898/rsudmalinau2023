<script src="<?php echo base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url() . 'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css' ?>" rel="stylesheet" type="text/css" />
<div id="alert"></div>

<div class="row">
	<div class="col-lg-12">
		<?php echo form_open('kepegawaian_tv/parameter/simpan', 'role="form" id="form_parameter"'); ?>
		<div class="card">
			<div class="card-body">
				<h6><b>Pengaturan Tinggi/Durasi</b></h6>
				<hr>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Lama Durasi Refresh Halaman</label>
						<?php echo
						form_hidden('keys[]', 'all_reload') . '<div class="input-group">' .
							form_input('vals[]', !empty($vals['all_reload']) ? $vals['all_reload'] : null, '
						class="form-control inp_reload" placeHolder="Detik ... contoh : 1800" required') ?>
						<span class="input-group-append"><span class="input-group-text"><i class="fas fa-clock fa-btn"></i> Detik</span></span>
					</div>
				</div>
				<div class="form-group col-md-6">
					<label>Tinggi Kolom Widget</label>
					<?php echo
					form_hidden('keys[]', 'height_konten') . '<div class="input-group">' .
						form_input('vals[]', !empty($vals['height_konten']) ? $vals['height_konten'] : null, '
						class="form-control inp_konten" placeHolder=" ... contoh : 500" required') ?>
					<span class="input-group-append"><span class="input-group-text"><i class="fas fa-cube fa-btn"></i> Pixel</span></span>
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label>Tinggi Kolom Pengumuman</label>
				<?php echo
				form_hidden('keys[]', 'height_sidebar_1') . '<div class="input-group">' .
					form_input('vals[]', !empty($vals['height_sidebar_1']) ? $vals['height_sidebar_1'] : null, '
						class="form-control inp_sidebar_1" placeHolder=" ... contoh : 300" required') ?>
				<span class="input-group-append"><span class="input-group-text"><i class="fas fa-cube fa-btn"></i> Pixel</span></span>
			</div>
		</div>
		<div class="form-group col-md-6">
			<label>Tinggi Kolom Galeri</label>
			<?php echo
			form_hidden('keys[]', 'height_sidebar_2') . '<div class="input-group">' .
				form_input('vals[]', !empty($vals['height_sidebar_2']) ? $vals['height_sidebar_2'] : null, '
						class="form-control inp_sidebar_2" placeHolder=" ... contoh : 300" required') ?>
			<span class="input-group-append"><span class="input-group-text"><i class="fas fa-cube fa-btn"></i> Pixel</span></span>
		</div>
		<br><br>
		<h6><b>Pengaturan Warna</b></h6>
		<hr>
	</div>
	<br>

	<!-- isian form warna -->
	<div class="form-group col-md-3">
		<label>Warna Background Header</label>
		<?php echo
		form_hidden('keys[]', 'header_color') . '<div class="input-group colorize">' .
			form_input('vals[]', !empty($vals['header_color']) ? $vals['header_color'] : null, '
								class="form-control header_color" placeHolder=" ... contoh : #500380" required') ?>
		<span class="input-group-text">
			<span class="input-group-addon"><i></i></span>
		</span>
	</div>
</div>
<div class="form-group col-md-3">
	<label>Warna Teks Header</label>
	<?php echo
	form_hidden('keys[]', 'color_text_header') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['color_text_header']) ? $vals['color_text_header'] : '#fff', '
								class="form-control color_text_header" placeHolder=" ... contoh : #ffffff"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Background Dasar</label>
	<?php echo
	form_hidden('keys[]', 'basic_color') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['basic_color']) ? $vals['basic_color'] : null, '
								class="form-control basic_color" placeHolder=" ... contoh : #b781cb" required') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Teks Dasar</label>
	<?php echo
	form_hidden('keys[]', 'color_text_basic') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['color_text_basic']) ? $vals['color_text_basic'] : '#000', '
								class="form-control color_text_basic" placeHolder=" ... contoh : #000000"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Background Judul</label>
	<?php echo
	form_hidden('keys[]', 'title_color') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['title_color']) ? $vals['title_color'] : '#000', '
								class="form-control title_color" placeHolder=" ... contoh : #000000"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>
<div class="form-group col-md-3">
	<label>Warna Teks Judul</label>
	<?php echo
	form_hidden('keys[]', 'color_text_title') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['color_text_title']) ? $vals['color_text_title'] : '#f8c300', '
								class="form-control color_text_title" placeHolder=" ... contoh : #f8c300"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Background Kolom</label>
	<?php echo
	form_hidden('keys[]', 'column_color') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['column_color']) ? $vals['column_color'] : '#fff', '
								class="form-control column_color" placeHolder=" ... contoh : #ffffff"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Teks Kolom</label>
	<?php echo
	form_hidden('keys[]', 'color_text_column') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['color_text_column']) ? $vals['color_text_column'] : '#000', '
								class="form-control color_text_column" placeHolder=" ... contoh : #000000"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Background Jam</label>
	<?php echo
	form_hidden('keys[]', 'time_color') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['time_color']) ? $vals['time_color'] : '#f8c300', '
								class="form-control time_color" placeHolder=" ... contoh : #f8c300"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>
<div class="form-group col-md-3">
	<label>Warna Teks Jam</label>
	<?php echo
	form_hidden('keys[]', 'color_text_time') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['color_text_time']) ? $vals['color_text_time'] : '#fff', '
								class="form-control color_text_time" placeHolder=" ... contoh : #ffffff"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Background Tanggal</label>
	<?php echo
	form_hidden('keys[]', 'date_color') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['date_color']) ? $vals['date_color'] : '#000', '
								class="form-control date_color" placeHolder=" ... contoh : #000000"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Teks Tanggal</label>
	<?php echo
	form_hidden('keys[]', 'color_text_date') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['color_text_date']) ? $vals['color_text_date'] : '#000', '
								class="form-control color_text_date" placeHolder=" ... contoh : #000000"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Background Teks Bergerak</label>
	<?php echo
	form_hidden('keys[]', 'marquee_color') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['marquee_color']) ? $vals['marquee_color'] : '#f8c300', '
								class="form-control marquee_color" placeHolder=" ... contoh : #f8c300"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

<div class="form-group col-md-3">
	<label>Warna Teks Bergerak</label>
	<?php echo
	form_hidden('keys[]', 'color_text_marquee') . '<div class="input-group colorize">' .
		form_input('vals[]', !empty($vals['color_text_marquee']) ? $vals['color_text_marquee'] : '#fff', '
								class="form-control color_text_marquee" placeHolder=" ... contoh : #ffffff"') ?>
	<span class="input-group-text">
		<span class="input-group-addon"><i></i></span>
	</span>
</div>
</div>

</div>
<br>
<div class="footer">
	<span class="btn btn-success btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan Pengaturan</span>
</div>
<?php echo form_close(); ?>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".colorize").colorpicker();

		$('.btn-simpan').click(function() {
			$('#form_parameter').submit();
		});

		$('#form_parameter').submit(function() {

			/*if (!$('.inp_menit').val()) {
					
				$('#alert').addClass('alert alert-danger').html('Isian tidak boleh kosong!');
				return false;	
			}*/
			if (!$('.inp_reload').val()) {

				$('#alert').addClass('alert alert-danger').html('Durasi Refresh tidak boleh kosong !');
				return false;
			}


		});

	});
</script>
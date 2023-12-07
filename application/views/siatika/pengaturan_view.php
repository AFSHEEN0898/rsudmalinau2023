<script src="<?php echo base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js');?>" type="text/javascript"></script>
<link href="<?php echo base_url().'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css'?>" rel="stylesheet" type="text/css" />
<div id="alert"></div>
		<div class="box">
			<?php echo form_open(@$link,'role="form" id="form_parameter"'); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-5">
						<label>Lama Durasi Refresh Halaman</label>
						<p><?php echo 
							form_hidden('keys[]','all_reload').'<div class="input-group">'.
							form_input('vals[]',!empty($vals['all_reload'])?$vals['all_reload']:null,'
								class="form-control inp_reload" placeHolder="Detik ... contoh : 30" required') ?>
								<span class="input-group-addon"><i class="fa fa-clock-o fa-btn"></i> Detik</span></div>
						</p>

						<label>Tinggi Kolom Widget</label>
						<p><?php echo 
							form_hidden('keys[]','height_konten').'<div class="input-group">'.
							form_input('vals[]',!empty($vals['height_konten'])?$vals['height_konten']:null,'
								class="form-control inp_konten" placeHolder=" ... contoh : 500" required') ?>
								<span class="input-group-addon"><i class="fa fa-arrows-v fa-btn"></i> Pixel</span></div>
						</p>
						<label>Tinggi Kolom Pengumuman</label>
						<p><?php echo 
							form_hidden('keys[]','height_sidebar_1').'<div class="input-group">'.
							form_input('vals[]',!empty($vals['height_sidebar_1'])?$vals['height_sidebar_1']:null,'
								class="form-control inp_sidebar_1" placeHolder=" ... contoh : 300" required') ?>
								<span class="input-group-addon"><i class="fa fa-arrows-v fa-btn"></i> Pixel</span></div>
						</p>
						<label>Tinggi Kolom Buku Tamu</label>
						<p><?php echo 
							form_hidden('keys[]','height_sidebar_2').'<div class="input-group">'.
							form_input('vals[]',!empty($vals['height_sidebar_2'])?$vals['height_sidebar_2']:null,'
								class="form-control inp_sidebar_2" placeHolder=" ... contoh : 300" required') ?>
								<span class="input-group-addon"><i class="fa fa-arrows-v fa-btn"></i> Pixel</span></div>
						</p>
					</div>
					<div class="col-lg-5">
						<div class="row">
							<div class="col-lg-6">
								<label>Warna Background Header</label>
								<p><?php echo 
									form_hidden('keys[]','header_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['header_color'])?$vals['header_color']:null,'
										class="form-control header_color" placeHolder=" ... contoh : #500380" required') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Background Dasar</label>
								<p><?php echo 
									form_hidden('keys[]','basic_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['basic_color'])?$vals['basic_color']:null,'
										class="form-control basic_color" placeHolder=" ... contoh : #b781cb" required') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
							<div class="col-lg-6">
								<label>Warna Teks Header</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_header').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_header'])?$vals['color_text_header']:'#fff','
										class="form-control color_text_header" placeHolder=" ... contoh : #ffffff"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Teks Dasar</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_basic').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_basic'])?$vals['color_text_basic']:'#000','
										class="form-control color_text_basic" placeHolder=" ... contoh : #000000"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
							<div class="col-lg-6">
								<label>Warna Background Judul</label>
								<p><?php echo 
									form_hidden('keys[]','title_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['title_color'])?$vals['title_color']:'#000','
										class="form-control title_color" placeHolder=" ... contoh : #000000"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Background Kolom</label>
								<p><?php echo 
									form_hidden('keys[]','column_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['column_color'])?$vals['column_color']:'#fff','
										class="form-control column_color" placeHolder=" ... contoh : #ffffff"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
							<div class="col-lg-6">
								<label>Warna Teks Judul</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_title').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_title'])?$vals['color_text_title']:'#f8c300','
										class="form-control color_text_title" placeHolder=" ... contoh : #f8c300"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Teks Kolom</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_column').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_column'])?$vals['color_text_column']:'#000','
										class="form-control color_text_column" placeHolder=" ... contoh : #000000"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
							<div class="col-lg-6">
								<label>Warna Background Galeri</label>
								<p><?php echo 
									form_hidden('keys[]','galeri_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['galeri_color'])?$vals['galeri_color']:'#000','
										class="form-control galeri_color" placeHolder=" ... contoh : #000000"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Background Jam</label>
								<p><?php echo 
									form_hidden('keys[]','time_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['time_color'])?$vals['time_color']:'#f8c300','
										class="form-control time_color" placeHolder=" ... contoh : #f8c300"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
							<div class="col-lg-6">
								<label>Warna Teks Galeri</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_galeri').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_galeri'])?$vals['color_text_galeri']:'#000','
										class="form-control color_text_galeri" placeHolder=" ... contoh : #000000"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Teks Jam</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_time').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_time'])?$vals['color_text_time']:'#fff','
										class="form-control color_text_time" placeHolder=" ... contoh : #ffffff"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
							<div class="col-lg-7">
								<label>Warna Background Tanggal</label>
								<p><?php echo 
									form_hidden('keys[]','date_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['date_color'])?$vals['date_color']:'#000','
										class="form-control date_color" placeHolder=" ... contoh : #000000"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Background Teks Bergerak</label>
								<p><?php echo 
									form_hidden('keys[]','marquee_color').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['marquee_color'])?$vals['marquee_color']:'#f8c300','
										class="form-control marquee_color" placeHolder=" ... contoh : #f8c300"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
							<div class="col-lg-5">
								<label>Warna Teks Tanggal</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_date').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_date'])?$vals['color_text_date']:'#000','
										class="form-control color_text_date" placeHolder=" ... contoh : #000000"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
								<label>Warna Teks Bergerak</label>
								<p><?php echo 
									form_hidden('keys[]','color_text_marquee').'<div class="input-group colorize">'.
									form_input('vals[]',!empty($vals['color_text_marquee'])?$vals['color_text_marquee']:'#fff','
										class="form-control color_text_marquee" placeHolder=" ... contoh : #ffffff"') ?>
										<span class="input-group-addon"><i></i></span></div>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="box-footer">
				<span class="btn btn-success btn-simpan btn-flat"><i class="fa fa-save"></i> &nbsp; Simpan</span>
				
			</div>
			<?php echo form_close(); ?>
		</div>

<script type="text/javascript">
	
	$(document).ready(function() {

		$(".colorize").colorpicker();

		$('.btn-simpan').click(function() {
			$('#form_parameter').submit();
		});
		
		$('#form_parameter').submit(function() {
			
			if (!$('.inp_reload').val()) {
					
				$('#alert').addClass('alert alert-danger').html('Durasi Refresh tidak boleh kosong !');
				return false;	
			}
			
			
		});
		
	});
	
</script>
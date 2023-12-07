<?php $code = $this->uri->segment(4);
?>
<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'; ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {


		<?php


		if ($code == 1 || $code == 2) { ?>


			$('#date_start').datetimepicker({
				format: 'yyyy-mm-dd hh:ii:ss',
				endDate: '+0d'
			});
		<?php } ?>

		tinymce.init({
			selector: "textarea",

			mode: "exact",
			theme: "modern",
			width: '300',
			height: "300",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality filemanager"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image preview media | print | code",
			image_advtab: true,
			templates: [{
					title: 'Test template 1',
					content: 'Test 1'
				},
				{
					title: 'Test template 2',
					content: 'Test 2'
				}
			]
		});

	});




	function getPermalink(data) {
		var permalink = data.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '_').toLowerCase();
		$('.url').html('<?php echo site_url('siatika/articles') ?>/' + permalink);
		$('.hi_permalink').attr('value', permalink);
	}



	function simpan_artikel() {
		var c_kategori = $('#kategori').val();
		var c_judul = $('#title').val();
		var c_date_start = $('#date_start').val();

		var c_date_end = $('#date_end').val();
		var c_tempat = $('#tempat').val();
		if (c_kategori == '') {
			$('#alert').addClass('alert alert-error').html('Kategori harus dipilih').show();
		} else if (c_judul == '') {
			$('#alert').addClass('alert alert-error').html('Judul harus diisi').show();
		} else if (c_date_start == '') {
			if (<?php echo $code; ?> == 3) {
				$('#alert').addClass('alert alert-error').html('Tanggal Mulai harus diisi').show();
			} else {
				$('#alert').addClass('alert alert-error').html('Tanggal harus diisi').show();
			}
		} else if (c_date_end == '') {
			$('#alert').addClass('alert alert-error').html('Tanggal Selesai harus diisi').show();
		} else if (c_tempat == '') {
			$('#alert').addClass('alert alert-error').html('Tempat harus diisi').show();

		} else {
			$('#form_article').submit();
		}


	}
</script>
<style type="text/css">
	section.content-header {
		padding-left: 25px;
	}
</style>
<?php (isset($default)) ? $row = $default->row() : $row = ''; ?>

<?php echo form_open_multipart('siatika/articles/save_article', 'id=form_article'); ?>
<div class="">
	<div class="row">
		<section class="col-lg-7 connectedSortable">
			<div class="card" id="box-main">
				<div class="card-body">
					<div id="alert"></div>
					<?php echo form_hidden('id_art', (!empty($row)) ? $row->id_article : ''); ?>
					<input type='hidden' name='sec' value='<?php echo $code ?>' class='code'>
					<?php if ($code != '3') {
						echo form_hidden('date_end', '0000-00-00 00:00:00');
					} ?>
					<div class="col-lg-12" style="padding-right:0px !important;">
						<div class="col-lg-12" style="float:left;background:#f9f9f9;border:1px solid #f1f1f1;padding:10px!important;">

							<div class="form-group">
								<p>
									<?php echo form_label('Kategori <code>*</code>') . form_dropdown('id_kategori', @$combo_kategori, @$row->id_kategori, 'class="form-control combo-box" id="kategori" style="width:100%" required') ?></p>

								<?php if ($code == '3') { ?>
									<label for="title">Nama Agenda <code>*</code></label>
								<?php } else { ?>
									<label for="title">Judul <code>*</code></label>
								<?php } ?>
								<input value="<?php echo (!empty($row)) ? $row->title : ''; ?>" id="title" class="form-control" name="title" type="text" autocomplete="off" onkeyup="getPermalink(this.value)" placeholder="Masukkan judul disini" required title="Judul Artikel Tidak Boleh Kosong">
								</p>
								<?php if ($code != '12') { ?>
									<p>

							</div>
							<input type="hidden" name="permalink" class="hi_permalink" value="<?php echo @$row->permalink ?>">
							<span class="permalink">Permalink</span> : <span class="url"></span></p>
						<?php } else { ?>

							<?php $gambar = array('name' => 'fupload', 'style' => 'border:1px solid #CCC', 'class' => 'required'); ?>
							<?php if (!empty($default)) $row = $default->row(); ?>
							<?php if (!empty($foto)) $ft = $foto->row(); ?>


							<label>Gambar</label>
							<?php echo form_upload($gambar) ?><br><br>
							<?php if ($title == "Ubah Slideshow") { ?>


								<?php if (!empty($ft->file_name)) $file = $ft->file_name;
										else $file = "no_image.jpg";
								?>
								<img src="<?php echo base_url('uploads/photos/' . $file) ?>" width="120" height="120"><br><br>
							<?php } ?>
						<?php } ?>
						</div>


						<?php if ($code == '3') { ?>

							<div class="form-group">
								<label for="title">Tempat <code>*</code></label>
								<p>
									<input value="<?php echo (!empty($row)) ? @$row->tempat : ''; ?>" id="tempat" class="form-control" name="tempat" type="text" autocomplete="off" placeholder="Masukkan tempat disini" required title="Judul Artikel Tidak Boleh Kosong">
								</p>
							</div>
							<div class="row">
								<div class="col-lg-5 no-padding">
									<p><label>Tanggal Mulai <code>*</code></label>
										<?php echo form_input(array('name' => 'date_start', 'id' => 'date_start', 'class' => 'form-control', 'required' => true), !empty($row->date_start) ? $row->date_start :  date('Y-m-d h:i:s')) ?></p>
								</div>
								<div class="col-lg-2" style="text-align:center">
									<label> <span class="badge badge-secondary" style="margin-top: 40px;">s.d</span> </label>
								</div>
								<div class="col-lg-5 no-padding">
									<p><label>Tanggal Selesai <code>*</code></label>
										<?php echo form_input(array('name' => 'date_end', 'id' => 'date_end', 'class' => 'form-control', 'required' => true), !empty($row->date_end) ? $row->date_end :  date('Y-m-d h:i:s')) ?></p>
								</div>
							</div>
							<div class="clear"></div>
							<div class="form-group">
								<label for="title">Kontak Person</label>
								<p>
									<input value="<?php echo (!empty($row)) ? @$row->kontak : ''; ?>" id="kontak" class="form-control" name="kontak" type="text" autocomplete="off" placeholder="Masukkan kontak person disini" required="" title="Kontak Tidak Boleh Kosong">
								</p>
							</div>
						<?php } ?>
						<?php if ($code == '3') { ?>
							<p>
								<label for="title">Keterangan</label>
								<textarea name="content" class="textarea text-area" style=""><?php echo (!empty($row)) ? stripslashes($row->content) : ''; ?></textarea>

							</p>
						<?php } elseif ($code == '12') {

						?>
							<p><label for="title">link</label>
								<input value="<?php echo (!empty($row)) ? @$row->content : ''; ?>" id="content" class="form-control" name="content" type="text" autocomplete="off" placeholder="Masukkan link disini" required="" title="Kontak Tidak Boleh Kosong">
							</p>
							<?php
							$chk_b = '';
							$chk_s = '';
							if (!empty($row)) {
								if ($row->extend == '_blank') $chk_b = 'TRUE';
								else if ($row->extend == 'self') $chk_s = 'TRUE';
								else {
									$chk_b = '';
									$chk_s = '';
								}
							}
							?>
							<p><label>Buka Sebagai</label>
								<?php echo form_radio('target', '_blank', $chk_b, 'class="required"') ?> Halaman Baru
								<?php echo form_radio('target', '_self', $chk_s, 'class="required"') ?> Masih Halaman Ini</p>



						<?php } else { ?>
							<p>
								<textarea name="content" class="textarea text-area" style=""><?php echo (!empty($row)) ? stripslashes($row->content) : ''; ?></textarea>

							</p>

						<?php } ?>


						<?php
						if (!empty($row->id_article)) {
							$cl = 'btn-warning';
							$tbl = 'Update';
						} else {
							$cl = 'btn-success';
							$tbl = 'Simpan';
						}
						?>

						<a class="btn <?php echo $cl ?>" onclick="simpan_artikel()"><i class="icon-white icon-ok-sign"></i> <?php echo $tbl ?></a>

						<!-- <a href="javascript:history.go(-1)" class="btn btn-danger"><i class="icon-white icon-remove"></i> Batal</a> -->
						<a href="<?php echo base_url('siatika/articles/list_data/' . $code); ?>" class="btn btn-danger"><i class="icon-white icon-remove"></i> Batal</a>


					</div>
					<div class="clear"></div>
				</div>
			</div>

		</section>
		<section class="col-lg-5 connectedSortable">
			<div class="card">
				<div class="card-body">
					<div class="col-lg-12 no-padding">
						<?php if ($code == 1 || $code == 2 || $code == 4 || $code == 14) { ?>
							<div class="col-lg-12">
								<div class="box box-primary">
									<div class="box-header" style="border-bottom:1px solid #f4f4f4">
										<h3 class="box-title">Terbitkan</h3>
									</div>
									<div class="box-body">
										<label>Tanggal Publikasi <code>*</code></label>

										<div class="input-group mb-3">
											<input type="text" name="date_start" class="form-control" required value="<?php echo  !empty($row->date_start) ? $row->date_start :  date('Y-m-d h:i:s'); ?>" id="date_start"></p>

											<div class="input-group-append">
												<span class="input-group-text"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>

								</div>
							</div>
						<?php } ?>
						<div id="div-cat" class="col-lg-12"></div>

					</div>
				</div>
			</div>
		</section>
	</div>
</div>
<?php echo form_close(); ?>
<script>
	initMce();
	$("#kategori").select2();

	$('#date_start').datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss'
	});
	$('#date_end').datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss'
	});
	$(document).ready(function() {
		$(".datemask").inputmask("dd/mm/yyyy", {
			"placeholder": "dd/mm/yyyy"
		});

		$('#form-title').html('<?php echo $title; ?>');
		bsCustomFileInput.init();
	});
	$(function() {

		//Datemask dd/mm/yyyy
		$("#datemask").inputmask("dd/mm/yyyy", {
			"placeholder": "dd/mm/yyyy"
		});
		//Datemask2 mm/dd/yyyy
		$("#datemask2").inputmask("mm/dd/yyyy", {
			"placeholder": "mm/dd/yyyy"
		});
		//Money Euro
		$("[data-mask]").inputmask();

		//Timepicker
		$(".timepicker").timepicker({
			autoclose: true,
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false,
			showInputs: false
			/*defaultTime:true*/
		});
		/*showInputs: false
    });*/
	});
</script>
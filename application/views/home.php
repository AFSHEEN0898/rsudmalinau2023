<?php
$st = get_stationer();
$s = $this->session->userdata('login_state');

?>
<!DOCTYPE html>
<html style="height: auto;">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo $st['aplikasi_s'] . ' - ' . $st['aplikasi'] ?></title>
	<style type="text/css">
		.by {
			vertical-align: bottom;
			height: 34px;
			border: 1px rgba(191, 191, 191, 0.6) solid;
		}

		.hide {
			display: none;
		}

		.app-icon {
			width: 30px;
			height: 30px;
			border-radius: 50%;
			text-align: center;
		}

		.app-icon img {
			max-width: 22px;
			margin-top: 4px;
		}

		.control-sidebar-heading {
			font-weight: 400;
			font-size: 16px;
			padding: 10px 0;
			margin-bottom: 10px;
			line-height: 1.1em;
		}

		.control-sidebar-heading .logo-brand img {
			max-width: 50px;
			padding: 0 10px 20px 0;
			margin-top: 0px;
			float: left;
		}

		.control-sidebar-menu {
			list-style: none;
			padding: 0;
			margin: 0 -15px;
		}
	</style>
	<link href="<?php echo base_url() . 'assets/css/all.min.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url() . 'assets/plugins/ionicons/ionicons.min.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url() . 'assets/css/OverlayScrollbars.min.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url() . 'assets/css/adminlte.min.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>" rel="stylesheet" />
	<link href="<?php echo base_url() . 'assets/plugins/select2/select2.min.css' ?>" rel="stylesheet">
	<!-- <link href="<?php echo base_url() . 'assets/css/general.css' ?>" rel="stylesheet"> -->
	<link href="<?php echo base_url() . 'assets/plugins/izitoast/iziToast.min.css' ?>" rel="stylesheet">
	<!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
	<link href="<?php echo base_url() ?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() . 'assets/bootstrap/css/datetimepicker.css' ?>" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url() . 'assets/js/jquery.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/js/jquery-ui.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/js/bootstrap.bundle.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/select2/select2.full.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/js/jquery.overlayScrollbars.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/js/adminlte.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/izitoast/iziToast.min.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<script src="<?php echo base_url() . 'assets/plugins/input-mask/jquery.inputmask.js' ?>" type="text/javascript"></script>
	<script src="<?php echo base_url() . 'assets/plugins/input-mask/jquery.inputmask.date.extensions.js' ?>" type="text/javascript"></script>
	<script src="<?php echo base_url() . 'assets/plugins/input-mask/jquery.inputmask.extensions.js' ?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap-datetimepicker.js'); ?>"></script>
	<!-- <script src="<?php echo base_url('assets/plugins/tinymce/js/tinymce/tinymce.min.js'); ?>" type="text/javascript"></script> -->
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . 'assets/js/general.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'; ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/timepicker/bootstrap-timepicker.js' ?>" type="text/javascript"></script>
	<script src="http://www.youtube.com/player_api"></script>
	<script>
		$(function() {
			//Initialize Select2 Elements
			$('.combo-box').select2();
		});
	</script>
	<style>
		.select2-container--default .select2-selection--single {

			border: 1px solid #ced4da !important;
			padding: .46875rem .75rem !important;
			height: calc(2.25rem + 2px) !important;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {

			padding-left: 0 !important;
			height: auto !important;
			margin-top: -3px !important;
		}

		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 31px !important;
			right: 6px !important;
		}
	</style>
</head>


<body class="sidebar-mini layout-fixed" style="height: auto;">
	<?php
	$on = get_role($this->session->userdata("id_pegawai"));
	$dircut = !empty($dircut) ? $dircut : $this->uri->segment(1);
	$app = @$on['aplikasi'][$dircut];
	//cek(count((array) @$on['aplikasi']));
	$username = $this->session->userdata('username');
	$nama = $this->session->userdata('nama');
	$id_operator = $this->session->userdata('id_pegawai');
	$file = $this->general_model->datagrab(array('tabel' => 'peg_pegawai', 'where' => array('id_pegawai' => $id_operator)))->row();
	//cek($this->db->last_query());
	$ava = (!empty($file->photo) and file_exists('./uploads/kepegawaian/pasfoto/' . $file->photo)) ? base_url() . 'uploads/kepegawaian/pasfoto/' . $file->photo : base_url() . 'assets/images/avatar.gif';
	$nama = $this->session->userdata('nama');
	?>

	<div class="wrapper">

		<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">


				<li class="nav-item dropdown">
					<a class="nav-link user-panel d-flex" data-toggle="dropdown" href="#" aria-expanded="false">
						<?php if ($s == "root") { ?>
							<img src="<?php echo $ava; ?>" class="img-circle" alt="Root" style="width: 24px">
							&nbsp; Root
						<?php } else { ?>
							<img src="<?php echo $ava; ?>" alt="<?php echo $nama ?>" class="img-circle" style="width: 24px"> &nbsp;
							<?php echo $nama ?>
						<?php } ?>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
						<div class="card card-widget widget-user" style="margin-bottom: 0rem">
							<!-- Add the bg color to the header using any of the bg-* classes -->
							<?php if ($s == "root") { ?>
								<div class="widget-user-header" style="background-color: #343a40">
									<h3 class="widget-user-username" style="color: #f8f9fa ">Root</h3>
								</div>
								<div class="widget-user-image">
									<img class="img-circle elevation-2" src="<?php echo $ava; ?>" alt="Root">
								</div>
								<div class="card-footer">
								</div>
							<?php } else { ?>
								<div class="widget-user-header" style="background-color: #343a40">
									<h3 class="widget-user-username" style="color: #f8f9fa "><?php echo $nama ?></h3>
									<h5 class="widget-user-desc" style="color: #f8f9fa "><?php echo $this->session->userdata('nama_role'); ?></h5>
								</div>
								<div class="widget-user-image">
									<img class="img-circle elevation-2" src="<?php echo $ava; ?>" alt="User Avatar">
								</div>
								<div class="card-footer">
									<?php echo anchor(
										'/Home/akun/',
										'<i class="fas fa-user-lock"></i> &nbsp; Akun &amp; Password',
										'class="btn btn-default btn-profil"'
									); ?>
								</div>
							<?php } ?>
						</div>

					</div>
				</li>
				<li class="nav-item">
					<?php if (count((array) @$on['aplikasi']) == 1 or $s == "root") { ?>
						<a class="nav-link btn-off" href="<?php echo site_url('Login/process_logout') ?>"><i class="fas fa-power-off"></i></a>
					<?php } else { ?>
						<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
							<i class="fas fa-power-off"></i>
						</a>
					<?php } ?>
				</li>

			</ul>
		</nav>
		<!-- Left side column. contains the logo and sidebar -->
		<?php

		$logo_instansi = (file_exists(FCPATH . 'uploads/logo/' . $st['pemerintah_logo']) and !empty($st['pemerintah_logo'])) ? base_url() . 'uploads/logo/' . $st['pemerintah_logo'] : base_url() . 'assets/logo/brand.png';

		?>

		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<a href="#" class="brand-link text-center" style="font-size: .9rem">
				<span class="brand-text font-weight-light "><?php echo $st['pemerintah'] ?></span>
			</a>


			<!-- sidebar: style can be found in sidebar.less -->
			<div class="sidebar">
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="<?php echo $logo_instansi; ?>" class="img-circle" alt="Root">
					</div>
					<div class="info">
						<a href="#" class="d-block"><?php echo $st['instansi_code'] ?></a>
					</div>
				</div>

				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

						<?php

						if ($s == "root") {

							$this->load->view('umum/rootnav_view');
						} else {
							$b = $this->uri->segment(2);
							$cls_act =  ($b == "home") ? 'nav-link active' : 'nav-link'; ?>

							<li class="nav-item"><?php echo anchor($app['direktori'] . '/home', '<i class="fas fa-home nav-icon"></i> <p>Beranda</p>', 'class="' . $cls_act . '" ') ?></li>
						<?php
							$id_peg = $this->session->userdata('id_pegawai');
							if ($app['direktori'] == 'referensi') get_ref_nav($id_peg);
							else get_nav($id_peg, 1, $app['id_aplikasi']);
						}
						?>
					</ul>
				</nav>
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" style="min-height: 35px;">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">
								<?php echo (!empty($title)) ? $title : null; ?>
								<?php echo (!empty($descript)) ? '<small>' . $descript . '</small>' : null; ?>
							</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<?php
								if (isset($breadcrumb)) {
									if ($s != 'root') echo '<li class="breadcrumb-item>' . anchor(site_url('home'), '<i class="fas fa-tachometer-alt"></i>&nbsp; Beranda /&nbsp; </a>') . '</li>';
									else echo '<li breadcrumb-item>' . anchor('', '<i class="fas fa-tachometer-alt"></i> &nbsp; ') . '</li>';
									foreach ($breadcrumb as $bre => $val) {
										echo '<li class="breadcrumb-item">' . anchor($bre, $val) . '</li>';
									}
								}
								?>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<?php
					$notif = array(
						'ok' => $this->session->flashdata('ok'),
						'fail' => $this->session->flashdata('fail'),
					);
					if (!empty($notif['ok'])) { ?>
						<script>
							iziToast.show({
								title: 'Pesan',
								message: '<?php echo $notif['ok'] ?>',
								position: 'topCenter',
								theme: 'light',
								color: 'green',
								imageWidth: 50,
								transitionIn: 'fadeInUp',
								class: 'iziToast iziToast-theme-light iziToast-color-green iziToast-animateInside iziToast-opened',
								icon: 'iziToast-icon ico-success revealIn',
								timeout: 3000,
							});
						</script>
					<?php
					} elseif (!empty($notif['fail'])) { ?>
						<script>
							iziToast.error({
								title: 'Pesan',
								message: '<?php echo $notif['fail'] ?>',
								position: 'topCenter',
								theme: 'light',
								color: 'red',
								imageWidth: 50,
								transitionIn: 'fadeInUp',
								timeout: 3000,
								class: 'iziToast iziToast-theme-light iziToast-color-red iziToast-animateInside iziToast-paused iziToast-opened',
								icon: 'iziToast-icon ico-error revealIn',
							});
						</script>
					<?php
					}
					?>
				</div><!-- /.container-fluid -->
			</div>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row" id="form-box" style="display: none">
						<div class="col-md-10">
							<div class="card card-outline card-warning">

								<!-- /.card-header -->
								<div class="card-body">
									<div class="overlay" id="form-overlay">
										<i class="fas fa-2x fa-sync-alt fa-spin"></i>
									</div>
									<div id="form-content"></div>
								</div>
								<!-- /.card-body -->
							</div>
						</div>
					</div>
					<?php if (@$content) $this->load->view($content); ?>
				</div>
			</section>
			<a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top" style="">
				<i class="fas fa-chevron-up"></i>
			</a>

		</div><!-- /.content-wrapper -->

		<footer class="main-footer text-sm">
			<strong>Copyright © <?php $y = ($st['copyright']) ? $st['copyright'] : date('Y');
								echo $y ?> | <?php echo $st['instansi'] . ' - ' . $st['pemerintah'] ?>.</strong>

		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark" style="display: none;">
			<!-- Create the tabs -->
			<div class="p-3 control-sidebar-content">
				<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
					<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fas fa-home"></i></a></li>

					<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fas fa-cogs"></i></a></li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content"></div><!-- /.tab-pane -->
			</div>
		</aside><!-- /.control-sidebar -->

		<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
		<div class='control-sidebar-bg'></div>

	</div><!-- ./wrapper -->

	<!-- Modal -->

	<div class="modal" id="modal-profil" tabindex="-1" role="dialog" aria-hidden="true"></div>
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title form-title"><i class="fa fa-trash"></i> &nbsp; Konfirmasi Hapus</h4>
				</div>
				<div class="modal-body"><span class="form-delete-msg"></span></div>
				<div class="modal-footer">
					<button class="btn btn-default pull-left" data-dismiss="modal" type="button">Batal</button>
					<a class="form-delete-url"><button class="btn btn-danger" type="button">Hapus</button></a>
					<a class="form-delete-btn" style="display: none"><button class="btn btn-danger" type="button">Hapus</button></a>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title form-title"><i class="fas fa-question"></i> &nbsp; Konfirmasi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body"><span class="form-delete-msg"></span></div>
				<div class="modal-footer justify-content-between">
					<button class="btn btn-default float-left" data-dismiss="modal" type="button">Batal</button>
					<a class="form-delete-url"><button class="btn btn-danger" type="button">Hapus</button></a>
					<a class="form-delete-btn" style="display: none"><button class="btn btn-danger" type="button">Hapus</button></a>
				</div>
			</div>
		</div>
	</div>


	<?php
	if (count((array) @$on['aplikasi']) > 1) { ?>
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- Home tab content -->
				<div id="control-sidebar-settings-tab" class="tab-pane active">
					<h3 class="control-sidebar-heading">
						<?php
						if (!empty($st['aplikasi_logo'])) {
							$logo = (file_exists(FCPATH . 'uploads/logo/' . $st['aplikasi_logo'])) ? base_url() . 'uploads/logo/' . $st['aplikasi_logo'] : base_url() . 'assets/logo/logo.png';
						} else {
							$logo = base_url() . 'assets/logo/logo.png';
						}
						?>
						<div class="logo-brand">
							<img src="<?php echo $logo ?>" style="" />
							<?php echo $st['aplikasi_s'] ?>
							<p><small><?php echo $st['aplikasi'] ?></small></p>
						</div>
					</h3>
					<p class="text-center">
						<a href="<?php echo site_url('Login/role_choice') ?>" class="btn btn-warning btn-sm" style="color: #1f2d3d"><i class="fa fa-recycle fa-btn"></i> Aplikasi</a>&nbsp;
						<?php echo anchor('Login/process_logout', '<i class="fas fa-power-off"></i> &nbsp; Logout', 'class="btn-off btn btn-danger btn-sm" style="color: #fff"'); ?>
					</p>
					<h5 style="font-size: 14px">Pindah Aplikasi</h5>
					<!-- <ul class="products-list product-list-in-card pl-2 pr-2"> -->
					<?php foreach ($on['aplikasi'] as $k => $v) {
						if ($v['direktori'] != $this->uri->segment(1)) {
							$ava_app = (file_exists('./assets/logo/' . $v['direktori'] . '.png') ? $v['direktori'] . '.png' : 'logo.png'); ?>
							<a href="<?php echo site_url('home/aplikasi/' . $v['direktori']); ?>">
								<div class="info-box mb-3" style="background: <?php echo $v['warna'] ?>; color: #fff">
									<span class="info-box-icon"><img src="<?php echo base_url() . 'assets/logo/' . $ava_app ?>" class="img-size-50" /></span>

									<div class="info-box-content" style="font-size: .875em">
										<span class="info-box-number"><?php echo $v['nama_aplikasi'] ?></span>
										<span class="info-box-text"><?php echo $v['nama_role'] ?></span>
									</div>
									<!-- /.info-box-content -->
								</div>
							</a>
					<?php  }
					} ?>
					<!-- </ul> -->
					<!-- /.control-sidebar-menu -->

				</div>


			</div>
		</aside>
	<?php } ?>

	<div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content bg-danger">
				<div class="modal-header">
					<h4 class="modal-title alert-icon"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body alert-message"></div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function varian(hex, lum) {

			// validate hex string
			hex = String(hex).replace(/[^0-9a-f]/gi, '');
			if (hex.length < 6) {
				hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
			}
			lum = lum || 0;

			// convert to decimal and change luminosity
			var rgb = "#",
				c, i;
			for (i = 0; i < 3; i++) {
				c = parseInt(hex.substr(i * 2, 2), 16);
				c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
				rgb += ("00" + c).substr(c.length);
			}

			return rgb;
		}
		$(document).ready(function() {
			//$('#form-box').hide();
			$('.sidebar-mini .main-sidebar .sidebar .nav-pills > li.nav-item > a.active').css('background-color', varian('<?php echo $st['main_color'] ?>', -0.2));
			$('.sidebar-mini .main-header').css('background-color', '<?php echo $st['main_color'] ?>');
			$('.sidebar-mini .main-sidebar .brand-link').css('background-color', varian('<?php echo $st['main_color'] ?>', -0.3));
			$('.back-to-top').css('background-color', '<?php echo $st['main_color'] ?>');
			$('.back-to-top').css('border-color', '<?php echo $st['main_color'] ?>');
			$('pre').css('padding-left', '300px');
		});
	</script>

</body>

</html>
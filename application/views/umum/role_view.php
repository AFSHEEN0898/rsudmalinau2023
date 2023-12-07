<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title><?php echo $st['aplikasi_s'] . ' - ' . $st['aplikasi'] ?></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- CSS -->
	<link href="<?php echo base_url() . 'assets/css/all.min.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url() . 'assets/css/adminlte.min.css' ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link href="<?php echo base_url() . 'assets/css/login.css' ?>" rel="stylesheet">
	<style>
		#box_message {
			margin-top: 20px;
			font-size: 130%
		}

		.exlcm {
			margin-right: 10px;
		}
	</style>
	<!-- JS -->
	<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.min.js' ?>"></script>

</head>

<body class="login-page" <?php if (!empty($st['main_color'])) echo 'style="background: ' . $st['main_color'] . '"'; ?>>

	<div class="login-drop"></div>
	<div class="login-drop-2"></div>
	<div class="login-drop-3"></div>
	<div class="login-drop-bg" style="padding-top: 287px; height: 620.5px;">
		<i class="fas fa-qrcode"></i>
		<i class="fas fa-qrcode"></i>
		<i class="fas fa-qrcode"></i>
	</div>
	<div class="center-block footer">
		<div class="col-lg-12 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
			<div class="login-box">
				<div class="login-logo">
					<?php
					$logo_instansi = (file_exists(FCPATH . 'uploads/logo/' . $st['pemerintah_logo']) and !empty($st['pemerintah_logo'])) ? base_url() . 'uploads/logo/' . $st['pemerintah_logo'] : base_url() . 'assets/logo/brand.png';
         
					?>
					<img src="<?php echo $logo_instansi ?>" />
				</div>
				<p class="top-brand">
					<?php if (!empty($st['pemerintah'])) echo $st['pemerintah']; ?><br>
					<span><?php echo $st['instansi'] ?></span>
				</p>
				<!-- /.login-logo -->
				<div class="card">
					<ul class="products-list product-list-in-card pl-2 pr-2">

						<?php foreach ($role as $v) {
							$ava = !file_exists('./assets/logo/' . $v['dir'] . '.png') ? base_url() . 'assets/logo/logo.png' : base_url() . 'assets/logo/' . $v['dir'] . '.png';
						?>


							<li class="item">
								<a href="<?php echo site_url('home/aplikasi/' . $v['dir']) ?>">
									<div class="product-img" style="width: 70px;">
										<div style="background: <?php echo $v['warna'] ?>;" class="role-iconic">
											<img src="<?php echo $ava ?>">
										</div>
									</div>
									<div class="col-lg-9 col-sm-8 col-xs-8">
										<div class="product-info" style="margin-left: 90px">
											<a href="<?php echo site_url('home/aplikasi/' . $v['dir']) ?>" class="product-title role-head"><?php echo $v['aplikasi'] ?></a>
											<span class="product-description role-head">
												<?php echo $v['role'] ?>
											</span>
										</div>
									</div>
								</a>
							</li>
						<?php } ?>

						<div class="clear text-center box-btn-keluar">
							<?php echo anchor('login/process_logout', '<i class="fa fa-power-off"></i> &nbsp; Keluar Aplikasi', 'class="btn btn-danger btn-sm"') ?>

						</div>
					</ul>
					<!-- /.login-card-body -->
				</div>
				<div class="login-logo">

					<?php
					if (!empty($st['aplikasi_logo'])) {
						$logo = (file_exists(FCPATH . 'uploads/logo/' . $st['aplikasi_logo'])) ? base_url() . 'uploads/logo/' . $st['aplikasi_logo'] : base_url() . 'assets/logo/logo.png';
					} else {
						$logo = base_url() . 'assets/logo/logo.png';
					}
					?>
					<div class="logo-brand"><img src="<?php echo $logo ?>" style="width: 85px;height: 85px;" /></div>
					<?php echo $st['aplikasi_s'] ?>
					<p style="line-height: 0.3em;margin-top: 6px;"><small><?php echo $st['aplikasi'] ?></small></p>
				</div><!-- /.login-logo -->

			</div>
		</div>
	</div>



</body>
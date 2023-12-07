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
	<script type="text/JavaScript">
		$(document).ready(function(){
	        var excl=' <div class="pull-left exlcm" style="width: 15px"><span class="fas fa-exclamation" aria-hidden="true"></span></div> &nbsp; ';
	        $(".btn-login").click(function() {
		        $("#login_form").submit();
	        })
	        
            $('#email').focus();
			$("#login_form").submit(function() {
                if ($("#email").val()=="" || $("#password").val()==""){
                    $("#box_message").html(excl+'<div class="pull-left">&nbsp; Username atau Password harus diisi!</div><div class="clear"></div>').addClass('alert alert-danger');
                        $("#email").focus();
                    } else {
                        $('#loading').show();
                        $('.btn-lgn').attr('disabled','disabled').html('<span class="fas fa-spinner" aria-hidden="true"></span>&nbsp; Proses Autentifikasi ...');
						$.ajax({
							type: "POST",
							url: $(this).attr('action'),
							data: $(this).serialize(),
							dataType: "json",
							success: function(msg) {
                                $('#loading').hide();

                                if (parseInt(msg.sign) == 406) {
                                	$("#box_message").html('<span class="fas fa-exclamation" aria-hidden="true"></span> &nbsp;'+msg.text).addClass('alert alert-danger').show();
									$("#ajaxcaptcha").empty('');
									$("#ajaxcaptcha").append().html(msg.captcha);
									$("#cicaptcha").val('');
									$('.btn-lgn').removeAttr('disabled').html('Login');

                                } else if (parseInt(msg.sign) == 404 || parseInt(msg.sign) == 3) {
									$("#box_message").html(excl+'<div class="pull-left">'+msg.teks+'</div><div class="clear"></div>').addClass('alert alert-danger').show();
									$('.btn-lgn').removeAttr('disabled').html('Login');
									if (msg.captcha !=null) {
										$("#ajaxcaptcha").empty('');
										$("#ajaxcaptcha").append().html(msg.captcha);
										$("#cicaptcha").val('');
									}
								} else if (parseInt(msg.sign) == 102)  window.location = '<?php echo site_url() ?>'+msg.aplikasi;
								else window.location = '<?php echo site_url() ?>'+msg.aplikasi;
                                
							},
                            error: function(x, t, m) {
                                 $('#loading').hide();
                                if(t==="timeout") {
                                    $("#box_message").html(excl+'<div class="pull-left">Timeout</div><div class="clear"></div>').addClass('alert alert-danger').show();
                                } else {
                                    $("#box_message").html(excl+'<div class="pull-left">'+t+'</div><div class="clear"></div>').addClass('alert alert-danger').show();
                                }
                            }
						});
			
				}
				return false;
				
			});

            $('#loading').hide();   
		});
        </script>


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
		<div class="login-box">
			<div class="login-logo">
				<?php
				$logo_instansi = (file_exists(FCPATH . 'uploads/logo/' . $st['pemerintah_logo']) and !empty($st['pemerintah_logo'])) ? base_url() . 'uploads/logo/' . $st['pemerintah_logo'] : base_url() . 'assets/logo/brand.png';
         
				?>
				<img src="<?php echo $logo_instansi ?>"  style="height: 150px;"/>
			</div>
			<p class="top-brand">
				<?php if (!empty($st['pemerintah'])) echo $st['pemerintah']; ?><br>
				<span><?php echo $st['instansi'] ?></span>
			</p>
			<!-- /.login-logo -->
			<div class="card">
				<div class="card-body login-card-body">

					<?php echo form_open('/Login/login_process', array('name' => 'login_form ', 'id' => 'login_form')) ?>
					<div id="box_message"></div>
					<?php
					if (!empty($ok)) echo '<div class="alert alert-success"><span class="fas fa-exclamation" aria-hidden="true"></span> &nbsp; ' . $ok . '</div>';
					if (!empty($fail)) echo '<div class="alert alert-danger"><span class="fas fa-exclamation" aria-hidden="true"></span> ' . $fail . '</div>';
					?>
					<div class="input-group mb-3">
						<?php echo form_input('username', $this->session->flashdata('welcome'), 'class="form-control" id="email"') ?>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<?php echo form_password('password', null, 'class="form-control" id="password"') ?>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<?php
					if (!empty($captcha) && $captcha == 1) {
					?>
						<div class="form-group has-feedback">
							<label>Bukan Robot? <span class="asterix">*</span></label>
							<div>
								<div class="input-group input-group-lg mb-3">
									<input id="cicaptcha" name="cicaptcha" type="text" class="form-control" placeholder="Masukkan Kode">
									<span class="input-group-text">
										<div id="ajaxcaptcha"><?php echo $cicaptcha_html; ?></div>
									</span>
								</div>

							</div>
						</div>
					<?php
					}
					?>
					<div class="social-auth-links text-center mb-3">
						<button type="submit" class="btn btn-block btn-success btn-lgn">Login</button>
					</div>
					<?php echo form_close() ?>

				</div>
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
			<p class="text-logo-login">&copy; <?php echo $st['copyright'] . '. ' . $st['aplikasi'] . '<br>' . $st['instansi'] . ', ' . $st['pemerintah'] ?></p>

		</div>
	</div>



</body>
<!DOCTYPE html>
<?php header("Refresh:".(@$par['refresh_time'])?:''); ?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="<?php echo @$par['all_reload'];?>">

    <title><?php echo $title ?></title>

    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/admin-lte.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/skins.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/general.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style_cms.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/js/style.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/app.min.js'?>"></script>

	<script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>

	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/tasktimer/dist/tasktimer.min.js' ?>"></script>
    <script src="<?php echo base_url()?>assets/video/video.js" type="text/javascript"></script>
	<style>
		body{ background: #f8e5ff;font-family: Arial}
		.logo { z-index: 999; }
		.logo_app h2 { color: #fff; letter-spacing: -1px; font-size: 1.0em; font-weight: 600; text-align: left; 
			line-height: 0.9em; margin-top: 18px; text-transform: uppercase}
		.logo_app img { float: left; max-height: 65px; margin: 5px 8px 15px 12px}
		.col-sm-6, .col-sm-5 { position: relative; }
		.marquee-box { background: #000; color: #fff; position: fixed; bottom: 0; padding-top: 2px; letter-spacing: 2px; z-index: 999; right: 80px; left: 80px; height: 40px;}
		.marquee-box ul li { list-style: none; margin-left: 80px; float: left;}
		.marquee-box ul li i { margin: 0 0px 0 0; font-size: 1.3em; margin-top:-10px; padding:0px;}
		.marquee-box img{ height:35px; }
		.jam{ background: #f8c300;position:fixed;left:0px;bottom:0;font-size: 16px;height:40px;width:80px;margin-bottom: 0px;padding: 10px;font-weight: bold;}
		.tanggal{ background: url(<?php echo base_url()?>uploads/logo/tanggal.png) no-repeat left top; position:fixed;right:0px;bottom:0;font-size: 16px;height:40px;width:115px;margin-bottom: 0px;padding: 13px 10px 10px 15px;font-weight: bold;z-index: 999999999;color:#fff;}
		.logo img { float: left; margin: 15px 10px 10px 20px; max-height: 50px; }
		.logo h2, .logo h1 { padding: 0; margin: 20px 0 0 0; color: #fff;/*text-transform: uppercase; text-shadow: 1px 1px 2px #fff*/ }
		.logo h2 { font-size: 1em;  letter-spacing: 3px; text-transform: uppercase; }
		.logo h1 { font-size: 1.6em; margin-top: 0; font-weight: bold }
		.kiri .konten { margin : 10px; color: #444}
		.kiri .konten .judul { padding: 10px; font-size: 1.4em; letter-spacing: 3px; 
				text-transform: uppercase; border: 1px dashed #444; font-weight: 600}
		.kanan .konten { margin : 0px 10px 0px 10px; color: #fff; text-align: right;margin-right: 0px; padding-right: 10px;}
		.kanan .konten .judul { padding: 10px 20px; font-size: 1.4em; letter-spacing: -1px; 
				text-transform: uppercase; background: rgb(12, 94, 132);
				text-align: right; font-weight: 600; margin-left: -10px;    margin-right: -10px;}
		.jud-ext { border-radius: 0 !important }
		.drop-bg { position: absolute; width: 100%; top: 0; left: 0; overflow: hidden; z-index: 100 }
		.drop-bg img { max-width: 100%; }
		.box-image-konten img {max-width: 100%;    border: 3px solid #ccc;height:auto; }
		.no_kiri { position: absolute; left: 20px; bottom: 75px; padding: 10px 0 10px 0; opacity: 0.5;
			text-align: center; min-width: 40px; height: 40px; font: 1.4em Arial; font-weight: bold; color: #fff; background: #222;}
		.no_kanan { position: absolute; right: 20px; bottom: 75px; padding: 10px 0 10px 0; opacity: 0.5;
			text-align: center; min-width: 40px; height: 40px; font: 1.4em Arial; font-weight: bold; color: #fff; background: #ddd;}
		.unit { display: none; }
		
		.news-title { font-size: 1.2em; text-align: left; padding: 4px 0 8px 0; margin-bottom: 10px; border-bottom: 1px dashed #f8c300 }
		.news-title-sub {font-size: 0.9em; line-height: 1em; text-align: right}
		.news-content p{ line-height: 160%;height:130px;}
		/*.news-content p{ line-height: 20px;}*/
		/*#box-image { margin-left: -5px; }*/
		.foto { text-align: center !important; position: relative; overflow: hidden}
		.foto-title {  background: #000; top: 0; left: 0; padding: 3px 10px;color: #fff;  font-size: 80%; letter-spacing: 1px;text-align: center;}
		.video-title {  background: #000; top: 0; left: 0; padding: 3px 10px;color: #fff; font-size: 90%; letter-spacing: 1px;text-align: center;}

		.foto-content {  position: absolute; background: #000; padding: 3px 10px; left: 0; bottom: 15px; color: #fff; opacity: 0.4; width: 100%; display: none; }
		.info-box {
		  margin-bottom: 5px;
		}
		.box-header.with-border {
		    background: #000;
		}
		.box-header {
		    color: #f8c300;
		    padding: 2px;
		    text-align: left;
		    border-top-left-radius: 5px;
		    border-top-right-radius: 5px;
		}
		.box-header .box-title {
		    font-size: 30px;
		    font-family: latin;
		}

		.box-header .box-title b, strong {
		    font-size: 30px;
		    font-family: latin;
		    letter-spacing: 1mm;
		    font-weight: 100 !important;
		}
		
		
		.box {
		    margin: 3px;
		    border-radius:5px;
		}
		.box.box-default{
			border: none;
		}
		.box-body h5{
			text-align: left;
		    margin-left: 15px;
		    font-weight: bold;
		}

		.luar { 
			overflow: hidden; 
			position: relative; 
			min-height: 210px; 
			} 
		.dalam{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}
		.luar-berita { 
			overflow: hidden; 
			position: relative; 
			min-height: 210px; 
			} 
		.dalam-berita{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}
		.luar-info { 
			overflow: hidden; 
			position: relative; 
			min-height: 210px; 
			} 
		.dalam-info{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}
		.luar_pelatihan { 
			overflow: hidden; 
			position: relative; 
			min-height: 200px; 
			} 
		.dalam_pelatihan{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}
		.dalam p img{
			width:100% !important;
			height:auto !important;
			text-align: center !important;
		}
		.dalam img{
			width:100% !important;
			height:auto !important;
			text-align: center !important;
		}
		video {
	  		width: 100%;
	  		object-fit: cover;
	  		/*object-fit: cover;*/
	  		height: 225px;
  		}
  		.dalam-berita p{
  			word-spacing: -1px;
  		}
  		.dalam-berita img{
  			margin: 0px 10px 2px 0px !important;
  			width:40% !important;
  			height:135px !important;
  		}
  		.dalam-info p{
  			line-height: 15px !important;
  			font-size:10px;
  			word-spacing: -1px;

  		}
  		.dalam p{
  			line-height: 15px !important;
  			font-size:10px;
  			word-spacing: -1px;

  		}
  		.pengumuman p{
  			line-height: 15px !important;
  			font-size:10px;
  			word-spacing: -1px;

  		}
	</style>
	<script type="text/javascript">
	 window.onload = function() { 
	 	jam();
	 }

	function checkTime(i) {
	    if (i<10) {i = "0" + i};
	    return i;
	}

	setInterval(1000);

		 function jam() {
		  var e = document.getElementById('jam'),
		  d = new Date(), h, m, s;
		  date = d.getDate();
		  h = d.getHours();
		  m = set(d.getMinutes());
		  s = set(d.getSeconds());

		  e.innerHTML = h +':'+ m +':'+ s;

		  setTimeout('jam()', 1000);
		 }

		 function set(e) {
		  e = e < 10 ? '0'+ e : e;
		  return e;
	}
	</script>
	<script type="text/javascript">
		function teks_bergerak() {
			$.ajax({
				url: '<?php echo site_url('sitika/display/teksbergerak') ?>',
				cache: false,
				success: function(msg) {
					$('.box-marquee').html(msg); 
				},error:function(error){
					show_error('ERROR : '+error).show();
				}
			});
		}
		teks_bergerak();
	</script>
</head>
  
<body class="skin-blue sidebar-mini" style="color:#ffffff">
	
	<div class="row">
		<div class="col-lg-12" style="height: 85px;background:<?php echo (@$par['header_color'])?:'#500380';?>">	<!-- parameter : header_color -->		
			<div class="logo pull-left" style="margin-left: 15px;">
					<?php $ava = file_exists('./logo/'.$par['pemerintah_logo']) ? base_url().'logo/'.$par['pemerintah_logo'] : base_url().'assets/logo/brand.png'; ?>
					<img src="<?php echo $ava ?>"><div class="pull-left">
						<h2><?php echo $par['pemerintah'] ?></h2>
						<h1><?php echo $par['instansi'] ?></h1>
					</div>
					<div class="clear"></div>
				</div>
				<div class="logo_app pull-right" style="margin-right: 15px;">
					<div class="pull-left">
						<h2 style="color : <?php echo (@$par['title_color'])?:'#ffffff';?>"><?php echo str_replace(' ','<br>',@$par['application_title']) ?></h2> <!-- parameter : apps_title -->
					</div>
					<?php $ava = file_exists('./assets/logo/'.$folder.'.png') ? base_url().'assets/logo/'.$folder.'.png' : base_url().'assets/logo/logo.png'; ?>
					<img src="<?php echo $ava ?>">
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
		</div>
	</div>
	<div class="row">
	<div class="col-lg-12" style="background:<?php echo (@$par['tv_color'])?:'#75ff9c';?> ;padding:5px"><!-- parameter : color_tv -->
		<div class="row" style="padding:1px 30px 10px 25px">
			<div class="col-lg-5 no-padding" style="padding-left:10px;">
				<div class="row">
					<div class="col-lg-12" style="">
						<div class="box box-default" style="height:<?php echo (@$par['box_berita_height_2'])?:'320';?>px;background:<?php echo (@$par['berita_background_color'])?:'#ffffff';?>;color:<?php echo (@$par['berita_text_color'])?:'#ffffff';?>">
								<div class="box-header" style="background:linear-gradient(to right, <?php echo (@$par['berita_header_color'])?:'#510045';?>,<?php echo (@$par['berita_header_text_color'])?:'#ffffff';?>);"><!-- parameter : background_berita -->
				                	<h3 class="box-title" style="color:<?php echo (@$par['berita_header_text_color'])?:'#ffffff';?>"><b><?php echo (@$par['berita_title'])?:'-';?></b></h3><!-- parameter : warna_berita -->
				              	</div>
				          	<div class="box-body no-padding" style="height:<?php echo (@$par['box_berita_height_2'])?((@$par['box_berita_height_2'] - 40)):'270';?>px; overflow:hidden;">			               
								<div id="box-pengumuman" style="padding:0px 10px;background:<?php echo (@$par['berita_background_color'])?:'#ffffff';?>">
				          			<div class="widget-berita" id="postBerita"></div>
				          		</div>
			          		</div>
				        </div> 
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-default" style="height:<?php echo (@$par['box_agenda_height_2'])?:'320';?>px;background:<?php echo (@$par['agenda_background_color'])?:'#ffffff';?>;color:<?php echo (@$par['agenda_text_color'])?:'#ffffff';?>">
								<div class="box-header" style="background:linear-gradient(to right, <?php echo (@$par['agenda_header_color'])?:'#510045';?>,<?php echo (@$par['agenda_header_text_color'])?:'#ffffff';?>);"><!-- parameter : background_agenda -->
				                	<h3 class="box-title" style="color:<?php echo (@$par['agenda_header_text_color'])?:'#ffffff';?>"><b><?php echo (@$par['agenda_title'])?:'-';?></b></h3><!-- parameter : warna_agenda -->
				              	</div>
				          	<div class="box-body no-padding" style="height:<?php echo (@$par['box_agenda_height_2'])?((@$par['box_agenda_height_2'] - 30)):'240';?>px; overflow:hidden;"><!-- parameter : warna_kegiatan -->			               
								<div id="box-pengumuman" style="padding:0px 10px;">
				          			<div class="widget-pelatihan" id="postPelatihan"></div>
				          		</div>
			          		</div>
				        </div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="row">
					<div class="col-lg-12" style="">
						<div class="box box-default" style="height:<?php echo (@$par['box_galeri_height_2'])?:'220';?>px;background:<?php echo (@$par['galeri_background_color'])?:'#ffffff';?>;color:<?php echo (@$par['galeri_text_color'])?:'#ffffff';?>">
							<div class="box-header" style="background:linear-gradient(to right, <?php echo (@$par['galeri_header_color'])?:'#510045';?>,<?php echo (@$par['galeri_header_text_color'])?:'#ffffff';?>);"><!-- parameter : background_galeri -->
			                	<h3 class="box-title" style="color:<?php echo (@$par['galeri_header_text_color'])?:'#ffffff';?>"><b><?php echo (@$par['galeri_title'])?:'-';?></b></h3><!-- parameter : warna_galeri -->
			              	</div>
			              	<div class="box-body no-padding">
				           		<!-- postGAL1 -->
									<div id="postGAL1" class="no-padding">
									<?php
										if ($foto->num_rows() > 0) {
												$i = 0;
												foreach ($foto->result() as $f) { 
													$i++;
													$id_gal = 'gal_kiri';
													$jml_kar = strlen($f->judul);?>
													<div id="<?php echo $id_gal; ?>">
														<?php
														if($jml_kar > 20){ ?>
															<div class="foto-title" style="padding-bottom: 0px;">
																<marquee><?php echo $f->judul; ?></marquee>
															</div>
														<?php }else{ ?>
															<div class="foto-title" style="padding-bottom: 4px; text-align: justify;"><?php echo $f->judul; ?></div>
														<?php } ?>

									<img src="<?php echo base_url().'uploads/sitika/galeri/foto/'.$f->foto; ?>" style="min-width:100%; height:<?php echo (@$par['photo_height_2'])?:'165';?>px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;"/>
														<?php if (!empty($f->keterangan)) 
									echo '<div class="foto-content">'.$f->keterangan.'</div>'; ?>
													</div>
												<?php } 
													} else { echo '<div class="alert">Belum ada Foto ...</div>'; }
													
											?>

									<?php echo $this->ajax_pagination_gal1->create_links();?>
								</div>
								<script type="text/javascript">
									$(document).ready(function() {
										var gal1 = setInterval(getgal1, 9000);
										function getgal1() {
							    				getData_gal1();
										    }
										 getgal1();
									});
								</script>
							</div>
	            		</div> 
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
              				<div class="box box-default" style="height:<?php echo (@$par['box_pengumuman_height_2'])?:'400';?>px;background:<?php echo (@$par['pengumuman_background_color'])?:'#ffffff';?>;color:<?php echo (@$par['pengumuman_text_color'])?:'#ffffff';?>;">
								<div class="box-header" style="background:linear-gradient(to right, <?php echo (@$par['pengumuman_header_color'])?:'#510045';?>,<?php echo (@$par['pengumuman_header_text_color'])?:'#ffffff';?>);"><!-- parameter : background_pengumuman -->
				                	<h3 class="box-title" style="color:<?php echo (@$par['pengumuman_header_text_color'])?:'#ffffff';?>"><b><?php echo (@$par['pengumuman_title'])?:'-';?></b></h3><!-- parameter : warna_pengumuman -->
				              	</div>
					          	<div class="box-body no-padding" style="height:<?php echo (@$par['box_pengumuman_height_2'])?((@$par['box_pengumuman_height_2'])):'350';?>px; overflow:hidden;">			               
									<div id="" style="padding:0px 10px;">
					          			<div class="widget-pengumuman" id="postPengumuman"></div>
					          		</div>
				          		</div>
				          	</div> 
					</div>
				</div>
			</div>
			<div class="col-lg-4 no-padding">
				<div class="row">
					<div class="col-lg-12" style="">
              				<div class="box box-default" style="height:<?php echo (@$par['box_informasi_height_2'])?:'310';?>px;background:<?php echo (@$par['informasi_background_color'])?:'#ffffff';?>;color:<?php echo (@$par['informasi_text_color'])?:'#ffffff';?>;">
								<div class="box-header" style="background:linear-gradient(to right, <?php echo (@$par['informasi_header_color'])?:'#510045';?>,<?php echo (@$par['informasi_header_text_color'])?:'#ffffff';?>);"><!-- parameter : background_informasi -->
				                	<h3 class="box-title" style="color:<?php echo (@$par['informasi_header_text_color'])?:'#ffffff';?>"><b><?php echo (@$par['informasi_title'])?:'-';?></b></h3><!-- parameter : warna_informasi -->
				              	</div>
					          	<div class="box-body no-padding" style="height:<?php echo (@$par['box_informasi_height_2'])?((@$par['box_informasi_height_2'] - 50)):'250';?>px; overflow:hidden;">			               
									<div id="" style="padding:0px 10px;">
					          			<div class="widget-informasi" id="postInformasi"></div>
					          		</div>
				          		</div>
				          	</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
              				<div class="box box-default" style="height:<?php echo (@$par['box_video_height_2'])?:'300';?>px;background:<?php echo (@$par['video_background_color'])?:'#ffffff';?>;color:<?php echo (@$par['video_text_color'])?:'#ffffff';?>">
								<div class="box-header" style="background:linear-gradient(to right, <?php echo (@$par['video_header_color'])?:'#510045';?>,<?php echo (@$par['video_header_text_color'])?:'#ffffff';?>);"><!-- parameter : background_video -->
				                	<h3 class="box-title" style="color:<?php echo (@$par['video_header_text_color'])?:'#ffffff';?>"><b><?php echo (@$par['video_title'])?:'-';?></b></h3><!-- parameter : warna_video -->
				              	</div>
		              		<div class="box-body no-padding" style="height:<?php echo (@$par['video_height_2'])?(@$par['video_height_2'] + 2):'282';?>px; overflow:hidden;">
									<div class="box-body no-padding" style="overflow:hidden;">
										
					          			<div class="widget-video" id="postVideo"></div>	
							        </div>					    
									</div>
									<?php if ($musik->num_rows() > 0){ ?>
									<div style="display: none;">			
										<div id="audio0">
											<audio preload autoplay id="audio1" >Your browser does not support HTML5 Audio!</audio>
										</div>
										<?php
											$no=1;
											$tracks = array();
											foreach ($musik->result() as $mus) {
												$tracks[] = '{"track":"'.$no.'","name":"'.str_replace('.mp3', '', $mus->backsound).'","length":"01:00","file":"'.str_replace('.mp3', '', $mus->backsound).'"}';
												$no+=1;
											}
										?>
									</div>
									<script type="text/javascript">
										var b = document.documentElement;
										b.setAttribute('data-useragent', navigator.userAgent);
										b.setAttribute('data-platform', navigator.platform);

										jQuery(function ($) {
										    var supportsAudio = !!document.createElement('audio').canPlayType;
										    if (supportsAudio) {
										        var index = 0,
										            playing = false,
										            mediaPath = '<?php echo base_url("uploads/sitika/galeri/backsound") ?>/',
										            extension = '',
										            tracks = [<?php echo implode(",", $tracks);?>],
										            trackCount = tracks.length,
										            npAction = $('#npAction'),
										            npTitle = $('#npTitle'),

										            audio = $('#audio1').bind('play', function () {
										                playing = true;
										                npAction.text('Now Playing...');

										            }).bind('pause', function () {
										                playing = false;
										                npAction.text('Paused...');
										            }).bind('ended', function () {
										                npAction.text('Paused...');
										                if ((index + 1) < trackCount) {
										                    index++;
										                    loadTrack(index);
										                    audio.play();
										                } else {
										                    audio.pause();
										                    index = 0;
										                    loadTrack(index);
										                }
										            }).get(0),
										            btnPrev = $('#btnPrev').click(function () {
										                if ((index - 1) > -1) {
										                    index--;
										                    loadTrack(index);
										                    if (playing) {
										                        audio.play();
										                    }
										                } else {
										                    audio.pause();
										                    index = 0;
										                    loadTrack(index);
										                }
										            }),
										            btnNext = $('#btnNext').click(function () {
										                if ((index + 1) < trackCount) {
										                    index++;
										                    loadTrack(index);
										                    if (playing) {
										                        audio.play();
										                    }
										                } else {
										                    audio.pause();
										                    index = 0;
										                    loadTrack(index);
										                }
										            }),
										            li = $('#plList li').click(function () {
										                var id = parseInt($(this).index());
										                if (id !== index) {
										                    playTrack(id);
										                }
										            }),
										            loadTrack = function (id) {
										                $('.plSel').removeClass('plSel');
										                $('#plList li:eq(' + id + ')').addClass('plSel');
										                npTitle.text(tracks[id].name);
										                index = id;
										                audio.src = mediaPath + tracks[id].file + extension;
										            },
										            playTrack = function (id) {
										                loadTrack(id);
										                audio.play();
										            };
										        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
										        loadTrack(index);
										    }
										});
									</script>
									<?php } ?>
								</div>
              				</div>
					</div>
				</div>
			</div>
		</div>
	<script type="text/javascript">
	  $(document).ready(function() {
	  		// ajak pengumuman (ajax kayak kieee)
	  	$.ajax({
			url : "<?php echo site_url('sitika/display/ajaxPaginationinformasi2');?>",
			// dataType : "JSON",
			success : function(data){
				$('.widget-informasi').html(data);
			}
		});
	  	$.ajax({
			url : "<?php echo site_url('sitika/display/ajaxPaginationberita2');?>",
			// dataType : "JSON",
			success : function(data){
				$('.widget-berita').html(data);
			}
		});
	  	$.ajax({
			url : "<?php echo site_url('sitika/display/ajaxPaginationpelatihan2');?>",
			// dataType : "JSON",
			success : function(data){
				$('.widget-pelatihan').html(data);
			}
		});
	  	$.ajax({
			url : "<?php echo site_url('sitika/display/ajaxPaginationpengumuman2');?>",
			// dataType : "JSON",
			success : function(data){
				$('.widget-pengumuman').html(data);
			}
		});
	  	$.ajax({
			url : "<?php echo site_url('sitika/display/ajaxPaginationfoto');?>",
			// dataType : "JSON",
			success : function(data){
				$('.widget-foto').html(data);
			}
		});
	  	$.ajax({
			url : "<?php echo site_url('sitika/display/ajaxPaginationvideo');?>",
			// dataType : "JSON",
			success : function(data){
				$('.widget-video').html(data);
			}
		});
	  	// ./ajak pelatihan (ajax kayak kieee)
	    setInterval(function(){
	      tgl_reload();
	    }, 200000);
	  });
	  function tgl_reload(){
	    $.ajax({
	      url: "<?php echo site_url('sitika/display/ajax_tgl') ?>",
	      dataType:'JSON',
	      success:function(data){
	        $.each(data, function(k, v){
	          $('#tgl_bawah').html(v.tgl);
	        });
	      }
	    });
	  }
	</script>
	<script type="text/javascript">
	  $(document).ready(function() {

	  	
	   /* setInterval(function(){
	      tgl_reload();
	    }, 200000);*/
	  });
	</script>
</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<h3 class="jam" id="jam" style="color: <?php echo (@$par['date_text_color'])?:'#ffffff';?>;background: <?php echo (@$par['date_background_color'])?:'#f8c300';?>;"></h3>
				<div class="box-marquee"  style="font-size: 120%;">	
				</div>
			<h3 class="tanggal" id="tgl_bawah">
				<?php echo date_indox(date('Y-m-d'),2);?>
			</h3>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			var h_image = ($(window).height()-$('.marquee-box').height())*0.3;
			$('#box-image').height(h_image+10);
			$('.col-sm-5, .col-sm-7,.drop-bgx').height($(window).height());
			$('#konten-pengumuman').height($(window).height()-$('.marquee-box').height()-h_image-150);
		});
	</script>
	<div class="clear"></div>
</body>
</html>
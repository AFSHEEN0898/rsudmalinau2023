<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <meta http-equiv="refresh" content="<?php echo @$all_reload->all_reload;?>">
	    <title><?php echo @$title ?></title>

	    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
	    <link href="<?php echo base_url().'assets/css/admin-lte.css' ?>" rel="stylesheet">
		<link href="<?php echo base_url().'assets/css/skins.css' ?>" rel="stylesheet">
		<link href="<?php echo base_url().'assets/css/general.css' ?>" rel="stylesheet">
		<link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

		<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'assets/js/app.min.js'?>"></script>

		<script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>

		<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
		<link href="<?php echo base_url().'assets/css/AdminLTE.min.css' ?>" rel="stylesheet" type="text/css" />


		<link href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.css' ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.print.css' ?>" rel="stylesheet" type="text/css" media="print" />

	    <script src="<?php echo base_url()?>assets/plugins/fullcalendar/moment.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fullcalendar/fullcalendar.js"></script>

		<script src="<?php echo base_url('assets/plugins/highchart/highcharts.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/tasktimer/dist/tasktimer.min.js' ?>"></script>

		<style>
			body{font-size: 12px !important;}
			.logo { z-index: 999; }
			.logo_app h2 { color: #fff; letter-spacing: -1px; font-size: 1.6em; font-weight: 600; text-align: left; 
				line-height: 0.9em; margin-top: 28px; text-transform: uppercase}
			.logo_app img { float: left; max-height: 65px; margin: 5px 8px 15px 12px}
			.col-sm-6, .col-sm-5 { position: relative; }
			/*.marquee-box { background: <?php echo @$par['marquee_color'];?>; color:<?php echo @$par['color_text_marquee'];?>; position: fixed; bottom: 0; padding-top: 8px; letter-spacing: 2px; z-index: 999; right: 80px; left: 80px; height: 40px;}
			.marquee-box ul li { list-style: none; margin-left: 80px; float: left;}
			.marquee-box ul li i { margin: 0 0px 0 0; font-size: 12px; margin-top:-10px; padding:0px;}
			.marquee-box img{ height:35px; }*/
			.jam{ background: yellow;color:black;font-size: 16px !important;position:fixed;left:0px;bottom:0;font-size: 12px;height:40px;width:80px;margin-bottom: 0px;padding: 10px;font-weight: bold;}
			.tanggal{
				border-bottom: 40px solid #FFA600;
				border-left: 15px solid transparent;
				border-right: 0px solid transparent;
				font-size: 16px;
				height: 40px;
				width: 115px;
				position:fixed;
				right:0px;
				bottom:0;
				margin-bottom: 0px;
				z-index: 999999999;
				font-weight: bold;
				color:<?php echo @$par['color_text_date'];?>;
				}
			.logo img { float: left; margin: 15px 10px 10px 20px; max-height: 50px; }
			.logo h2, .logo h1 { padding: 0; margin: 20px 0 0 0; color: #fff;/*text-transform: uppercase; text-shadow: 1px 1px 2px #fff*/ }
			.logo h2 { font-size: 1em;  letter-spacing: 3px; text-transform: uppercase; }
			.logo h1 { font-size: 1.6em; margin-top: 0; font-weight: bold }
			.kiri .konten { margin : 10px; color: #444}
			.kiri .konten .judul { padding: 10px; font-size: 12px; letter-spacing: 3px; 
					text-transform: uppercase; border: 1px dashed #444; font-weight: 600}
			.kanan .konten { margin : 0px 10px 0px 10px; color: #fff; text-align: right;margin-right: 0px; padding-right: 10px;}
			.kanan .konten .judul { padding: 10px 20px; font-size: 12px; letter-spacing: -1px; 
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
			
			.news-title { font-size: 12px; text-align: left; padding: 4px 0 8px 0; margin-bottom: 10px; border-bottom: 1px dashed #f8c300 }
			.news-title-sub {font-size: 12px; line-height: 1em; text-align: right}
			/*.news-content p{ line-height: 160%;height:145px;}*/
			/*.news-content p{ line-height: 20px;}*/
			/*#box-image { margin-left: -5px; }*/
			.foto { text-align: center !important; position: relative; overflow: hidden}
			.foto-title {  background: #f0f0f0; top: 0; left: 0; padding: 3px 10px; margin-bottom: 0px; height: 26px;
					color: <?php echo @$par['color_text_galeri'];?>; opacity: 0.7; font-size: 160%; letter-spacing: 1px; font-size: 14px;}

			.foto-content {  position: absolute; background: #000; padding: 3px 10px; left: 0; bottom: 15px; color: #fff; opacity: 0.4; width: 100%; display: none; }
			.info-box {
			  margin-bottom: 5px;
			}
			.table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th{
				padding: 3px;
			}
			.badge{
				    background-color: rgba(119, 119, 119, 0.35);
			}
			.striper { 
				overflow: hidden;
				position: relative;
				height: 20px; 
				} 
			.strip-word{ 
				position: absolute; 
				left: 0; 
				top: 0; 
			}

			.striper_peng { 
				overflow: hidden;
				position: relative
				} 
			.strip-peng{ 
				position:absolute; 
				left: 0; 
				top: 0; 
			}
			#postSatu .box-header{
				display: block;
     			padding: 2px 5px;
			    position: relative;
				background: <?php echo @$set_widget_1->background_title;?>; /* For browsers that do not support gradients */
				background: -webkit-linear-gradient(left, <?php echo @$set_widget_1->background_title;?> , #fff); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(right, <?php echo @$set_widget_1->background_title;?>, #fff); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(right, <?php echo @$set_widget_1->background_title;?>, #fff); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to right, <?php echo @$set_widget_1->background_title;?> , #fff); /* Standard syntax */color: #000;
			}
			#postDua .box-header{
				display: block;
     			padding: 2px 5px;
			    position: relative;
				background: <?php echo @$set_widget_2->background_title;?>; /* For browsers that do not support gradients */
				background: -webkit-linear-gradient(right, <?php echo @$set_widget_2->background_title;?> , #fff); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(left, <?php echo @$set_widget_2->background_title;?>, #fff); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(left, <?php echo @$set_widget_2->background_title;?>, #fff); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to left, <?php echo @$set_widget_2->background_title;?> , #fff); /* Standard syntax */color: #000;
			}
			#postTiga .box-header{
				display: block;
     			padding: 2px 5px;
			    position: relative;
				background: <?php echo @$set_widget_3->background_title;?>; /* For browsers that do not support gradients */
				background: -webkit-linear-gradient(left, <?php echo @$set_widget_3->background_title;?> , #fff); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(right, <?php echo @$set_widget_3->background_title;?>, #fff); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(right, <?php echo @$set_widget_3->background_title;?>, #fff); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to right, <?php echo @$set_widget_3->background_title;?> , #fff); /* Standard syntax */color: #000;
			}
			#postEmpat .box-header{
				display: block;
     			padding: 2px 5px;
			    position: relative;
				background: <?php echo @$set_widget_4->background_title;?>; /* For browsers that do not support gradients */
				background: -webkit-linear-gradient(right, <?php echo @$set_widget_4->background_title;?> , #fff); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(left, <?php echo @$set_widget_4->background_title;?>, #fff); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(left, <?php echo @$set_widget_4->background_title;?>, #fff); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to left, <?php echo @$set_widget_4->background_title;?> , #fff); /* Standard syntax */color: #000;
			}
			#postLima .box-header{
				display: block;
     			padding: 2px 5px;
			    position: relative;
				background: <?php echo @$set_widget_5->background_title;?>; /* For browsers that do not support gradients */
				background: -webkit-linear-gradient(right, <?php echo @$set_widget_5->background_title;?> , #fff); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(left, <?php echo @$set_widget_5->background_title;?>, #fff); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(left, <?php echo @$set_widget_5->background_title;?>, #fff); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to left, <?php echo @$set_widget_5->background_title;?> , #fff); /* Standard syntax */color: #000;
			}
			#postEnam .box-header{
				display: block;
     			padding: 2px 5px;
			    position: relative;
				background: <?php echo @$set_widget_6->background_title;?>; /* For browsers that do not support gradients */
				background: -webkit-linear-gradient(left, <?php echo @$set_widget_6->background_title;?> , #fff); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(right, <?php echo @$set_widget_6->background_title;?>, #fff); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(right, <?php echo @$set_widget_6->background_title;?>, #fff); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to right, <?php echo @$set_widget_6->background_title;?> , #fff); /* Standard syntax */color: #000;
			}


			#postSatu .angka{
				color: <?php echo @$set_widget_1->background_title;?>;
				position: relative;
			    min-height: 1px;
			    padding-right: 15px;
			    padding-left: 15px;
			    text-align: center;
			    border-right: 1px solid #ccc;
			}
			#postDua .angka{
				color: <?php echo @$set_widget_2->background_title;?>;
				position: relative;
			    min-height: 1px;
			    padding-right: 15px;
			    padding-left: 15px;
			    text-align: center;
			    border-right: 1px solid #ccc;
			}
			#postTiga .angka{
				color: <?php echo @$set_widget_3->background_title;?>;
				position: relative;
			    min-height: 1px;
			    padding-right: 15px;
			    padding-left: 15px;
			    text-align: center;
			    border-right: 1px solid #ccc;
			}
			#postEmpat .angka{
				color: <?php echo @$set_widget_4->background_title;?>;
				position: relative;
			    min-height: 1px;
			    padding-right: 15px;
			    padding-left: 15px;
			    text-align: center;
			    border-right: 1px solid #ccc;
			}
			#postLima .angka{
				color: <?php echo @$set_widget_5->background_title;?>;
				position: relative;
			    min-height: 1px;
			    padding-right: 15px;
			    padding-left: 15px;
			    text-align: center;
			    border-right: 1px solid #ccc;
			}
			#postEnam .angka{
				color: <?php echo @$set_widget_6->background_title;?>;
				position: relative;
			    min-height: 1px;
			    padding-right: 15px;
			    padding-left: 15px;
			    text-align: center;
			    border-right: 1px solid #ccc;
			}


			#postSatu .box-header h5{
				font-family:latin; 
				font-size:35px;
				line-height: 15px;
				padding-bottom: 0px;
				font-weight: 500;
				text-align: left;
     			margin-top:0px;
			    color:<?php echo @$set_widget_1->color_title;?> !important;
			    padding:0px 5px 10px 5px;
			}
			#postDua .box-header h5{
				font-family:latin; 
				font-size:35px;
				line-height: 15px;
				padding-bottom: 0px;
				font-weight: 500;
				text-align: left;
     			margin-top:0px;
			    color:<?php echo @$set_widget_2->color_title;?> !important;
			    padding:0px 5px 10px 5px;
			}
			#postTiga .box-header h5{
				font-family:latin; 
				font-size:35px;
				line-height: 15px;
				padding-bottom: 0px;
				font-weight: 500;
				text-align: left;
     			margin-top:0px;
			    color:<?php echo @$set_widget_3->color_title;?> !important;
			    padding:0px 5px 10px 5px;
			}
			#postEmpat .box-header h5{
				font-family:latin; 
				font-size:35px;
				line-height: 15px;
				padding-bottom: 0px;
				font-weight: 500;
				text-align: left;
     			margin-top:0px;
			    color:<?php echo @$set_widget_4->color_title;?> !important;
			    padding:0px 5px 10px 5px;
			}
			#postLima .box-header h5{
				font-family:latin; 
				font-size:35px;
				line-height: 15px;
				padding-bottom: 0px;
				font-weight: 500;
				text-align: left;
     			margin-top:0px;
			    color:<?php echo @$set_widget_5->color_title;?> !important;
			    padding:0px 5px 10px 5px;
			}
			#postEnam .box-header h5{
				font-family:latin; 
				font-size:35px;
				line-height: 15px;
				padding-bottom: 0px;
				font-weight: 500;
				text-align: left;
     			margin-top:0px;
			    color:<?php echo @$set_widget_6->color_title;?> !important;
			    padding:0px 5px 10px 5px;
			}

			#postSatu{
			    background: linear-gradient(<?php echo @$set_widget_1->background_kolom;?>, #ffffff);
			}
			#postDua{
			    background: linear-gradient(<?php echo @$set_widget_2->background_kolom;?>, #ffffff);
			}
			#postTiga{
			    background: linear-gradient(<?php echo @$set_widget_3->background_kolom;?>, #ffffff);
			}
			#postEmpat{
			    background: linear-gradient(<?php echo @$set_widget_4->background_kolom;?>, #ffffff);
			}
			#postLima{
			    background: linear-gradient(<?php echo @$set_widget_5->background_kolom;?>, #ffffff);
			}
			#postEnam{
			    background: linear-gradient(<?php echo @$set_widget_6->background_title;?>, #ffffff);
			    color: <?php echo @$set_widget_6->color_title;?> !important;
			}


			.box{
			    border-top: none;
			    border-radius:inherit;
			    margin-bottom: 5px;
			}
			.pull-left h1,h2{
				 color:<?php echo @$set_warna_latar->header_color_teks;?> !important;
				 font-weight: bold;
				}
		</style>
	</head>
	<body class="skin-blue sidebar-mini" style="background: <?php echo @$set_warna_latar->warna_latar;?> !important;">
		<div style="position: fixed; z-index: 9999; background: #000; padding: 0; bottom: 0; width: 100%; height: 40px">
			<h5 class="jam" id="jam"  style="z-index:99999999999"></h5>
				<div class="col-lg-12" style="font-size: 120%;text-align:center;color:#FFFFFF;">

						<?php 
						$arr_run = array();
						foreach($runing->result() as $art){
							array_push($arr_run, $art->teks_bergerak);
						}

						echo '<marquee style="padding-top: 8px;">'.implode(" | ", $arr_run).'</marquee>';
						
									?>
				</div>
		<div class="tanggal" id="tgl_bawah">
			<div style="padding-top:10px;">
				<?php echo date_indo(date('Y-m-d'),2);?>
			</div>
		</div>
	</div>
	<div class="row">
			<div class="col-lg-12" style="background: <?php echo @$set_warna_latar->header_color;?> !important; height: 80px;">			
				<div class="logo pull-left" style="margin-left: 15px;">
						<?php
						$ava = file_exists('./logo/'.$par['pemerintah_logo']) ? base_url().'logo/'.$par['pemerintah_logo'] : base_url().'assets/logo/brand.png'; ?>
							<img src="<?php echo $ava ?>"><div class="pull-left">
							<h2 style="color: <?php echo @$par['color_text_header'];?>;"><?php echo $par['pemerintah'] ?></h2>
							<h1 style="color: <?php echo @$par['color_text_header'];?>;"><?php echo $par['instansi'] ?></h1>
						</div>
						<div class="clear"></div>
					</div>
				
				<div class="logo_app pull-right" style="margin-right: 15px;">
				<div class="pull-left">
							<h2><?php echo str_replace(' ',' ',@$set_warna_latar->nama_ids) ?></h2>
						</div>
						<?php $ava = file_exists('./assets/logo/'.$folder.'.png') ? base_url().'assets/logo/'.$folder.'.png' : base_url().'assets/logo/logo.png'; ?>
						<img src="<?php echo $ava ?>">
						<div class="clear"></div>
					</div>
				<div class="clear"></div>
			</div>

			<div class="col-lg-12">
				<div class="col-lg-6" style="padding: 5px 5px 0px 5px; <?php echo (!empty($set_widget_1->lebar) ? 'width:'.$set_widget_1->lebar.'% !important;' : null);?>">
					<div class="box box-default box-konten">
						<div id="postSatu" style="height:<?php echo @$set_widget_1->tinggi;?>px; overflow: hidden;">
							<div class="wid-kolom-satu"></div>
						</div>
					</div>
				</div>
				<div class="col-lg-6" style="padding: 5px 5px 0px 5px; <?php echo (!empty($set_widget_2->lebar) ? 'width:'.$set_widget_2->lebar.'% !important;' : null);?>">
					<div class="box box-default box-konten">
						<div id="postDua" style="height:<?php echo @$set_widget_2->tinggi;?>px; overflow: hidden;">
							<div class="wid-kolom-dua"></div>
						</div>
					</div>
				</div>
				<div class="col-lg-6" style="padding: 5px 5px 0px 5px; <?php echo (!empty($set_widget_3->lebar) ? 'width:'.$set_widget_3->lebar.'% !important;' : null);?>">
					<div class="box box-default box-konten">
						<div id="postTiga" style="height:<?php echo @$set_widget_3->tinggi;?>px; overflow: hidden;">
							<div class="wid-kolom-tiga"></div>
						</div>
					</div>
				</div>

				<div class="col-lg-6" style="padding: 5px 5px 0px 5px; <?php echo (!empty($set_widget_4->lebar) ? 'width:'.$set_widget_4->lebar.'% !important;' : null);?>">
					<div class="box box-default box-konten">
						<div id="postEmpat" style="height:<?php echo @$set_widget_4->tinggi;?>px; overflow: hidden;">
							<div class="wid-kolom-empat"></div>
						</div>
					</div>
				</div>

				<div class="col-lg-6" style="padding: 5px 5px 0px 5px; <?php echo (!empty($set_widget_5->lebar) ? 'width:'.$set_widget_5->lebar.'% !important;' : null);?>">
					<div class="box box-default box-konten">
						<div id="postLima" style="height:<?php echo @$set_widget_5->tinggi;?>px; overflow: hidden;">
							<div class="wid-kolom-lima"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			var id_ids = "<?php echo $id_ids; ?>";
			function get_ids(posisi, target, post, target_ids, link_func, target_luar){
				$.ajax({
					url : "<?php echo site_url($dir.'/load_data/');?>/"+posisi+"/"+target+"/"+post+"/"+id_ids+"/"+target_ids+"/"+link_func+"/"+target_luar,
					mthod : "POST",
					success : function(data){
						$('.'+target_ids).html(data);
					}
				});
			}
			
			$(document).ready(function() {
				
				 get_ids(1, 'postWidSatu', 'page_satu', 'wid-kolom-satu', 'getDataIDSSatu', 'postSatu');
				 get_ids(2, 'postWidDua', 'page_dua', 'wid-kolom-dua', 'getDataIDSDua', 'postDua');
				 get_ids(3, 'postWidTiga', 'page_tiga', 'wid-kolom-tiga', 'getDataIDSTiga', 'postTiga');
				 get_ids(4, 'postWidEmpat', 'page_empat', 'wid-kolom-empat', 'getDataIDSEmpat', 'postEmpat');
				 get_ids(5, 'postWidTiga', 'page_lima', 'wid-kolom-lima', 'getDataIDSLima', 'postLima');
				 get_ids(6, 'postWidEnam', 'page_enam', 'wid-kolom-enam', 'getDataIDSEnam', 'postEnam');
			
			});
		</script>

		<script type="text/javascript">
			window.onload = function() { jam(); }

			 function jam() {
			  var e = document.getElementById('jam'),
			  d = new Date(), h, m, s;
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
	</body>
</html>
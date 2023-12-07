<!DOCTYPE html>
<?php header("Refresh:" . (@$par['refresh_time_2']) ?: ''); ?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="<?php echo @$par['refresh_time_2']; ?>">

    <title><?php echo $title ?></title>

    <link href="<?php echo base_url() . 'assets/css/adminlte.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url() . 'assets/css/skins.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url() . 'assets/css/general.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url() . 'assets/css/style_cms.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url() . 'assets/js/style.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url() . 'assets/js/style.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url() . 'assets/plugins/owl-carousel/owl.carousel.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url() . 'assets/plugins/owl-carousel/owl.theme.default.min.css' ?>" rel="stylesheet">
    <!-- <link href="<?php echo base_url() . 'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet"> -->

    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.min.js' ?>"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url() . 'assets/bootstrap/js/bootstrap.min.js' ?>"></script> -->
    <script src="<?php echo base_url() . 'assets/js/bootstrap.bundle.min.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/app.min.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/owl-carousel/owl.carousel.min.js' ?>"></script>

    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/general.js' ?>"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.tubeplayer.min.js' ?>"></script> -->

    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>

    <script type="text/javascript" src="<?php echo base_url() . 'assets/plugins/tasktimer/dist/tasktimer.min.js' ?>"></script>
    <script src="<?php echo base_url() ?>assets/video/video.js" type="text/javascript"></script>
    <!-- <script src="http://www.youtube.com/player_api"></script> -->
    <style>
        body {
            background: <?php echo (@$par['color_basic_2']) ?: '#f8e5ff'; ?>;
            font-family: Arial;
            margin: 0px;
        }

        .logo {
            z-index: 999;
        }

        .logo_app h2 {
            color: #fff;
            letter-spacing: -1px;
            font-size: 1.0em;
            font-weight: 600;
            text-align: left;
            line-height: 0.9em;
            margin-top: 18px;
            text-transform: uppercase
        }

        .logo_app img {
            float: left;
            /* max-height: 65px;
            margin: 5px 8px 15px 12px */
        }

        .col-sm-6,
        .col-sm-5 {
            position: relative;
        }

        .marquee-box {
            background: #000;
            color: #fff;
            position: fixed;
            bottom: 0;
            padding-top: 5px;
            letter-spacing: 2px;
            z-index: 999;
            right: 80px;
            left: 80px;
            /* padding: 5px; */
            /* height: 40px; */
        }

        .marquee-box ul li {
            list-style: none;
            margin-left: 80px;
            float: left;
        }

        .marquee-box ul li i {
            margin: 0 0px 0 0;
            font-size: 1.3em;
            margin-top: -10px;
            padding: 0px;
        }

        .marquee-box img {
            height: 30px;
            padding-bottom: 3px;
            /* padding: 2px; */
        }




        .marquee-box b {
            /* color: red; */
            font-size: 16px;
            /* padding: 10px; */
        }

        .jam {
            background: <?php echo (@$par['color_time_2']) ?: '#f8c300'; ?>;
            color: <?php echo (@$par['color_text_time_2']) ?: '#ffffff'; ?>;
            position: fixed;
            left: 0px;
            bottom: 0;
            font-size: 16px;
            /* height: 40px; */
            width: 80px;
            margin-bottom: 0px;
            padding: 10px;
            font-weight: bold;
        }

        .tanggal {
            /* background: url(<?php echo base_url() ?>uploads/logo/tanggal.png) no-repeat left top; */
            position: fixed;
            right: 0px;
            bottom: 0;
            font-size: 16px;
            /* height: 40px; */
            width: 125px;
            margin-bottom: 0px;
            /* padding: 10px; */
            padding: 10px 10px 10px 15px;
            font-weight: bold;
            z-index: 999999999;
            background: <?php echo (@$par['color_date_2']) ?: '#dc3545'; ?>;
            color: <?php echo (@$par['color_text_date_2']) ?: '#ffffff'; ?>;
        }

        .logo img {
            float: left;
            margin: 10px 10px 10px 20px;
            max-height: 70px;
        }

        .logo h2,
        .logo h1 {
            padding: 0;
            margin: 20px 0 0 0;
            /* color: #fff; */
            /*text-transform: uppercase; text-shadow: 1px 1px 2px #fff*/
        }

        .logo h2 {
            font-size: 1em;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .logo h1 {
            font-size: 1.6em;
            margin-top: 0;
            font-weight: bold
        }

        .kiri .konten {
            margin: 10px;
            color: #444
        }

        .kiri .konten .judul {
            padding: 10px;
            /* font-size: 1.4em; */
            letter-spacing: 3px;
            text-transform: uppercase;
            border: 1px dashed #444;
            font-weight: 600
        }

        .kanan .konten {
            margin: 0px 10px 0px 10px;
            color: #fff;
            text-align: right;
            margin-right: 0px;
            padding-right: 10px;
        }

        .kanan .konten .judul {
            padding: 10px 20px;
            /* font-size: 1.4em; */
            letter-spacing: -1px;
            text-transform: uppercase;
            background: rgb(12, 94, 132);
            text-align: right;
            font-weight: 600;
            margin-left: -10px;
            margin-right: -10px;
        }

        .jud-ext {
            border-radius: 0 !important
        }

        .drop-bg {
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 100
        }

        .drop-bg img {
            max-width: 100%;
        }

        .box-image-konten img {
            max-width: 100%;
            border: 3px solid #ccc;
            height: auto;
        }

        .no_kiri {
            position: absolute;
            left: 20px;
            bottom: 75px;
            padding: 10px 0 10px 0;
            opacity: 0.5;
            text-align: center;
            min-width: 40px;
            height: 40px;
            /* font: 1.4em Arial; */
            font-weight: bold;
            color: #fff;
            background: #222;
        }

        .no_kanan {
            position: absolute;
            right: 20px;
            bottom: 75px;
            padding: 10px 0 10px 0;
            opacity: 0.5;
            text-align: center;
            min-width: 40px;
            height: 40px;
            /* font: 1.4em Arial; */
            font-weight: bold;
            color: #fff;
            background: #ddd;
        }

        .unit {
            display: none;
        }

        .news-title {
            /* font-size: 1.2em; */
            text-align: left;
            padding: 4px 0 8px 0;
            margin-bottom: 10px;
            border-bottom: 1px dashed #f8c300
        }

        .news-title-sub {
            /* font-size: 0.9em; */
            line-height: 1em;
            text-align: right
        }

        .news-content p {
            line-height: 160%;
            height: 130px;
        }

        /*.news-content p{ line-height: 20px;}*/
        /*#box-image { margin-left: -5px; }*/
        .foto {
            text-align: center !important;
            position: relative;
            overflow: hidden
        }

        .foto-title {
            background: #000000;
            top: 0;
            left: 0;
            padding: 3px 10px;
            color: #ffffff;
            /* font-size: 80%; */
            letter-spacing: 1px;
            text-align: center;
        }

        .video-title {
            background: #000000;
            top: 0;
            left: 0;
            padding: 3px 10px;
            color: #ffffff;
            /* font-size: 90%; */
            letter-spacing: 1px;
            text-align: center;
        }

        .foto-content {
            position: absolute;
            background: #000;
            padding: 3px 10px;
            left: 0;
            bottom: 15px;
            color: #fff;
            opacity: 0.4;
            width: 100%;
            display: none;
        }

        .info-box {
            margin-bottom: 5px;
        }

        .card-header.with-border {
            background: #000;
        }

        .card-header {
            color: #f8c300;
            padding: 2px;
            text-align: left;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-header .card-title {
            /* font-size: 30px; */
            font-family: latin;
        }

        .card-header .card-title b,
        strong {
            /* font-size: 30px; */
            font-family: latin;
            letter-spacing: 1mm;
            font-weight: 100 !important;
        }

        .card {
            /* margin: 3px; */
            border-radius: 5px;
            margin-bottom: 0px;
        }

        .card.card-default {
            border: none;
        }

        .card-body {
            padding: 0px;

        }

        .card-body h5 {
            text-align: left;
            margin-left: 15px;
            font-weight: bold;

        }

        .luar {
            overflow: hidden;
            position: relative;
            min-height: 210px;
        }

        .dalam {
            position: absolute;
            left: 0;
            top: 0;
        }

        .luar-berita {
            overflow: hidden;
            position: relative;
            min-height: 210px;
        }

        .dalam-berita {
            position: absolute;
            left: 0;
            top: 0;
        }

        .luar-info {
            overflow: hidden;
            position: relative;
            min-height: 210px;
        }

        .dalam-info {
            position: absolute;
            left: 0;
            top: 0;
        }

        .luar_pelatihan {
            overflow: hidden;
            position: relative;
            min-height: 200px;
        }

        .dalam_pelatihan {
            position: absolute;
            left: 0;
            top: 0;
        }

        .dalam p img {
            width: 100% !important;
            height: auto !important;
            text-align: center !important;
        }

        .dalam img {
            width: 100% !important;
            height: auto !important;
            text-align: center !important;
        }

        video {
            width: 100%;
            object-fit: cover;
            /*object-fit: cover;*/
            height: 172px;
        }

        .dalam-berita p {
            word-spacing: -1px;
        }

        .dalam-berita img {
            margin: 0px 10px 2px 0px !important;
            width: 40% !important;
            height: 135px !important;
        }

        .dalam-info p {
            line-height: 15px !important;
            /* font-size: 10px; */
            word-spacing: -1px;

        }

        .dalam p {
            line-height: 15px !important;
            /* font-size: 10px; */
            word-spacing: -1px;

        }

        .pengumuman p {
            line-height: 15px !important;
            /* font-size: 10px; */
            word-spacing: -1px;

        }
    </style>
    <script type="text/javascript">
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            };
            return i;
        }

        setInterval(1000);

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            date = d.getDate();
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>


</head>

<body class="skin-blue sidebar-mini" style="color:#ffffff">

    <div class="row" style="margin-right:0px; margin-left:0px;">
        <div class="col-lg-12" style="height: 85px;background:<?php echo (@$par['color_header_2']) ?: '#500380'; ?>; color:<?php echo (@$par['color_text_header_2']) ?: '#ffffff'; ?>">
            <!-- parameter : header_color -->
            <div class="logo pull-left" style="margin-left: 0px;display: flex;justify-content: start;">
                <?php $ava = file_exists('./uploads/logo/' . @$par['pemerintah_logo']) ? base_url() . 'uploads/logo/' . $par['pemerintah_logo'] : base_url() . 'assets/logo/brand.png'; ?>
                <img src="<?php echo $ava ?>">
                <div class="">
                    <h2><?php echo $par['pemerintah'] ?></h2>
                    <h1><?php echo $par['instansi'] ?></h1>
                </div>
                <!-- <div class="clear"></div> -->
            </div>
            <div class="logo_app pull-right" style="margin-right: 15px;">

                <!-- <img src="<?php echo base_url() . 'uploads/siatika/galeri/pegawai/' . @$h_peg->file; ?>" alt="<?php echo @$h_peg->jabatan; ?>" style=" max-height: 85px;"> -->


                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php if ($musik->num_rows() > 0) { ?>
        <div style="display: none;">
            <div id="audio0">
                <audio preload autoplay id="audio1">Your browser does not support HTML5 Audio!</audio>
            </div>
            <?php
            $no = 1;
            $tracks = array();
            foreach ($musik->result() as $mus) {
                $tracks[] = '{"track":"' . $no . '","name":"' . str_replace('.mp3', '', $mus->backsound) . '","length":"01:00","file":"' . str_replace('.mp3', '', $mus->backsound) . '"}';
                $no += 1;
            }
            ?>
        </div>
        <script type="text/javascript">
            var b = document.documentElement;
            b.setAttribute('data-useragent', navigator.userAgent);
            b.setAttribute('data-platform', navigator.platform);

            jQuery(function($) {
                var supportsAudio = !!document.createElement('audio').canPlayType;
                if (supportsAudio) {
                    var index = 0,
                        playing = false,
                        mediaPath = '<?php echo base_url("uploads/siatika/galeri/backsound") ?>/',
                        extension = '',
                        tracks = [<?php echo implode(",", $tracks); ?>],
                        trackCount = tracks.length,
                        npAction = $('#npAction'),
                        npTitle = $('#npTitle'),

                        audio = $('#audio1').bind('play', function() {
                            playing = true;
                            npAction.text('Now Playing...');

                        }).bind('pause', function() {
                            playing = false;
                            npAction.text('Paused...');
                        }).bind('ended', function() {
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
                        btnPrev = $('#btnPrev').click(function() {
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
                        btnNext = $('#btnNext').click(function() {
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
                        li = $('#plList li').click(function() {
                            var id = parseInt($(this).index());
                            if (id !== index) {
                                playTrack(id);
                            }
                        }),
                        loadTrack = function(id) {
                            $('.plSel').removeClass('plSel');
                            $('#plList li:eq(' + id + ')').addClass('plSel');
                            npTitle.text(tracks[id].name);
                            index = id;
                            audio.src = mediaPath + tracks[id].file + extension;
                        },
                        playTrack = function(id) {
                            loadTrack(id);
                            audio.play();
                        };
                    extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
                    loadTrack(index);
                }
            });
        </script>
    <?php } ?>
    <div class="row" style="margin-right:0px; margin-left:0px;">

        <div class="col-lg-7" style="margin-top: 10px;">
            <div class="row">
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:<?php echo (@$par['height_profil_1']) ?: '330'; ?>px;font-size:<?php echo (@$par['font_profil_1']) ?: '14'; ?>px;background:<?php echo (@$par['color_box_profil_1']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_profil_1']) ?: '#000000'; ?>;">
                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_profil_1']) ?: '#510045'; ?>,#ffffff);">
                            <!-- parameter : background_berita -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_profil_1']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Profil Pegawai</b></span><!-- parameter : warna_berita -->
                        </div>
                        <?php
                        if (!empty($par['height_profil_1'])) {
                            $t_profil = (int) $par['height_profil_1'] - 32;
                        } else {
                            $t_profil = 248;
                        }
                        ?>
                        <div class="card-body no-padding" style="height:<?php echo $t_profil; ?>px; overflow:hidden;">
                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">
                                <div class="widget-pegawai" id="postPegawai"></div>
                                <?php
                                if ($pegawai->num_rows() > 0) {
                                ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {

                                            pageScroll();
                                            $("#contain").mouseover(function() {
                                                clearTimeout(my_time);
                                            }).mouseout(function() {
                                                pageScroll();
                                            });

                                            getWidthHeader('table_fixed', 'table_scroll');

                                        });

                                        var my_time;

                                        function pageScroll() {
                                            var objDiv = document.getElementById("contain");
                                            objDiv.scrollTop = objDiv.scrollTop + 1;
                                            if ((objDiv.scrollTop + <?php echo (int)$t_profil; ?>) == objDiv.scrollHeight) {
                                                objDiv.scrollTop = 0;
                                            }
                                            my_time = setTimeout('pageScroll()', 50);
                                        }

                                        function getWidthHeader(id_header, id_scroll) {
                                            var colCount = 0;
                                            $('#' + id_scroll + ' tr:nth-child(1) td').each(function() {
                                                if ($(this).attr('colspan')) {
                                                    colCount += +$(this).attr('colspan');
                                                } else {
                                                    colCount++;
                                                }
                                            });

                                            for (var i = 1; i <= colCount; i++) {
                                                var th_width = $('#' + id_scroll + ' > tbody > tr:first-child > td:nth-child(' + i + ')').width();
                                                $('#' + id_header + ' > thead th:nth-child(' + i + ')').css('width', th_width + 'px');
                                            }
                                        }
                                    </script>
                                    <style>
                                        #contain {
                                            height: <?php echo $t_profil . 'px' ?>;
                                            overflow-y: scroll;
                                            padding: 10px;
                                        }

                                        #table_scroll {
                                            width: 100%;
                                            margin-top: 100px;
                                            margin-bottom: 100px;

                                        }

                                        #table_scroll tbody td {
                                            padding: 10px;
                                            /* background-color: #7fe55e;
                                        color: #fff; */
                                        }
                                    </style>
                                    <div id="contain">
                                        <table border="0" id="table_scroll table-sm">
                                            <tbody>
                                                <?php
                                                foreach ($pegawai->result() as $pg) {
                                                    if (!empty($pg->photo)) {
                                                        $photo = base_url('uploads/kepegawaian/pasfoto/' . $pg->photo);
                                                    } else {
                                                        $photo = base_url('assets/images/noimage.jpg');
                                                    }
                                                ?>
                                                    <tr>
                                                        <td style="width: 30%;padding-top:20px;padding-left:20px;">Nama</td>
                                                        <td style="width: 5%;padding-top:20px;">:</td>
                                                        <td style="width: 70%;padding-top:20px;"><?php echo $pg->nama; ?></td>
                                                        <td rowspan="5" style="padding-top:20px;padding-right:20px;"><img src="<?php echo $photo; ?>" alt="" height="150px" width="125px" style="border-radius: 5px;object-fit: cover;object-position: center;"></td>

                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:20px;">NIP</td>
                                                        <td>:</td>
                                                        <td><?php echo $pg->nip; ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:20px;">Tempat, Tanggal Lahir</td>
                                                        <td>:</td>
                                                        <td><?php echo $pg->tempat_lahir . ', ' . tanggal_indo(date('Y-m-d', strtotime(@$pg->tanggal_lahir))); ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:20px;">Jabatan</td>
                                                        <td>:</td>
                                                        <td><?php echo $pg->nama_jabatan; ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:20px;">Unit Organisasi</td>
                                                        <td>:</td>
                                                        <td><?php echo $pg->nama_bidang; ?></td>

                                                    </tr>
                                                    <tr style="border-bottom: 1px solid black; ">
                                                        <td style="padding-bottom:20px;padding-left:20px;">Alamat</td>
                                                        <td style="padding-bottom:20px;">:</td>
                                                        <td style="padding-bottom:20px;"><?php echo  $pg->lamat; ?></td>

                                                    </tr>
                                                <?php

                                                    # code...
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                } else {
                                    echo '<div class="alert">Belum ada profil pegawai yang tersedia ...</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:<?php echo (@$par['height_foto_2']) ?: '239'; ?>px;background:<?php echo (@$par['color_box_foto_2']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_foto_2']) ?: '#000000'; ?>;">
                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_foto_2']) ?: '#510045'; ?>,#ffffff);">
                            <!-- parameter : background_berita -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_foto_2']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Galeri Kegiatan</b></span><!-- parameter : warna_berita -->
                        </div>
                        <?php
                        if (!empty($par['height_foto_2'])) {
                            $t_foto = (int) $par['height_foto_2'] - 32;
                            $t_img = $t_foto - 55;
                        } else {
                            $t_foto = 193;
                            $t_img = 148;
                        }
                        ?>
                        <div class="card-body no-padding" style="height:<?php echo $t_foto; ?>px; overflow:hidden;padding:10px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div id="postGAL1" style="padding:0px !important;margin:0px !important; height:<?php echo $t_foto; ?>px !important;">
                                        <?php
                                        if ($foto_kiri->num_rows()) {
                                        ?>
                                            <div class="owl-carousel kiri">
                                                <?php
                                                foreach ($foto_kiri->result() as $fkr) {
                                                    $jml_kar = strlen($fkr->judul);
                                                ?>
                                                    <div>
                                                        <?php
                                                        if ($jml_kar > 20) { ?>
                                                            <div class="foto-title" style="padding-bottom: 0px;">
                                                                <marquee><?php echo $fkr->judul; ?></marquee>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="foto-title" style="padding-bottom: 4px; text-align: justify;"><?php echo $fkr->judul; ?></div>
                                                        <?php } ?>

                                                        <img src="<?php echo base_url() . 'uploads/siatika/galeri/foto/' . $fkr->foto; ?>" style="width:100%; height:<?php echo $t_img; ?>px;object-fit: cover;object-position: center;" />

                                                    </div>
                                                <?php
                                                    # code...
                                                }
                                                ?>

                                            </div>
                                            <script type="text/javascript">
                                                $(".kiri").owlCarousel({
                                                    loop: true,
                                                    autoplay: true,
                                                    items: 1,
                                                    // nav: true,
                                                    autoplayTimeout: 10000,
                                                    autoplayHoverPause: true,
                                                    animateOut: 'slideOutUp',
                                                    animateIn: 'slideInUp'
                                                });
                                            </script>
                                        <?php
                                        } else {
                                            echo '<div class="alert">Belum ada Foto ...</div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div id="postGAL1" style="padding:0px !important;margin:0px !important; height:<?php echo $t_foto; ?>px !important;">
                                        <?php
                                        if ($foto_kanan->num_rows()) {
                                        ?>
                                            <div class="owl-carousel kanan">
                                                <?php
                                                foreach ($foto_kanan->result() as $fkn) {
                                                    $jml_kar = strlen($fkn->judul);
                                                ?>
                                                    <div>
                                                        <?php
                                                        if ($jml_kar > 20) { ?>
                                                            <div class="foto-title" style="padding-bottom: 0px;">
                                                                <marquee><?php echo $fkn->judul; ?></marquee>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="foto-title" style="padding-bottom: 4px; text-align: justify;"><?php echo $fkn->judul; ?></div>
                                                        <?php } ?>

                                                        <img src="<?php echo base_url() . 'uploads/siatika/galeri/foto/' . $fkn->foto; ?>" style="width:100%; height:<?php echo $t_img; ?>px;object-fit: cover;object-position: center;" />

                                                    </div>
                                                <?php
                                                    # code...
                                                }
                                                ?>

                                            </div>
                                            <script type="text/javascript">
                                                $(".kanan").owlCarousel({
                                                    loop: true,
                                                    autoplay: true,
                                                    items: 1,
                                                    // nav: true,
                                                    autoplayTimeout: 10000,
                                                    autoplayHoverPause: true,
                                                    animateOut: 'slideOutUp',
                                                    animateIn: 'slideInUp'
                                                });
                                            </script>
                                        <?php
                                        } else {
                                            echo '<div class="alert">Belum ada Foto ...</div>';
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-5" style="margin-top: 10px;">
            <div class="row">
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:<?php echo (@$par['height_informasi_2']) ?: '260'; ?>px;font-size:<?php echo (@$par['font_informasi_2']) ?: '14'; ?>px;background:<?php echo (@$par['color_box_informasi_2']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_informasi_2']) ?: '#000000'; ?>;">
                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_informasi_2']) ?: '#510045'; ?>,#ffffff);">
                            <!-- parameter : background_berita -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_informasi_2']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Informasi</b></span><!-- parameter : warna_berita -->
                        </div>
                        <?php
                        if (!empty($par['height_informasi_2'])) {
                            $t_informasi = (int) $par['height_informasi_2'] - 32;
                        } else {
                            $t_informasi = 178;
                        }
                        ?>
                        <div class="card-body no-padding" style="height:<?php echo $t_informasi; ?>px; overflow:hidden;">
                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">
                                <!-- <div class="widget-informasi" id="postInformasi"></div> -->
                                <?php
                                if ($informasi->num_rows()) {

                                ?>
                                    <div class="owl-carousel informasi">
                                        <?php
                                        foreach ($informasi->result() as $inf) {

                                        ?>
                                            <div>
                                                <div class="card " style="padding:0px 10px;font-size:<?php echo (@$par['font_informasi_2']) ?: '14'; ?>px;background:<?php echo (@$par['color_box_informasi_2']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_informasi_2']) ?: '#000000'; ?>">
                                                    <div class="card-title" style="border-bottom: 1px solid #000;">
                                                        <div class="row">
                                                            <div class="col-lg-12" style="font-size: 16px;"><?php echo $inf->title ?></div>

                                                        </div>
                                                    </div>
                                                    <div class="card-body luar" style="min-height:220px; margin-top:10px;text-align:justify;word-spacing:3px;">
                                                        <div class="dalam">
                                                            <?php
                                                            $total = strlen($inf->content);
                                                            // cek($total);
                                                            if ($total < 500) {
                                                                echo $inf->content;
                                                            } else {
                                                            ?>
                                                                <marquee direction="up" behavior="scroll" scrollamount="5">
                                                                    <?php echo $inf->content; ?>
                                                                </marquee>
                                                            <?php
                                                            }
                                                            ?>
                                                           
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php
                                            # code...
                                        }
                                        ?>

                                    </div>
                                    <script type="text/javascript">
                                        $(".informasi").owlCarousel({
                                            loop: true,
                                            autoplay: true,
                                            items: 1,
                                            // nav: true,
                                            autoplayTimeout: 10000,
                                            autoplayHoverPause: true,

                                        });
                                    </script>
                                <?php
                                } else {
                                    echo '<div class="alert">Belum ada informasi yang tersedia ...</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:<?php echo (@$par['height_pengumuman_2']) ?: '220'; ?>px;font-size:<?php echo (@$par['font_pengumuman_2']) ?: '14'; ?>px;background:<?php echo (@$par['color_box_pengumuman_2']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_pengumuman_2']) ?: '#000000'; ?>;">

                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_pengumuman_2']) ?: '#510045'; ?>, #ffffff);">
                            <!-- parameter : background_video -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_pengumuman_2']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Pengumuman</b></span><!-- parameter : warna_video -->
                        </div>
                        <?php
                        if (!empty($par['height_pengumuman_2'])) {
                            $t_pengumuman = (int) $par['height_pengumuman_2'] - 32;
                        } else {
                            $t_pengumuman = 188;
                        }
                        ?>
                        <div class="card-body no-padding" style="height:<?php echo $t_pengumuman; ?>px; overflow:hidden;">
                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">

                                <!-- <div class="widget-pengumuman" id="postPengumuman"></div> -->
                                <?php
                                if ($pengumuman->num_rows()) {

                                ?>
                                    <div class="owl-carousel pengumuman">
                                        <?php
                                        foreach ($pengumuman->result() as $peng) {

                                        ?>
                                            <div>
                                                <div class="card" style="padding:0px 10px;font-size:<?php echo (@$par['font_pengumuman_2']) ?: '14'; ?>px;background:<?php echo (@$par['color_box_pengumuman_2']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_pengumuman_2']) ?: '#000000'; ?>">
                                                    <div class="card-title" style="border-bottom: 1px dashed #000;">
                                                        <div class="row">
                                                            <div class="col-lg-12"><?php echo $peng->title ?></div>

                                                        </div>
                                                    </div>
                                                    <div class="card-body luar" style="min-height:220px; margin-top:10px;text-align:justify;line-height:1.42857143;word-spacing:3px;">
                                                        <div class="dalam">
                                                            <?php
                                                            $total = strlen($peng->content);
                                                            // cek($total);
                                                            if ($total < 500) {
                                                                echo $peng->content;
                                                            } else {
                                                            ?>
                                                                <marquee direction="up" behavior="scroll" scrollamount="5">
                                                                    <?php echo $peng->content; ?>
                                                                </marquee>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php
                                            # code...
                                        }
                                        ?>

                                    </div>
                                    <script type="text/javascript">
                                        $(".pengumuman").owlCarousel({
                                            loop: true,
                                            autoplay: true,
                                            items: 1,
                                            // nav: true,
                                            autoplayTimeout: 10000,
                                            autoplayHoverPause: true,

                                        });
                                    </script>
                                <?php
                                } else {
                                    echo '<div class="alert">Belum ada pengumuman yang tersedia ...</div>';
                                }
                                ?>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom: 10px;">

                    <!-- <div class="card card-default" style="height:110px;background:#ffffff;color:#ffffff;"> -->
                    <img src="<?php echo base_url() . '/uploads/brands/' . @$par['header_image']; ?>" style="width: 100%; height:80px; border-radius:5px">
                    <!-- </div> -->


                </div>
            </div>

        </div>



        <script type="text/javascript">
            window.onload = function() {
                jam();

            }
            $(document).ready(function() {
                // $(".carouselVideo").carousel("pause")
                // ajak pengumuman (ajax kayak kieee)

                $.ajax({
                    url: "<?php echo site_url('siatika/display/ajaxPaginationinformasi'); ?>",
                    // dataType : "JSON",
                    success: function(data) {
                        $('.widget-informasi').html(data);
                    }
                });


                $.ajax({
                    url: "<?php echo site_url('siatika/display/ajaxPaginationpengumuman'); ?>",
                    // dataType : "JSON",
                    success: function(data) {
                        $('.widget-pengumuman').html(data);
                    }
                });

                setInterval(function() {
                    tgl_reload();
                }, 200000);
            });

            function tgl_reload() {
                $.ajax({
                    url: "<?php echo site_url('siatika/display/ajax_tgl') ?>",
                    dataType: 'JSON',
                    success: function(data) {
                        $.each(data, function(k, v) {
                            $('#tgl_bawah').html(v.tgl);
                        });
                    }
                });
            }
        </script>

        <!-- </div> -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="jam" id="jam"></h3>
            <div class="box-marquee" style="font-size: 120%;background:<?php echo (@$par['color_footer_2']) ?: '#000000'; ?>;color:<?php echo (@$par['color_text_footer_2']) ?: '#ffffff'; ?>">
                <?php

                $ava = file_exists('./uploads/logo/' . @$par['pemerintah_logo']) ? base_url() . 'uploads/logo/' . $par['pemerintah_logo'] : base_url() . 'assets/logo/brand.png';
                $img = '<img src="' . $ava . '" height="50">';
                echo '
                    <marquee class="marquee-box">
                        <div >';
                $j = 1;
                foreach ($running_text->result() as $m) {
                    $star = ($j > 1) ? '&nbsp;&nbsp;' . $img . '&nbsp;&nbsp; ' : null;
                    echo '' . $star . '<b>' . $m->teks_bergerak . '</b> ';
                    $j += 1;
                }
                echo '
                        </div>
                    </marquee>';

                ?>
            </div>
            <h3 class="tanggal" id="tgl_bawah">
                <?php echo date_indox(date('Y-m-d'), 2); ?>
            </h3>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                var h_image = ($(window).height() - $('.marquee-box').height()) * 0.3;
                $('#box-image').height(h_image + 10);
                $('.col-sm-5, .col-sm-7,.drop-bgx').height($(window).height());
                $('#konten-pengumuman').height($(window).height() - $('.marquee-box').height() - h_image - 150);
            });
        </script>
    </div>



    <div class="clear"></div>
</body>

</html>
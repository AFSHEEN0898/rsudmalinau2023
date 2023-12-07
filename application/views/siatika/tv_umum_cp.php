<!DOCTYPE html>
<?php header("Refresh:" . (@$par['refresh_time_1']) ?: ''); ?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="<?php echo @$par['refresh_time_1']; ?>">

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
            background: #f8e5ff;
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
            background: <?php echo (@$par['color_time_1']) ?: '#f8c300'; ?>;
            color: <?php echo (@$par['color_text_time_1']) ?: '#ffffff'; ?>;
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
            background: <?php echo (@$par['color_date_1']) ?: '#dc3545'; ?>;
            color: <?php echo (@$par['color_text_date_1']) ?: '#ffffff'; ?>;
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
            font-size: 1.4em;
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
            font-size: 1.4em;
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
            font: 1.4em Arial;
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
            font: 1.4em Arial;
            font-weight: bold;
            color: #fff;
            background: #ddd;
        }

        .unit {
            display: none;
        }

        .news-title {
            font-size: 1.2em;
            text-align: left;
            padding: 4px 0 8px 0;
            margin-bottom: 10px;
            border-bottom: 1px dashed #f8c300
        }

        .news-title-sub {
            font-size: 0.9em;
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
            font-size: 80%;
            letter-spacing: 1px;
            text-align: center;
        }

        .video-title {
            background: #000000;
            top: 0;
            left: 0;
            padding: 3px 10px;
            color: #ffffff;
            font-size: 90%;
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
            font-size: 10px;
            word-spacing: -1px;

        }

        .dalam p {
            line-height: 15px !important;
            font-size: 10px;
            word-spacing: -1px;

        }

        .pengumuman p {
            line-height: 15px !important;
            font-size: 10px;
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

    <script type="text/javascript">
        $(document).ready(function() {

            // ajak informasi (ajax kayak kieee)
            $.ajax({
                url: "<?php echo site_url('siatika/display/ajaxPaginationinformasi'); ?>",
                // dataType : "JSON",
                success: function(data) {
                    $('.widget-informasi').html(data);
                }
            });
            // ./ajak informasi (ajax kayak kieee)


            // ajak pengumuman (ajax kayak kieee)
            $.ajax({
                url: "<?php echo site_url('siatika/display/ajaxPaginationpengumuman'); ?>",
                // dataType : "JSON",
                success: function(data) {
                    $('.widget-pengumuman').html(data);
                }
            });
            // ./ajak pengumuman (ajax kayak kieee)


        });
    </script>
</head>

<body class="skin-blue sidebar-mini" style="color:#ffffff">

    <div class="row" style="margin-right:0px; margin-left:0px;">
        <div class="col-lg-12" style="height: 85px;background:<?php echo (@$par['color_header_1']) ?: '#500380'; ?>; color:<?php echo (@$par['color_text_header_1']) ?: '#ffffff'; ?>">
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

                <!-- <img src="<?php echo base_url() . 'uploads/siatika/galeri/pegawai/' . $h_peg->file; ?>" alt="<?php echo $h_peg->jabatan; ?>" style=" max-height: 85px;"> -->


                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="row" style="margin-right:0px; margin-left:0px;">

        <div class="col-lg-7" style="margin-top: 10px;">
            <!-- parameter : color_tv -->
            <div class="row" style="display:flex; flex-wrap:wrap; justify-content:space-between;">
                <div class="col-lg-6" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:220px;background:<?php echo (@$par['color_box_pengumuman_1']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_pengumuman_1']) ?: '#000000'; ?>">

                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_pengumuman_1']) ?: '#510045'; ?>, #ffffff);">
                            <!-- parameter : background_video -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_pengumuman_1']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Pengumuman</b></span><!-- parameter : warna_video -->
                        </div>
                        <div class="card-body no-padding" style="height:188px; overflow:hidden; color:#000;">
                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">

                                <div class="widget-pengumuman" id="postPengumuman"></div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-6" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:220px;background: <?php echo (@$par['color_box_video_1']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_video_1']) ?: '#000000'; ?>">
                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_video_1']) ?: '#510045'; ?>, #ffffff);">
                            <!-- parameter : background_berita -->
                            <span class="card-title" style="color: <?php echo (@$par['color_title_video_1']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Galeri Video</b></span><!-- parameter : warna_berita -->
                        </div>
                        <div class="card-body no-padding" style="height:187px; overflow:hidden;">

                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">

                                <?php
                                if ($mode_video == 1) {
                                ?>
                                    <div id="audio02">
                                        <video autoplay="autoplay" preload id="video1" style="height:173px;object-fit: fill;">Your browser does not support HTML5 Audio!</video>
                                    </div>

                                    <div id="plwrapx">
                                        <ul id="plListx">
                                            <?php
                                            $no = 1;
                                            $tracks = array();
                                            foreach ($video->result() as $mus) {
                                                $tracks[] = '{"track":"' . $no . '","name":"' . str_replace('.mp4', '', $mus->video) . '","lenght":"01:00","file":"' . str_replace('.mp4', '', $mus->video) . '"}';
                                            ?>
                                            <?php $no += 1;
                                            } ?>
                                        </ul>
                                    </div>
                                    <script type="text/javascript">
                                        var b = document.documentElement;
                                        b.setAttribute('data-useragent', navigator.userAgent);
                                        b.setAttribute('data-platform', navigator.platform);

                                        jQuery(function($) {
                                            var supportsAudio = !!document.createElement('video').canPlayType;
                                            if (supportsAudio) {
                                                var index = 0,
                                                    playing = false,
                                                    mediaPath = '<?php echo base_url("uploads/siatika/galeri/video") ?>/',
                                                    extension = '',
                                                    tracks = [<?php echo implode(",", $tracks); ?>],
                                                    trackCount = tracks.length,
                                                    npAction = $('#npAction'),
                                                    npTitle = $('#npTitle'),

                                                    audio = $('#video1').bind('play', function() {
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
                                                    li = $('#plListx li').click(function() {
                                                        var id = parseInt($(this).index());
                                                        if (id !== index) {
                                                            playTrack(id);
                                                        }
                                                    }),
                                                    loadTrack = function(id) {
                                                        $('.plSelx').removeClass('plSelx');
                                                        $('#plListx li:eq(' + id + ')').addClass('plSelx');
                                                        npTitle.text(tracks[id].name);
                                                        index = id;
                                                        audio.src = mediaPath + tracks[id].file + extension;
                                                    },
                                                    playTrack = function(id) {
                                                        loadTrack(id);
                                                        audio.play();
                                                    };
                                                extension = audio.canPlayType('video/mp4') ? '.mp4' : audio.canPlayType('video/ogg') ? '.ogg' : '';
                                                loadTrack(index);
                                            }
                                        });
                                    </script>
                                <?php
                                } else {
                                ?>
                                    <iframe width="100%" height="173px;" src="<?php echo $video->youtube_link; ?>?autoplay=1&controls=0&loop=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>


                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:215px;background:  <?php echo (@$par['color_box_berlangsung_1']) ?: '#ffffff'; ?>;color: <?php echo (@$par['color_text_berlangsung_1']) ?: '#000000'; ?>">

                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_berlangsung_1']) ?: '#510045'; ?>,#ffffff);">
                            <!-- parameter : background_video -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_berlangsung_1']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Agenda Berlangsung</b></span><!-- parameter : warna_video -->
                        </div>

                        <div class="card-body no-padding" style="height:183px; overflow:hidden; color:#000">
                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">
                                <div class="widget-berlangsung" id="postBerlangsung"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:215px;background:<?php echo (@$par['color_box_rencana_1']) ?: '#ffffff'; ?>;color: <?php echo (@$par['color_text_rencana_1']) ?: '#000000'; ?>">
                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_rencana_1']) ?: '#510045'; ?>,#ffffff);">
                            <!-- parameter : background_berita -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_rencana_1']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Jadwal Agenda</b></span><!-- parameter : warna_berita -->
                        </div>

                        <div class="card-body no-padding" style="height:183px; overflow:hidden;">
                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">

                                <div class="widget-pelatihan" id="postPelatihan"></div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:125px;background:  <?php echo (@$par['color_foto_pegawai']) ?: '#510045'; ?>;">

                        <div class="card-body no-padding" style=" overflow:hidden;">
                            <div class="card-body no-padding" style="overflow:hidden;padding:10px">

                                <div class="owl-carousel owl-theme owl-loaded owl-drag foto">
                                    <div class="owl-stage-outer">

                                        <div class="owl-stage" style="transform: translate3d(-1527px, 0px, 0px); transition: all 0.25s ease 0s; width: 3334px;">
                                            <?php
                                            $no = 1;
                                            foreach ($foto->result() as $ft) {
                                                $aktif = '';
                                                if ($no <= 7) {
                                                    $aktif = 'active';
                                                }
                                            ?>
                                                <div class="owl-item <?php echo $aktif; ?>" style="width: 128.906px; margin-right: 10px;">
                                                    <div class="item">
                                                        <img src="<?php echo base_url('uploads/siatika/galeri/foto/' . @$ft->foto); ?>" alt="" style="height: 105px;border-radius:5px">
                                                    </div>
                                                </div>
                                            <?php
                                                $no++;
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="owl-nav disabled">

                                    </div>

                                </div>

                                <script type="text/javascript">
                                    var owl = $('.foto');
                                    owl.owlCarousel({
                                        items: 6,
                                        loop: true,
                                        margin: 10,
                                        autoplay: true,
                                        autoplayTimeout: 3000,
                                        autoplayHoverPause: true
                                    });
                                </script>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-lg-5" style="margin-top: 10px;">
            <!-- parameter : color_tv -->

            <div class="row">
                <div class="col-lg-12" style="margin-bottom: 10px;">

                    <!-- <div class="card card-default" style="height:110px;background:#ffffff;color:#ffffff;"> -->
                    <img src="<?php echo base_url() . '/uploads/brands/' . @$par['header_image']; ?>" style="width: 100%; height:80px">
                    <!-- </div> -->


                </div>
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:270px;background:<?php echo (@$par['color_box_informasi_1']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_informasi_1']) ?: '#000000'; ?>;">
                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_informasi_1']) ?: '#510045'; ?>,#ffffff);">
                            <!-- parameter : background_berita -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_informasi_1']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Informasi</b></span><!-- parameter : warna_berita -->
                        </div>
                        <div class="card-body no-padding" style="height:238px; overflow:hidden; ">
                            <div class="card-body no-padding" style="overflow:hidden;padding:5px">
                                <div class="widget-informasi" id="postInformasi"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="card card-default" style="height:212px;background:<?php echo (@$par['color_box_foto_1']) ?: '#ffffff'; ?>;color:<?php echo (@$par['color_text_foto_1']) ?: '#000000'; ?>;">
                        <div class="card-header" style="padding:10px; background:linear-gradient(to right, <?php echo (@$par['color_foto_1']) ?: '#510045'; ?>,#ffffff);">
                            <!-- parameter : background_berita -->
                            <span class="card-title" style="color:<?php echo (@$par['color_title_foto_1']) ?: '#ffffff'; ?>;font-family:latin; font-size:30px;line-height: 15px;padding-bottom: 0px;"><b>Galeri Kegiatan</b></span><!-- parameter : warna_berita -->
                        </div>
                        <div class="card-body no-padding" style="height:180px; overflow:hidden;padding:5px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div id="postGAL1" style="padding:0px !important;margin:0px !important; height:180px !important;">
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

                                                        <img src="<?php echo base_url() . 'uploads/siatika/galeri/foto/' . $fkr->foto; ?>" style="width:100%; height:135px;object-fit: cover;object-position: center;" />

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
                                    <div id="postGAL1" style="padding:0px !important;margin:0px !important; height:180px !important;">
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

                                                        <img src="<?php echo base_url() . 'uploads/siatika/galeri/foto/' . $fkn->foto; ?>" style="width:100%; height:135px;object-fit: cover;object-position: center;" />

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



        <script type="text/javascript">
            window.onload = function() {
                jam();
                $('.carouselVideo').carousel({
                    interval: false,
                });
            }
            $(document).ready(function() {
                // $(".carouselVideo").carousel("pause")
                // ajak pengumuman (ajax kayak kieee)
                $.ajax({
                    url: "<?php echo site_url('siatika/display/ajaxPaginationberlangsung'); ?>",
                    // dataType : "JSON",
                    success: function(data) {
                        $('.widget-berlangsung').html(data);
                    }
                });
                $.ajax({
                    url: "<?php echo site_url('siatika/display/ajaxPaginationinformasi'); ?>",
                    // dataType : "JSON",
                    success: function(data) {
                        $('.widget-informasi').html(data);
                    }
                });

                $.ajax({
                    url: "<?php echo site_url('siatika/display/ajaxPaginationpelatihan'); ?>",
                    // dataType : "JSON",
                    success: function(data) {
                        $('.widget-pelatihan').html(data);
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
            <div class="box-marquee" style="font-size: 120%;background:<?php echo (@$par['color_footer_1']) ?: '#000000'; ?>;color:<?php echo (@$par['color_text_footer_1']) ?: '#ffffff'; ?>">
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
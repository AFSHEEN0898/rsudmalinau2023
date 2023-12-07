<?php
echo @$css_load;
echo @$include_script;

$box_cls = !empty($tabs) ? 'nav-tabs-custom' : 'card';
?>
<script src="<?php echo base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url() . 'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function() {
        $('.heading').parent().find('td').addClass('headings');
    });
    <?php echo  @$script ?>
</script>

<!-- <div class="<?php echo $box_cls ?>" id="box-main"> -->
<div class="card" id="box-main">
    <?php if (!empty($tabs)) { ?>
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <?php
            foreach ($tabs as $t) { 
                $on = '';
                if ($t['on'] != null) {
                    $on = 'active';
                }
                echo '
							<li ' . (!empty($t['on']) ? ' class="nav-item " id="custom-content-below-settings-tab"' : null) . '>
                    <a class="nav-link ' . $on . '"  ' . (!empty($t['url']) ? ' href="' . $t['url'] . '"' : null) . '  style="padding:10px;">' . $t['text'] . '</a></li>';
            }
            ?>
        </ul> 
    <?php } ?>

    <?php if (!empty($tombol) or !empty($extra_tombol)) { ?>

        <div class="card-header with-border">
            <div class="row">
                <div class="col-md-7" style="margin-bottom: 10px"><?php echo @$tombol ?></div>
                <?php if (!empty($extra_tombol)) echo '<div class="col-md-5">' . $extra_tombol . '</div>'; ?>
            </div>
        </div><!-- /.box-header -->
    <?php } ?>
    <?php echo form_open_multipart($this->dir . '/simpan_umum', 'role="form" id="form_parameter"'); ?>

    <div class="card-body table-responsive<?php if (!empty($overflow)) echo " over-width" ?>">
        <div id="alert"></div>


        <div class="card" style="padding: 20px;margin-bottom: 30px;">
            <h6><b>Pengaturan Dasar</b></h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Mode Tampilan Video</label>
                        <?php echo form_hidden('keys[]', 'mode_video_umum'); ?>
                        <?php echo form_dropdown('vals[]', @$cb_mode, !empty($vals['mode_video_umum']) ? $vals['mode_video_umum'] : 1, 'class="form-control combo-box"') ?>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Lama Durasi Refresh Halaman</label>
                        <?php echo form_hidden('keys[]', 'refresh_time_1'); ?>
                        <div class="input-group">
                            <?php echo form_input('vals[]', !empty($vals['refresh_time_1']) ? $vals['refresh_time_1'] : null, '
                                 class="form-control inp_reload" placeHolder="Detik ... contoh : 1800" required') ?>
                            <span class="input-group-append"><span class="input-group-text">Detik</span></span>

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Dasar</label>
                        <?php echo form_hidden('keys[]', 'color_basic_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_basic_1']) ? $vals['color_basic_1'] : '#f8e5ff', '
								class="form-control color_basic_1" placeHolder=" ... contoh : #f8e5ff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="padding: 20px;margin-bottom: 30px;">
            <h6><b>Pengaturan Header</b></h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Header</label>
                        <?php echo form_hidden('keys[]', 'color_header_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_header_1']) ? $vals['color_header_1'] : '#500380', '
								class="form-control color_header_1" placeHolder=" ... contoh : #500380"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Teks Header</label>
                        <?php echo form_hidden('keys[]', 'color_text_header_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_header_1']) ? $vals['color_text_header_1'] : '#ffffff', '
								class="form-control color_text_header_1" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="padding: 20px;margin-bottom: 30px;">
            <h6><b>Pengaturan Footer</b></h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Footer</label>
                        <?php echo form_hidden('keys[]', 'color_footer_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_footer_1']) ? $vals['color_footer_1'] : '#000', '
								class="form-control color_footer_1" placeHolder=" ... contoh : #000000"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Waktu</label>
                        <?php echo form_hidden('keys[]', 'color_time_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_time_1']) ? $vals['color_time_1'] : '#f8c300', '
								class="form-control color_time_1" placeHolder=" ... contoh : #f8c300"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Tanggal</label>
                        <?php echo form_hidden('keys[]', 'color_date_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_date_1']) ? $vals['color_date_1'] : '#dc3545', '
								class="form-control color_date_1" placeHolder=" ... contoh : #dc3545"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Teks Footer</label>
                        <?php echo form_hidden('keys[]', 'color_text_footer_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_footer_1']) ? $vals['color_text_footer_1'] : '#ffffff', '
								class="form-control color_text_footer_1" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Teks Waktu</label>
                        <?php echo form_hidden('keys[]', 'color_text_time_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_time_1']) ? $vals['color_text_time_1'] : '#fff', '
								class="form-control color_text_time_1" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Teks Tanggal</label>
                        <?php echo form_hidden('keys[]', 'color_text_date_1'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_date_1']) ? $vals['color_text_date_1'] : '#fff', '
								class="form-control color_text_date_1" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="padding: 20px;margin-bottom: 20px;">
            <h6 style="margin-top: 20px;"><b>Pengaturan Foto Pegawai</b></h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Box</label>
                        <?php echo form_hidden('keys[]', 'color_foto_pegawai'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_foto_pegawai']) ? $vals['color_foto_pegawai'] : '#ffffff', '
								class="form-control color_foto_pegawai" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Tinggi Box</label>
                        <?php echo form_hidden('keys[]', 'height_foto_pegawai'); ?>
                        <div class="input-group">
                            <?php echo form_input('vals[]', !empty($vals['height_foto_pegawai']) ? $vals['height_foto_pegawai'] : 125, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                            <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Jumlah Slide</label>
                        <?php echo form_hidden('keys[]', 'slide_foto_pegawai'); ?>
                        <div class="input-group">
                            <?php echo form_input('vals[]', !empty($vals['slide_foto_pegawai']) ? $vals['slide_foto_pegawai'] : 6, '
                                         class="form-control " placeHolder="Contoh : 6" required') ?>
                            <span class="input-group-append"><span class="input-group-text"> Slide</span></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-5 card" style="padding: 20px;margin:10px;">
                <h6><b>Pengaturan Pengumuman</b></h6>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Judul</label>
                            <?php echo form_hidden('keys[]', 'color_pengumuman_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_pengumuman_1']) ? $vals['color_pengumuman_1'] : '#510045', '
								class="form-control color_pengumuman_1" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_pengumuman_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_pengumuman_1']) ? $vals['color_title_pengumuman_1'] : '#ffffff', '
								class="form-control color_title_pengumuman_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Box</label>
                            <?php echo form_hidden('keys[]', 'color_box_pengumuman_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_pengumuman_1']) ? $vals['color_box_pengumuman_1'] : '#ffffff', '
								class="form-control color_box_pengumuman_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_pengumuman_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_pengumuman_1']) ? $vals['color_text_pengumuman_1'] : '#000000', '
								class="form-control color_text_pengumuman_1" placeHolder=" ... contoh : #000000"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Tinggi Box</label>
                            <?php echo form_hidden('keys[]', 'height_pengumuman_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_pengumuman_1']) ? $vals['height_pengumuman_1'] : 220, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Ukuran Text Box</label>
                            <?php echo form_hidden('keys[]', 'font_pengumuman_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['font_pengumuman_1']) ? $vals['font_pengumuman_1'] : 14, '
                                         class="form-control " placeHolder="Pixel ... contoh : 12" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 card" style="padding: 20px;margin:10px;">
                <h6><b>Pengaturan Informasi</b></h6>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Judul</label>
                            <?php echo form_hidden('keys[]', 'color_informasi_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_informasi_1']) ? $vals['color_informasi_1'] : '#510045', '
								class="form-control color_informasi_1" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_informasi_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_informasi_1']) ? $vals['color_title_informasi_1'] : '#ffffff', '
								class="form-control color_title_informasi_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Box</label>
                            <?php echo form_hidden('keys[]', 'color_box_informasi_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_informasi_1']) ? $vals['color_box_informasi_1'] : '#ffffff', '
								class="form-control color_box_informasi_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_informasi_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_informasi_1']) ? $vals['color_text_informasi_1'] : '#000000', '
								class="form-control color_text_informasi_1" placeHolder=" ... contoh : #000000"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Tinggi Box</label>
                            <?php echo form_hidden('keys[]', 'height_informasi_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_informasi_1']) ? $vals['height_informasi_1'] : 270, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Ukuran Text Box</label>
                            <?php echo form_hidden('keys[]', 'font_informasi_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['font_informasi_1']) ? $vals['font_informasi_1'] : 14, '
                                         class="form-control " placeHolder="Pixel ... contoh : 12" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-5 card" style="padding: 20px;margin:10px;">
                <h6><b>Pengaturan Agenda Berlangsung</b></h6>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Judul</label>
                            <?php echo form_hidden('keys[]', 'color_berlangsung_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_berlangsung_1']) ? $vals['color_berlangsung_1'] : '#510045', '
								class="form-control color_berlangsung_1" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_berlangsung_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_berlangsung_1']) ? $vals['color_title_berlangsung_1'] : '#ffffff', '
								class="form-control color_title_berlangsung_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Box</label>
                            <?php echo form_hidden('keys[]', 'color_box_berlangsung_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_berlangsung_1']) ? $vals['color_box_berlangsung_1'] : '#ffffff', '
								class="form-control color_box_berlangsung_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_berlangsung_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_berlangsung_1']) ? $vals['color_text_berlangsung_1'] : '#000000', '
								class="form-control color_text_berlangsung_1" placeHolder=" ... contoh : #000000"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Tinggi Box</label>
                            <?php echo form_hidden('keys[]', 'height_berlangsung_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_berlangsung_1']) ? $vals['height_berlangsung_1'] : 215, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Ukuran Text Box</label>
                            <?php echo form_hidden('keys[]', 'font_berlangsung_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['font_berlangsung_1']) ? $vals['font_berlangsung_1'] : 14, '
                                         class="form-control " placeHolder="Pixel ... contoh : 12" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 card" style="padding: 20px;margin:10px;">
                <h6><b>Pengaturan Rencana Agenda</b></h6>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Judul</label>
                            <?php echo form_hidden('keys[]', 'color_rencana_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_rencana_1']) ? $vals['color_rencana_1'] : '#510045', '
								class="form-control color_rencana_1" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_rencana_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_rencana_1']) ? $vals['color_title_rencana_1'] : '#ffffff', '
								class="form-control color_title_rencana_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Box</label>
                            <?php echo form_hidden('keys[]', 'color_box_rencana_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_rencana_1']) ? $vals['color_box_rencana_1'] : '#ffffff', '
								class="form-control color_box_rencana_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_rencana_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_rencana_1']) ? $vals['color_text_rencana_1'] : '#000000', '
								class="form-control color_text_rencana_1" placeHolder=" ... contoh : #000000"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Tinggi Box</label>
                            <?php echo form_hidden('keys[]', 'height_rencana_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_rencana_1']) ? $vals['height_rencana_1'] : 215, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Ukuran Text Box</label>
                            <?php echo form_hidden('keys[]', 'font_rencana_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['font_rencana_1']) ? $vals['font_rencana_1'] : 14, '
                                         class="form-control " placeHolder="Pixel ... contoh : 12" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-5 card" style="padding: 20px;margin:10px;">
                <h6><b>Pengaturan Galeri Video</b></h6>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Judul</label>
                            <?php echo form_hidden('keys[]', 'color_video_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_video_1']) ? $vals['color_video_1'] : '#510045', '
								class="form-control color_video_1" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_video_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_video_1']) ? $vals['color_title_video_1'] : '#ffffff', '
								class="form-control color_title_video_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Box</label>
                            <?php echo form_hidden('keys[]', 'color_box_video_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_video_1']) ? $vals['color_box_video_1'] : '#ffffff', '
								class="form-control color_box_video_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_video_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_video_1']) ? $vals['color_text_video_1'] : '#000000', '
								class="form-control color_text_video_1" placeHolder=" ... contoh : #000000"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Tinggi Box</label>
                            <?php echo form_hidden('keys[]', 'height_video_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_video_1']) ? $vals['height_video_1'] : 220, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 card" style="padding: 20px;margin:10px;">
                <h6><b>Pengaturan Galeri Foto</b></h6>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Judul</label>
                            <?php echo form_hidden('keys[]', 'color_foto_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_foto_1']) ? $vals['color_foto_1'] : '#510045', '
								class="form-control color_foto_1" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_foto_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_foto_1']) ? $vals['color_title_foto_1'] : '#ffffff', '
								class="form-control color_title_foto_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Box</label>
                            <?php echo form_hidden('keys[]', 'color_box_foto_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_foto_1']) ? $vals['color_box_foto_1'] : '#ffffff', '
								class="form-control color_box_foto_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_foto_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_foto_1']) ? $vals['color_text_foto_1'] : '#000000', '
								class="form-control color_text_foto_1" placeHolder=" ... contoh : #000000"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Tinggi Box</label>
                            <?php echo form_hidden('keys[]', 'height_foto_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_foto_1']) ? $vals['height_foto_1'] : 212, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>




    </div>
    <div class=" card-footer">
        <span class="btn btn-success btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan Pengaturan</span>

    </div>
    <?php echo form_close(); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".colorize").colorpicker();
            // $(".colorize").colorpicker();
            $('.btn-simpan').click(function() {
                $('#form_parameter').submit();
            });

            $('#form_parameter').submit(function() {

                /*if (!$('.inp_menit').val()) {
                	$('#alert').addClass('alert alert-danger').html('Isian tidak boleh kosong!');
                	return false;	
                }*/
                if (!$('.inp_reload').val()) {

                    $('#alert').addClass('alert alert-danger').html('File tidak boleh kosong !');
                    return false;
                }

            });

        });
    </script>
</div>


<?php if (!empty($load_view)) $this->load->view($load_view); ?>
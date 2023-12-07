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
                    <a class="nav-link ' . $on . '" ' . (!empty($t['url']) ? ' href="' . $t['url'] . '"' : null) . ' style="padding:10px;">' . $t['text'] . '</a></li>';
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

    <?php echo form_open_multipart($this->dir . '/simpan_internal', 'role="form" id="form_parameter"'); ?>

    <div class="card-body table-responsive<?php if (!empty($overflow)) echo " over-width" ?>">
        <div id="alert"></div>

        <div class="card" style="padding: 20px;margin-bottom: 30px;">
            <h6><b>Pengaturan Dasar</b></h6>
            <hr>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Lama Durasi Refresh Halaman</label>
                        <?php echo form_hidden('keys[]', 'refresh_time_2'); ?>
                        <div class="input-group">
                            <?php echo form_input('vals[]', !empty($vals['refresh_time_2']) ? $vals['refresh_time_2'] : null, '
                                 class="form-control inp_reload" placeHolder="Detik ... contoh : 1800" required') ?>
                            <span class="input-group-append"><span class="input-group-text"><i class="fas fa-clock fa-btn"></i> Detik</span></span>

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Dasar</label>
                        <?php echo form_hidden('keys[]', 'color_basic_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_basic_2']) ? $vals['color_basic_2'] : '#f8e5ff', '
								class="form-control color_basic_2" placeHolder=" ... contoh : #f8e5ff"') ?>
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
                        <?php echo form_hidden('keys[]', 'color_header_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_header_2']) ? $vals['color_header_2'] : '#500380', '
								class="form-control color_header_2" placeHolder=" ... contoh : #500380"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Teks Header</label>
                        <?php echo form_hidden('keys[]', 'color_text_header_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_header_2']) ? $vals['color_text_header_2'] : '#ffffff', '
								class="form-control color_text_header_2" placeHolder=" ... contoh : #ffffff"') ?>
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
                        <?php echo form_hidden('keys[]', 'color_footer_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_footer_2']) ? $vals['color_footer_2'] : '#000', '
								class="form-control color_footer_2" placeHolder=" ... contoh : #000000"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Waktu</label>
                        <?php echo form_hidden('keys[]', 'color_time_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_time_2']) ? $vals['color_time_2'] : '#f8c300', '
								class="form-control color_time_2" placeHolder=" ... contoh : #f8c300"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Background Tanggal</label>
                        <?php echo form_hidden('keys[]', 'color_date_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_date_2']) ? $vals['color_date_2'] : '#dc3545', '
								class="form-control color_date_2" placeHolder=" ... contoh : #dc3545"') ?>
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
                        <?php echo form_hidden('keys[]', 'color_text_footer_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_footer_2']) ? $vals['color_text_footer_2'] : '#ffffff', '
								class="form-control color_text_footer_2" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Teks Waktu</label>
                        <?php echo form_hidden('keys[]', 'color_text_time_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_time_2']) ? $vals['color_text_time_2'] : '#fff', '
								class="form-control color_text_time_2" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="font-weight: normal;">Warna Teks Tanggal</label>
                        <?php echo form_hidden('keys[]', 'color_text_date_2'); ?>
                        <div class="input-group colorize">
                            <?php echo form_input('vals[]', !empty($vals['color_text_date_2']) ? $vals['color_text_date_2'] : '#fff', '
								class="form-control color_text_date_2" placeHolder=" ... contoh : #ffffff"') ?>
                            <span class="input-group-text">
                                <span class="input-group-addon"><i></i></span>
                            </span>
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
                            <?php echo form_hidden('keys[]', 'color_pengumuman_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_pengumuman_2']) ? $vals['color_pengumuman_2'] : '#510045', '
								class="form-control color_pengumuman_2" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_pengumuman_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_pengumuman_2']) ? $vals['color_title_pengumuman_2'] : '#ffffff', '
								class="form-control color_title_pengumuman_2" placeHolder=" ... contoh : #ffffff"') ?>
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
                            <?php echo form_hidden('keys[]', 'color_box_pengumuman_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_pengumuman_2']) ? $vals['color_box_pengumuman_2'] : '#ffffff', '
								class="form-control color_box_pengumuman_2" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_pengumuman_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_pengumuman_2']) ? $vals['color_text_pengumuman_2'] : '#000000', '
								class="form-control color_text_pengumuman_2" placeHolder=" ... contoh : #000000"') ?>
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
                            <?php echo form_hidden('keys[]', 'height_pengumuman_2'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_pengumuman_2']) ? $vals['height_pengumuman_2'] : 220, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Ukuran Text Box</label>
                            <?php echo form_hidden('keys[]', 'font_pengumuman_2'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['font_pengumuman_2']) ? $vals['font_pengumuman_2'] : null, '
                                         class="form-control " placeHolder="Pixel ... contoh : 14" required') ?>
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
                            <?php echo form_hidden('keys[]', 'color_informasi_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_informasi_2']) ? $vals['color_informasi_2'] : '#510045', '
								class="form-control color_informasi_2" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_informasi_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_informasi_2']) ? $vals['color_title_informasi_2'] : '#ffffff', '
								class="form-control color_title_informasi_2" placeHolder=" ... contoh : #ffffff"') ?>
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
                            <?php echo form_hidden('keys[]', 'color_box_informasi_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_informasi_2']) ? $vals['color_box_informasi_2'] : '#ffffff', '
								class="form-control color_box_informasi_2" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_informasi_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_informasi_2']) ? $vals['color_text_informasi_2'] : '#000000', '
								class="form-control color_text_informasi_2" placeHolder=" ... contoh : #000000"') ?>
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
                            <?php echo form_hidden('keys[]', 'height_informasi_2'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_informasi_2']) ? $vals['height_informasi_2'] : 260, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Ukuran Text Box</label>
                            <?php echo form_hidden('keys[]', 'font_informasi_2'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['font_informasi_2']) ? $vals['font_informasi_2'] : 14, '
                                         class="form-control " placeHolder="Pixel ... contoh : 14" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-5 card" style="padding: 20px;margin:10px;">
                <h6><b>Pengaturan Profil Pegawai</b></h6>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Background Judul</label>
                            <?php echo form_hidden('keys[]', 'color_profil_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_profil_1']) ? $vals['color_profil_1'] : '#510045', '
								class="form-control color_profil_1" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_profil_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_profil_1']) ? $vals['color_title_profil_1'] : '#ffffff', '
								class="form-control color_title_profil_1" placeHolder=" ... contoh : #ffffff"') ?>
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
                            <?php echo form_hidden('keys[]', 'color_box_profil_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_profil_1']) ? $vals['color_box_profil_1'] : '#ffffff', '
								class="form-control color_box_profil_1" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_profil_1'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_profil_1']) ? $vals['color_text_profil_1'] : '#000000', '
								class="form-control color_text_profil_1" placeHolder=" ... contoh : #000000"') ?>
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
                            <?php echo form_hidden('keys[]', 'height_profil_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_profil_1']) ? $vals['height_profil_1'] : 330, '
                                         class="form-control " placeHolder="Pixel ... contoh : 220" required') ?>
                                <span class="input-group-append"><span class="input-group-text"> Pixel</span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Ukuran Text Box</label>
                            <?php echo form_hidden('keys[]', 'font_profil_1'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['font_profil_1']) ? $vals['font_profil_1'] : 14, '
                                         class="form-control " placeHolder="Pixel ... contoh : 14" required') ?>
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
                            <?php echo form_hidden('keys[]', 'color_foto_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_foto_2']) ? $vals['color_foto_2'] : '#510045', '
								class="form-control color_foto_2" placeHolder=" ... contoh : #510045"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Judul</label>
                            <?php echo form_hidden('keys[]', 'color_title_foto_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_title_foto_2']) ? $vals['color_title_foto_2'] : '#ffffff', '
								class="form-control color_title_foto_2" placeHolder=" ... contoh : #ffffff"') ?>
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
                            <?php echo form_hidden('keys[]', 'color_box_foto_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_box_foto_2']) ? $vals['color_box_foto_2'] : '#ffffff', '
								class="form-control color_box_foto_2" placeHolder=" ... contoh : #ffffff"') ?>
                                <span class="input-group-text">
                                    <span class="input-group-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-weight: normal;">Warna Teks Box</label>
                            <?php echo form_hidden('keys[]', 'color_text_foto_2'); ?>
                            <div class="input-group colorize">
                                <?php echo form_input('vals[]', !empty($vals['color_text_foto_2']) ? $vals['color_text_foto_2'] : '#000000', '
								class="form-control color_text_foto_2" placeHolder=" ... contoh : #000000"') ?>
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
                            <?php echo form_hidden('keys[]', 'height_foto_2'); ?>
                            <div class="input-group">
                                <?php echo form_input('vals[]', !empty($vals['height_foto_2']) ? $vals['height_foto_2'] : 239, '
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
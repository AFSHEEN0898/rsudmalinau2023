<?php
echo @$css_load;
echo @$include_script;

$box_cls = !empty($tabs) ? 'nav-tabs-custom' : 'card';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.heading').parent().find('td').addClass('headings');
    });
    <?php echo  @$script ?>
</script>

<!-- <div class="<?php echo $box_cls ?>" id="box-main"> -->
<div class="card" id="box-main">
    <?php if (!empty($tabs)) { ?>
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <?php
            foreach ($tabs as $t) {
                if (!empty($t['on'])) {
                    $aktif = 'active';
                } else {
                    $aktif = '';
                }
                echo '<li class="nav-item" >
					<a' . (!empty($t['url']) ? ' class="nav-link ' . $aktif . '"  id="custom-tabs-two-home-tab" role="tab" aria-controls="custom-tabs-two-home" style="padding:10px" aria-selected="true" href="' . $t['url'] . '"' : null) . '>' . $t['text'] . '</a></li>';
            }
            ?>
        </ul>
    <?php } ?>

    <?php if (!empty($tombol) or !empty($extra_tombol)) { ?>
</div>
<div>
    <div class="card-header with-border ">
        <div class="row">
            <div class="col-md-7" style="margin-bottom: 10px"><?php echo @$tombol ?></div>
            <?php if (!empty($extra_tombol)) echo '<div class="col-md-5">' . $extra_tombol . '</div>'; ?>
        </div>
    </div><!-- /.box-header -->
<?php } ?>

<div class="tab-pane card-body table-responsive<?php if (!empty($overflow)) echo " over-width" ?>">
    <div id="alert"></div>

    <?php echo form_open($this->dir . '/simpan', 'role="form" id="form_parameter"'); ?>
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12">
                <!-- kolom kiri -->

                <div class="row">
                    <div class="col-md-5">
                        <label>Kode Pemerintah</label>
                        <p>
                            <?php echo
                            form_hidden('keys[]', 'pemerintah_s') .
                                form_input('vals[]', !empty($vals['pemerintah_s']) ? $vals['pemerintah_s'] : null, '
									class="form-control inp_menit" placeHolder="Fax..." required') ?>
                        </p>
                    </div>
                    <div class="col-md-7">
                        <label>Nama Pemerintah</label>
                        <p>
                            <?php echo
                            form_hidden('keys[]', 'pemerintah') .
                                form_input('vals[]', !empty($vals['pemerintah']) ? $vals['pemerintah'] : null, '
									class="form-control inp_menit" placeHolder="penjelasan..." required') ?>
                        </p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label>Kode Instansi</label>
                        <p>
                            <?php echo
                            form_hidden('keys[]', 'instansi_s') .
                                form_input('vals[]', !empty($vals['instansi_s']) ? $vals['instansi_s'] : null, '
									class="form-control inp_menit" placeHolder="Fax..." required') ?>
                        </p>
                    </div>
                    <div class="col-md-7">
                        <label>Nama Instansi</label>
                        <p>
                            <?php echo
                            form_hidden('keys[]', 'instansi') .
                                form_input('vals[]', !empty($vals['instansi']) ? $vals['instansi'] : null, '
									class="form-control inp_menit" placeHolder="penjelasan..." required') ?>
                        </p>
                    </div>

                </div>

                <label>Nama Instansi (Kode HTML)</label>
                <p>
                    <?php echo
                    form_hidden('keys[]', 'instansi_code') .
                        form_input('vals[]', !empty($vals['instansi_code']) ? $vals['instansi_code'] : null, '
									class="form-control inp_menit" placeHolder="Fax..." required') ?>
                </p>


                <div class="row">
                    <div class="col-md-5">
                        <label>Copyright</label>
                        <p>
                            <?php echo
                            form_hidden('keys[]', 'copyright') .
                                form_input('vals[]', !empty($vals['copyright']) ? $vals['copyright'] : null, '
									class="form-control inp_menit" placeHolder="Copyright" required') ?>
                        </p>
                    </div>

                </div>

                <!-- kolom kiri -->

            </div>

            <div class="col-lg-12 card-footer">
                <span class="btn btn-success btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan Pengaturan</span>

            </div>

        </div>
        <?php echo form_close(); ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            // $(".colorize").colorpicker();
            $('.btn-simpan').click(function() {
                $('#form_parameter').submit();
            });

            // $('#form_parameter').submit(function() {

            //     /*if (!$('.inp_menit').val()) {
            //     	$('#alert').addClass('alert alert-danger').html('Isian tidak boleh kosong!');
            //     	return false;	
            //     }*/


            // });

        });
    </script>
</div>
<?php if (!empty($links) or !empty($total) or !empty($box_footer)) { ?>

    <div class="card-footer">
        <div class="stat-info">
            <?php if (!empty($links)) { ?><div class="pull-left" style="margin-right: 10px"><?php echo $links ?></div><?php } ?>
            <?php if (!empty($total)) { ?><div class="pull-left">
                    <ul class="pagination">
                        <li class="page-item"><a>Total</a></li>
                        <li><a><strong><?php echo $total ?></strong></a></li>
                    </ul>
                </div><?php } ?>
        </div>
        <?php if (!empty($box_footer)) echo $box_footer; ?>
        <div class="clear"></div>
        <?php if (!empty($filter)) $this->load->view($filter); ?>

    </div>

<?php } ?>
</div>
<?php if (!empty($load_view)) $this->load->view($load_view); ?>
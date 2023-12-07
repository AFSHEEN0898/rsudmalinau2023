<div class="row">
    <div class="col-lg-6 col-6">

        <div class="small-box bg-info">
            <div class="inner">
                <h3>UMUM</h3>
                <p>Tema dengan Video</p>
            </div>
            <div class="icon">
                <i class="fa fa-tv"></i>
            </div>
            <a href="<?php echo base_url('siatika/display/tv_umum'); ?>" target="_blank" class="small-box-footer">Lihat TV <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-6 col-6">

        <div class="small-box bg-success">
            <div class="inner">
                <h3>INTERNAL</h3>
                <p>Tema dengan Audio</p>
            </div>
            <div class="icon">
                <i class="fa fa-tv"></i>
            </div>
            <a href="<?php echo base_url('siatika/display/tv_internal'); ?>" target="_blank" class="small-box-footer">Lihat TV <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-file-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Data Pegawai</span>
                <span class="info-box-number"><?php echo $t_pegawai; ?></span>
            </div>

        </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fa fa-info"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Informasi</span>
                <span class="info-box-number"><?php echo $t_informasi; ?></span>
            </div>

        </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-bullhorn"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pengumuman</span>
                <span class="info-box-number"><?php echo $t_pengumuman; ?></span>
            </div>

        </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-calendar-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Agenda</span>
                <span class="info-box-number"><?php echo $t_agenda; ?></span>
            </div>

        </div>

    </div>

</div>
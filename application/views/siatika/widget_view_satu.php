<script src="<?php echo base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js');?>" type="text/javascript"></script>
<link href="<?php echo base_url().'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css'?>" rel="stylesheet" type="text/css" />
<div id="alert"></div>
		<div class="box">
		    <div class="box-header with-border">
			    <div class="row">
			    	<div class="col-md-7" style="margin-bottom: 10px;font-weight:bold;">
			  			<?php echo $kembali;?>
						<!-- div class="btn-group" style="margin-left: 5px;">
							<div class="btn btn-primary dropdown-toggle btn-flat"><?php echo @$kolom?></div>
						</div -->
						<?php echo '<p class="pull-left" style="margin: 5px;">'.@$info_ids."(".@$kolom.")</p>";?>
					</div>				
			    </div>
		    </div>

			<div class="box-body">
					<div class="col-lg-12">
						
						<div class="col-lg-12 no-padding" style="border: 1px solid #ccc;height:<?php echo @$set_widget_1->tinggi;?>px;">
							<div class="box-header with-border">
								<div class="pull-left">
									<?php echo @$btn_tambah_1;?>
								</div>
								<div class="pull-right">
									<?php echo @$btn_setting_1;?>
								</div>
							</div>
							<div class="box-body">
								<?php
								if(@$dt_widget_1->num_rows() > 0){
									$no1 = 1; $jml = $dt_widget_1->num_rows();
									foreach ($dt_widget_1->result() as $satu) { ?>
										<div class="btn-group" style="width: 100%; margin: 2px;">
											<span class="btn btn-flat btn-default">
												<?php echo $satu->judul;?>
											</span>
											<button class="btn btn-default dropdown-toggle btn-flat" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="<?php echo site_url(@$this->dir.'/add_widget/'.@$code.'/'.@$satu->posisi.'/'.@$satu->id_konten);?>" class="btn-editc" act="">Edit</a></li>
												<li><a href="#" class="btn-delete" act="<?php echo site_url(@$dir.'/delete_widget/'.@$code.'/'.in_de(array('id_konten'=>@$satu->id_konten)));?>" msg="Apakah anda yakin ingin menghapus widget ini ?">Hapus</a></li>
											</ul>
											<?php
												if($satu->status==1){
													$bg = 'btn-success';
													$link = site_url(@$this->dir.'/aktiv_no/'.@$code.'/'.in_de(array('id_konten'=>$satu->id_konten, 'kd'=>'0')));
												}else{
													$bg = 'btn-default';
													$link = site_url(@$this->dir.'/aktiv_no/'.@$code.'/'.in_de(array('id_konten'=>$satu->id_konten, 'kd'=>'1')));
												}
											?>
											<a href="<?php echo $link?>" class="btn <?php echo $bg;?> btn-flat">
												<i class="fa fa-power-off"></i>
											</a>
											<?php
												if ($no1!=1) {
													$naik = site_url($this->dir.'/urutkan/'.@$code.'/'.in_de(array('id_konten'=>$satu->id_konten, 'urut'=>$satu->urut, 'kd'=>'up', 'id_ids'=>$satu->id_ids, 'pos'=>$satu->posisi)));
													?>
													<a href="<?php echo $naik;?>" class="btn btn-default btn-flat">
														<i class="fa fa-arrow-up"></i>
													</a>
											<?php	}
												if ($no1!=$jml){
													$trn = site_url($this->dir.'/urutkan/'.@$code.'/'.in_de(array('id_konten'=>$satu->id_konten, 'urut'=>$satu->urut, 'kd'=>'down', 'id_ids'=>$satu->id_ids, 'pos'=>$satu->posisi)));
													?>
													<a href="<?php echo $trn;?>" class="btn btn-default btn-flat">
														<i class="fa fa-arrow-down"></i>
													</a>
											<?php	}
											?>
										</div>
									<?php $no1+=1; }
								}
								?>
							</div>
						</div>
					</div>
				<div class="col-lg-12">
					<br>
					<div style="border: 1px solid #ccc;height:<?php echo @$set_widget_6->tinggi;?>px; margin-bottom:20px;">
					
						<div class="col-lg-12 no-padding">
							<div class="box-header with-border">
								<div class="pull-left">
									<?php echo @$btn_tambah_6;?>
								</div>
								<div class="pull-right">
									<?php echo @$btn_setting_6;?>
								</div>
							</div>
							<div class="box-body">
							<?php
									if(@$dt_widget_6->num_rows() > 0){
										$no6 = 1; $jml6 = $dt_widget_6->num_rows();
										foreach ($dt_widget_6->result() as $enam) { ?>
											<div class="btn-group" style="width: 100%; margin: 2px;">
												<span class="btn btn-flat btn-default">
													Teks Bergerak
												</span>
												<button class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li><a href="<?php echo site_url(@$this->dir.'/add_widget/'.@$code.'/'.@$enam->posisi.'/'.@$enam->id_konten);?>" class="btn-editx" act="">Edit</a></li>
													<li><a href="#" class="btn-delete" act="<?php echo site_url(@$dir.'/delete_widget/'.@$code.'/'.in_de(array('id_konten'=>@$enam->id_konten)));?>" msg="Apakah anda yakin ingin menghapus widget ini ?">Hapus</a></li>
												</ul>
												<?php
													if($enam->status==1){
														$bg = 'btn-success';
														$link = site_url(@$this->dir.'/aktiv_no/'.@$code.'/'.in_de(array('id_konten'=>$enam->id_konten, 'kd'=>'0')));
													}else{
														$bg = 'btn-default';
														$link = site_url(@$this->dir.'/aktiv_no/'.@$code.'/'.in_de(array('id_konten'=>$enam->id_konten, 'kd'=>'1')));
													}
												?>
												<a href="<?php echo $link?>" class="btn <?php echo $bg;?> btn-flat">
													<i class="fa fa-power-off"></i>
												</a>
												<?php
													if ($no6!=1) {
														$naik = site_url($this->dir.'/urutkan/'.@$code.'/'.in_de(array('id_konten'=>$enam->id_konten, 'urut'=>$enam->urut, 'kd'=>'up', 'id_ids'=>$enam->id_ids, 'pos'=>$enam->posisi)));
														?>
														<a href="<?php echo $naik;?>" class="btn btn-default btn-flat">
															<i class="fa fa-arrow-up"></i>
														</a>
												<?php	}
													if ($no6!=$jml6){
														$trn = site_url($this->dir.'/urutkan/'.@$code.'/'.in_de(array('id_konten'=>$enam->id_konten, 'urut'=>$enam->urut, 'kd'=>'down', 'id_ids'=>$enam->id_ids, 'pos'=>$enam->posisi)));
														?>
														<a href="<?php echo $trn;?>" class="btn btn-default btn-flat">
															<i class="fa fa-arrow-down"></i>
														</a>
												<?php	}
												?>
											</div>
										<?php $no6+=1; }
									}
									?>
							</div>
						</div>
					</div>
			
		</div>
<script type="text/javascript">
	
	$(document).ready(function() {

		$(".colorize").colorpicker();

		$('.btn-simpan').click(function() {
			$('#form_parameter').submit();
		});
		
		$('#form_parameter').submit(function() {
			
			if (!$('.inp_reload').val()) {
					
				$('#alert').addClass('alert alert-danger').html('Durasi Refresh tidak boleh kosong !');
				return false;	
			}
			
			
		});
		
	});
	
</script>
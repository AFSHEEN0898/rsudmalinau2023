<div id="<?php echo $target; ?>">


<?php 
	foreach($dtduk->result() as $row){
			   		
			   ?>		

              <div class="info-box">
                <div class="info-box-content" style="margin-left:0px;">
                	<div class="row">
	                	<div class="col-lg-9">
	                	<!--DIANMIC DATA -->
		                  <style>
		                  	.table-condensed td { padding: 1px 2px !important;}
		                  </style>
                		<table class="table table-striped table-condensed" style="text-align:left; font-size:11px;margin-bottom:0px; line-height: 11px;color:black">
	                    	<tbody>
		                      <tr>
		                      	<td style="width:2%;">1. </td><td  style="width:20%;">Nama</td><td style="width:2%;">:</td><td style="width:76%;"><b><?php echo $row->nama; ?></b></td>
		                      </tr>
		                      <tr>
		                      	<td style="width:2%;">2. </td><td  style="width:20%;">Nip<br></td><td style="width:2%;">: </td><td style="width:76%;"><?php echo @$row->nip ?></td>
		                      </tr>
		                      <tr>
		                      	<td style="width:2%;">3. </td><td  style="width:20%;">Jabatan<br>&nbsp;&nbsp;</td><td style="width:2%;">: </td><td style="width:76%;"><?php echo @$row->nama_jabatan ?></td>
		                      </tr>
		                      <tr>
		                      	<td style="width:2%;">4. </td><td  style="width:20%;">Tempat / Tgl Lahir</td><td style="width:2%;">:</td><td style="width:76%;"><?php echo $row->tempat_lahir.', '.tanggal_indo($row->tanggal_lahir)?>
		                      		<?php 
		                      		$tgl_skr = date('Y-m-d');
		                      		if ($row->tanggal_lahir == $tgl_skr) {
		                      			echo "<span class='blink_me' style='color:red;'> Selamat Ulang Tahun</span>";
		                      		}else{
		                      			echo "";
		                      		}
		                      		
		                      		?>
		                      	</td>
		                      </tr>
		                      <tr>
		                      	<td style="width:2%;">5. </td><td  style="width:20%;">Alamat<br>&nbsp;&nbsp;</td><td style="width:2%;text-align:top;">: </td><td style="width:76%;text-align:top;"><?php echo $row->lamat ?></td>
		                      </tr>
		                    </tbody>
		                  </table>

		                  <!-- ./DINAMIC DATA -->

		                </div>
		                <div class="col-lg-3">
		                	<?php if (!empty($row->photo )) {
		                        echo '<center>
		                			<div id="frame" style="width:100px;height:90px;overflow:hidden;margin-top:10px;box-shadow: 3px 3px 5px #ccc;" >
		                				<img src="'.base_url()."uploads/kepegawaian/pasfoto/".@$row->photo.'" style="width:100%;margin-top:-1px;" class="img-responsive"/>
		                			</div>
		                			</center>';
		                      }else{
		                        echo " Belum ada foto";
		                      }
		                      ?>
		                </div>
		            </div>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

			<?php } 
	          
			
echo $paging_sub;
?>
</div>
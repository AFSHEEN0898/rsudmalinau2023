<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<div class="box box-primary">
    <div class="box-header" style="border-bottom:1px solid #f4f4f4">
      <h3 class="box-title">Kategori</h3>
    </div>
	<div class="box-body">
		<table width="325">
			<tr valign='top'>
				<td><?php 
					$no = 1;
					if(($data_cat->num_rows()!=0)){
						foreach($data_cat->result() as $row_cat): 

						// --- begin periksa chekbox yang terpilih (metode serialize) ---
						if(isset($cat_chk)){
							in_array($row_cat->id_cat,$cat_chk)?$chk="checked":$chk=null;
						}else{
							$chk=null;
						}
						// --- end of periksa chekbox yang terpilih (metode serialize) ---
						$id_pertama = ($no == 1) ? 'id="check1"':null;
						
						?>

							<input type="checkbox" <?php echo $id_pertama; ?> class="on_check incheck" name="id_cat[]" value="<?php echo $row_cat->id_cat ?>" <?php echo $chk;?>> <?php echo $row_cat->category ?><br>
					<?php 
					$no += 1;
					endforeach;
					}else{ 
						echo "Belum ada kategori";
					}
					?>
				</td>
			</tr>
			<tr>
				<td><br>
					<a href="#" onclick="new_cat()" title="Tambah Kategori" class="btn btn-success btn-flat btn-sm">
						<i class="fa fa-btn fa-plus"></i> Tambah Kategori Baru
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
	<?php echo  @$out_script; ?>
	$(document).ready(function(){
		
		$('input[type="checkbox"].incheck, input[type="radio"].incheck').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass: 'iradio_minimal-blue'
			});
	});
</script>
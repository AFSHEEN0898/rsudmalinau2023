<script type="text/javascript">
	$(document).ready(function(){
	$('#box_delete').hide();

		$('.cek').click(function(){
			var ju = 0;
			$('.cek').each(function(){
				if($(this).is(':checked')) ju+=1;
			});
				
			if (ju > 0) {
				$('#box_delete').show();             
			}else{
				$('#box_delete').hide();
			}
		});
	});
</script>
<fieldset>
	<legend><?php echo $title?>
	<a href="#" act="<?php echo site_url('cms/categories/add_cat/'.$this->uri->segment(4))?>" id="button_plus"><button class="btn btn-primary"><i class="icon-plus-sign icon-white"></i></button></a>
	</legend>
	
	<div id='form_modal'></div>
	
	<p>
	<?php
		$msg = $this->session->flashdata('msg');
		if(!empty($msg)) notif($msg);
	?>
	</p>
	
	<?php echo form_open('cms/categories/delete_categories/'.$this->uri->segment(4),'id="form_delete"')?>
	<table class="table table-striped table-bordered table-condensed table-nonfluid" id="tbl_data">
		<tr>
			<th width='10' style='text-align:center'>No</th>
			<th width='200'>Kategori</th>
			<th width='200'>Slug</th>
			<th width='50' style='text-align:center'>Aksi</th>
			<th width='50' class='tengah'><input type='checkbox' name='cek_all' id='cek_all' onclick='checkAll("tbl_data","cek_all");showDeleteButton("cek","box_delete");'></th>
		</tr>
		<?php 
			if($data_tabel->num_rows()!=0){ 
			$no = 1;
			foreach($data_tabel->result() as $row):?>
			<tr>
				<td style='text-align:center'><?php echo $no ?></td>
				<td><?php echo $row->category ?></td>
				<td><?php echo $row->slug ?></td>
				<td style='text-align:center'>
					<a href="#" class="button_edit" act="<?php echo site_url('cms/categories/add_cat/'.$this->uri->segment(4)."/".$row->id_cat) ?>" ><i class="icon-pencil"></i></a>
					<?php if($row->id_cat != 0 AND $row->code != 15):?>
					<a class="button_delete" href="#" act="<?php echo site_url('cms/categories/delete_categories/'.$this->uri->segment(4)."/".$row->id_cat)?>" title="Apakah Anda ingin menghapus kategori <?php echo $row->category?>?"><i class="icon-trash"></i></a>
					<?php endif; ?>
				</td>
				<td class='tengah'><input type="checkbox" name="cek[]" class="cek" value="<?php echo $row->id_cat?>"></td>
			</tr>
		<?php 
			$no++;
			endforeach;}else{
		?>
		<tr>
			<td colspan='5'>Tidak ditemukan data</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan='5'><div id="itemtot">Total : <?php echo $total ; ?></div></td>
		</tr>
	</table>
	<?php echo form_close()?>
	
	<p><div id="box_delete">Aksi untuk yang dicentang : [<a href="#" onclick="confirmDelete()">Hapus</a>]</div></p>
	
	<div id="paginationfooter">
		<div id="itempag"><?php echo $links ; ?></div>
	</div>
</fieldset>
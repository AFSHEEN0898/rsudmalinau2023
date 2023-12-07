<script type="text/javascript">
	function cat_fill(e){
		$('#personel_cat').val(e);
	}
	
	<?php if (!empty($pilih)) echo "$('#personel_cat').val(".$pilih.");"; ?>
	<?php if (!empty($pilih)) echo "show_column(".$pilih.");"; ?>
</script>
<?php echo form_dropdown('kategori',$dt_cat,!empty($pilih)?$pilih:null,'onchange=cat_fill(this.value);show_column(this.value)')?> 
<a href="#" onclick="new_cat()" title="Tambah Kategori"><span class="btn btn-primary"><i class="icon-white icon-plus-sign"></i></span></a>
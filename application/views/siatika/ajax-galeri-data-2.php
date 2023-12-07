<?php
if ($foto_kanan->num_rows() > 0) {
	$i = 0;
	foreach ($foto_kanan->result() as $f) {
		$i++;
		$id_gal = 'gal_kiri';
		$jml_kar = strlen($f->judul); ?>
		<div id="<?php echo $id_gal; ?>">
			<?php
			if ($jml_kar > 20) { ?>
				<div class="foto-title" style="padding-bottom: 0px;">
					<marquee><?php echo $f->judul; ?></marquee>
				</div>
			<?php } else { ?>
				<div class="foto-title" style="padding-bottom: 4px; text-align: justify;"><?php echo $f->judul; ?></div>
			<?php } ?>

			<img src="<?php echo base_url() . 'uploads/siatika/galeri/foto/' . $f->foto; ?>" style="width:100%; height:185px;object-fit: cover;object-position: center;" />
			<?php if (!empty($f->keterangan))
				echo '<div class="foto-content">' . $f->keterangan . '</div>'; ?>
		</div>
<?php }
} else {
	echo '<div class="alert">Belum ada Foto ...</div>';
}

?>

<?php echo $this->ajax_pagination_gal2->create_links(); ?>
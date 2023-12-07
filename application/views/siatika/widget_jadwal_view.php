<?php

if (!empty($rencana_pelatihan)) {
	echo $rencana_pelatihan;
} else {
	echo '<div class="alert alert-warning alert-dismissible">Belum ada rencana agenda !</div>';
} ?>
<?php echo $this->ajax_pagination_pelatihan->create_links(); ?>

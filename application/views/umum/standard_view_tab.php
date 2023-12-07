<?php
echo @$css_load;
echo @$include_script;

?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.heading').parent().find('td').addClass('headings');
	});
	<?php echo  @$script ?>
</script>
<div class="card card-primary card-outline card-outline-tabs" id="box-main">
	<div class="card-header p-0 border-bottom-0">
		<ul class="nav nav-tabs" role="tablist">
			<?php
			foreach ($tabs as $t) {
				echo '<li class="nav-item" > 
                <a' . (!empty($t['url']) ? ' style="padding:10px" href="' . $t['url'] . '"' : null) . (!empty($t['on']) ? ' class="nav-link active" ' : ' class="nav-link" ') . ' >' . $t['text'] . '</a></li>';
			}
			?>
		</ul>
	</div>
	<div class="card-body">
		<div class="tab-content">
			<?php
			foreach ($tabs as $t) { ?>
				<div class="tab-pane fade <?php echo (!empty($t['on']) ? ' active show' : '') ?> " role="tabpanel">

					<?php echo $tabel ?>
				</div>
			<?php
			}
			?>

		</div>
	</div>
</div>
<?php
echo @$css_load;
echo @$include_script;
$box_cls = !empty($tabs) ? 'card card-primary card-outline card-outline-tabs' : 'card';
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.heading').parent().find('td').addClass('headings');
	});
	<?php echo  @$script ?>
</script>
<style>
	.blink_me {
		animation: blinker 1s linear infinite;
	}

	@keyframes blinker {
		50% {
			opacity: 0.0;
		}
	}
</style>
<!-- <div class="<?php echo $box_cls ?>" id="box-main"> -->
<!-- card card-primary card-outline card-outline-tabs -->
<div class="row">
	<div class="col-md-12">
		<div class="<?php echo $box_cls ?>" id="box-main">
			<?php if (!empty($tabs)) { ?>
				<div class="card-header p-0 border-bottom-0">
					<ul class="nav nav-tabs">
						<?php
						foreach ($tabs as $t) {
							echo '<li class="nav-item">
					<a style="padding:10px"' . (!empty($t['on']) ? ' class="nav-link active"' : 'class="nav-link"') . (!empty($t['url']) ? ' href="' . $t['url'] . '"' : null) . '>' . $t['text'] . '</a></li>';
						}
						?>
					</ul>
				<?php } ?>

				<?php if (!empty($tombol) or !empty($extra_tombol)) { ?>

					<div class="card-header">
						<div class="row">
							<div class="col-md-7" style="margin-bottom: 10px"><?php echo @$tombol ?></div>
							<?php if (!empty($extra_tombol)) echo '<div class="col-md-5">' . $extra_tombol . '</div>'; ?>
						</div>
					</div><!-- /.box-header -->
				<?php } ?>
				<?php if (!empty($tabs)) { ?>
				</div><?php } ?>
			<div class="card-body<?php if (!empty($overflow)) echo " over-width" ?>">

				<?php
				echo @$graph_area;
				echo '<div class="wmd-view-topscroll">
				    <div class="scroll-div">
				        &nbsp;
				    </div>
				</div>
				<div class="wmd-view">
				    <div class="dynamic-div">
				        ' . $tabel . '
				    </div>
				</div>';
				?>
			</div>
			<?php if (!empty($links) or !empty($total) or !empty($box_footer)) { ?>

				<div class="card-footer">
					<div class="stat-info">
						<?php if (!empty($links)) { ?><div class="float-left" style="margin-right: 10px"><?php echo $links ?></div><?php } ?>
						<?php if (!empty($total)) { ?><div class="float-left">
								<ul class="pagination pagination-sm m-0 float-right">
									<li class="page-item"><a class="page-link">Total</a></li>
									<li class="page-item"><a class="page-link"><strong><?php echo $total ?></strong></a></li>
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
	</div>
</div>
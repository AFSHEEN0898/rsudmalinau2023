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

<?php
/*echo $total_rows;*/
if ($total_rows >= 1) {
	$nox = 1;
	foreach ($detail_kegiatan_mi->result() as $row) { ?>
		<div class="informasi informasi-">
			<div class="blink_me badge" style="position:absolute;top:5px;right:10px"><?php echo $total_rows; ?></div>
			<div class="luar_mingni_kir" style="min-height:220px; margin-top:10px;text-align:justify;line-height:1.42857143;word-spacing:3px;">
				<div class="dalam-mingni_kir" style="padding:0px;">
					<table class="table table-condensed table-sm" style="color:#000;text-align:left; font-size:11px;width:100%;">
						<tbody>
							<tr>
								<td style=""> Agenda<br>&nbsp;&nbsp;</td>
								<td style="text-align:top;">: </td>
								<td style="text-align:top;"><?php echo $row->title; ?></td>
							</tr>
							<tr>
								<td style="">Tempat<br>&nbsp;&nbsp;</td>
								<td style="text-align:top;">: </td>
								<td style="text-align:top;"><?php echo $row->tempat; ?></td>
							</tr>
							<tr>
								<td style="">Keterangan</td>
								<td style="">: </td>
								<td style=""><?php echo !empty($row->content) ? $row->content : '-'; ?></td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>

		</div>
<?php $nox += 1;
	}
} else {
	echo '<div class="alert alert-warning alert-dismissible">Belum ada agenda berlangsung !</div>';
} ?>
<?php echo $this->ajax_pagination_berlangsung->create_links(); ?>

<script>
	$(document).ready(function() {
		$('.luar_mingni_kir').height($('.box-mingguini').height() - 140);
		$('.dalam-mingni_kir').each(function() {
			set_peng($(this));
		});

		function set_peng(from) {
			setTimeout(function() {
				setInterval(function() {
					if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
						var posnow = $(from).css('top');
						if (parseInt(posnow) > (-1) * parseInt($(from).css('height'))) {
							$(from).css('top', (parseInt(posnow) - 18) + 'px')
						} else {
							$(from).animate({
								'top': 10
							});
						}
					}
				}, 5000);
			}, 1500);
		}
	});

	$(document).ready(function() {
		$('.striper_mingni').width($('.box-mingguini'));
		$('.strip-mingni').each(function() {
			set_movex($(this));
		});

		function set_movex(from) {
			setInterval(function() {
				var posnow = $(from).css('left');
				if ((parseInt(posnow) - parseInt($(from).css('width')) + 150) > (-1) * parseInt($(from).css('width'))) {
					$(from).css('left', (parseInt(posnow) - 10) + 'px')
				} else {
					$(from).animate({
						'left': 30
					})
				}
			}, 800)
		}
	});
</script>
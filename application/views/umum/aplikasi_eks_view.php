<script type="text/JavaScript">
	$(document).ready(function() {
		
		$('#btn-simpan').click(function() {
			$('#form_akun').submit();
		});
		$(".btn-db").click(function() {
			$('.box-pos-wait').show(); $('.box-pos-teks').html(null);$('.box-footer').hide();
			$('#alert-wait').modal('show');
				dbloader($(this));
			return false;
		});
		
		$('.btn-close').click(function() {
			$('#alert-wait').modal('hide');
		});
		
		$('.load_list').each(function() {
			
			var u = $(this);
			var ide = u.attr('id')
			$.ajax({
			url: '<?php echo site_url('inti/aplikasi/load_setup') ?>/'+ide,
			dataType: 'json',
			success: function(msg) {
				u.children('td.logo').html(msg.ava);
				u.children('td.judul').html(msg.judul);
				u.children('td.deskripsi').html(msg.deskripsi);
				u.children('td.link-pasang').children().attr('href',msg.link_pasang);
			},error: function (data, status, e) {
                $('.box-pos-wait').hide();
				txt = (e == "SyntaxError: JSON.parse: unexpected character at line 1 column 1 of the JSON data") ? "Kesalahan <b>DB</b> Modul Aplikasi" : "Kesalahan tidak diketahui";
				$('.box-pos-teks').append('<h4 class="text-danger"><strong><i class="fa fa-ban fa-btn"></i> Kesalahan</strong></h4><p class="text-danger">'+txt+' <b>'+ide+'</b></p>');
				$('.box-footer').show();
				$('#alert-wait').modal('show');
			}
		});
		});
		
		$('.link-pasang').click(function() {
			var e = $(this).children().attr('href');
			$('#modal-setup-url').removeAttr('disabled').html('<i class="fa fa-life-ring fa-btn"></i> Memasang Aplikasi');
			$('.btn-setup-batal').removeAttr('disabled');
			$('.modal-setup-on').hide();
			$('.modal-setup-text').show();
			$('#modal-setup').modal('show');
			$('#modal-setup-url').attr('href',e);			
			return false;
		})
		
		$('#modal-setup-url').click(function() {
			$(this).attr('disabled','disabled').html('<i class="fa fa-spin fa-spinner fa-btn"></i> Proses Memasang ...');
			$('.modal-setup-text').hide();
			$('.modal-setup-on').show();
			$('.btn-setup-batal').attr('disabled','disabled');
		});
		
		$('.btn-delete-app').click(function() {
			
		});
	});
	
	function dbloader(e) {
		
		$.ajax({
			url: e.attr('href'),
			dataType: 'json',
			success: function(msg) {
				
				if (parseInt(msg.sign) == 1) {
					$('.box-pos-wait').hide(); 
					$('.box-pos-teks').append(msg.text);
					if (msg.total != msg.done && msg.kolom != msg.koldone) dbloader(e);
					$('.box-footer').show();
				} 
				
			},error: function (data, status, e) {
                $('.box-pos-wait').hide();
				txt = (e == "SyntaxError: JSON.parse: unexpected character at line 1 column 1 of the JSON data") ? "Kesalahan pada <b>DB</b> Modul Aplikasi" : "Kesalahan tidak diketahui";
				$('.box-pos-teks').append('<h4 class="text-danger"><strong><i class="fa fa-ban fa-btn"></i> Kesalahan</strong></h4><p class="text-danger">'+txt+'</p>');
				$('.box-footer').show();
			}
		});
		
	}
</script>

<div class="modal fade" id="modal-setup" tabindex="-1" role="dialog" aria-hidden="true" aria-modal="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title form-title">Konfirmasi Pemasangan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<span class="modal-setup-text">Apakah akan memasangkan aplikasi ini ... ?</span>
				<span class="modal-setup-on on-hide">
					<div class="pull-left">
						<i class="fa fa-spin fa-spinner" style="font-size: 3em; margin-right: 10px"></i>
					</div>
					<div class="pull-left">Proses pemasangan aplikasi, akan memakan waktu sedikit lama,<br>mohon tunggu ...</div>
					<div class="clear"></div>
				</span>
			</div>
			<div class="modal-footer justify-content-between ">
				<button class="btn btn-default btn-setup-batal pull-left" data-dismiss="modal" type="button">Batal</button>
				<a id="modal-setup-url" class="btn btn-info"><i class="fa fa-life-ring fa-btn"></i> Memasang Aplikasi</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="alert-wait" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pesan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="box-pos-wait">
					<h2 class="text-center"><i class="fas fa-sync-alt fas fa-spinner"></i></h2>
					<h4 class="text-center">Mohon Tunggu<br>Melaksanakan Proses ...</h4>
				</div>
				<div class="box-pos-teks"></div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
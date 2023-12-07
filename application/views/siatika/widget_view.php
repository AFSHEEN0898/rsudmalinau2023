<script type="text/javascript">
	$(document).ready(function(){

		$('.pesan').hide();
		contentloader("<?php echo site_url('sipinta/widget/show_widget/1')?>","#box_sidebar1");
		contentloader("<?php echo site_url('sipinta/widget/show_widget/2')?>","#box_sidebar2");
		contentloader("<?php echo site_url('sipinta/widget/show_widget/3')?>","#box_sidebar3");

	});
	
	
	function button_delete(va) {

		var act = ($(va).attr('act'));
		var title = ($(va).attr('title'));
    	bootbox.dialog(title, [{
			"label" 	: "Ya",
			"class" 	: "btn-danger",
			"icon"  	: "icon-trash icon-white",
			"callback"	: function() {
				window.location.replace(act);
			}
		}, {
			"label" 	: "Tidak",
			"class" 	: "btn-success",
			"icon"		: "icon-repeat icon-white",
		}],{
			backdrop	: false,
			show 		: true
		});
	
	}
</script>
<?php
	$opsi_widget 	= array(
						'1' => 'Galeri',
						'2' => 'Berita',
						'3' => 'Personel',
						'4' => 'Download',
						'5' => 'Kalender',
						'6' => 'Teks',
						'7' => 'Statistik',
						'8' => 'Tautan',
						'9' => 'Login Form',
						'10'=> 'Alamat',
						'11'=> 'Kategori',
						'12'=> 'Navigasi',
						'13' => 'Jurnal',
						'14' => 'FAQ',
						'15' => 'Profil',
						'16' => 'Press Release'
						
						);
?>
<fieldset>
	<legend>Manajemen Widget &nbsp;
	<a href="<?php echo site_url('sipinta/widget/add_widget')?>" class="btn btn-primary"><i class="icon-white icon-plus-sign"></i></a>
	</legend>
	<div>
		<?php
			$msg = $this->session->flashdata('msg');
			if(!empty($msg)) notif($msg);
		?>
		<p><span class="pesan"></span></p>
		<span id="box_sidebar1"></span>
		<span id="box_sidebar2"></span>
		<span id="box_sidebar3"></span>
	</div>
</fieldset>
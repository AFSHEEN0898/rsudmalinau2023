<?php
$a = $this->uri->segment(1);
$b = $this->uri->segment(2);
$c = $this->uri->segment(3);
$d = $this->uri->segment(4);
$s = $this->session->userdata('login_state');
$st = get_stationer();
?>


<?php if ($this->config->config['root'] == 1) { ?>
	
	<?php
	$cls_dasar = ($c == "parameter") ? 'class="nav-link active"' : 'class="nav-link"';
	$cls_aplikasi =  ($b == "Aplikasi") ? 'class="nav-link active"' : 'class="nav-link"';
	$cls_kewenangan =  ($b == "Kewenangan") ? 'class="nav-link active"' : 'class="nav-link"';
	$cls_operator = ($b == "Operator") ? 'class="nav-link active"' : 'class="nav-link"';
	$cls_impor = ($b == "impor") ? 'class="nav-link active"' : 'class="nav-link"';
	?>

	<li class="nav-item">
		<a href="<?php echo site_url('inti/Pengaturan/parameter') ?>" <?php echo $cls_dasar ?>>
			<i class="nav-icon fas fa-cube"></i>
			<p>
				Dasar
			</p>
		</a>
	</li>
	<li class="nav-item">
		<a href="<?php echo site_url('inti/Aplikasi/load_list') ?>" <?php echo $cls_aplikasi ?>>
			<i class="nav-icon fas fa-plug"></i>
			<p>
				Aplikasi
			</p>
		</a>
	</li>
	<li class="nav-item">
		<a href="<?php echo site_url('inti/Kewenangan') ?>" <?php echo $cls_kewenangan ?>>
			<i class="nav-icon fas fa-lock"></i>
			<p>
				Kewenangan
			</p>
		</a>
	</li>
	<li class="nav-item">
		<a href="<?php echo site_url('inti/Operator') ?>" <?php echo $cls_operator ?>>
			<i class="nav-icon fas fa-users"></i>
			<p>
				Operator
			</p>
		</a>
	</li>
	<?php
	$menuact =  ($b == "Navi") ? 'menu-open' : '';
	$linkact =  ($b == "Navi") ? 'class="nav-link active"' : 'class="nav-link"';
	?>
	<li class="nav-item has-treeview <?php echo $menuact?>">
		<a href="#" <?php echo $linkact?>>
			<i class="nav-icon fas fa-cogs"></i>
			<p>
				Modul
				<i class="fas fa-angle-left right"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<?php
			$mod =  ($b == "Navi" and $d == in_de(array('ref' => 1))) ? 'class="nav-link active"' : 'class="nav-link"';
			$ref =  ($b == "Navi" and $d == in_de(array('ref' => 2))) ? 'class="nav-link active"' : 'class="nav-link"';
			?>
			<li class="nav-item">
				<a href="<?php echo site_url('inti/Navi/show_navi/' . in_de(array('ref' => 1))) ?>" <?php echo $mod ?>>
					<i class="far fa-circle nav-icon"></i>
					<p>Modul</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?php echo site_url('inti/Navi/show_navi/' . in_de(array('ref' => 2))) ?>" <?php echo $ref ?>>
					<i class="far fa-circle nav-icon"></i>
					<p>Referensi</p>
				</a>
			</li>
		</ul>
	</li>
<?php } ?> 


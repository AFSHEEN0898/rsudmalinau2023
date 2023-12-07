<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller
{
	var $dir = 'siatika/articles';
	var $bulan = array(
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember'
	);

	function __construct()
	{
		parent::__construct();
		$this->load->helper('cmd', 'cms_helper');
		if (not_login(uri_string())) redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
		$this->id_petugas = $id_pegawai;
		if ($this->cr('spk1')) {
			/*Administrator Sapras*/
			$this->where = array();
		} elseif ($this->cr('spk2')) {
			/*Verifikator Data Sekolah*/
			$this->where = array();
		} else {
			$this->where = array();
		}
	}

	function cr($e)
	{
		return $this->general_model->check_role($this->id_petugas, $e);
	}

	public function index()
	{
		$this->list_data();
	}

	public function list_data($sec, $status = 1, $offset = null, $id = null, $search = null)
	{
		$id_operator = $this->session->userdata('id_pegawai');

		if (@$_POST['key'] != '') {
			$key = $_POST['key'];
			$this->session->set_userdata('kunci', $key);
		} else {
			if ($offset != '') $key = $this->session->userdata('kunci');
			else $this->session->unset_userdata('kunci');
			$key = '';
		}
		$tipe = array(
			'1' => 'Informasi',
			'2' => 'Berita',
			'4' => 'Pengumuman',
			'3' => 'Agenda'
		);
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');

		if (!empty($search_key)) {
			$fcari = array(
				'title' 		=> $search_key,
				'content' 		=> $search_key,
			);
			$data['for_search'] = $fcari['title'];
			$data['for_search'] = $fcari['content'];
		} else if ($search) {
			$fcari = $search;
			$data['for_search'] = $fcari['title'];
			$data['for_search'] = $fcari['content'];
		}

		$from = array(
			'sitika_articles tj' => '',
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);
		$select = 'tj.*,te.nama_kategori';
		// cek($this->general_model->check_role($this->session->userdata('id_pegawai'), "operator_sitika"));
		// if ($this->general_model->check_role($this->session->userdata('id_pegawai'), "operator_sitika")) {
		if ($status != 2) {
			$where = array('tj.status !=' => 2, 'tj.code' => $sec);
		} else {
			$where = array('tj.status' => 2, 'tj.code' => $sec);
		}
		$where1 = array('tj.status !=' => 2, 'tj.code' => $sec);
		$where2 = array('tj.status' => 2, 'tj.code' => $sec);
		// } else {
		// 	if ($status != 2) {
		// 		$where = array('tj.status !=' => 2, 'tj.code' => $sec, 'tj.id_operator' => $id_operator);
		// 	} else {
		// 		$where = array('tj.status ' => 2, 'tj.code' => $sec, 'tj.id_operator' => $id_operator);
		// 	}
		// 	$where1 = array('tj.status !=' => 2, 'tj.code' => $sec, 'tj.id_operator' => $id_operator);
		// 	$where2 = array('tj.status' => 2, 'tj.code' => $sec, 'tj.id_operator' => $id_operator);
		// }
		$config['base_url']	= site_url($this->dir . '/list_data/' . $sec . '/' . $status);
		$config['total_rows'] = $this->general_model->datagrabs(array('tabel' => $from, 'order' => 'tj.id_article DESC', 'select' => $select, 'search' => $fcari, 'where' => $where))->num_rows();
		$total = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'tj.id_article DESC', 'select' => $select, 'search' => $fcari, 'where' => $where1))->num_rows();
		$total_sampah = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'tj.id_article DESC', 'select' => $select, 'search' => $fcari, 'where' => $where2))->num_rows();
		$data['total']	= $config['total_rows'];
		$config['per_page']		= '10';
		$config['uri_segment']	= '6';
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$st = get_stationer();
		$data_article = $this->general_model->datagrabs(array('tabel' => $from, 'order' => 'tj.date_start DESC', 'select' => $select, 'where' => $where, 'limit' => $lim, 'offset' => $offs, 'search' => $fcari));
		//cek($this->db->last_query());
		if ($data_article->num_rows() > 0) {
			$this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed table-nonfluid" id="tbl_data">', 'table_close' => '</table'));
			if ($sec == '3') {
				if (in_array($offset, array('cetak', 'excel'))) {
					$this->table->set_heading(
						array('data' => 'No', 'style' => 'text-align:center'),
						array('data' => 'Kategori'),
						array('data' => 'Judul'),
						array('data' => 'Tempat'),
						array('data' => 'Tanggal Mulai'),
						array('data' => 'Tanggal Selesai'),
						array('data' => 'Kontak Person')
					);
				} else {
					$this->table->set_heading(
						array('data' => 'No', 'style' => 'text-align:center'),
						array('data' => 'Status', 'style' => 'text-align:center'),
						array('data' => 'Kategori'),
						array('data' => 'Judul'),
						array('data' => 'Tempat'),
						array('data' => 'Tanggal Mulai'),
						array('data' => 'Tanggal Selesai'),
						array('data' => 'Kontak Person'),
						array('data' => 'Aksi', 'style' => 'text-align:center', 'colspan' => 2)
					);
				}
			} else {
				if (in_array($offset, array('cetak', 'excel'))) {
					$this->table->set_heading(
						array('data' => 'No', 'width' => '20', 'style' => 'text-align:center'),
						array('data' => 'Kategori'),
						array('data' => 'Judul'),
						array('data' => 'Konten'),
						array('data' => 'Tanggal/Waktu')
					);
				} else {
					$this->table->set_heading(
						array('data' => 'No', 'width' => '20', 'style' => 'text-align:center'),
						array('data' => 'Status', 'width' => '20', 'style' => 'text-align:center'),
						array('data' => 'Kategori'),
						array('data' => 'Judul'),
						array('data' => 'Konten'),
						array('data' => 'Tanggal'),
						array('data' => 'Aksi', 'width' => '70', 'style' => 'text-align:center', 'colspan' => 2)
					);
				}
			}
			$bln = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
			$no = 1 + $offset;
			foreach ($data_article->result() as $row) {
				$arrcat = @unserialize($row->id_cat);


				$kategori = array();
				if (is_array($arrcat)) {
					foreach ($arrcat as $cat) {
						$ktg = $this->general_model->datagrab(array('tabel' => 'sitika_categories', 'where' => array('id_cat' => $cat)))->row();
						$kat = @$ktg->category;
						$kategori[] = $kat;
					}
					$cat = @implode(', ', $kategori);
				} else {
					$cat = '';
				}

				if ($sec == '3') {
					// if ($row->id_operator == $id_operator  || $id_operator == 1) {

					if ($row->status == 2) {
						$statusx = 'Draft';
						$res_edit = '<a href="' . site_url($this->dir . '/restore_data/' . $sec . '/' . $row->id_article . '/' . $status) . '"  msg="Apakah Anda yakin ingin me-<i>restore</i> artikel ini?" act="" title="Restore" class="btn btn-xs btn-flat btn-primary"><i class="fa fa-redo"></i></a>';
						$res_del = ' <a class="btn btn-xs btn-flat btn-danger btn-delete" href="#" act="' . site_url($this->dir . '/delete_data/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Hapus ' . $tipe[$sec] . ' - ' . $row->title . '" msg="Apakah anda yakin ingin menghapus data ini ?"><i class="fa fa-power-off"></i></a>';
					} elseif ($row->status == 1) {
						$statusx = anchor(site_url($this->dir . '/tidak_aktif/' . $sec . '/' . $row->id_article . '/' . $status), '<i class="fa fa-power-off">&nbsp;&nbsp;Tampil</i>', 'class="btn btn-xs btn-success"');
						$res_edit = anchor('#', '<i class="fa fa-pen"></i>', 'class="btn btn-xs btn-flat btn-warning btn-edit" act="' . site_url($this->dir . '/add_data/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Klik untuk edit data"');
						$res_del = ' <a class="btn btn-xs btn-flat btn-danger btn-delete" href="#" act="' . site_url($this->dir . '/delete_article/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Buang ' . $tipe[$sec] . ' - ' . $row->title . '" msg="Apakah anda yakin ingin membuang data ini ?"><i class="fa fa-trash"></i></a>';
					} else {
						$statusx = anchor(site_url($this->dir . '/aktif/' . $sec . '/' . $row->id_article . '/' . $status), '<i class="fa fa-power-off">&nbsp;&nbsp;Tidak Tampil</i>', 'class="btn btn-xs btn-default"');
						$res_edit = anchor('#', '<i class="fa fa-pen"></i>', 'class="btn btn-xs btn-flat btn-warning btn-edit" act="' . site_url($this->dir . '/add_data/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Klik untuk edit data"');
						$res_del = ' <a class="btn btn-xs btn-flat btn-danger btn-delete" href="#" act="' . site_url($this->dir . '/delete_article/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Buang ' . $tipe[$sec] . ' - ' . $row->title . '" msg="Apakah anda yakin ingin membuang data ini ?"><i class="fa fa-trash"></i></a>';
					}
					$cont = $this->truncate(strip_tags($row->content), 200);
					if (in_array($offset, array('cetak', 'excel'))) {
						$this->table->add_row(
							$no++,
							$row->nama_kategori,
							$row->title,
							$row->tempat,
							tanggal($row->date_start) . ' ' . date('H:i:s', strtotime(@$row->date_start)),
							tanggal($row->date_end) . ' ' . date('H:i:s', strtotime(@$row->date_end)),
							$row->kontak
						);
					} else {
						$this->table->add_row(
							$no++,
							$statusx,
							$row->nama_kategori,
							$row->title,
							$row->tempat,
							tanggal($row->date_start) . ' ' . date('H:i:s', strtotime(@$row->date_start)),
							tanggal($row->date_end) . ' ' . date('H:i:s', strtotime(@$row->date_end)),
							$row->kontak,
							array(
								'style' => 'text-align:center',
								'data'	=> $res_edit
							),
							array(
								'style' => 'text-align:center',
								'data'	=> $res_del
							)
						);
					}
					// }
				} else {
					// if ($row->id_operator == $id_operator  || $id_operator == 1) {
					if ($row->status == 2) {
						$statusx = 'Draft';
						$res_edit = '<a href="' . site_url($this->dir . '/restore_data/' . $sec . '/' . $row->id_article . '/' . $status) . '"  msg="Apakah Anda yakin ingin me-<i>restore</i> artikel ini?" act="" title="Restore" class="btn btn-xs btn-flat btn-primary"><i class="fa fa-redo"></i></a>';
						$res_del = ' <a class="btn btn-xs btn-flat btn-danger btn-delete" href="#" act="' . site_url($this->dir . '/delete_data/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Hapus ' . $tipe[$sec] . ' - ' . $row->title . '" msg="Apakah anda yakin ingin menghapus data ini ?"><i class="fa fa-power-off"></i></a>';
					} elseif ($row->status == 1) {
						$statusx = anchor(site_url($this->dir . '/tidak_aktif/' . $sec . '/' . $row->id_article . '/' . $status), '<i class="fa fa-power-off">&nbsp;&nbsp;Tampil</i>', 'class="btn btn-xs btn-success"');
						$res_edit = anchor('#', '<i class="fa fa-pen"></i>', 'class="btn btn-xs btn-flat btn-warning btn-edit" act="' . site_url($this->dir . '/add_data/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Klik untuk edit data"');
						$res_del = ' <a class="btn btn-xs btn-flat btn-danger btn-delete" href="#" act="' . site_url($this->dir . '/delete_article/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Buang ' . $tipe[$sec] . ' - ' . $row->title . '" msg="Apakah anda yakin ingin membuang data ini ?"><i class="fa fa-trash"></i></a>';
					} else {
						$res_edit = anchor('#', '<i class="fa fa-pen"></i>', 'class="btn btn-xs btn-flat btn-warning btn-edit" act="' . site_url($this->dir . '/add_data/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Klik untuk edit data"');
						$statusx = anchor(site_url($this->dir . '/aktif/' . $sec . '/' . $row->id_article . '/' . $status), '<i class="fa fa-power-off">&nbsp;&nbsp;Tidak Tampil</i>', 'class="btn btn-xs btn-default"');
						$res_del = ' <a class="btn btn-xs btn-flat btn-danger btn-delete" href="#" act="' . site_url($this->dir . '/delete_article/' . $sec . '/' . $row->id_article . '/' . $status) . '" title="Buang ' . $tipe[$sec] . ' - ' . $row->title . '" msg="Apakah anda yakin ingin membuang data ini ?"><i class="fa fa-trash"></i></a>';
					}

					$cont = $this->truncate(strip_tags($row->content), 200);
					if (in_array($offset, array('cetak', 'excel'))) {
						$this->table->add_row(
							array('style' => 'text-align:center', 'data' => $no),
							$row->nama_kategori,
							$row->title,
							$cont,
							tanggal($row->date_start) . ' ' . date('H:i:s', strtotime(@$row->date_start))
						);
					} else {
						$this->table->add_row(
							array('style' => 'text-align:center', 'data' => $no),
							$statusx,
							$row->nama_kategori,
							$row->title,
							$cont,
							tanggal($row->date_start) . ' ' . date('H:i:s', strtotime(@$row->date_start)),
							array(
								'style' => 'text-align:center',
								'data'	=> $res_edit
							),
							array(
								'style' => 'text-align:center',
								'data'	=> $res_del
							)
						);
						// }
					}
					$no++;
				}
			}
			$tabel = $this->table->generate();
		} else {
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}

		$btn_tambah = anchor('', '<i class="fa fa-plus-square fa-btn"></i> &nbsp; Tambah Data', 'class="btn btn-success  btn-edit" act="' . site_url($this->dir . '/add_data/' . $sec) . '"	title="Klik untuk tambah data"');
		if (($data_article->num_rows() > 0) && ($status == 1 || $status == null)) {
			$btn_cetak =
				'<div class="btn-group" style="margin-left: 5px;">
				<a class="btn btn-warning dropdown-toggle " data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
				<i class="fa fa-print"></i> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu pull-right">
				<li class="dropdown-item">' . anchor($this->dir . '/list_data/' . @$sec . '/' . @$status . '/cetak/' . @$id . '/' . in_de($search_key) . '', '<i class="fa fa-print"></i> Cetak', 'target="_blank"') . '</li>
				<li class="dropdown-item">' . anchor($this->dir . '/list_data/' . @$sec . '/' . @$status . '/excel/' . @$id . '/' . in_de($search_key) . '', '<i class="fa fa-file-excel"></i> Excel', 'target="_blank"') . '</li>
				</ul>
				</div>';
		}
		$data['extra_tombol'] =
			form_open($this->dir . '/list_data/' . $sec, 'id="form_search" role="form"') .
			'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="' . @$search_key . '">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>' .
			form_close();
		$data['tombol'] = $btn_tambah . ' ' . @$btn_cetak;
		$title = 'Data ' . @$tipe[$sec] . '';
		if ($offset == "cetak") {
			$data['title'] = '<h3>' . $title . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print', $data);
		} else if ($offset == "excel") {
			$data['file_name'] = $title . '.xls';
			$data['title'] = '<h3>' . $data['title'] . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel', $data);
		} else {
			$data['title'] 		= $title;
			$data['tabel'] = $tabel;
			if ($status == 1) {
				$tab1 = array('text' => '<i class="fa fa-fw fa-laptop"></i> Utama (' . $total . ')', 'on' => 1);
				$tab2 = array('text' => '<i class="fa fa-trash"></i> Sampah (' . $total_sampah . ')', 'on' => null, 'url' => site_url($this->dir . '/list_data/' . $sec . '/2'), 'style' => 'background:red;');
			} else {
				$tab1 = array('text' => '<i class="fa fa-fw fa-laptop"></i> Utama (' . $total . ')', 'on' => null, 'url' => site_url($this->dir . '/list_data/' . $sec . '/1'), 'style' => 'background:green;');
				$tab2 = array('text' => '<i class="fa fa-trash"></i> Sampah (' . $total_sampah . ')', 'on' => 1);
			}

			$data['title'] 		= $title;
			$data['tabs'] = array($tab1, $tab2);
			$data['content'] = 'umum/standard_view';
			$this->load->view('home', $data);
		}
	}


	function aktif($sec, $id = null, $status)
	{
		$data = array('status'	=> '1');
		$this->general_model->save_data('sitika_articles', $data, 'id_article', $id);
		$this->session->set_flashdata('ok', 'Informasi Berhasil diaktifkan');
		redirect($this->dir . '/list_data/' . $sec . '/' . $status);
	}


	function tidak_aktif($sec, $id = null, $status)
	{
		$data = array('status'	=> '3');
		$this->general_model->save_data('sitika_articles', $data, 'id_article', $id);
		$this->session->set_flashdata('fail', 'Informasi Berhasil dinonaktifkan');
		redirect($this->dir . '/list_data/' . $sec . '/' . $status);
	}
	function get_status_article($sec, $status)
	{
		/*$query = $this->universal_model->data_list('sitika_articles',null,null,array('code' => $sec, 'status' => $status));*/
		$query = $this->general_model->datagrab(array('tabel' => 'sitika_articles', 'where' => array('code' => $sec, 'status' => $status)));

		return $query->num_rows();
	}

	function get_permalink($code = NULL, $data = NULL)
	{
		die(json_encode(array('hasil' => permalink(@$code, @$data))));
	}

	public function add_data($sec = NULL, $id = NULL, $id_upload = null)
	{
		/*cek($sec);
		cek($id);
		cek($id_upload);*/
		$tipe = array(
			'1' => 'Informasi',
			'2' => 'Berita',
			'3' => 'Agenda',
			'4' => 'Pengumuman'
		);
		$data['default']	= $this->general_model->datagrab(array('tabel' => 'sitika_articles', 'where' => array('id_article' => $id)));
		$data['sec']		= $sec;
		$judul 				= !empty($id) ? "Ubah" : "Tambah " . $tipe[$sec] . " Baru";
		$data['title'] 		= $judul;
		$data['id']			= $id;

		$data['combo_kategori'] = $this->general_model->combo_box(array('tabel' => 'ref_kategori', 'key' => 'id_kategori', 'val' => array('nama_kategori')));



		$this->load->view('siatika/articles_form', $data);
	}

	// function refresh_cat($sec=null,$id=null){
	// 	if(!empty($id)){
	// 		$cat 	= $this->general_model->datagrab(array('tabel' => 'sitika_articles', 'where'=>array('code'=>$sec,'id_article'=>$id)))->row();
	// 		$arrcat = @unserialize(@$cat->id_cat);
	// 	}else{
	// 		$arrcat	= null;
	// 	}

	// 	$data['data_cat'] = $this->general_model->datagrab(array('tabel' => 'sitika_categories', 'where'=>array('code'=>$sec)));
	// 	$data['cat_chk'] = $arrcat;

	// 	$this->load->view('siatika/category_list', $data);
	// }

	// function combo_category($sec, $selected = null){
	// 	$cat = $this->category_model->list_data($sec);

	// 	$combo_cat = array();
	// 	$combo_cat[''] = '';
	// 	foreach($cat->result() as $row){
	// 		$combo_cat[$row->id_cat] = $row->category;
	// 	}
	// 	$data['selected'] 	= $selected;
	// 	$data['combo_cat'] 	= $combo_cat;
	// 	$this->load->view('siatika/category_combo_view',$data);
	// }


	function save_article()
	{
		// print_r($_POST);die();
		$kik = $this->input->post('kik');
		$id_artikel = $this->input->post('id_art');
		$id_foto = $this->input->post('id_art', TRUE);
		$foto_prev = $this->input->post('foto_prev', TRUE);
		$foto = @$_FILES['foto']['tmp_name'];

		$id_upload	= $this->input->post('id_upload');
		$id_cat 	= @serialize($this->input->post('id_cat'));
		$sec		= $this->input->post('sec');
		$date_start = $this->input->post('date_start');
		$date_end 	= $this->input->post('date_end');
		$jeda 		= $this->input->post('jeda');
		$title 		= $this->input->post('title');
		$content	= $this->input->post('content');
		$target		= $this->input->post('target');
		$permalink 	= $this->input->post('permalink');
		$tempat 	= $this->input->post('tempat');
		$kontak 	= $this->input->post('kontak');
		$id_kategori 	= $this->input->post('id_kategori');
		$base_url 	= base_url();
		$content    = str_replace('../../../', $base_url, $content); // pada saat simpan data
		$content    = str_replace('../', '', $content); // ini hanya terjadi jika edit data
		$content    = stripcslashes($content);
		/*cek($id_artikel);
    	die();*/
		if (!empty($date_start)) $date_post = $date_start;
		else $date_post = date('Y-m-d h:i:s');
		//$date_ki = $date_start.' '.$kik;
		/*cek(date('Y-m-d H:m:s', strtotime($date_ki)));
		die();*/
		if (empty($target)) {
			$data = array(
				'id_cat'	=> $id_cat,
				/*'date_start'=> date('Y-d-m H:i:s', strtotime($date_ki)),*/
				'date_start' => $date_post,
				// 'date_end'	=> $date_end,
				'jeda'		=> $jeda,
				'code'		=> $sec,
				'title'		=> $title,
				'content'	=> $content,
				'status'	=> '1',
				'permalink' => $permalink,
				'tempat' => $tempat,
				'kontak' => $kontak,
				'id_kategori' => $id_kategori,
				'id_operator' => $this->session->userdata('id_pegawai')
			);
		} else {
			$data = array(
				'id_cat'	=> $id_cat,
				'date_start' => $date_post,
				// 'date_end'	=> $date_end,
				'jeda'		=> $jeda,
				'code'		=> $sec,
				'title'		=> $title,
				'content'	=> $content,
				'extend'	=> $target,
				'status'	=> '1',
				'permalink' => $permalink,
				'tempat' => $tempat,
				'kontak' => $kontak,
				'id_kategori' => $id_kategori,
				'id_operator' => $this->session->userdata('id_pegawai')
			);
		}
		// cek($date_end);
		// die();
		if ($date_end != '0000-00-00 00:00:00') {
			$data['date_end'] = $date_end;
		}
		$this->general_model->save_data('sitika_articles', $data, 'id_article', $id_artikel);
		/*$id_prog = $this->general_model->save_data('sch_ref_program',array('nama_program' => $nama_program,'kode_program'=>$cek_no_kode)) ;*/
		$id = $this->db->insert_id();
		/*cek($_FILES['fupload']);
		die();*/
		$this->load->library('upload');
		if ($id_foto == NULL) {
			// $get_save = $this->general_model->save_data($data);
			$id = $this->db->insert_id();
			// jika udah disimpan lakukan penyimpanan foto dan update tabel
			if ($foto != NULL) {
				$path = './uploads/siatika/konten';
				if (!is_dir($path)) mkdir($path, 0777, TRUE);
				$this->load->library('upload');
				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => '*',
				));
				$upload = $this->upload->do_upload('foto');
				$data_upload = $this->upload->data();
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				//cek($data_upload);
				if ($upload) {
					// lakukan update tabel
					$param = array(
						'tabel' => 'sitika_articles',
						'data' => array(
							'foto' => $data_upload['file_name']
						)
					);
					$param['where'] = array('id_article' => $id);
					$this->general_model->save_data($param);
				}
			}
		} else {
			// jika tidak maka lakukan update
			// if ($id_foto != NULL) {
			// 	$param['where'] = array('id_article' => $id_foto);
			// }
			// // lakukan update tabel terlebih dahulu
			// $get_save = $this->general_model->save_data($param);
			// jika sudah cek apakah dia upload foto atau ngga,
			if ($foto != null) {
				// jika upload foto maka lakukan penghapusan foto berdasarkan nama filenya
				$path = './uploads/siatika/konten';
				$prev = $this->input->post('foto_prev');
				if (!empty($prev)) {
					$path_pasfoto = $path . '/' . $prev;
					if (file_exists($path_pasfoto)) unlink($path_pasfoto);
				}
				// kemudian upload file baru
				$this->load->library('upload');
				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => 'jpg|jpeg|png|gif',
				));
				$upload = $this->upload->do_upload('foto');
				$data_upload = $this->upload->data();
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				cek($data_upload);
				if ($upload) {
					// lakukan update tabel
					$param = array(
						'tabel' => 'sitika_articles',
						'data' => array(
							'foto' => $data_upload['file_name']
						)
					);
					$param['where'] = array('id_article' => $id_foto);
					$this->general_model->save_data($param);
				}
			}
		}
		if (empty($id_artikel)) $this->session->set_flashdata('ok', 'Data berhasil disimpan.');
		else $this->session->set_flashdata('ok', 'Data berhasil diupdate.');

		redirect('siatika/articles/list_data/' . $sec);
	}
	function delete_article($sec, $id = null)
	{
		/*cek($sec);
		cek($id);
		die();*/
		$data = array(
			'status'	=> '2'
		);

		$this->general_model->save_data('sitika_articles', $data, 'id_article', $id);
		$this->session->set_flashdata('ok', 'Data Publikasi Berhasil dibuang');
		redirect($this->dir . '/list_data/' . $sec . '/' . $status);
		//$del = $this->general_model->delete_data('sitika_articles','id_article',$id);
		/*if ($del) {
			$this->session->set_flashdata('ok','Data articles Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Data articles Gagal di Hapus');
		}*/
	}

	function restore_data($sec, $id = null, $status)
	{
		/*cek($status);
		die();*/
		$data = array('status'	=> '3');
		$this->general_model->save_data('sitika_articles', $data, 'id_article', $id);
		$this->session->set_flashdata('ok', 'Data Publikasi Berhasil di Kembalikan');
		redirect($this->dir . '/list_data/' . $sec . '/' . $status);
	}

	function delete_data($sec, $id = null, $status, $id_uploads = null)
	{
		$del = $this->general_model->delete_data('sitika_articles', 'id_article', $id);

		if ($del) {
			$this->session->set_flashdata('ok', 'Data Publikasi Berhasil di Hapus');
		} else {
			$this->session->set_flashdata('fail', 'Data Publikasi Gagal di Hapus');
		}
		redirect($this->dir . '/list_data/' . $sec . '/' . $status);
	}

	function truncate($str, $len)
	{
		$tail 	= max(0, $len - 10);
		$trunk 	= substr($str, 0, $tail);
		$trunk 	.= strrev(preg_replace('~^..+?[\s,:]\b|^...~', '...', strrev(substr($str, $tail, $len - $tail))));
		return $trunk;
	}
}

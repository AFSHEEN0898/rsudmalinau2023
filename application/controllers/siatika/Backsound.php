<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Backsound extends CI_Controller
{

	var $dir = 'siatika/backsound';
	var $folder = 'siatika';

	function __construct()
	{
		parent::__construct();
		login_check($this->session->userdata('login_state'));
	}

	public function index()
	{
		$this->list_data();
	}

	// index
	function list_data($search = null, $offset = null)
	{

		$data['breadcrumb'] = array('siatika/backsound/list_data' => 'Backsound');
		// define offfset
		$offset = !empty($offset) ? $offset : null;
		$in = $this->input->post();
		$vse = null;
		$fcari = null;
		if (!empty($in)) {
			$vse = array(
				'status' => $in['status'],
				'keterangan' => $in['keterangan'],
			);
			if (!empty($in['keterangan'])) {
				$fcari = array(
					'keterangan' => $in['keterangan'],
				);
			} else {
				$fcari = un_de($search);
			}
		} else if ($search) {
			$vse = un_de($search);
			$fcari = un_de($search);
		}
		// $search = !empty($vse) ? $se = array('teks_bergerak' => $vse['text_search']) : null;
		$where = array();
		if (isset($vse['status']) && $vse['status'] != '') $where['status'] = $vse['status'];
		$array_status = array(
			'' => 'Semua Status',
			1 => 'Tidak Tampil',
			2 => 'Tampil'
		);
		$data['combo_status'] = $array_status;
		// define offfset
		$data['graph_area'] = form_open('siatika/backsound', 'id="form_search" class="form-horizontal"') . '
	                  <div class="box-body">
		              	<div class="col-md-6">
			                <div class="form-group">
			                  <label class="col-sm-4 control-label">Status</label>
			                  <div class="col-sm-8">
			                    ' . form_dropdown("status", $data['combo_status'], @$vse['status'], "id='filter_status' class='form-control' style='width:100%'") . '
			                  </div>
			                </div>
		              	</div>
		              	<div class="col-md-6">
			                <div class="form-group">
			                  	<label class="col-sm-4 control-label">Keterangan</label>
				                  	<div class="col-sm-8">
								<div class="input-group">
		                      	<input name="keterangan" type="text" placeholder="Keterangan ..." class="form-control pull-right" value="' . @$vse['keterangan'] . '">
		                    			<div class="input-group-btn">
	                        				<button class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
	                      				</div>
	                    			</div>
			                	</div>
			                </div>
		              	</div>
		              </div>
		              ' . form_close();
		$param_total = array(
			'select' => '*',
			'tabel'	=> array(
				'sitika_backsound' => ''
			),
			'where' => $where,
			'search' => $fcari
		);

		// $config['base_url']	= site_url($this->dir.'/list_data/'.in_de($var));
		$config['total_rows'] = $this->general_model->datagrabs($param_total)->num_rows();
		// $config['per_page']	= '10';
		// $config['uri_segment'] = '5';
		// $this->pagination->initialize($config);
		// $data['links']	= $this->pagination->create_links();
		// cetak excel dan html
		$offs = (!in_array($offset, array("cetak", "excel"))) ?  @$offset : NULL;
		$lim = (!in_array($offset, array("cetak", "excel"))) ? @$config['per_page'] : NULL;

		$query = $this->general_model->datagrabs(array(
			'select' => '*',
			'tabel'	=> array(
				'sitika_backsound' => ''
			),
			'where' => $where,
			'search' => $fcari,
			// 'offset' => $offs,
			'order' => 'urut, backsound, keterangan ASC',
			// 'limit' => $lim
		));
		if ($query->num_rows() != 0) {
			$classy = (in_array($offset, array("cetak", "excel"))) ? 'class="tabel_print" border=1' : 'class="table table-bordered table-condensed no-fluid" ';
			$this->table->set_template(array('table_open' => '<table ' . $classy . '>'));
			$heads = array('No');
			if (!in_array($offset, array('cetak', 'excel'))) $heads[] = '';
			$heads = array_merge_recursive(
				array(
					'NO',
					'',
					'FILE NAME',
					'KETERANGAN'
				)
			);
			if (!in_array($offset, array('cetak', 'excel'))) {
				$heads[] = array('data' => 'AKSI', 'colspan' => 5);
			}
			$this->table->set_heading($heads);
			$no = $offset + 1;
			// Meng-list usulan
			$no = 1;
			$j = 1;
			$sel = array();
			foreach ($query->result() as $row) {
				if ($j > 1) $sel[] = array('id' => $row->id_backsound, 'urut' => $row->urut);
				$j += 1;
			}
			$aft = null;
			foreach ($query->result() as $row) {
				// me-list data yang akan ditampilkan
				$backsound = '<a class="fancybox" target="_blank" href="' . base_url() . 'uploads/siatika/galeri/backsound/' . $row->backsound . '" title="' . @$row->judul . '"><i class="fa fa-file-audio "></i></a>';
				$rows = array(
					array('data' => $no, 'style' => 'text-align:center'),
					array('data' => @$backsound ?: '-', 'style' => 'text-align:center'),
					array('data' => @$row->backsound ?: '-', 'style' => 'text-align:left'),
					array('data' => @$row->keterangan ?: '-', 'style' => 'text-align:left')
				);
				// tambbah tombol edit dan delete
				if ($row->status == '1') {
					$link_power = anchor(site_url($this->dir . '/power_on/' . in_de(array('id_backsound' => $row->id_backsound))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-default" ');
				} elseif ($row->status == '2') {
					$link_power = anchor(site_url($this->dir . '/power_off/' . in_de(array('id_backsound' => $row->id_backsound))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-success" ');
				}
				@$trn = ($no < $query->num_rows() and $query->num_rows() > 1) ? anchor('siatika/backsound/trade/' . $row->id_backsound . '/' . $row->urut . '/' . $sel[$no - 1]['id'] . '/' . $sel[$no - 1]['urut'], '<i class="fa fa-arrow-down"></i>', 'class="btn btn-xs btn-info"') : '-';
				@$naik = ($no > 1 and $query->num_rows() > 1)  ? anchor('siatika/backsound/trade/' . $row->id_backsound . '/' . $row->urut . '/' . $aft['id'] . '/' . $aft['urut'], '<i class="fa fa-arrow-up"></i>', 'class="btn btn-xs btn-info"') : '-';
				$link_edit = anchor('#', '<i class="fa fa-pen"></i>', 'act="' . site_url($this->dir . '/add_data/' . in_de(array('id_backsound' => $row->id_backsound))) . '" class="btn btn-xs btn-warning btn-edit" title="Klik untuk edit data."');
				$link_delete = '<div class="text-center"><a href="' . site_url($this->dir . '/delete_aset/' . in_de(array('id_backsound' => $row->id_backsound))) . '" class="btn btn-xs btn-danger btn-delete" title="Hapus Data" msg="Yakin untuk menghapus data ini"><i class="fa fa-trash"></i></a></div>';
				// meng-assign data ke tabel
				if (!in_array($offset, array('cetak', 'excel'))) {
					// add edit and delete button
					$rows[] = array('data' => $link_power, 'style' => 'text-align:center');
					$rows[] = array('data' => $link_edit, 'style' => 'text-align:center');
					$rows[] = array('data' => $link_delete, 'style' => 'text-align:center');

					$rows[] = array('data' => $trn, 'style' => 'text-align:center');
					$rows[] = array('data' =>  $naik, 'style' => 'text-align:center');
				}
				$this->table->add_row($rows);
				$aft = array('id' => $row->id_backsound, 'urut' => $row->urut);
				$no++;
			}
			$tabel = '<div class="table-responsive">' . $this->table->generate() . '</div>';
		} else {
			$tabel = '<div class="alert alert-confirm pull-left">Belum ada data</div><div class="clear"></div>';
		}

		$btn_cetak = ($query->num_rows() > 0) ?
			'<div class="btn-group"  tyle="margin-left: 5px;">
		<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
		<i class="fa fa-print"></i> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu pull-right">
		<li class="dropdown-item">' . anchor('siatika/backsound/list_data/' . in_de($vse) . '/cetak', '<i class="fa fa-print"></i> Cetak', 'target="_blank"') . '</li>
		<li class="dropdown-item">' . anchor('siatika/backsound/list_data/' . in_de($vse) . '/excel', '<i class="fa fa-file-excel"></i> Ekspor Excel', 'target="_blank"') . '</li>
		</ul>
		</div>' : null;
		$data['script'] = "
		$(document).ready(function(){
			$(\".fancybox\").fancybox();
			$('select.cbox').select2();
		});
		";
		$j = 'Backsound';
		$data['box'] = 'box-success';
		$data['tombol'] = anchor('#', '<i class="fa fa-plus-square fa-btn"></i> &nbsp;  Tambah Data ', 'class="btn btn-success  btn-edit" act="' . site_url($this->dir . '/add_data') . '" title="Klik untuk Tambah Data Backsound"') . ' ' . $btn_cetak;
		$data['total'] = $config['total_rows'];
		$data['tabel']	= $tabel;
		if ($offset == "cetak") {
			$data['title'] = '<h3>' . $j . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print', $data);
		} else if ($offset == "excel") {
			$data['file_name'] = str_replace(" ", "_", strtolower('jenis_arsip')) . '.xls';
			$data['title'] = '<h3>' . $j . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel', $data);
		} else {
			$data['tabel'] = $tabel;
			$data['title'] = $j;
			$data['content'] = "umum/standard_view";
			$this->load->view('home', $data);
		}
	}

	function add_data($id = null)
	{
		if ($id != NULL) {
			$p = un_de($id);
			$data['dt'] = $this->general_model->datagrab(
				array(
					'select' => '*',
					'tabel'	=> array(
						'sitika_backsound' => ''
					),
					'where' => array(
						'id_backsound' => $p['id_backsound']
					)
				)
			)->row();
		}
		$data['title']	= (!empty($id) ? 'Ubah' : 'Entri') . ' Data Backsound';
		$combo_status = array(
			'2' => 'Tampil',
			'1' => 'Tidak Tampil',

		);
		$data['form_link'] = $this->dir . '/save_data/' . $id;
		$data['multi'] = 1;
		$disabled = '';
		$data['form_data'] = '
				<input type="hidden" name="id_backsound" value="' . @$data['dt']->id_backsound . '" />
					<div class="form-group"><p>' . form_label('File Backsound  <code>*</code>') . '<p></p>';
		if (!empty(@$data['dt']->backsound)) {
			@$button_audio =
				form_hidden('backsound_prev', @$data['dt']->backsound) .
				'<a class="fancybox btn btn-success" target="_blank" href="' . base_url() . 'uploads/siatika/galeri/backsound/' . @$data['dt']->backsound . '" title="' . @$data['dt']->keterangan . '"><i class="fa fa-file-audio-o "></i> Play Audio ' . @$data['dt']->keterangan . '</a>';
		}
		$data['form_data'] .= '<input type="file" name="backsound" class="form-control" accept="audio/*" required></p><span>* Catatan : Ukuran file maksimal 5 MB dengan ektensi MP3.</span>
					</div>
					<div class="form-group">' .
			@$button_audio
			. '
					</div>
					<div class="form-group">
						' . form_label('Status <code>*</code>') . form_dropdown("status", $combo_status, @$data['dt']->status, "id='status' class='combo-box' style='width:100%' required") . '
					</div>
					<div class="form-group">' .
			form_label('Keterangan') .
			form_input('keterangan', @$data['dt']->keterangan, 'class="form-control" style="width:100%"') . '
					</div>
					
		';
		$this->load->view('umum/form_view', $data);
	}


	function save_data($id = null)
	{
		// deklarasikan id dan nama foto yang lama
		$id_backsound = $this->input->post('id_backsound', TRUE);
		$backsound_prev = $this->input->post('backsound_prev', TRUE);
		$backsound = $_FILES['backsound']['name'];
		$file_backsound = null;
		// jika id = null maka lakukan insert
		// cek(
		// 	$this->input->post()
		// );
		// cek($_FILES['backsound']);
		// cek($backsound);
		// die();
		if ($backsound != null) {
			$new_name = 'audio_' . date('Ymd') . '_' . date('His');
			// jika upload backsound maka lakukan penghapusan backsound berdasarkan nama filenya
			$path = './uploads/siatika/galeri/backsound';
			$prev = $this->input->post('backsound_prev');
			if (!empty($prev)) {
				$path_pasbacksound = $path . '/' . $prev;
				if (file_exists($path_pasbacksound)) unlink($path_pasbacksound);
			}
			// kemudian upload file baru
			$this->load->library('upload');
			$this->upload->initialize(array(
				'upload_path' => $path,
				'allowed_types' => 'mp3',
				'file_name' => $new_name,
				'max_size' => '5000'
			));
			$upload = $this->upload->do_upload('backsound');
			// $data_upload = $this->upload->data();
			// $onerror = $this->upload->display_errors('&nbsp', '&nbsp');
			// cek($upload);
			// die();
			if ($upload) {
				// lakukan update tabel
				$data_upload = $this->upload->data();
				$file_backsound = $data_upload['file_name'];
			} else {
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				$this->session->set_flashdata(
					'fail',
					'File Backsound Gagal Diunggah <br>' . $onerror
				);
				redirect($this->dir);
			}
		} else {
			# code...
			$file_backsound = !empty($backsound_prev) ? $backsound_prev : null;
		}
		$query = $this->general_model->datagrab(
			array(
				'select' => '(MAX(urut) + 1) as new_urut',
				'tabel'	=> array(
					'sitika_backsound' => ''
				),
				// 'where' => $where,
				// 'search' => $search,
				'order' => 'urut, backsound ASC'
			)
		)->row();
		$param = array(
			'tabel' => 'sitika_backsound',
			'data' => array(
				'keterangan' => $this->input->post('keterangan'),
				'status' => $this->input->post('status') ?: 0,
				'urut' => (($query->new_urut) ?: 0),
				'backsound' => $file_backsound
			)
		);
		if ($id_backsound == NULL) {
			$get_save = $this->general_model->save_data($param);
			$id = $this->db->insert_id();
		} else {
			// jika tidak maka lakukan update
			if ($id_backsound != NULL) {
				$param['where'] = array('id_backsound' => $id_backsound);
			}
			// lakukan update tabel terlebih dahulu
			$get_save = $this->general_model->save_data($param);
		}
		if ($get_save) {
			$this->session->set_flashdata('ok', 'Data Backsound Berhasil Disimpan');
			redirect($this->dir);
		} else {
			$this->session->set_flashdata('fail', 'Data Backsound Gagal Disimpan');
			redirect($this->dir);
		}
	}


	function save_data_cp($id = null)
	{
		// deklarasikan id dan nama backsound yang lama
		$id_backsound = $this->input->post('id_backsound', TRUE);
		$backsound_prev = $this->input->post('backsound_prev', TRUE);
		$backsound = $_FILES['backsound']['tmp_name'];
		// jika id = null maka lakukan insert
		// jika id = null maka lakukan insert
		$query = $this->general_model->datagrab(
			array(
				'select' => '(MAX(urut) + 1) as new_urut',
				'tabel'	=> array(
					'sitika_backsound' => ''
				),
				'where' => $where,
				'search' => $search,
				'order' => 'urut, backsound ASC'
			)
		)->row();
		$param = array(
			'tabel' => 'sitika_backsound',
			'data' => array(
				'keterangan' => $this->input->post('keterangan'),
				'status' => $this->input->post('status') ?: 0,
				'urut' => (($query->new_urut) ?: 0)
			)
		);
		if ($id_backsound == NULL) {
			$get_save = $this->general_model->save_data($param);
			$id = $this->db->insert_id();
			// jika udah disimpan lakukan penyimpanan backsound dan update tabel
			if ($backsound != NULL) {
				$path = './uploads/siatika/galeri/backsound';
				if (!is_dir($path)) mkdir($path, 0777, TRUE);
				$this->load->library('upload');
				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => 'mp3',
					'file_name' => substr(md5(microtime()), rand(0, 26), 5),
					'max_size' => '2000'
				));
				$upload = $this->upload->do_upload('backsound');
				$data_upload = $this->upload->data();
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				// cek($data_upload);
				if ($upload) {
					// lakukan update tabel
					$param = array(
						'tabel' => 'sitika_backsound',
						'data' => array(
							'backsound' => $data_upload['file_name']
						)
					);
					$param['where'] = array('id_backsound' => $id);
					$this->general_model->save_data($param);
				} else {
					$this->session->set_flashdata('fail', 'Data Backsound Gagal Disimpan');
					redirect($this->dir);
				}
			}
			$this->session->set_flashdata('ok', 'Data Backsound Berhasil Disimpan');
			redirect($this->dir);
		} else {
			// jika tidak maka lakukan update
			if ($id_backsound != NULL) {
				$param['where'] = array('id_backsound' => $id_backsound);
			}
			// lakukan update tabel terlebih dahulu
			$get_save = $this->general_model->save_data($param);
			// jika sudah cek apakah dia upload backsound atau ngga,
			if ($backsound != null) {
				// jika upload backsound maka lakukan penghapusan backsound berdasarkan nama filenya
				$path = './uploads/siatika/galeri/backsound';
				$prev = $this->input->post('backsound_prev');
				if (!empty($prev)) {
					$path_pasbacksound = $path . '/' . $prev;
					if (file_exists($path_pasbacksound)) unlink($path_pasbacksound);
				}
				// kemudian upload file baru
				$this->load->library('upload');
				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => 'mp3',
					'file_name' => substr(md5(microtime()), rand(0, 26), 5),
					'max_size' => '2000'
				));
				$upload = $this->upload->do_upload('backsound');
				$data_upload = $this->upload->data();
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				cek($data_upload);
				if ($upload) {
					// lakukan update tabel
					$param = array(
						'tabel' => 'sitika_backsound',
						'data' => array(
							'backsound' => $data_upload['file_name']
						)
					);
					$param['where'] = array('id_backsound' => $id_backsound);
					$this->general_model->save_data($param);
				} else {
					$data['error'] = $this->upload->display_errors();

					$this->session->set_flashdata('fail', 'Data Backsound Gagal Disimpan <br>' . $data['error']);
					redirect($this->dir);
				}
			}
			// 
			$this->session->set_flashdata('ok', 'Data Backsound Berhasil Diubah');
			redirect('siatika/backsound');
		}
	}


	function delete_aset($code = NULL)
	{
		$p = un_de($code);
		// dilist daftar file dengan id_penghapusan $code
		$result = $this->general_model->datagrab(
			array(
				'select' => '*',
				'tabel' => 'sitika_backsound',
				'where' => array(
					'id_backsound' => $p['id_backsound']
				)
			)
		)->row();
		$this->general_model->delete_data('sitika_backsound', 'id_backsound', $p['id_backsound']);
		$file_name = $result->backsound;
		$path =  base_url() . 'uploads/siatika/galeri/backsound/' . $file_name;
		if (is_file('uploads/siatika/galeri/backsound/' . $file_name)) {
			unlink('uploads/siatika/galeri/backsound/' . $file_name);
		}
		$this->session->set_flashdata('ok', 'Data Backsound berhasil dihapus.');
		redirect($this->dir);
	}

	public function power_off($id = null)
	{
		$data = un_de($id);
		$id_backsound = $data['id_backsound'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_backsound',
			'data' => array(
				'status' => '1'
			)
		);
		$param['where'] = array('id_backsound' => $id_backsound);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Backsound yang dipilih berubah menjadi tidak tampil.');
			redirect($this->dir);
		}
	}

	public function power_on($id = null)
	{
		$data = un_de($id);
		$id_backsound = $data['id_backsound'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_backsound',
			'data' => array(
				'status' => '2'
			)
		);
		$param['where'] = array('id_backsound' => $id_backsound);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Backsound yang dipilih berubah menjadi tampil.');
			redirect($this->dir);
		}
	}

	function trade($a1, $a2, $b1, $b2)
	{
		$this->general_model->save_data('sitika_backsound', array('urut' => $b2), 'id_backsound', $a1);
		$this->general_model->save_data('sitika_backsound', array('urut' => $a2), 'id_backsound', $b1);
		$this->session->set_flashdata('ok', 'Urutan berhasil disimpan ...');
		redirect($this->dir);
	}
}

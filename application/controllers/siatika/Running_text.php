<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Running_text extends CI_Controller
{

	var $dir = 'siatika/running_text';
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
		// $p = un_de($filter);
		// $filter_status = @$p['filter_status'];
		// $search = @$p['text_search'];
		// $data['css_load'] = '<link href="'.base_url().'assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />';
		// $data['include_script'] = '
		// <script type="text/javascript" src="'.base_url().'assets/plugins/select2/select2.js"></script>';
		// inisialisasi breadcrumb
		$data['breadcrumb'] = array('siatika/running_text/list_data' => 'Teks Bergerak');
		// define offfset
		$offset = !empty($offset) ? $offset : null;
		$in = $this->input->post();
		$vse = null;
		$fcari = null;
		if (!empty($in)) {
			$vse = array(
				'status' => $in['status'],
				'teks_bergerak' => $in['teks_bergerak'],
			);
			if(!empty($in['teks_bergerak'])){
				$fcari = array(
					'teks_bergerak' => $in['teks_bergerak'],
				);
			}else {
				$fcari = un_de($search);
			}
		} else if ($search) {
			$vse = un_de($search);
			$fcari = un_de($search);
		}
		// $search = !empty($vse) ? $se = array('teks_bergerak' => $vse['text_search']) : null;
		$where = array();
		if (isset($vse['status']) && $vse['status'] != '') $where['status'] = $vse['status'];
		// cek($vse);
		// cek($in);
		$array_status = array(
			'' => 'Semua Status',
			1 => 'Tidak Tampil',
			2 => 'Tampil'
		);
		$data['combo_status'] = $array_status; 
		// define offfset
		$data['graph_area'] = form_open('siatika/running_text', 'id="form_search" class="form-horizontal"') . '
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
			                  	<label class="col-sm-4 control-label">Pencarian</label>
				                  	<div class="col-sm-8">
								<div class="input-group">
		                      	<input name="teks_bergerak" type="text" placeholder="Teks Bergerak ..." class="form-control pull-right" value="' . @$vse['teks_bergerak'] . '">
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
				'sitika_running_text' => ''
			),
			'where' => $where,
			'search' => $fcari
		);
		// $var = array(
		// 	'status' => $vse['status'],
		// 	'teks_bergerak' => $vse['teks_bergerak']
		// );
		// $config['base_url']	= site_url($this->dir.'/list_data/'.in_de($var));
		$config['total_rows'] = $this->general_model->datagrabs($param_total)->num_rows();
		// $config['per_page']	= '10';
		// $config['uri_segment'] = '5';
		// $this->pagination->initialize($config);
		// $data['links']	= $this->pagination->create_links();
		// cetak excel dan html
		$offs = (!in_array($offset, array("cetak", "excel"))) ?  $offset : NULL;
		$lim = (!in_array($offset, array("cetak", "excel"))) ? @$config['per_page'] : NULL;

		$query = $this->general_model->datagrabs(array(
			'select' => '*',
			'tabel'	=> array(
				'sitika_running_text' => ''
			),
			'where' => $where,
			'search' => $fcari,
			'order' => 'urut, teks_bergerak ASC'
		));
		// cek($where);
		// cek($vse);
		// cek($fcari);
		// cek($this->db->last_query());
		if ($query->num_rows() != 0) {
			$classy = (in_array($offset, array("cetak", "excel"))) ? 'class="tabel_print" border=1' : 'class="table table-bordered table-condensed no-fluid" ';
			$this->table->set_template(array('table_open' => '<table ' . $classy . '>'));
			$heads = array('No');
			if (!in_array($offset, array('cetak', 'excel'))) $heads[] = '';
			$heads = array_merge_recursive(
				array(
					'NO',
					'TEKS BERGERAK'
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
				if ($j > 1) $sel[] = array('id' => $row->id_running_text, 'urut' => $row->urut);
				$j += 1;
			}
			$aft = null;
			foreach ($query->result() as $row) {
				// me-list data yang akan ditampilkan
				$rows = array(
					array('data' => $no, 'style' => 'text-align:center'),
					array('data' => @$row->teks_bergerak ?: '-', 'style' => 'text-align:left')
				);
				// tambbah tombol edit dan delete
				if ($row->status == '1') {
					$link_power = anchor(site_url($this->dir . '/power_on/' . in_de(array('id_running_text' => $row->id_running_text))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-default" ');
				} elseif ($row->status == '2') {
					$link_power = anchor(site_url($this->dir . '/power_off/' . in_de(array('id_running_text' => $row->id_running_text))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-success" ');
				}
				@$trn = ($no < $query->num_rows() and $query->num_rows() > 1) ? anchor('siatika/running_text/trade/' . $row->id_running_text . '/' . $row->urut . '/' . $sel[$no - 1]['id'] . '/' . $sel[$no - 1]['urut'], '<i class="fa fa-arrow-down"></i>', 'class="btn btn-xs btn-info"') : '-';
				@$naik = ($no > 1 and $query->num_rows() > 1)  ? anchor('siatika/running_text/trade/' . $row->id_running_text . '/' . $row->urut . '/' . $aft['id'] . '/' . $aft['urut'], '<i class="fa fa-arrow-up"></i>', 'class="btn btn-xs btn-info"') : '-';
				$link_edit = anchor('#', '<i class="fa fa-pen"></i>', 'act="' . site_url($this->dir . '/add_data/' . in_de(array('id_running_text' => $row->id_running_text))) . '" class="btn btn-xs btn-warning btn-edit" title="Klik untuk edit data."');
				$link_delete = '<div class="text-center"><a href="' . site_url($this->dir . '/delete_aset/' . in_de(array('id_running_text' => $row->id_running_text))) . '" class="btn btn-xs btn-danger btn-delete" title="Hapus Data" msg="Yakin untuk menghapus data ini"><i class="fa fa-trash"></i></a></div>';
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
				// buat query jika ada entitas di bawahnya
				$aft = array('id' => $row->id_running_text, 'urut' => $row->urut);
				$no++;
			}
			$tabel = '<div class="table-responsive">' . $this->table->generate() . '</div>';
		} else {
			$tabel = '<div class="alert alert-confirm pull-left">Belum ada data</div><div class="clear"></div>';
		}
		// $var = array(
		// 	'filter_status' => $vse['status'],
		// 	'text_search' => $vse['text_search']
		// );
		$btn_cetak = ($query->num_rows() > 0) ?
			'<div class="btn-group"  tyle="margin-left: 5px;">
		<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
		<i class="fa fa-print"></i> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu pull-right">
		<li class="dropdown-item">' . anchor('siatika/running_text/list_data/' . in_de($vse) . '/cetak', '<i class="fa fa-print"></i> Cetak', 'target="_blank"') . '</li>
		<li class="dropdown-item">' . anchor('siatika/running_text/list_data/' . in_de($vse) . '/excel', '<i class="fa fa-file-excel"></i> Ekspor Excel', 'target="_blank"') . '</li>
		</ul>
		</div>' : null;
		$data['script'] = "
		$(document).ready(function(){
			$(\".fancybox\").fancybox();
			$('select.cbox').select2();
			$('.tanggal').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true
			});
		});
		";
		$j = 'Teks Bergerak';
		$data['box'] = 'box-success';
		$data['tombol'] = anchor('#', '<i class="fa fa-plus-square fa-btn"></i> &nbsp; Tambah Data ', 'class="btn btn-success  btn-edit" act="' . site_url($this->dir . '/add_data') . '" title="Klik untuk Tambah Data Teks Bergerak"') . ' ' . $btn_cetak;
		$data['total'] = @$config['total_rows'];
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
						'sitika_running_text' => ''
					),
					'where' => array(
						'id_running_text' => $p['id_running_text']
					)
				)
			)->row();
		}
		$data['title']	= (!empty($id) ? 'Ubah' : 'Entri') . ' Data Teks Bergerak';
		$combo_status = array(
			'2' => 'Tampil',
			'1' => 'Tidak Tampil',
			
		);
		$data['form_link'] = $this->dir . '/save_data/' . $id;
		$data['multi'] = 1;
		$disabled = '';
		$data['form_data'] = '
				<input type="hidden" name="id_running_text" value="' . @$data['dt']->id_running_text . '" />
					<div class="form-group">
					' . form_label('Teks Bergerak <code>*</code>') . form_input('teks_bergerak', @$data['dt']->teks_bergerak, 'class="form-control" placeholder="Deskripsi Teks Bergerak" required') . '
					</div>
					<div class="form-group">
						' . form_label('Status <code>*</code>') . form_dropdown("status", $combo_status, @$data['dt']->status, "id='status' class='combo-box' style='width:100%'") . '
					</div>
		';
		$this->load->view('umum/form_view', $data);
	}

	function save_data($id = null)
	{
		// deklarasikan id dan nama running_text yang lama
		$id_running_text = $this->input->post('id_running_text', TRUE);
		// jika id = null maka lakukan insert
		$query = $this->general_model->datagrab(
			array(
				'select' => '(MAX(urut) + 1) as new_urut',
				'tabel'	=> array(
					'sitika_running_text' => ''
				),
				'where' => $where,
				'search' => $search,
				'order' => 'urut, teks_bergerak ASC'
			)
		)->row();
		$param = array(
			'tabel' => 'sitika_running_text',
			'data' => array(
				'teks_bergerak' => $this->input->post('teks_bergerak'),
				'status' => $this->input->post('status') ?: 0,
				'urut' => (($query->new_urut) ?: 0)
			)
		);
		if ($id_running_text == NULL) {
			$get_save = $this->general_model->save_data($param);
			$this->session->set_flashdata('ok', 'Data Teks Bergerak Berhasil Disimpan');
			redirect($this->dir);
		} else {
			// jika tidak maka lakukan update
			if ($id_running_text != NULL) {
				$param['where'] = array('id_running_text' => $id_running_text);
			}
			// lakukan update tabel terlebih dahulu
			$get_save = $this->general_model->save_data($param);
			// 
			$this->session->set_flashdata('ok', 'Data Teks Bergerak Berhasil Diubah');
			redirect('siatika/running_text');
		}
	}


	function delete_aset($code = NULL)
	{
		$p = un_de($code);
		$this->general_model->delete_data('sitika_running_text', 'id_running_text', $p['id_running_text']);
		$this->session->set_flashdata('ok', 'Data Teks Bergerak berhasil dihapus.');
		redirect($this->dir);
	}

	public function power_off($id = null)
	{
		$data = un_de($id);
		$id_running_text = $data['id_running_text'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_running_text',
			'data' => array(
				'status' => '1'
			)
		);
		$param['where'] = array('id_running_text' => $id_running_text);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Teks Bergerak yang dipilih berubah menjadi tidak tampil.');
			redirect($this->dir);
		}
	}

	public function power_on($id = null)
	{
		$data = un_de($id);
		$id_running_text = $data['id_running_text'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_running_text',
			'data' => array(
				'status' => '2'
			)
		);
		$param['where'] = array('id_running_text' => $id_running_text);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Teks Bergerak yang dipilih berubah menjadi tampil.');
			redirect($this->dir);
		}
	}

	function trade($a1, $a2, $b1, $b2)
	{
		$this->general_model->save_data('sitika_running_text', array('urut' => $b2), 'id_running_text', $a1);
		$this->general_model->save_data('sitika_running_text', array('urut' => $a2), 'id_running_text', $b1);
		$this->session->set_flashdata('ok', 'Urutan berhasil disimpan ...');
		redirect($this->dir);
	}
}

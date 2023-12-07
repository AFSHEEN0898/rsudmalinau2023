<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Text extends CI_Controller {
	var $dir = 'siatika/text';
	var $folder = 'siatika';
	var $kd = 1;
	var $pos = 1;
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index() {
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL) {
		$title = 'Teks Bergerak';
		$data['breadcrumb'] = array($this->dir => $title);
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'isi' 		=> $search_key,
			);
			$data['for_search'] = $fcari['isi'];
		}else{
			$fcari=un_de($search);
			$data['for_search'] = $fcari['isi'];
		}
		$from = 'info_text';
		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from, 'select'=>'id_text','search' => $fcari))->num_rows();
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$dt = $this->general_model->datagrab(array('tabel'=>$from, 'search'=>$fcari, 'limit'=>$lim, 'offset'=>$offs, 'order'=>'urut asc'));
		if($dt->num_rows() > 0){
			$heads = array('No','Teks');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Status ');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' urutkan ','colspan' => 2);
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);
			$no = 1 + $offset; $jml = $dt->num_rows();
			foreach ($dt->result() as $row) {
				$rows = array();
				$rows[] = array('data'=>$no, 'align'=>'center');
				$rows[] = array('data'=>@$row->isi, 'align'=>'');
				if (!in_array($offset,array("cetak","excel"))) {
					if($row->status==0){
						$aktiv_no = anchor(site_url($this->dir.'/aktiv_no/'.in_de(array('id_text'=>$row->id_text, 'kd'=>'1'))), '<i class="fa fa-power-off"></i>', 'class="btn btn-flat btn-default btn-xs" title="Klik untuk mengaktifkan." ');
					}else{
						$aktiv_no = anchor(site_url($this->dir.'/aktiv_no/'.in_de(array('id_text'=>$row->id_text, 'kd'=>'0'))), '<i class="fa fa-power-off"></i>', 'class="btn btn-flat btn-success btn-xs" title="Klik untuk men-non-aktifkan." ');
					}
					$rows[] = array('data'=>$aktiv_no, 'align'=>'center');
					if($no!=1){
						$naik = anchor(site_url($this->dir.'/urutkan/'.in_de(array('id_text'=>$row->id_text, 'urut'=>$row->urut, 'kd'=>'up' ))), '<i class="fa fa-arrow-up"></i>', 'class="btn btn-flat btn-info btn-xs" title="Klik untuk menaikan." ');
					}else{
						$naik = '';
					}
					$rows[] = array('data'=>$naik, 'align'=>'center');
					if($no!=$jml){
						$turun = anchor(site_url($this->dir.'/urutkan/'.in_de(array('id_text'=>$row->id_text, 'urut'=>$row->urut, 'kd'=>'down' ))), '<i class="fa fa-arrow-down"></i>', 'class="btn btn-flat btn-info btn-xs" title="Klik untuk menurunkan." ');
					}else{
						$turun = '';
					}
					$rows[] = array('data'=>$turun, 'align'=>'center');

					$ubah = anchor('#', '<span class="fa fa-edit"></span>', 'act="'.site_url($this->dir.'/add_text/'.in_de(array('id_text'=>$row->id_text))).'" class="btn btn-xs btn-warning btn-flat btn-edit" title="Klik untuk edit text"');
					$hps = anchor('#', '<span class="fa fa-trash"></span>', 'act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_text'=>$row->id_text) )).'" class="btn btn-xs btn-danger btn-delete btn-flat" msg="Apakah anda yakin ingin menghapus text ?"');
					$rows[] = array('data'=>$ubah, 'align'=>'center');
					$rows[] = array('data'=>$hps, 'align'=>'center');
				}
				$this->table->add_row($rows);
				$no+=1;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data '.$title.' masih kosong ...</div>';
		}
		$data['tombol'] = anchor('#', '<i class="fa fa-plus fa-btn"></i>'.$title,
			'class="btn btn-flat btn-success btn-edit" act="'.site_url($this->dir.'/add_text').'" title="Klik untuk tambah '.$title.'"');
		if ($offset == "cetak") {
			$data['title'] = '<h3>'.$title.'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print',$data);
		} else if ($offset == "excel") {
			$data['file_name'] = $title.'.xls';
			$data['title'] = '<h3>'.$title.'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel',$data);
		} else {
			$data['title'] 		= $title;
			$data['tabel'] = $tabel;
			$data['content'] = 'umum/standard_view';
			$this->load->view('home', $data);
		}
	}

	public function add_text($code=NULL){
		$data['title'] = ($code!=NULL) ? 'Edit Data' : 'Tambah Data';
		if($code!=NULL){
			$p = un_de($code);
			$dt = $this->general_model->datagrab(array('tabel'=>'info_text', 'where'=>array('id_text'=>$p['id_text']) ))->row();
		}
		$data['form_link'] = $this->dir.'/save_text/'.$code;
		$data['form_data'] = form_label('Teks');
		$data['form_data'] .= form_textarea('isi', @$dt->isi, 'class="form-control" required');
		$this->load->view('umum/form_view',$data);
	}

	function save_text($code=NULL){
		$par = array(	'tabel'=>'info_text',
						'data'=>array('isi'=>$this->input->post('isi')),
						);
		if($code!=NULL){
			$p = un_de($code);
			$id_text = $p['id_text'];
			$par['where'] = array('id_text'=>$id_text);
		}else{
			$cek_urut = $this->general_model->datagrab(array('tabel'=>'info_text', 'select'=>'max(urut) as urut' ))->row();
			if($cek_urut->urut > 0){
				$urut = $cek_urut->urut+1;
			}else{
				$urut = 1;
			}
			$par['data']['urut'] = $urut;
		}
		$save = $this->general_model->save_data($par);
		if($save){
			$this->session->set_flashdata('ok', 'Slide berhasil disimpan');
		}else{
			$this->session->set_flashdata('fail', 'Slide gagal disimpan');
		}
		redirect($this->dir);
	}

	function aktiv_no($code=NULL){
		$p = un_de($code);
		$par = array('tabel'=>'info_text', 'data'=>array('status'=>$p['kd']), 'where'=>array('id_text'=>$p['id_text']) );
		$this->general_model->save_data($par);
		redirect($this->dir);
	}

	function urutkan($code=NULL){
		$p = un_de($code);
		$id_text = $p['id_text'];
		$urut = $p['urut'];
		$kd = $p['kd'];
		if($kd=='down'){
			$urut_ganti = $urut+1;
		}else{
			$urut_ganti = $urut-1;
		}
		
		$par_pengganti = array('tabel'=>'info_text', 'data'=>array('urut'=>$urut), 'where'=>array('urut'=>$urut_ganti) );
		$pengganti = $this->general_model->save_data($par_pengganti);

		$par = array('tabel'=>'info_text', 'data'=>array('urut'=>$urut_ganti), 'where'=>array('id_text'=>$id_text) );
		$ganti_urut = $this->general_model->save_data($par);
		redirect($this->dir);
	}

	function delete_data($code=NULL){
		$p = un_de($code);
		$del_peng = $this->general_model->delete_data('info_text', 'id_text', $p['id_text']);
		$dt = $this->general_model->datagrab(array('tabel'=>'info_text','order'=>'urut asc'));
		$no = 1;
		foreach ($dt->result() as $row) {
			$par = array('tabel'=>'info_text',
							'data'=>array('urut'=>$no),
							'where'=>array('id_text'=>$row->id_text) );
			$this->general_model->save_data($par);
			$no+=1;
		}
		if($del_peng){
			$this->session->set_flashdata('ok', 'Teks Bergerak berhasil dihapus');
		}else{
			$this->session->set_flashdata('fail', 'Teks Bergerak gagal dihapus');
		}
		redirect($this->dir);
	}
}
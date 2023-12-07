<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ref_konten extends CI_Controller {
	var $dir = 'siatika/ref_konten';
	var $folder = 'siatika';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL){
		$title = 'Refferensi Konten';
		$data['breadcrumb'] = array($this->dir => $title);
		$data['title'] = $title;
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'a.ref_konten' 		=> $search_key
			);
			$data['for_search'] = $fcari['a.ref_konten'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['a.ref_konten'];
		}
		$from = array('ids_ref_konten a'=>'',
						'ids_tipe_konten b'=>array('a.id_tipe_konten=b.id_tipe_konten','left') );
		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from, 'select'=>'a.id_ref_konten','search' => $fcari))->num_rows();
		$config['per_page']		= '20';
		$config['uri_segment']	= '5';
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$dt = $this->general_model->datagrab(array('tabel'=>$from, 'search'=>$fcari, 'limit'=>$lim, 'offset'=>$offs, 'order'=>'b.id_tipe_konten asc, a.id_ref_konten asc' ));
		if($dt->num_rows() > 0){
			$heads = array('No', 'Referensi Konten', 'Tipe Konten');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);
			$no = 1 + $offset;
			foreach ($dt->result() as $row) {
				$rows = array();
				$rows[] = array('data'=>$no, 'align'=>'center');
				$rows[] = array('data'=>$row->ref_konten, 'align'=>'left');
				$rows[] = array('data'=>$row->tipe_konten, 'align'=>'left');
				if (!in_array($offset,array("cetak","excel"))) {
					$ubah = anchor('#', '<span class="fa fa-edit"></span>', 'act="'.site_url($this->dir.'/add_data/'.in_de(array('id_ref_konten'=>$row->id_ref_konten))).'" class="btn btn-xs btn-warning btn-flat btn-edit" title="Klik untuk edit pengumuman"');
					$hps = anchor('#', '<span class="fa fa-trash"></span>', 'act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_ref_konten'=>$row->id_ref_konten) )).'" class="btn btn-xs btn-danger btn-delete btn-flat" msg="Apakah anda yakin ingin menghapus pengumuman '.$row->ref_konten.' ?"');
					$rows[] = array('data'=>$ubah, 'align'=>'center');
					$rows[] = array('data'=>$hps, 'align'=>'center');
				}
				$this->table->add_row($rows);
				$no+=1;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		$btn_tambah = anchor('#', '<i class="fa fa-plus fa-btn"></i>'.$title, 'act="'.site_url($this->dir.'/add_data').'" class="btn btn-flat btn-success btn-edit" title="Klik untuk tambah pengumuman"');
		$data['tombol'] = $btn_tambah;
		$data['tabel'] = $tabel;
		$data['content'] = 'umum/standard_view';
		$this->load->view('home', $data);
	}

	public function add_data($code=NULL){
		if ($code!=NULL) {
			$p = un_de($code);
			$dt = $this->general_model->datagrab(array('tabel'=>'ids_ref_konten', 'where'=>array('id_ref_konten'=>$p['id_ref_konten']) ))->row();
		}
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ids_tipe_konten', 'key'=>'id_tipe_konten', 'val'=>array('tipe_konten') ));
		$data['title'] = ($code!=NULL) ? 'Edit Referensi Konten' : 'Buat Referensi Konten Baru';
		$data['form_link'] = $this->dir.'/simpan_data/'.$code;
		$data['form_data'] = '<p><label>Referensi Konten</label></p>';
		$data['form_data'] .= '<p><input type="text" name="ref_konten" class="form-control" value="'.@$dt->ref_konten.'" required></p>';
		$data['form_data'] .= '<p><label>Tipe Konten</label></p>';
		$data['form_data'] .= '<p>'.form_dropdown('id_tipe_konten', $cb_tipe, @$dt->id_tipe_konten, 'class="form-control combo-box" required style="width: 100%;"').'</p>';
		$this->load->view('umum/form_view', $data);
	}

	function simpan_data($code=NULL){
		$in = $this->input->post();
		$par = array(
				'tabel'=>'ids_ref_konten',
				'data'=>array(	'ref_konten'=>$in['ref_konten'],
								'id_tipe_konten'=>$in['id_tipe_konten'] ),
			);
		if($code!=NULL){
			$p = un_de($code);
			$id_ref_konten = $p['id_ref_konten'];
			$par['where'] = array('id_ref_konten'=>$id_ref_konten);
		}
		$sef_news = $this->general_model->save_data($par);
		if($sef_news){
			$this->session->set_flashdata('ok', 'Referensi Konten berhasil disimpan');
		}else{
			$this->session->set_flashdata('fail', 'Referensi Konten gagal disimpan');
		}
		redirect($this->dir);
	}

	function delete_data($code=NULL){
		$p = un_de($code);
		$del_peng = $this->general_model->delete_data('ids_ref_konten', 'id_ref_konten', $p['id_ref_konten']);
		if($del_peng){
			$this->session->set_flashdata('ok', 'Referensi Konten berhasil dihapus');
		}else{
			$this->session->set_flashdata('fail', 'Referensi Konten gagal dihapus');
		}
		redirect($this->dir);
	}
}
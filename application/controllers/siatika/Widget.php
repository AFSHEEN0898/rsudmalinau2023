<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Widget extends CI_Controller {
	var $dir = 'siatika/widget';
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
		$title = 'Widget';
		$data['title'] = $title;
		$data['breadcrumb'] = array($this->dir => $title);
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'a.id_data' 		=> $search_key
			);
			$data['for_search'] = $fcari['a.id_data'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['a.id_data'];
		}
		$from = array('ids_konten a'=>'',
						'ids_ref_konten b'=>array('a.id_data=b.id_ref_konten', 'left'),
						'ids_tipe_konten c'=>array('b.id_tipe_konten=c.id_tipe_konten','left') );
		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from, 'select'=>'a.id_konten','search' => $fcari))->num_rows();
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$dt = $this->general_model->datagrab(array('tabel'=>$from, 'search'=>$fcari, 'limit'=>$lim, 'offset'=>$offs, 'order'=>'a.urut asc' ));
		if($dt->num_rows() > 0){
			$heads = array('No', 'Judul', 'Tipe Konten', 'Konten', 'Durasi (detik)');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Status ');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Urutkan ','colspan' => 2);
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);
			$no = 1 + $offset; $jml = $dt->num_rows();
			foreach ($dt->result() as $row) {
				$rows = array();
				$rows[] = array('data'=>$no, 'align'=>'center');
				$rows[] = array('data'=>$row->judul, 'align'=>'left');
				$rows[] = array('data'=>$row->tipe_konten, 'align'=>'left');
				$rows[] = array('data'=>$row->ref_konten, 'align'=>'left');
				$rows[] = array('data'=>$row->durasi, 'align'=>'center');
				if (!in_array($offset,array("cetak","excel"))) {
					if($row->status==0){
						$stt = anchor(site_url($this->dir.'/aktiv_no/'.in_de(array('id_konten'=>$row->id_konten, 'kd'=>'1'))), '<span class="fa fa-power-off"></span>', 'class="btn btn-flat btn-default btn-xs" title="Klik untuk mengaktifkan." ');
					}else{
						$stt = anchor(site_url($this->dir.'/aktiv_no/'.in_de(array('id_konten'=>$row->id_konten, 'kd'=>'0'))), '<span class="fa fa-power-off"></span>', 'class="btn btn-flat btn-success btn-xs" title="Klik untuk men-non-aktifkan." ');
					}
					$ubah = anchor('#', '<span class="fa fa-edit"></span>', 'act="'.site_url($this->dir.'/add_data/'.in_de(array('id_konten'=>$row->id_konten))).'" class="btn btn-xs btn-warning btn-flat btn-edit" title="Klik untuk edit konten"');
					$hps = anchor('#', '<span class="fa fa-trash"></span>', 'act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_konten'=>$row->id_konten) )).'" class="btn btn-xs btn-danger btn-delete btn-flat" msg="Apakah anda yakin ingin menghapus '.$row->judul.' ?"');
					if($no!=1){
						$naik = anchor(site_url($this->dir.'/urutkan/'.in_de(array('id_konten'=>$row->id_konten, 'urut'=>$row->urut, 'kd'=>'up'))), '<i class="fa fa-arrow-up"></i>', 'class="btn btn-flat btn-info btn-xs" title="Klik untuk menaikan." ');
					}else{
						$naik = '';
					}
					if($no!=$jml){
						$turun = anchor(site_url($this->dir.'/urutkan/'.in_de(array('id_konten'=>$row->id_konten, 'urut'=>$row->urut, 'kd'=>'down'))), '<i class="fa fa-arrow-down"></i>', 'class="btn btn-flat btn-info btn-xs" title="Klik untuk menurunkan." ');
					}else{
						$turun = '';
					}
					$rows[] = array('data'=>$stt, 'align'=>'center');
					$rows[] = array('data'=>$naik, 'align'=>'center');
					$rows[] = array('data'=>$turun, 'align'=>'center');
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

	function aktiv_no($code=NULL){
		$p = un_de($code);
		$par = array('tabel'=>'ids_konten', 'data'=>array('status'=>$p['kd']), 'where'=>array('id_konten'=>$p['id_konten']) );
		$this->general_model->save_data($par);
		redirect($this->dir);
	}
	function urutkan($code=NULL){
		$p = un_de($code);
		$id_konten = $p['id_konten'];
		$urut = $p['urut'];
		$kd = $p['kd'];
		if($kd=='up'){
			$urut_ganti = $urut-1;
		}else{
			$urut_ganti = $urut+1;
		}
		$par_pengganti = array('tabel'=>'ids_konten', 'data'=>array('urut'=>$urut), 'where'=>array('urut'=>$urut_ganti) );
		$pengganti = $this->general_model->save_data($par_pengganti);

		$par = array('tabel'=>'ids_konten', 'data'=>array('urut'=>$urut_ganti), 'where'=>array('id_konten'=>$id_konten) );
		$ganti_urut = $this->general_model->save_data($par);
		redirect($this->dir);
	}

	public function add_data($code=NULL){
		if ($code!=NULL) {
			$p = un_de($code);
			$dt = $this->general_model->datagrab(array('tabel'=>'ids_konten', 'where'=>array('id_konten'=>$p['id_konten']) ))->row();
			$cb_dt = $this->general_model->combo_box(array('tabel'=>'ids_ref_konten', 'key'=>'id_ref_konten', 'val'=>array('ref_konten'), 'where'=>array('id_tipe_konten'=>@$dt->id_tipe_konten) ));
		}else{
			$cb_dt = array(''=>'-- Pilih --');
		}
		$data['title'] = ($code!=NULL) ? 'Edit Widget' : 'Buat Widget Baru';
		$data['form_link'] = $this->dir.'/simpan_data/'.$code;
		$data['form_data'] = '<label>Judul</label>';
		$data['form_data'] .= '<p><input type="text" name="judul" class="form-control" value="'.@$dt->judul.'" required></p>';
		$data['form_data'] .= '<label>Tipe Konten</label>';
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ids_tipe_konten','key'=>'id_tipe_konten','val'=>array('tipe_konten') ));
		$data['form_data'] .= '<p>'.form_dropdown('id_tipe_konten', $cb_tipe, @$dt->id_tipe_konten, 'class="form-control combo-box" id="id_tipe_konten" style="width: 100%;" required').'</p>';
		$data['form_data'] .= '<label>Konten</label>';
		$data['form_data'] .= '<p>'.form_dropdown('id_data', $cb_dt, @$dt->id_data,'class="form-control combo-box" id="id_data" style="width: 100%;" required').'</p>';
		$data['form_data'] .= '<label>Durasi (Detik)</label>';
		$data['form_data'] .= '<p><input type="text" name="durasi" class="form-control" value="'.@$dt->durasi.'"></p>';
		$data['script'] = "
							$('#id_tipe_konten').change(function(){
								var id_tipe_konten = $('#id_tipe_konten').val();
								$.ajax({
									url  	: '".site_url($this->folder.'/get_konten/')."',
									type 	: 'POST',
									data 	: 'id_tipe_konten='+id_tipe_konten,
									datatype: 'JSON',
									success	: function(data){
										$('#id_data').html(data);
									}
								});
							});
						";
		$this->load->view('umum/form_view', $data);
	}

	public function simpan_data($code=NULL){
		$in = $this->input->post();
		$par = array(
			'tabel'=>'ids_konten',
			'data'=>array(
				'judul'=>$in['judul'],
				'id_tipe_konten'=>$in['id_tipe_konten'],
				'id_data'=>$in['id_data'],
				'durasi'=>$in['durasi']
				),
			);
		if($code!=NULL){
			$p = un_de($code);
			$id_konten = $p['id_konten'];
			$par['where'] = array('id_konten'=>$id_konten);
		}else{
			$cek_urutan = $this->general_model->datagrab(array('tabel'=>'ids_konten', 'select'=>'urut', 'order'=>'urut desc', 'limit'=>1, 'offset'=>0));
			if($cek_urutan->num_rows() > 0){
				$urut = $cek_urutan->row('urut')+1;
			}else{
				$urut = 1;
			}
 			$par['data']['urut'] = $urut;
		}
		$sef_peng = $this->general_model->save_data($par);
		if($sef_peng){
			$this->session->set_flashdata('ok', 'Konten berhasil disimpan');
		}else{
			$this->session->set_flashdata('fail', 'Konten gagal disimpan');
		}
		redirect($this->dir);
	}

	function delete_data($code=NULL){
		$p = un_de($code);
		$del_peng = $this->general_model->delete_data('ids_konten', 'id_konten', $p['id_konten']);
		if($del_peng){
			$this->session->set_flashdata('ok', 'Widget berhasil dihapus');
		}else{
			$this->session->set_flashdata('fail', 'Widget gagal dihapus');
		}
		redirect($this->dir);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {
	var $dir = 'sitika/categories';

	function __construct() {
		parent::__construct();
		//$this->load->model('sitika/category_model');
		
		$jenis = $this->session->userdata('username');
		if(!empty($jenis)){
			$jenis = $jenis;
		}else{
			$jenis = null;
		}
		
		login_check($jenis);
		
		$code = $this->session->userdata('role');
		/*if($this->session->userdata('id_role') != '1'){
			if(!in_array($this->uri->segment(4),@unserialize($code[0]))) {
				$this->session->set_flashdata('msg','Maaf, sepertinya Anda tidak memiliki hak akses terhadap halaman ini.');
				redirect('sitika/error/');
			}
		}*/
	}
	
	public function index() {
		$this->list_data();
	}
	
	function list_data($sec, $offset = null, $id = null,$search=null){
		$tipe = array(
					'1' => 'Berita',
					'2' => 'Artikel',
					'3' => 'Agenda',
					'4' => 'Pengumuman',
					'5' => 'Teks Bergerak',
					'6' => 'Slideshow',
					'7' => 'Personel',
					'8' => 'Download',
					'9' => 'Pengaturan',
					'10' => 'Galeri',
					'11' => 'Halaman',
					'12' => 'Tautan',
					'14' => 'Lowongan Kerja',
					'15' => 'Forum',
					'16' => 'Jurnal');
		
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'category' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['category'];
		} else if ($search) {
			$fcari=$search;
			$data['for_search'] = $fcari['category'];
		}
		$config['base_url'] 	= site_url('sitika/categories/list_data/'.$sec);
		

        $config['total_rows'] 	= $this->general_model->datagrab(array(
					'tabel' => 'sitika_categories',
					'where' => array('code' => $sec)
				))->num_rows();
        $config['per_page'] 	= '10';
		$config['uri_segment'] 	= '5';
        $this->pagination->initialize($config);
       	$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$st = get_stationer();
 		$data_tabel= $this->general_model->datagrab(array('tabel'=>'sitika_categories', 'order'=>'id_cat DESC','where'=>array('code'=>$sec),'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));
		
		if ($data_tabel->num_rows() > 0) {

			$heads[]= array('data' => 'No ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Kategori','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Slug','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => 'Aksi ','colspan' => 2,'style'=>'background:#f4f4f4;');
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);
			$bln = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			$no = 1 + $offset;
			foreach ($data_tabel->result() as $row) {

				$rows = array(
					array('data' => $no)
				);
				$rows[] = array(
					'data' =>$row->category);
				$rows[] = array(
					'data' =>$row->slug);
				

				if (!in_array($offset,array("cetak","excel"))) {
					$ubah = anchor('#', '<i class="fa fa-pen"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/add_cat/'.$sec.'/'.$row->id_cat).'" title="Edit Data Agenda Kegiatan..."');
					/*$ubah = anchor($this->dir.'/add_cat/'.$sec.'/'.$row->id_cat,'<i class="fa fa-pen"></i>','
						class="btn btn-xs btn-flat btn-warning"	title="Edit Data Agenda Kegiatan..."');
*/

					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.$sec.'/'.$row->id_cat).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					
					$rows[] = 	$ubah;
					$rows[] = 	$hapus;
				}
				$this->table->add_row($rows);
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}

		//$btn_tambah = anchor($this->dir.'/add_cat/'.$sec,'<i class="fa fa-plus fa-btn"></i> Kategori','class="btn btn-success btn-flat"	title="Klik untuk tambah data"');
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Kategori', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_cat/'.$sec).'" title="Klik untuk tambah data"');
		


		$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
		$data['extra_tombol'] = 
				form_open($this->dir.'/list_data/'.$sec,'id="form_search" role="form"').
				'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>'.
				form_close();

		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
       
		$data['title'] = 'Manajemen Kategori '.$sec;
		
		
		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		$title = 'Data Kategori Berita';
		
		if ($offset == "cetak") {
			$data['title'] = '<h3>'.$title.'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print',$data);
		} else if ($offset == "excel") {
			$data['file_name'] = $title.'.xls';
			$data['title'] = '<h3>'.$data['title'].'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel',$data);
		} else {
			$data['title'] 		= $title;
			$data['tabel'] = $tabel;
			$data['content'] = 'umum/standard_view';
			$this->load->view('home', $data);
		}
	}
	
	function add_cat($sec,$id=null){
		$tipe = array(
					'1' => 'Berita',
					'2' => 'Artikel',
					'3' => 'Agenda',
					'4' => 'Pengumuman',
					'5' => 'Teks Bergerak',
					'6' => 'Slideshow',
					'7' => 'Personel',
					'8' => 'Download',
					'9' => 'Pengaturan',
					'10' => 'Galeri',
					'11' => 'Halaman',
					'12' => 'Tautan',
					'14' => 'Lowongan Kerja',
					'15' => 'Forum',
					'16' => 'Jurnal');
		
		$combo_parent_cat = $this->general_model->combo_box(array('tabel' => 'sitika_categories','key' => 'id_cat','where'=>array('code'=>$sec),'val' => array('category')));
		$judul 				= !empty($id) ? "Ubah" : "Tambah Berita Baru";
      	

		$data['sec']		= $sec;
		$data['selected_parent']= $this->general_model->datagrab(array(
					'tabel' => 'sitika_categories',
					'where' => array('id_cat' => $id)
				))->row();
		$data['title'] 		= $judul;
		$data['id']			= $id;

		$data['title'] = (!empty($code)) ? 'Ubah Data Kategori' : 'Kategori Baru';
		
			$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => 'sitika_categories',
					'where' => array('id_cat' => $id)))->row() : null;
		
		$data['form_link'] = $this->dir.'/save_cat/'.$sec.'/'.$id;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_cat" class="id_cat" value="'.$id .'"/>';
		$data['form_data'] .= '<input type="hidden" name="code" class="code" value="'.$sec .'"/>';
		$data['form_data'] .= '<div class="row"><div class="col-lg-4">';
		$data['form_data'] .= '<label>Kategori</label>';
		$data['form_data'] .= form_input('category', @$dt->category,'class="form-control" placeholder="berita pemerintah" required');
		/*$data['form_data'] .= '<p></p>';
		$data['form_data'] .= '<label>Slug</label>';
		$data['form_data'] .= form_input('slug', @$dt->slug,'class="form-control" placeholder="berita-pemerintah"');*/
		$data['form_data'] .= '<p></p>';
		$data['form_data'] .= '<label>Parent</label>';
		$data['form_data'] .= form_dropdown('id_cat_parent', @$combo_parent_cat,@$dt->id_cat_parent,'class="form-control combo-box"  style="width: 100%" id="id_cat_parent"');
		$data['form_data'] .= '</div></div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		$this->load->view('umum/form_view', $data);


	}
	
	//new select where kategori//
	function save_cat($sec){
		$id_cat = $this->input->post('id_cat');
		//$category = $this->input->post('category');
		/*cek($sec);
		cek($category);
		die();*/
		if($this->input->post('slug')==null){
			$judule = str_replace(array('(',')','_','/','\\','*','&','+','#','@','~','!','%','$','?',';',':','^',' '), ('-'), $this->input->post('category'));
			$slug = str_replace(array('--','---','----','-----'), ('-'), $judule);
		}else {
			$judule = str_replace(array('(',')','_','/','\\','*','&','+','#','@','~','!','%','$','?',';',':','^',' '), ('-'), $this->input->post('slug'));
			$slug = str_replace(array('--','---','----','-----','------'), ('-'), $judule);
		}
		$par2 = array(
			'tabel'=>'sitika_categories',
			'data'=>array(
				'code'=>$this->input->post('code'),
				'category'=>$this->input->post('category'),
				'slug'=>$slug,
				'id_cat_parent'=>$this->input->post('id_cat_parent')
				),
			);
		if($id_cat!=NULL){
			$par2['where'] = array('id_cat'=>$id_cat);
		}

		$simpan = $this->general_model->save_data($par2);

		if($simpan) $this->session->set_flashdata('msg','Data berhasil disimpan...');
		else $this->session->set_flashdata('msg','Data gagal disimpan...');
		
		redirect($this->dir.'/list_data/'.$sec);
	}
	//end version//
	
	function save_cat_flash($sec=null){

		if($this->input->post('slug')==null){
			$extends = @serialize($_POST['kolom_tambahan']);
			$judule = str_replace(array('(',')','_','/','\\','*','&','+','#','@','~','!','%','$','?',';',':','^',' '), ('-'), $this->input->post('category'));
			$slug = str_replace(array('--','---','----','-----'), ('-'), $judule);
			//$data = array('code'=>$sec,'category'=>$this->input->post('category'),'slug'=>$this->input->post('slug'),'id_cat_parent'=>$this->input->post('parent_cat'),'extends_cat'=>$extends);
		}else{
			$judule = str_replace(array('(',')','_','/','\\','*','&','+','#','@','~','!','%','$','?',';',':','^',' '), ('-'), $this->input->post('slug'));
			$slug = str_replace(array('--','---','----','-----','------'), ('-'), $judule);
		}

		$extends = @serialize($_POST['kolom_tambahan']);
		if($sec == '7'){
			$par2 = array(
				'tabel'=>'sitika_categories',
				'data'=>array(
					'code'=>$this->input->post('code'),
					'category'=>$this->input->post('category'),
					'slug'=>$slug,
					'id_cat_parent'=>$this->input->post('id_cat_parent')
					),
				);
		}else{
			$par2 = array(
				'tabel'=>'sitika_categories',
				'data'=>array(
					'code'=>$this->input->post('code'),
					'category'=>$this->input->post('category'),
					'slug'=>$slug,
					'extends_cat'=>$extends,
					'id_cat_parent'=>$this->input->post('id_cat_parent')
					),
				);

		}		
		$simpan = $this->general_model->save_data($par2);		
		die(json_encode(array('sign' => '1','pesan'=>'Kategori berhasil ditambahkan')));
	}
	
	function refresh_cat($sec,$id=null){
		$data['category_checked']   = !empty($id) ? $this->article_model->category_checked($id) : null;
		$this->load->view('sitika/category_list', $data);
	}
	
	function list_parent_cat($sec=NULL){		
		$comnbo_parent_cat = array();
		$combo_parent_cat['0'] = '- Pilih -';
		$xx=$this->general_model->datagrab(array('tabel' => 'sitika_categories', 'where'=>array('code'=>$sec)));

		foreach($xx->result() as $row){
			$combo_parent_cat[$row->id_cat] = $row->category;		}
		
		$data['combo_parentcat']= $combo_parent_cat;
		$this->load->view('sitika/category_parent',$data);
	}
	
	function delete_data($sec,$id){

		$in_cek = @$_POST['cek'];
		
		if(empty($in_cek)) $hapus = $this->general_model->delete_data('sitika_categories','id_cat',$id);
		else foreach($in_cek as $id){$hapus = $this->general_model->delete_data('sitika_categories','id_cat',$id);}
		
		if($hapus) $this->session->set_flashdata('msg','Data berhasil dihapus...');
		else $this->session->set_flashdata('msg','Data gagal dihapus...');
		
		redirect($this->dir.'/list_data/'.$sec);
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_ajax extends CI_Controller {
	var $dir = 'siatika/data_ajax';
	var $folder = 'siatika';

	function __construct() {
		parent::__construct();
		$this->in_app = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
		$this->load->library('ajax_pagination_widget');
		// $this->load->library(array(
		// 	'ajax_pagination_widget','ajax_pagination_jadwal','ajax_pagination_jadwal_bd','ajax_pagination_jadwal_bs','ajax_pagination_widget','ajax_pagination_widget','ajax_pagination_widget','ajax_pagination_satyalencana'
		// 	,'ajax_pagination_surat_masuk','ajax_pagination_surat_keluar','Ajax_pagination_infotamu_hadir', 'ajax_pagination_widget'));
		$this->load->helper('ids');
		$this->load->helper('cmd');

	}

	// public function index() {
	// 	echo "INDEX";
	// }

	// view data galeri
	
	function lap_pegawai($target, $post, $id_konten, $jeda_dalam, $link_func='PostForm', $offset=0){
		// cek($target);
		// cek($post);
		// cek($id_konten);
		// cek($jeda_dalam);
		// cek($link_func);
		// cek($offset);
		// die();
		if($id_konten!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_konten)
			))->row();
			// cek($en);
		}else{
			$en = NULL;
		}

		$id_unit = 3;
		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post($post);
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $kolom = array(0=>'nama', 'ttl', 'nip', 'golru', 'jabatan', 'mkg', 'diklat', 'pendidikan', 'usia');

	    $data['search'] = array(
								'baris' => 0,
								'tgl_cetak' => (@$en->param1!=NULL) ? tanggal_php($en->param1) : date('Y-m-d'),
								'penetap' => 1,
								'kolom' => $kolom,
								'id' => (@$en->param3!=NULL) ? $en->param3 : 1
		);
	    
				 $from = array(
		            'peg_pegawai a' => '',
		            'ref_unit b' => array('b.id_unit = a.id_unit','left'),
		            'ref_bidang c' => array('c.id_bidang = a.id_bidang','left'),
		            'ref_jabatan d' => array('d.id_jabatan = a.id_jabatan','left'),
		            'ref_eselon e' => array('e.id_eselon = a.id_eselon','left'),
		            'ref_jenis_kelamin f' => array('f.id_jeniskelamin = a.id_jeniskelamin','left'),
		            'ref_agama g' => array('g.id_agama = a.id_agama','left'),
		            'ref_status_pegawai h' => array('h.id_status_pegawai = a.id_status_pegawai','left'),
		        );
				
        		$select = '*,a.alamat as lamat';
				$where = array('a.id_status_pegawai != 7  AND a.id_status_pegawai !=0'=>NULL);
				if($id_unit != NULL ){
					$where = array('a.id_status_pegawai != 7  AND a.id_status_pegawai !=0'=>NULL, 'b.id_unit' => $id_unit);
				}
				
				

		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => $where))->num_rows();

			// cek($total_rows);
		$config_widget['target']      = '#'.$target;
        $config_widget['base_url']    = base_url($this->dir.'/lap_pegawai/'.$target.'/'.$post.'/'.$id_konten.'/'.$jeda_dalam.'/'.$link_func);
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = 9;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
		
		$this->ajax_pagination_widget->initialize($config_widget);

		$dtduk = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => 'a.nama',
			'where' => $where));
		// cek($offset);
		// cek($dtduk->result());

		$border = 'border="1"';

		$this->table->set_template(array('table_open'=>'<table style="'.$te.'" class="table no-fluid table-bordered tabel_print on-fittop" width="100%" '.$border.'>'));
		$head = array(array('data' => 'NO', 'class' => 'add_th bg-gray'));
		$s = 1;

		
		$data['dtduk'] = $dtduk;
		$data['target'] = $target;
		$data['paging_sub'] = $this->ajax_pagination_widget->create_links($jeda_dalam, $post);

		$this->load->view($this->folder.'/widget_duk_ajax',$data);
	}

	function galeri($target, $post, $id_konten, $jeda_dalam, $link_func='PostForm', $offset=0){
		if($id_konten!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_konten)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post($post);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    // golek posisi widget aktif
	    if(count($en) > 0) $data['set'] = $this->general_model->datagrab(array(
	    	'tabel'=>'ids_setting',
	    	'where'=>array('id_ids'=>$en->id_ids, 'posisi'=>$en->posisi)
	    	))->row();

	    $data['jeda_dalam'] = $jeda_dalam;

	    
	   	$from = array(
			'sitika_foto a' => '',
		);
		$select = '*';
		//$where = ;
		$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
					'where' => array('id_konten' => $id_konten, 'status'=>1)
				))->row();
		// cek($en);
				
		 $where = !empty($en) && $en->param1 != 3 ? array('a.status'=>2) : null;
				

		// $per_page = (@$en->per_page!=NULL) ? $en->per_page : 1;
		$per_page = 1;
		// cek($per_page);
		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => $where))->num_rows();

		$config_widget['target']      = '#'.$target;
        $config_widget['base_url']    = base_url($this->dir.'/galeri/'.$target.'/'.$post.'/'.$id_konten.'/'.$jeda_dalam.'/'.$link_func);
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = 9;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
		
		$this->ajax_pagination_widget->initialize($config_widget);

		$dt_widget = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => 'urut ASC',
			'where' => $where));
		// cek($offset);
		// cek($dt_widget->result());
		
		if ($dt_widget->num_rows() > 0) {
			$heads3[]= array('data' => 'No ');
			$heads3[] = array('data' => 'Judul');
			$heads3[] = array('data' => 'Tgl Upload','style'=>'');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-striped table-responsive " style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads3);

			$no = 1+$offset;
			foreach ($dt_widget->result() as $row) {
				$rows = array();
				$rows[] = 	array('data'=>$no);
				$rows[] =  array('data' => '<marquee scrolldelay="200">'.$row->judul.'</marquee>');
				$rows[] = 	tanggal($row->tanggal);
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		

		$from_setting = array(
					'ids_konten a' => '',
					'ids c' => array('c.id_ids = a.id_ids','left'),
					'ids_setting b' => array('b.id_ids = c.id_ids','left'),
		);

		if(count($en) > 0) $cek_id_ids = $this->general_model->datagrab(array('tabel' => $from_setting,
					'select' => '','where'=>array('a.id_konten'=>$en->id_konten)))->row();

		if(isset($cek_id_ids)) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
			'select' => '','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

		$data['height_kolom'] = @$cek_ids->tinggi - 50;
		$data['page']= $page;
		$data['dt_widget'] = $dt_widget;
		$data['total_rows'] = $total_rows;


		$data['offset'] = $offset;
		if(isset($cek_id_ids)){
			$data['set_widget_1'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>1)))->row();
			$data['set_widget_2'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>2)))->row();
			$data['set_widget_3'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>3)))->row();
			$data['set_widget_4'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>4)))->row();
			$data['set_widget_5'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>5)))->row();
			$data['set_widget_6'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>6)))->row();
		}
		


		$data['id_kontent'] = @$en->id_konten;
		$data['tabel'] = $tabel;
		$data['target'] = $target;
		$data['paging_sub'] = $this->ajax_pagination_widget->create_links($jeda_dalam, $post);

		$this->load->view($this->folder.'/load_galeri',$data);
	}



	function lap_informasi($target, $post, $id_konten, $jeda_dalam, $link_func='PostForm', $offset=0){
		// cek($target);
		// cek($post);
		// cek($id_konten);
		// cek($jeda_dalam);
		// cek($link_func);
		// cek($offset);
		// die();
		if($id_konten!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_konten)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post($post);
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $kolom = array(0=>'nama', 'ttl', 'nip', 'golru', 'jabatan', 'mkg', 'diklat', 'pendidikan', 'usia');

	    $data['search'] = array(
								'baris' => 0,
								'tgl_cetak' => (@$en->param1!=NULL) ? tanggal_php($en->param1) : date('Y-m-d'),
								'penetap' => 1,
								'kolom' => $kolom,
								'id' => (@$en->param3!=NULL) ? $en->param3 : 1
							);
	    
				 $from = array(
		            'sitika_articles a' => '');
				
        		$select = 'a.*';
				$where = array('a.status'=>1,'a.code'=>1,'id_kategori'=>$en->id_kategori);
				
				

		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => $where))->num_rows();

		$config_widget['target']      = '#'.$target;
        $config_widget['base_url']    = base_url($this->dir.'/lap_informasi/'.$target.'/'.$post.'/'.$id_konten.'/'.$jeda_dalam.'/'.$link_func);
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = 9;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
		
		$this->ajax_pagination_widget->initialize($config_widget);

		$dtduk = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => 'a.date_start DESC',
			'where' => $where));
		// cek($offset);

		$border = 'border="1"';

		$this->table->set_template(array('table_open'=>'<table style="'.$te.'" class="table no-fluid table-bordered tabel_print on-fittop" width="100%" '.$border.'>'));
		$head = array(array('data' => 'NO', 'class' => 'add_th bg-gray'));
		$s = 1;

		$from_setting = array(
					'ids_konten a' => '',
					'ids c' => array('c.id_ids = a.id_ids','left'),
					'ids_setting b' => 'b.id_ids = c.id_ids',
		);

		$cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
			'select' => '','where'=>array('id_ids'=>@$en->id_ids,'posisi'=>@$en->posisi)))->row();

		$data['height_kolom'] = @$cek_ids->tinggi;
		$data['font_size'] = @$en->param2;
		$data['dtduk'] = $dtduk;
		$data['target'] = $target;
		$data['paging_sub'] = $this->ajax_pagination_widget->create_links($jeda_dalam, $post);

		$this->load->view($this->folder.'/widget_informasi_ajax',$data);
	}


	function lap_agenda($target, $post, $id_konten, $jeda_dalam, $link_func='PostForm', $offset=0){
		// cek($target);
		// cek($post);
		// cek($id_konten);
		// cek($jeda_dalam);
		// cek($link_func);
		// cek($offset);
		// die();
		if($id_konten!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_konten)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post($post);
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $kolom = array(0=>'nama', 'ttl', 'nip', 'golru', 'jabatan', 'mkg', 'diklat', 'pendidikan', 'usia');

	    $data['search'] = array(
								'baris' => 0,
								'tgl_cetak' => (@$en->param1!=NULL) ? tanggal_php($en->param1) : date('Y-m-d'),
								'penetap' => 1,
								'kolom' => $kolom,
								'id' => (@$en->param3!=NULL) ? $en->param3 : 1
							);
	    
				 $from = array(
		            'sitika_articles a' => '');
				
        		$select = 'a.*';
				$where = array('a.status'=>1,'a.code'=>3,'id_kategori'=>$en->id_kategori);
				
				

		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => $where))->num_rows();

		$config_widget['target']      = '#'.$target;
        $config_widget['base_url']    = base_url($this->dir.'/lap_agenda/'.$target.'/'.$post.'/'.$id_konten.'/'.$jeda_dalam.'/'.$link_func);
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = 9;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
		
		$this->ajax_pagination_widget->initialize($config_widget);

		$dtduk = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => 'a.date_start DESC',
			'where' => $where));
		// cek($offset);

		$border = 'border="1"';

		$this->table->set_template(array('table_open'=>'<table style="'.$te.'" class="table no-fluid table-bordered tabel_print on-fittop" width="100%" '.$border.'>'));
		$head = array(array('data' => 'NO', 'class' => 'add_th bg-gray'));
		$s = 1;

		$from_setting = array(
					'ids_konten a' => '',
					'ids c' => array('c.id_ids = a.id_ids','left'),
					'ids_setting b' => 'b.id_ids = c.id_ids',
		);

		$cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
			'select' => '','where'=>array('id_ids'=>@$en->id_ids,'posisi'=>@$en->posisi)))->row();

		$data['height_kolom'] = @$cek_ids->tinggi;
		$data['font_size'] = @$en->param2;
		$data['dtduk'] = $dtduk;
		$data['target'] = $target;
		$data['paging_sub'] = $this->ajax_pagination_widget->create_links($jeda_dalam, $post);

		$this->load->view($this->folder.'/widget_agenda_ajax',$data);
	}
	function lap_pengumuman($target, $post, $id_konten, $jeda_dalam, $link_func='PostForm', $offset=0){
		// cek($target);
		// cek($post);
		// cek($id_konten);
		// cek($jeda_dalam);
		// cek($link_func);
		// cek($offset);
		// die();
		if($id_konten!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_konten)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post($post);
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $kolom = array(0=>'nama', 'ttl', 'nip', 'golru', 'jabatan', 'mkg', 'diklat', 'pendidikan', 'usia');

	    $data['search'] = array(
								'baris' => 0,
								'tgl_cetak' => (@$en->param1!=NULL) ? tanggal_php($en->param1) : date('Y-m-d'),
								'penetap' => 1,
								'kolom' => $kolom,
								'id' => (@$en->param3!=NULL) ? $en->param3 : 1
							);
	    
				 $from = array(
		            'sitika_articles a' => '');
				
        		$select = 'a.*';
				$where = array('a.status'=>1,'a.code'=>4,'id_kategori'=>$en->id_kategori);
				
				

		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => $where))->num_rows();

		$config_widget['target']      = '#'.$target;
        $config_widget['base_url']    = base_url($this->dir.'/lap_agenda/'.$target.'/'.$post.'/'.$id_konten.'/'.$jeda_dalam.'/'.$link_func);
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = 9;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
		
		$this->ajax_pagination_widget->initialize($config_widget);

		$dtduk = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => 'a.date_start DESC',
			'where' => $where));
		// cek($offset);

		$border = 'border="1"';

		$this->table->set_template(array('table_open'=>'<table style="'.$te.'" class="table no-fluid table-bordered tabel_print on-fittop" width="100%" '.$border.'>'));
		$head = array(array('data' => 'NO', 'class' => 'add_th bg-gray'));
		$s = 1;

		$from_setting = array(
					'ids_konten a' => '',
					'ids c' => array('c.id_ids = a.id_ids','left'),
					'ids_setting b' => 'b.id_ids = c.id_ids',
		);

		$cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
			'select' => '','where'=>array('id_ids'=>@$en->id_ids,'posisi'=>@$en->posisi)))->row();

		$data['height_kolom'] = @$cek_ids->tinggi;
		$data['font_size'] = @$en->param2;
		$data['dtduk'] = $dtduk;
		$data['target'] = $target;
		$data['paging_sub'] = $this->ajax_pagination_widget->create_links($jeda_dalam, $post);

		$this->load->view($this->folder.'/widget_pengumuman_ajax',$data);
	}

	//video
	function lap_video($target, $post, $id_konten, $jeda_dalam, $link_func='PostForm', $offset=0){
		if($id_konten!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_konten)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post($post);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    // golek posisi widget aktif
	    if(count($en) > 0) $data['set'] = $this->general_model->datagrab(array(
	    	'tabel'=>'ids_setting',
	    	'where'=>array('id_ids'=>$en->id_ids, 'posisi'=>$en->posisi)
	    	))->row();

	    
	   	$from = array(
			'sitika_video a' => '',
		);
		$select = '*';
		//$where = ;
		$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
					'where' => array('id_konten' => $id_konten, 'status'=>1)
				))->row();
		// cek($en);
				
		 $where = !empty($en) && $en->param1 != 3 ? array('a.status'=>2) : null;
				

		// $per_page = (@$en->per_page!=NULL) ? $en->per_page : 1;
		$per_page = 1;
		// cek($per_page);
		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => array('a.status'=>2)))->num_rows();

		$dt_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => array('a.status'=>2)))->row();

	    $data['jeda_dalam'] = $total_rows;

		$config_widget['target']      = '#'.$target;
        $config_widget['base_url']    = base_url($this->dir.'/lap_video/'.$target.'/'.$post.'/'.$id_konten.'/'.$jeda_dalam.'/'.$link_func);
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = 9;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
		
		$this->ajax_pagination_widget->initialize($config_widget);

		$dt_widget = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => 'a.tanggal, a.id_video DESC',
			'where' => $where));
		// cek($offset);
		// cek($dt_widget->result());
		
		if ($dt_widget->num_rows() > 0) {
			$heads3[]= array('data' => 'No ');
			$heads3[] = array('data' => 'Judul');
			$heads3[] = array('data' => 'Tgl Upload','style'=>'');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-striped table-responsive " style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads3);

			$no = 1+$offset;
			foreach ($dt_widget->result() as $row) {
				$rows = array();
				$rows[] = 	array('data'=>$no);
				$rows[] =  array('data' => '<marquee scrolldelay="200">'.$row->judul.'</marquee>');
				$rows[] = 	tanggal($row->tanggal);
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		

		$from_setting = array(
					'ids_konten a' => '',
					'ids c' => array('c.id_ids = a.id_ids','left'),
					'ids_setting b' => array('b.id_ids = c.id_ids','left'),
		);

		$cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
			'select' => '','where'=>array('id_ids'=>@$en->id_ids,'posisi'=>@$en->posisi)))->row();

		$data['height_kolom'] = @$cek_ids->tinggi-40;
		$data['page']= $page;
		$data['dt_widget'] = $dt_widget;
		$data['total_rows'] = $total_rows;


		$data['offset'] = $offset;
		if(isset($cek_id_ids)){
			$data['set_widget_1'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>1)))->row();
			$data['set_widget_2'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>2)))->row();
			$data['set_widget_3'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>3)))->row();
			$data['set_widget_4'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>4)))->row();
			$data['set_widget_5'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>5)))->row();
			$data['set_widget_6'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>6)))->row();
		}
		


		$data['id_kontent'] = @$en->id_konten;
		$data['tabel'] = $tabel;
		$data['target'] = $target;
		$data['paging_sub'] = $this->ajax_pagination_widget->create_links($jeda_dalam, $post);

		$this->load->view($this->folder.'/widget_video_ajax',$data);
	}

	//runing
	function runningtext($target, $post, $id_konten, $jeda_dalam, $link_func='PostForm', $offset=0){
		if($id_konten!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_konten)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post($post);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    // golek posisi widget aktif
	    if(count($en) > 0) $data['set'] = $this->general_model->datagrab(array(
	    	'tabel'=>'ids_setting',
	    	'where'=>array('id_ids'=>$en->id_ids, 'posisi'=>$en->posisi)
	    	))->row();

	    
	   	$from = array(
			'sitika_running_text a' => '',
		);
		$select = '*';
		//$where = ;
		$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
					'where' => array('id_konten' => $id_konten, 'status'=>1)
				))->row();
		// cek($en);
				
		 $where = !empty($en) && $en->param1 != 3 ? array('a.status'=>2) : null;
				

		
		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 1;

		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => array('a.status'=>2)))->num_rows();

		$dt_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => array('a.status'=>2)))->row();

	    $data['jeda_dalam'] = $total_rows;

		$config_widget['target']      = '#'.$target;
        $config_widget['base_url']    = base_url($this->dir.'/runningtext/'.$target.'/'.$post.'/'.$id_konten.'/'.$jeda_dalam.'/'.$link_func);
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = 9;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
		
		$this->ajax_pagination_widget->initialize($config_widget);

		$dt_widget = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => 'a.id_running_text',
			'where' => $where));
		
		$from_setting = array(
					'ids_konten a' => '',
					'ids c' => array('c.id_ids = a.id_ids','left'),
					'ids_setting b' => array('b.id_ids = c.id_ids','left'),
		);

		$cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
			'select' => '','where'=>array('id_ids'=>@$en->id_ids,'posisi'=>@$en->posisi)))->row();

		$data['height_kolom'] = @$cek_ids->tinggi-40;
		$data['page']= $page;
		$data['dt_widget'] = $dt_widget;
		$data['total_rows'] = $total_rows;


		$data['offset'] = $offset;
		if(isset($cek_id_ids)){
			$data['set_widget_1'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>1)))->row();
			$data['set_widget_2'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>2)))->row();
			$data['set_widget_3'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>3)))->row();
			$data['set_widget_4'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>4)))->row();
			$data['set_widget_5'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>5)))->row();
			$data['set_widget_6'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$cek_id_ids->id_ids, 'posisi'=>6)))->row();
		}
		


		$data['id_kontent'] = @$en->id_konten;
		$data['target'] = $target;
		$data['paging_sub'] = $this->ajax_pagination_widget->create_links($jeda_dalam, $post);

		$this->load->view($this->folder.'/load_teks',$data);
	}


}
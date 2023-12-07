<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class View extends CI_Controller {
	var $dir = 'siatika/view';
	var $folder = 'siatika';
	var $paging = null;
	function __construct() {
		parent::__construct();
		$this->load->library('ajax_pagination_widget');
		// $this->load->library('ajax_pagination_widget2');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index() {
		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload',
			'reload_konten','reload_slide1', 'reload_slide2', 'speed_run_text', 'height_konten',
			'height_sidebar_1','height_sidebar_2','header_color','basic_color','color_text_header','color_text_basic',
			'title_color','color_text_title','column_color','color_text_column','galeri_color','color_text_galeri','time_color',
			'color_text_time','date_color','color_text_date','marquee_color','color_text_marquee'),2);
		$data['dir'] = $this->dir;
		$data['folder'] = $this->folder;
		$this->load->view($this->folder.'/ids_view', $data);
	}

	public function tv($code=NULL){
		
		
		$o=$code;
		$dt = $this->general_model->datagrab(array('tabel'=>'ids', 'where'=>array('permalink'=>$code) ))->row();

		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload',
			'reload_konten','reload_slide1', 'reload_slide2', 'speed_run_text', 'height_konten',
			'height_sidebar_1','height_sidebar_2','header_color','basic_color','color_text_header','color_text_basic',
			'title_color','color_text_title','column_color','color_text_column','galeri_color','color_text_galeri','time_color',
			'color_text_time','date_color','color_text_date','marquee_color','color_text_marquee'),2);
		$data['dir'] = $this->dir;
		$data['folder'] = $this->folder;
		$data['title'] = $dt->nama_ids;
		$data['id_ids'] = $dt->id_ids;
		$data['app'] = $dt->nama_ids;

		$data['set_warna_latar'] = $this->general_model->datagrab(array('tabel'=>'ids', 'where'=>array('id_ids'=>$dt->id_ids)))->row();



		$data['set_widget_1'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$dt->id_ids, 'posisi'=>1)))->row();
		$data['set_widget_2'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$dt->id_ids, 'posisi'=>2)))->row();
		$data['set_widget_3'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$dt->id_ids, 'posisi'=>3)))->row();
		$data['set_widget_4'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$dt->id_ids, 'posisi'=>4)))->row();
		$data['set_widget_5'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$dt->id_ids, 'posisi'=>5)))->row();
		$data['set_widget_6'] = $this->general_model->datagrab(array('tabel'=>'ids_setting', 'where'=>array('id_ids'=>$dt->id_ids, 'posisi'=>6)))->row();



		$data['all_reload'] = $this->general_model->datagrab(array('tabel'=>'ids', 'where'=>array('id_ids'=>$dt->id_ids)))->row();
		$from_run = array(
			'sitika_running_text a' => '',
		);
		$runing = $this->general_model->datagrab(array(
							'tabel' => $from_run,
							'select' => '*',
							'where' => array('a.status'=>2),
							'order' => 'urut asc'
					)
				);
		// var_dump($runing->result());
		// var_dump($this->db->last_query());

		$data['runing']=$runing;
		if($dt->id_theme == 1){
			$this->load->view($this->folder.'/ids_view_satu', $data);
		}elseif($dt->id_theme == 2){
			$this->load->view($this->folder.'/ids_view_dua', $data);			
		}elseif($dt->id_theme == 3){
			$this->load->view($this->folder.'/ids_view_tiga', $data);			
		}elseif($dt->id_theme == 4){
			$this->load->view($this->folder.'/ids_view_empat', $data);			
		}elseif($dt->id_theme == 5){
			$this->load->view($this->folder.'/ids_view_lima', $data);			
		}else{
			$this->load->view($this->folder.'/ids_view_default', $data);			
		}
	}

	function teksbergerak() {

		$par = $this->general_model->get_param(array('pemerintah_logo','instansi'),2);
		$mar = $this->general_model->datagrab(
			array(
				'tabel'		=> 'info_text',
				'where'		=> array(
					'status'	=> '1'),
				'order'		=> 'urut asc' ));
		
		echo '
		<marquee class="marquee-box">
		<div>'; 
				//$path_inst_logo = !empty($par['pemerintah_logo']) ? FCPATH.'logo/'.$par['pemerintah_logo'] : null;
				$path_inst_logo = !empty($par['pemerintah_logo']) ? base_url().'logo/'.$par['pemerintah_logo'] : null;
				$logo_instansi = (file_exists($path_inst_logo) and !empty($par['pemerintah_logo'])) ? base_url().'logo/'.$par['pemerintah_logo'] : base_url().'assets/logo/brand.png';
				$j = 1;
				foreach($mar->result() as $m) {
					$star = ($j > 1) ? '&nbsp;&nbsp;<img src="'.$logo_instansi.'" height="50">&nbsp;&nbsp; ': null;
					echo '<b>'.$star.@$m->teks.'</b>';
					$j++;
				}
		echo '
		</div></marquee>';
	}


	function load_data_form($posisi, $target, $post, $id_ids, $target_ids, $link_func, $target_luar, $konten=0, $form_widget=0){
		// cek($posisi);
		// cek($target);
		// cek($post);
		// cek($id_ids);
		// cek($target_ids);
		// cek($link_func);
		// cek($target_luar);
		// cek($id_ids);
		// cek($konten);
		// cek($posisi);
		// die();
		$page = $this->input->post($post, TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $where = array('posisi' => $posisi, 'id_ids'=>$id_ids);
        if($konten > 0) $where['id_konten'] = $konten;
        if($form_widget == 0) $where['status'] = 1;
        if($form_widget == 0) $where['(mulai_tayang <= "'.date('Y-m-d').'" AND selesai_tayang >= "'.date('Y-m-d').'")'] = null;

		$dt_widget = $this->general_model->datagrab(array(
			'tabel'=> 'ids_konten',
			'where' => $where,
			'limit' => 1,
			'offset'=>$offset,
			'order' => 'urut asc'));

		$tot_widget = $this->general_model->datagrab(array(
					'tabel'=> 'ids_konten',
					// 'where' => array('posisi' => $posisi, 'status'=>1, 'id_ids'=>$id_ids),
					'where' => $where))->num_rows();
		// cek($form_widget);
		// cek($dt_widget->result());

        //pagination configuration
        $config_widget['target']      = '#'.$target_luar;
        $config_widget['base_url']    = base_url($this->dir.'/load_data/'.$posisi.'/'.$target.'/'.$post.'/'.$id_ids.'/'.$target_ids.'/'.$link_func.'/'.$target_luar);
       $config_widget['total_rows']  = $tot_widget;
        $config_widget['per_page']    = 1;
       	$config_widget['uri_segment'] = 11;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
        
       	$this->ajax_pagination_widget->initialize($config_widget);

       	// cek($tot_widget);
       	// cek($page);
       	// cek($post);
       	// cek($dt_widget->num_rows());
		if ($dt_widget->num_rows()) {
			# code...
			$row = $dt_widget->row();
			

			$script = "";
			// $script = null;
			// $paging = $this->ajax_tvpegkes_widget->create_links($row->jeda);
			// $this->paging = $this->ajax_pagination_widget->create_links($row->jeda, $post);
			$this->unit($row->id_data, $row->id_konten, 1, $target, $post);
			// json_encode($this->unit($row->tipe, $row->id_widget));
			//cek($paging);

		}else{
			$script = "";
			$this->paging = $this->ajax_pagination_widget->create_links(5, $post);
			$this->unit($konten, null, $this->paging, $target, $post);
		}
	}


	function load_data($posisi, $target, $post, $id_ids, $target_ids, $link_func, $target_luar){
		/*cek($posisi);
		cek($target);
		cek($post);
		cek($id_ids);
		cek($target_ids);
		cek($link_func);
		cek($target_luar);
		cek($id_ids);
		cek($posisi);
		die();*/

		$page = $this->input->post($post, TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $where = array('posisi' => $posisi, 'id_ids'=>$id_ids);
        $where['status'] = 1;
       // $where['(mulai_tayang <= "'.date('Y-m-d').'" AND selesai_tayang >= "'.date('Y-m-d').'")'] = null;
		$dt_widget = $this->general_model->datagrab(array(
			'tabel'=> 'ids_konten',
			'where' => $where,
			'limit' => 1,
			'offset'=>$offset,
			'order' => 'urut asc'));

		$tot_widget = $this->general_model->datagrab(array(
					'tabel'=> 'ids_konten',
					// 'where' => array('posisi' => $posisi, 'status'=>1, 'id_ids'=>$id_ids),
					'where' => $where))->num_rows();
		// cek($form_widget);
		// cek($dt_widget->result());

        //pagination configuration
        $config_widget['target']      = '#'.$target_luar;
        $config_widget['base_url']    = base_url($this->dir.'/load_data/'.$posisi.'/'.$target.'/'.$post.'/'.$id_ids.'/'.$target_ids.'/'.$link_func.'/'.$target_luar);
       	$config_widget['total_rows']  = $tot_widget;
        $config_widget['per_page']    = 1;
       	$config_widget['uri_segment'] = 11;
       	$config_widget['link_func'] = $link_func;
       	$config_widget['pag_func'] = 'ajaxLink';
       	$config_widget['pag_name'] = $post;
        
       	$this->ajax_pagination_widget->initialize($config_widget);

       	/*cek($tot_widget);
       	cek($page);
       	cek($post);*/
       	
		if ($dt_widget->num_rows() > 0) {
			# code...
			$row = $dt_widget->row();
			

			$script = "";
			// $script = null;
			$this->unit($row->id_data, $row->id_konten, 1, $target, $post);

		}else{
			$script = "";
			// $this->paging = $this->ajax_pagination_widget->create_links(5, $post);
			$this->unit(null, null, $this->paging, $target, $post);
		}
	}
	function unit($id_data, $id = null, $paging=null, $target=null, $post){
		/*cek($id_data);
		cek($id);
		cek($paging);
		cek($target);
		cek($paging);
		die();
*/
		/*cek($id);
		die()*/
		$data['id_konten'] = $id;
		
		$data['folder'] = $this->folder;
		if (!empty($id)) {
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id)
			))->row();
		}
		$par = $this->general_model->get_param(array('height_konten','height_sidebar_1','height_sidebar_2'),2);

		$from_setting = array(
					'ids_konten a' => '',
					'ids c' => array('c.id_ids = a.id_ids','left'),
					'ids_setting b' => array('b.id_ids = c.id_ids','left'),
		);

		$cek_id_ids = $this->general_model->datagrab(array('tabel' => $from_setting,
					'select' => '*','where'=>array('a.id_konten'=>$id)))->row();
		// cek($cek_id_ids->num_rows());

			
		switch (@$id_data){

			case 1: 
				// cek($target);
				$arr_target_sub = array('postWidSatu'=>'postLapDukSatu', 'postWidDua'=>'postLapDukDua', 'postWidTiga'=>'postLapDukTiga', 'postWidEmpat'=>'postLapDukEmpat', 'postWidLima'=>'postLapDukLima');
				$arr_target_sub_ids = array('postWidSatu'=>'lap-duk-satu', 'postWidDua'=>'lap-duk-dua', 'postWidTiga'=>'lap-duk-tiga', 'postWidEmpat'=>'lap-duk-empat', 'postWidLima'=>'lap-duk-lima');
				$arr_post_sub_ids = array('postWidSatu'=>'pageLapDukSatu', 'postWidDua'=>'pageLapDukDua', 'postWidTiga'=>'pageLapDukTiga', 'postWidEmpat'=>'pageLapDukEmpat', 'postWidLima'=>'pageLapDukLima');
				$arr_func = array('postWidSatu'=>'getDataLapDukSatu', 'postWidDua'=>'getDataLapDukDua', 'postWidTiga'=>'getDataLapDukTiga', 'postWidEmpat'=>'getDataLapDukEmpat', 'postWidLima'=>'getDataLapDukLima');

				$data['target'] = '#'.$target;
				$data['target_sub'] = $arr_target_sub[$target];
				$data['target_sub_ids'] = $arr_target_sub_ids[$target];
				$data['post_sub'] = $arr_post_sub_ids[$target];
				$data['link_func'] = $arr_func[$target];
				// if(empty($data['link_func'])) $data['link_func'] = 'postWidSatu';
				$data['judul'] = (@$en->id_widget!=NULL) ? $en->judul : 'Daftar Pegawai';
				$data['tgl_cetak'] = !empty(@$en->param1)?$en->param1:date('d/m/Y');
				$data['id_unit'] = !empty($en->param3)?$en->param3:1;
				$data['limit_row'] = 0;
				$data['kolom'] = array(0=>'nama', 'ttl', 'nip', 'golru', 'jabatan', 'mkg', 'diklat', 'pendidikan', 'usia');

				$data['search'] = array(
									'baris' => $data['limit_row'],
									'tgl_cetak' => tanggal_php($data['tgl_cetak']),
									'penetap' => 1,
									'kolom' => $data['kolom'],
									'id' => $data['id_unit']
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
				

				$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => $where))->num_rows();
				$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;
				
				$total_rows = $total_rows > 0 ? $total_rows : 1;
				$jeda = !empty($en->durasi) ? intval($en->durasi): 5;
				$jeda_luar = $jeda * ceil($total_rows / $per_page);
				
				$data['paging'] = $this->paging = $this->ajax_pagination_widget->create_links($jeda_luar, $post);
				// $data['paging_dalam'] =$this->paging = $this->ajax_tvpegkes_widget->create_links($jeda_luar);

				$data['jeda_dalam'] = $jeda;
				// cek($en->durasi);
				// cek($jeda);

				if(count($cek_id_ids) > 0) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
					'select' => '*','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;
				$this->load->view($this->folder.'/widget_duk',$data);
			break;

			case 2:
			/*video*/
				$arr_target_sub = array('postWidSatu'=>'postLapVideoSatu', 'postWidDua'=>'postLapVideoDua', 'postWidTiga'=>'postLapVideoTiga', 'postWidEmpat'=>'postLapVideoEmpat', 'postWidLima'=>'postLapVideoLima');
				$arr_target_sub_ids = array('postWidSatu'=>'lap-sch-satu', 'postWidDua'=>'lap-sch-dua', 'postWidTiga'=>'lap-sch-tiga', 'postWidEmpat'=>'lap-sch-empat', 'postWidLima'=>'lap-sch-lima');
				$arr_post_sub_ids = array('postWidSatu'=>'pageLapVideoSatu', 'postWidDua'=>'pageLapVideoDua', 'postWidTiga'=>'pageLapVideoTiga', 'postWidEmpat'=>'pageLapVideoEmpat', 'postWidLima'=>'pageLapVideoLima');
				$arr_func = array('postWidSatu'=>'getDataLapVideoSatu', 'postWidDua'=>'getDataLapVideoDua', 'postWidTiga'=>'getDataLapVideoTiga', 'postWidEmpat'=>'getDataLapVideoEmpat', 'postWidLima'=>'getDataLapVideoLima');

				$data['target'] = '#'.$target;
				$data['target_sub'] = $arr_target_sub[$target];
				$data['target_sub_ids'] = $arr_target_sub_ids[$target];
				$data['post_sub'] = $arr_post_sub_ids[$target];
				$data['link_func'] = $arr_func[$target];

				$data['judul'] = (@$en->id_widget!=NULL) ? $en->judul : 'Galeri Video';
				$data['tgl_cetak'] = !empty(@$en->param1)?$en->param1:date('d/m/Y');
				$data['id_unit'] = !empty($en->param3)?$en->param3:1;
				$data['limit_row'] = 0;
				
				$from = array(
					'sitika_video a' => ''
				);
				$select = '*';
				$order = 'a.tanggal, a.id_video DESC';
				$where = array('status'=>2);
				
				$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'order' => $order,
							'where' => $where))->num_rows();
				$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;
				
				$total_rows = $total_rows > 0 ? $total_rows : 1;
				$jeda = !empty($en->durasi) ? intval($en->durasi): 5;
				$jeda_luar = $jeda * ceil($total_rows / $per_page);
				
				$data['paging'] = $this->paging = $this->ajax_pagination_widget->create_links($jeda_luar, $post);
				
				$data['jeda_dalam'] = $jeda;
				
				if(count($cek_id_ids) > 0) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
					'select' => '*','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;
				$this->load->view($this->folder.'/widget_video',$data);
			break;

			case 3:
			/*informasi*/
				$arr_target_sub = array('postWidSatu'=>'postLapInformasiSatu', 'postWidDua'=>'postLapInformasiDua', 'postWidTiga'=>'postLapInformasiTiga', 'postWidEmpat'=>'postLapInformasiEmpat', 'postWidLima'=>'postLapInformasiLima');
				$arr_target_sub_ids = array('postWidSatu'=>'lap-sch-satu', 'postWidDua'=>'lap-sch-dua', 'postWidTiga'=>'lap-sch-tiga', 'postWidEmpat'=>'lap-sch-empat', 'postWidLima'=>'lap-sch-lima');
				$arr_post_sub_ids = array('postWidSatu'=>'pageLapInformasiSatu', 'postWidDua'=>'pageLapInformasiDua', 'postWidTiga'=>'pageLapInformasiTiga', 'postWidEmpat'=>'pageLapInformasiEmpat', 'postWidLima'=>'pageLapInformasiLima');
				$arr_func = array('postWidSatu'=>'getDataLapInformasiSatu', 'postWidDua'=>'getDataLapInformasiDua', 'postWidTiga'=>'getDataLapInformasiTiga', 'postWidEmpat'=>'getDataLapInformasiEmpat', 'postWidLima'=>'getDataLapInformasiLima');

				$data['target'] = '#'.$target;
				$data['target_sub'] = $arr_target_sub[$target];
				$data['target_sub_ids'] = $arr_target_sub_ids[$target];
				$data['post_sub'] = $arr_post_sub_ids[$target];
				$data['link_func'] = $arr_func[$target];

				$data['judul'] = (@$en->id_widget!=NULL) ? $en->judul : 'Informasi';
				$data['tgl_cetak'] = !empty(@$en->param1)?$en->param1:date('d/m/Y');
				$data['id_unit'] = !empty($en->param3)?$en->param3:1;
				$data['limit_row'] = 0;
				
				$from = array(
					'sitika_articles a' => ''
				);
				$select = '*';
				$order = 'a.date_start DESC';
				$where = array('a.status'=>1,'a.code'=>1,'id_kategori'=>$en->id_kategori);
				
				$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'order' => $order,
							'where' => $where))->num_rows();
				$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;
				
				$total_rows = $total_rows > 0 ? $total_rows : 1;
				$jeda = !empty($en->durasi) ? intval($en->durasi): 5;
				$jeda_luar = $jeda * ceil($total_rows / $per_page);
				
				$data['paging'] = $this->paging = $this->ajax_pagination_widget->create_links($jeda_luar, $post);
				
				$data['jeda_dalam'] = $jeda;
				
				if(count($cek_id_ids) > 0) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
					'select' => '*','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;
				$this->load->view($this->folder.'/widget_informasi',$data);
			break;


			case 4:
			/*agenda kegiatan*/
				$arr_target_sub = array('postWidSatu'=>'postLapAgendaSatu', 'postWidDua'=>'postLapAgendaDua', 'postWidTiga'=>'postLapAgendaTiga', 'postWidEmpat'=>'postLapAgendaEmpat', 'postWidLima'=>'postLapAgendaLima');
				$arr_target_sub_ids = array('postWidSatu'=>'lap-sch-satu', 'postWidDua'=>'lap-sch-dua', 'postWidTiga'=>'lap-sch-tiga', 'postWidEmpat'=>'lap-sch-empat', 'postWidLima'=>'lap-sch-lima');
				$arr_post_sub_ids = array('postWidSatu'=>'pageLapAgendaSatu', 'postWidDua'=>'pageLapAgendaDua', 'postWidTiga'=>'pageLapAgendaTiga', 'postWidEmpat'=>'pageLapAgendaEmpat', 'postWidLima'=>'pageLapAgendaLima');
				$arr_func = array('postWidSatu'=>'getDataLapAgendaSatu', 'postWidDua'=>'getDataLapAgendaDua', 'postWidTiga'=>'getDataLapAgendaTiga', 'postWidEmpat'=>'getDataLapAgendaEmpat', 'postWidLima'=>'getDataLapAgendaLima');

				$data['target'] = '#'.$target;
				$data['target_sub'] = $arr_target_sub[$target];
				$data['target_sub_ids'] = $arr_target_sub_ids[$target];
				$data['post_sub'] = $arr_post_sub_ids[$target];
				$data['link_func'] = $arr_func[$target];

				$data['judul'] = (@$en->id_widget!=NULL) ? $en->judul : 'Agenda kegiatan';
				$data['tgl_cetak'] = !empty(@$en->param1)?$en->param1:date('d/m/Y');
				$data['id_unit'] = !empty($en->param3)?$en->param3:1;
				$data['limit_row'] = 0;
				
				$from = array(
					'sitika_articles a' => ''
				);
				$select = '*';
				$order = 'a.date_start DESC';
				$where = array('a.status'=>1,'a.code'=>3,'id_kategori'=>$en->id_kategori);
				
				$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'order' => $order,
							'where' => $where))->num_rows();
				$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;
				
				$total_rows = $total_rows > 0 ? $total_rows : 1;
				$jeda = !empty($en->durasi) ? intval($en->durasi): 5;
				$jeda_luar = $jeda * ceil($total_rows / $per_page);
				
				$data['paging'] = $this->paging = $this->ajax_pagination_widget->create_links($jeda_luar, $post);
				
				$data['jeda_dalam'] = $jeda;
				
				if(count($cek_id_ids) > 0) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
					'select' => '*','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;
				$this->load->view($this->folder.'/widget_agenda',$data);
			break;



			case 6:
			/*pengumuman*/
				$arr_target_sub = array('postWidSatu'=>'postLapPenguSatu', 'postWidDua'=>'postLapPenguDua', 'postWidTiga'=>'postLapPenguTiga', 'postWidEmpat'=>'postLapPenguEmpat', 'postWidLima'=>'postLapPenguLima');
				$arr_target_sub_ids = array('postWidSatu'=>'lap-sch-satu', 'postWidDua'=>'lap-sch-dua', 'postWidTiga'=>'lap-sch-tiga', 'postWidEmpat'=>'lap-sch-empat', 'postWidLima'=>'lap-sch-lima');
				$arr_post_sub_ids = array('postWidSatu'=>'pageLapPenguSatu', 'postWidDua'=>'pageLapPenguDua', 'postWidTiga'=>'pageLapPenguTiga', 'postWidEmpat'=>'pageLapPenguEmpat', 'postWidLima'=>'pageLapPenguLima');
				$arr_func = array('postWidSatu'=>'getDataLapPenguSatu', 'postWidDua'=>'getDataLapPenguDua', 'postWidTiga'=>'getDataLapPenguTiga', 'postWidEmpat'=>'getDataLapPenguEmpat', 'postWidLima'=>'getDataLapPenguLima');

				$data['target'] = '#'.$target;
				$data['target_sub'] = $arr_target_sub[$target];
				$data['target_sub_ids'] = $arr_target_sub_ids[$target];
				$data['post_sub'] = $arr_post_sub_ids[$target];
				$data['link_func'] = $arr_func[$target];

				$data['judul'] = (@$en->id_widget!=NULL) ? $en->judul : 'Pengumuman';
				$data['tgl_cetak'] = !empty(@$en->param1)?$en->param1:date('d/m/Y');
				$data['id_unit'] = !empty($en->param3)?$en->param3:1;
				$data['limit_row'] = 0;
				
				$from = array(
					'sitika_articles a' => ''
				);
				$select = '*';
				$order = 'a.date_start DESC';
				$where = array('a.status'=>1,'a.code'=>4,'id_kategori'=>$en->id_kategori);
				
				$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'order' => $order,
							'where' => $where))->num_rows();
				$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;
				
				$total_rows = $total_rows > 0 ? $total_rows : 1;
				$jeda = !empty($en->durasi) ? intval($en->durasi): 5;
				$jeda_luar = $jeda * ceil($total_rows / $per_page);
				
				$data['paging'] = $this->paging = $this->ajax_pagination_widget->create_links($jeda_luar, $post);
				
				$data['jeda_dalam'] = $jeda;
				
				if(count($cek_id_ids) > 0) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
					'select' => '*','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;
				$this->load->view($this->folder.'/widget_pengumuman',$data);
			break;

			case 7: //galeri
				$arr_target_sub = array(
					'postWidSatu'=>'postGalSatu',
					'postWidDua'=>'postGalDua',
					'postWidTiga'=>'postGalTiga',
					'postWidEmpat'=>'postGalEmpat',
					'postWidLima'=>'postGalLima',
					'postWidEnam'=>'postGalEnam');
				$arr_target_sub_ids = array(
					'postWidSatu'=>'ids-gal-satu',
					'postWidDua'=>'ids-gal-dua',
					'postWidTiga'=>'ids-gal-tiga',
					'postWidEmpat'=>'ids-gal-empat',
					'postWidLima'=>'ids-gal-lima',
					'postWidEnam'=>'ids-gal-enam');

				$arr_post_sub_ids = array(
					'postWidSatu'=>'pageGalSatu',
					'postWidDua'=>'pageGalDua',
					'postWidTiga'=>'pageGalTiga',
					'postWidEmpat'=>'pageGalEmpat',
					'postWidLima'=>'pageGalLima',
					'postWidEnam'=>'pageGalEnam');

				$arr_func = array(
					'postWidSatu'=>'getDataGalSatu',
					'postWidDua'=>'getDataGalDua',
					'postWidTiga'=>'getDataGalTiga',
					'postWidEmpat'=>'getDataGalEmpat',
					'postWidLima'=>'getDataGalLima',
					'postWidEnam'=>'getDataGalEnam');

				$data['target'] = '#'.$target;
				$data['target_sub'] = $arr_target_sub[$target];
				$data['target_sub_ids'] = $arr_target_sub_ids[$target];
				$data['post_sub'] = $arr_post_sub_ids[$target];
				$data['link_func'] = $arr_func[$target];

				$data['judul'] = (@$en->id_ids!=NULL) ? $en->judul : 'Galeri';
				$data['limit_row'] = 0;
				$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
					'where' => array('id_konten' => $id)
				))->row();

				$where_data_widget = !empty($en) && $en->param1 != 3 ? array('posisi'=>$en->param1,'status'=>1) : null;
				$total_rows = $this->general_model->datagrab(array(
							'tabel' => 'sitika_foto',
							'where'=>$where_data_widget,
							'select' => '*',
							))->num_rows();
				/*cek($total_rows);
				die();*/
				$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;
				
				$total_rows = $total_rows > 0 ? $total_rows : 1;
				$jeda = !empty($en->durasi) ? intval($en->durasi): 5;
				$jeda_luar = $jeda * ceil($total_rows / $per_page);
				
				$data['paging'] = $this->paging = $this->ajax_pagination_widget->create_links($jeda_luar, $post);
				// cek($en->durasi);
				// $data['paging_dalam'] =$this->paging = $this->ajax_tvpegkes_widget->create_links($jeda_luar);

				$data['jeda_dalam'] = $jeda;
				// cek($en->durasi);
				// cek($jeda);
				// if (!empty($cek_id_ids->id_ids))
				if(count($cek_id_ids) > 0) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
					'select' => '*','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;

				$dt_widget = $this->general_model->datagrab(array(
							'tabel' => 'sitika_foto',
							'where'=>$where_data_widget,
							'select' => '*'));
				$data['dt_widget'] = $dt_widget;
				$data['func_data'] = 'galeri';
				$this->load->view($this->folder.'/widget_load',$data);
			break;
			case 8: //running text:
				$arr_target_sub = array(
					'postWidSatu'=>'postTeksSatu',
					'postWidDua'=>'postTeksDua',
					'postWidTiga'=>'postTeksTiga',
					'postWidEmpat'=>'postTeksEmpat',
					'postWidLima'=>'postTeksLima',
					'postWidEnam'=>'postTeksEnam');

				$arr_target_sub_ids = array(
					'postWidSatu'=>'ids-teks-satu',
					'postWidDua'=>'ids-teks-dua',
					'postWidTiga'=>'ids-teks-tiga',
					'postWidEmpat'=>'ids-teks-empat',
					'postWidLima'=>'ids-teks-lima',
					'postWidEnam'=>'ids-teks-enam');

				$arr_post_sub_ids = array(
					'postWidSatu'=>'pageTeksSatu',
					'postWidDua'=>'pageTeksDua',
					'postWidTiga'=>'pageTeksTiga',
					'postWidEmpat'=>'pageTeksEmpat',
					'postWidLima'=>'pageTeksLima',
					'postWidEnam'=>'pageTeksEnam');

				$arr_func = array(
					'postWidSatu'=>'getDataTeksSatu',
					'postWidDua'=>'getDataTeksDua',
					'postWidTiga'=>'getDataTeksTiga',
					'postWidEmpat'=>'getDataTeksEmpat',
					'postWidLima'=>'getDataTeksLima',
					'postWidEnam'=>'getDataTeksEnam');

				$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
					'where' => array('id_konten' => $id)
				))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;

				$data['target'] = '#'.$target;
				$data['target_sub'] = $arr_target_sub[$target];
				$data['target_sub_ids'] = $arr_target_sub_ids[$target];
				$data['post_sub'] = $arr_post_sub_ids[$target];
				$data['link_func'] = $arr_func[$target];

				$data['judul'] = (@$en->id_ids!=NULL) ? $en->judul : 'Berita & Pengumuman';

				$total_rows = $this->general_model->datagrab(array(
							'tabel' => 'sitika_running_text',
							'select' => '*',
							'where'=>array('status'=>2)
							))->num_rows();
				
				$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;
				
				$total_rows = $total_rows > 0 ? $total_rows : 1;
				$jeda = !empty($en->durasi) ? intval($en->durasi): 5;
				$jeda_luar = $jeda * ceil($total_rows / $per_page);
				
				$data['paging'] = $this->paging = $this->ajax_pagination_widget->create_links($jeda_luar, $post);
				// cek($en->durasi);
				// $data['paging_dalam'] =$this->paging = $this->ajax_tvpegkes_widget->create_links($jeda_luar);

				$data['jeda_dalam'] = $jeda;
				// cek($en->durasi);
				// cek($jeda);
				if(count($cek_id_ids) > 0) $cek_ids = $this->general_model->datagrab(array('tabel' =>'ids_setting',
					'select' => '','where'=>array('id_ids'=>$cek_id_ids->id_ids)))->row();

				$data['height_img'] = @$cek_ids->tinggi - 50;
				/*$data['paging'] = $paging;*/
				/*cek($cek_ids->tinggi);
				die();*/		
				$data['runningtext'] = 1;
				$data['func_data'] = 'runningtext';
				$this->load->view($this->folder.'/widget_load',$data);
			break;

		}
	}
}
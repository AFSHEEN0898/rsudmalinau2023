<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Home extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		$this->load->library('Ajax_pagination');
		$this->load->library('Ajax_pagination_gal1');
		$this->load->library('Ajax_pagination_gal2');
		$this->load->library('ajax_pagination_video');
		$this->load->library('ajax_pagination_informasi');
		$this->load->library('ajax_pagination_pelatihan');
		$this->load->library('ajax_pagination_pengumuman');
		$this->load->library('ajax_pagination_berlangsung');
		$this->load->library('ajax_pagination_gal3');
		$this->RenPel = 3; 
		$this->BerPel = 1;
		$this->perPage = 2;
		$this->informasi = 1;
		$this->pengumuman = 1;


		
	}

	function in_app() {
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
	}

	public function index() {
		
		login_check($this->session->userdata('login_state'));
		
		$data['title'] = 'Dasbor';
		$data['breadcrumb'] = array('' => $this->in_app(), $this->uri->segment(1).'/home' => 'Dasbor');	
	/*
		$data['jml_teks'] = $this->general_model->datagrab(array(
			'tabel' => 'tvpeg_teks','select' => 'count(id_teks) as jml'
		))->row();
		
		$data['widget_aktif'] = $this->general_model->datagrab(array(
			'tabel' => 'tvpeg_widget','select' => 'count(id_widget) as jml'
		))->row();*/
		
		
		$data['jml_teks'] = $this->general_model->datagrab(array(
			'tabel' => 'tvpeg_teks','select' => 'count(id_teks) as jml'
		))->row();
		
		$data['widget_aktif'] = $this->general_model->datagrab(array(
			'tabel' => 'tvpeg_widget','select' => 'count(id_widget) as jml'
		))->row();
		


		$from_news = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);

		$data['widget_new_i'] = $this->general_model->datagrab(array(
			'tabel' => $from_news,'select' => 'count(p.id_news) as jml','where'=>array('jenis_i'=>1)
		))->row();
		
		$data['widget_new_u'] = $this->general_model->datagrab(array(
			'tabel' => $from_news,'select' => 'count(p.id_news) as jml','where'=>array('jenis_u'=>1)
		))->row();
		
		

		$from_foto = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);

		$data['widget_foto_i'] = $this->general_model->datagrab(array(
			'tabel' => $from_foto,'select' => 'count(p.id_foto) as jml','where'=>array('jenis_i'=>1)
		))->row();
		
		$data['widget_foto_u'] = $this->general_model->datagrab(array(
			'tabel' => $from_foto,'select' => 'count(p.id_foto) as jml','where'=>array('jenis_u'=>1)
		))->row();
		
		
		$data['content'] = $this->uri->segment(1)."/dashboard_view";
		$this->load->view('home', $data);
		
	}
	
	function tv_umum() {
		
		$data['title'] = 'TV Info Pelatihan';
		
		$data['app'] = 'TV-Info Pelatihan';
		$data['folder'] = $this->uri->segment(1);
		
		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload'),2);	
		
		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1,'jenis_u'=>1),
			'order' => 'urut'));	
		

		$from_news = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
          
		$data['news'] = $this->general_model->datagrab(array(
			'tabel'=> $from_news,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_u'=>1),
			'order' => 'i.urut ASC'));	
		

		$from_foto = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$data['foto'] = $this->general_model->datagrab(array(
			'tabel'=> $from_foto,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_u'=>1),
			'order' => 'i.urut ASC'));		
		
		$data['det'] = $this->general_model->get_param('tvinfo_durasi');

        // KIRI
        //total rows count kiri


		//tanggal widget

		$tanggal_widget = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'select'=> 'tgl_mulai,tgl_selesai',
			'where' => array('tipe'=>3)
			))->row();

        // PESERTA
	        $from = array(
		              'pes_kelas p' => '',
		              'peserta i' => array('i.id = p.id_peserta','left'),
		              'jadwal_ins j' => array('j.id = p.id_jadwal','left'),
		              'ref_instansi k' => array('k.id_instansi = j.id_instansi','left'),
		              'program l' => array('l.id = j.id_program','left'),
		              'program n' => array('n.id =p.program','left'),
		              'ref_jenis_client m' => array('m.id_jenis_client = j.id_jenis_client','left')
		            );
		          
		     $q_l = $this->general_model->datagrab(array(
		            'tabel' => $from,
		            'order' => 'j.tanggal1 ASC',
		            'where' => array('j.tanggal1 BETWEEN "'.@$tanggal_widget->tgl_mulai.'" AND "'.@$tanggal_widget->tgl_selesai.'" '=>null),
		            'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
		            'limit'=>$this->perPage
		          ));
        // ./PESERTA

        $totalRec = $this->general_model->datagrab(array(
        	'tabel'=>$from,'where' => array('j.tanggal1 BETWEEN "'.@$tanggal_widget->tgl_mulai.'" AND "'.@$tanggal_widget->tgl_selesai.'" '=>null)))->num_rows();

        //pagination configuration
        $config['target']      = '#postPST';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
       	$config['uri_segment'] = '4';
        
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['peserta'] = $q_l->result();

        // ./KIRI

              // galeri
	      
		// GALERI FOTO 1
	      
		          
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$q_galeri1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>1,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGAL1';
        $config_gal['total_rows']  = $totalRec_gal1;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data

        $data['foto'] = $q_galeri1->result();
// ./ GALERI FOTO 1

        // GALERI KANAN
        $q_galeri2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>2,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal2['target']      = '#postGAL2';
        $config_gal2['base_url']    = base_url().'tv/home/ajaxPaginationGAL2';
        $config_gal2['total_rows']  = $totalRec_gal1;
        $config_gal2['per_page']    = 1;
       	$config_gal2['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal2);
        
        //get the posts data

        $data['foto_kanan'] = $q_galeri2->result();



       /* $q_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
					'where' => array('aktif'=>1),
		            'order' => 'id_video DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
					'where' => array('aktif'=>1)
		          ))->num_rows();*/

        //pagination configuration
        $config_gal['target']      = '#postvideo';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
       // $config_gal['total_rows']  = $totalRec_video;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_video->initialize($config_gal);
        
        //get the posts data

       // $data['video'] = $q_video->result();




        $data['musik'] = $this->general_model->datagrab(array('tabel'=>'tvpeg_sound','order'=>'id_sound asc' ));
			
		$this->load->view('tv/tv_umum_view',$data);
		
	}

	function tv_umum_2() {
		
		$data['title'] = 'TV Info Pelatihan';
		
		$data['app'] = 'TV-Info Pelatihan';
		$data['folder'] = $this->uri->segment(1);
		
		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload'),2);	
		
		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1,'jenis_u'=>1),
			'order' => 'urut'));	
		

		$from_news = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
          
		$data['news'] = $this->general_model->datagrab(array(
			'tabel'=> $from_news,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_u'=>1),
			'order' => 'i.urut ASC'));	
		

		$from_foto = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$data['foto'] = $this->general_model->datagrab(array(
			'tabel'=> $from_foto,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_u'=>1),
			'order' => 'i.urut ASC'));		
		
		$data['det'] = $this->general_model->get_param('tvinfo_durasi');

        // KIRI
        //total rows count kiri


		//tanggal widget

		$tanggal_widget = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'select'=> 'tgl_mulai,tgl_selesai',
			'where' => array('tipe'=>3)
			))->row();

        // PESERTA
	        $from = array(
		              'pes_kelas p' => '',
		              'peserta i' => array('i.id = p.id_peserta','left'),
		              'jadwal_ins j' => array('j.id = p.id_jadwal','left'),
		              'ref_instansi k' => array('k.id_instansi = j.id_instansi','left'),
		              'program l' => array('l.id = j.id_program','left'),
		              'program n' => array('n.id =p.program','left'),
		              'ref_jenis_client m' => array('m.id_jenis_client = j.id_jenis_client','left')
		            );
		          
		     $q_l = $this->general_model->datagrab(array(
		            'tabel' => $from,
		            'order' => 'j.tanggal1 ASC',
		            'where' => array('j.tanggal1 BETWEEN "'.@$tanggal_widget->tgl_mulai.'" AND "'.@$tanggal_widget->tgl_selesai.'" '=>null),
		            'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
		            'limit'=>$this->perPage
		          ));
        // ./PESERTA

        $totalRec = $this->general_model->datagrab(array(
        	'tabel'=>$from,'where' => array('j.tanggal1 BETWEEN "'.@$tanggal_widget->tgl_mulai.'" AND "'.@$tanggal_widget->tgl_selesai.'" '=>null)))->num_rows();

        //pagination configuration
        $config['target']      = '#postPST';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
       	$config['uri_segment'] = '4';
        
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['peserta'] = $q_l->result();

        // ./KIRI

              // galeri
	      
		// GALERI FOTO 1
	      
		          
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$q_galeri1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>1,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGAL1';
        $config_gal['total_rows']  = $totalRec_gal1;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data

        $data['foto'] = $q_galeri1->result();
// ./ GALERI FOTO 1

        // GALERI KANAN
        $q_galeri2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>2,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal2['target']      = '#postGAL2';
        $config_gal2['base_url']    = base_url().'tv/home/ajaxPaginationGAL2';
        $config_gal2['total_rows']  = $totalRec_gal1;
        $config_gal2['per_page']    = 1;
       	$config_gal2['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal2);
        
        //get the posts data

        $data['foto_kanan'] = $q_galeri2->result();



       /* $q_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
					'where' => array('aktif'=>1),
		            'order' => 'id_video DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
					'where' => array('aktif'=>1)
		          ))->num_rows();*/

        //pagination configuration
        $config_gal['target']      = '#postvideo';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
       // $config_gal['total_rows']  = $totalRec_video;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_video->initialize($config_gal);
        
        //get the posts data

       // $data['video'] = $q_video->result();


        // video
        $data['video'] = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'order' => 'id_video DESC',
		            'where' =>array('aktif'=>0)
		          ));
        $totalRec_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'where' =>array('aktif'=>0)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postvideo';
        //$config_gal['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
        $config_gal['total_rows']  = $totalRec_video;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        


        $data['musik'] = $this->general_model->datagrab(array('tabel'=>'tvpeg_sound','order'=>'id_sound asc' ));
			
		$this->load->view('tv/tv_umum_view_2',$data);
		
	}

	function ajax_musik() {
		$musik = $this->general_model->datagrab(array('tabel'=>'tvpeg_sound','order'=>'id_sound asc' ))->row();
	}

	function ajax_fotokiri(){
		$gal_foto = array(
			'tvpeg_widget_foto p' => '',
			'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
		);

      	
		$fotoxx = $this->general_model->datagrab(array(
		'tabel'=> $gal_foto,
		'where' => array('i.status'=>1,'p.jenis_u'=>1),
		'order' => 'i.id_foto desc'));
		$data ='';
		$data .= '<script type="text/javascript" src="'.base_url('assets/js/wowslider.js').'"></script>
				<script type="text/javascript" src="'.base_url('assets/js/script.js').'"></script>';
		foreach ($fotoxx->result() as $f) {
			$jmlx=strlen($f->judul);
			$kata = strlen($f->judul);
			if($kata > 50){
				$judul = "<marquee>".$f->judul."</marquee>";
			}else{
				$judul = $f->judul;
			}
			$data .= 
				'
													<li style="width: 10%;">
					<img src="'.base_url('uploads/tvinfo/'.$f->foto).'"  title="'.$judul.'" id="wows1_0" style="visibility: visible;">
				</li>
				';
        }
        
        die(json_encode($data));
	}
	
	function tv_internalx() {
		
		$data['title'] = 'TV Info Pelatihan';
		
		$data['app'] = 'TV-Info Pelatihan';
		$data['folder'] = $this->uri->segment(1);
		
		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload'),2);	
		
		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1,'jenis_i'=>1),
			'order' => 'urut'));	
		
/*
		$from_news = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
          
		$data['news'] = $this->general_model->datagrab(array(
			'tabel'=> $from_news,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_i'=>1),
			'order' => 'i.urut ASC'));	
		
*/		

 		
		$from_news = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
          
		$data['news'] = $this->general_model->datagrab(array(
			'tabel'=> $from_news,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_u'=>1),
			'order' => 'i.urut ASC'));	
		


		
		$from_informasi = array(
			'tvpeg_widget_informasi p' => '',
             'tvpeg_informasi i' => array('i.id_informasi = p.id_informasi','left')
			);
          
		$data['informasi'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_informasi',
			'limit' => 10,
			'offset' => 0,
			'order' => 'urut ASC'));	
		

		$from_foto = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$data['foto'] = $this->general_model->datagrab(array(
						'tabel'=> array(
								'tvpeg_widget_foto p' => '',
								'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')),
						'limit'=>1,
						'select'=>'*',
						'where' => array('i.status'=>2,'p.jenis_i'=>1),
						'order' => 'i.urut ASC'));		
		
		$data['det'] = $this->general_model->get_param('tvinfo_durasi');

		//tanggal widget

		$tanggal_widget = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'select'=> 'tgl_mulai,tgl_selesai',
			'where' => array('tipe'=>3)
			))->row();

        // PESERTA
	        $from = array(
		              'pes_kelas p' => '',
		              'peserta i' => array('i.id = p.id_peserta','left'),
		              'jadwal_ins j' => array('j.id = p.id_jadwal','left'),
		              'ref_instansi k' => array('k.id_instansi = j.id_instansi','left'),
		              'program l' => array('l.id = j.id_program','left'),
		              'program n' => array('n.id =p.program','left'),
		              'ref_jenis_client m' => array('m.id_jenis_client = j.id_jenis_client','left')
		            );
		          
		     $q_l = $this->general_model->datagrab(array(
		            'tabel' => $from,
		            'order' => 'j.tanggal1 ASC',
		           'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
		            'limit'=>$this->perPage
		          ));
        // ./PESERTA

        $totalRec = $this->general_model->datagrab(array(
        	'tabel'=>$from))->num_rows();

        //pagination configuration
        $config['target']      = '#postPST';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
       	$config['uri_segment'] = '4';
        
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['peserta'] = $q_l->result();

        // ./KIRI

      // GALERI FOTO 1
	      
		          
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$q_galeri1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>1,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGAL1';
        $config_gal['total_rows']  = $totalRec_gal1;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data

        $data['foto'] = $q_galeri1->result();
// ./ GALERI FOTO 1

        // GALERI KANAN
        $q_galeri2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>2,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal2['target']      = '#postGAL2';
        $config_gal2['base_url']    = base_url().'tv/home/ajaxPaginationGAL2';
        $config_gal2['total_rows']  = $totalRec_gal1;
        $config_gal2['per_page']    = 1;
       	$config_gal2['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal2);
        
        //get the posts data

        $data['foto_kanan'] = $q_galeri2->result();
// ./ GALERI FOTO 1
        // ./GALERI KANAN

        $data['musik'] = $this->general_model->datagrab(array('tabel'=>'tvpeg_sound','order'=>'id_sound asc' ));
        

/*


        $data['video'] = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'order' => 'id_video DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postvideo';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
        $config_gal['total_rows']  = $totalRec_video;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_video->initialize($config_gal);
        */

        // video
        $data['video'] = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'order' => 'id_video DESC',
		            'where' =>array('aktif'=>0)
		          ));
        $totalRec_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'where' =>array('aktif'=>0)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postvideo';
        //$config_gal['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
        $config_gal['total_rows']  = $totalRec_video;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
       // $this->ajax_pagination_video->initialize($config_gal);
        //--video tutup---//




		//informasi	
		
        $totalInformasi = $this->general_model->datagrab(array(
			'tabel' => 'tvpeg_informasi',
			'order'=>'urut ASC'
			))->num_rows();

        $config_gali['target']      = '#postInfo';
        $config_gali['base_url']    = base_url().'tv/home/ajaxPaginationinformasi';
        $config_gali['total_rows']  = $totalInformasi;
        $config_gali['per_page']    = $this->informasi;
       	$config_gali['uri_segment'] = '4';

        $this->ajax_pagination_informasi->initialize($config_gali);

        $data['total_rows']= $totalInformasi;
		$data['informasi'] = $this->general_model->datagrabs(array(
			'tabel' => 'tvpeg_informasi',
			'limit'=>$config_gali['per_page'],
			'order'=>'urut ASC',
			'offset'=>@$offset
			));



		/*$from_news = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
          
		$data['news'] = $this->general_model->datagrab(array(
			'tabel'=> $from_news,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_i'=>1),
			'order' => 'i.urut ASC'));	
		

*//*
		$from_pengumuman = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
        $totalPengumuman = $this->general_model->datagrab(array(
			'tabel' => $from_pengumuman,
			'where' => array('p.jenis_i'=>1)
			))->num_rows();

        $config_peng['target']      = '#postPengumuman';
        $config_peng['base_url']    = base_url().'tv/home/ajaxPaginationpengumuman';
        $config_peng['total_rows']  = $totalPengumuman;
        $config_peng['per_page']    = $this->pengumuman;
       	$config_peng['uri_segment'] = '4';

        $this->ajax_pagination_pengumuman->initialize($config_peng);

        $data['total_rows']= $totalPengumuman;
		$data['pengumuman'] = $this->general_model->datagrabs(array(
			'tabel' => $from_pengumuman,
			'order'=>'p.id_widget_news ASC',
			'where' => array('p.jenis_i'=>1),
			'limit'=>$config_peng['per_page'],
			'offset'=>@$offset
			));*/

	
        /*$totalPengumuman = $this->general_model->datagrab(array(
			'tabel' => 'tvpeg_informasi',
			'order'=>'urut ASC'
			))->num_rows();

        $config_peng['target']      = '#postPengumuman';
        $config_peng['base_url']    = base_url().'tv/home/ajaxPaginationpengumuman';
        $config_peng['total_rows']  = $totalPengumuman;
        $config_peng['per_page']    = $this->pengumuman;
       	$config_peng['uri_segment'] = '4';

        $this->ajax_pagination_pengumuman->initialize($config_peng);

        $data['total_rows']= $totalPengumuman;
		$data['informasi'] = $this->general_model->datagrabs(array(
			'tabel' => 'tvpeg_informasi',
			'limit'=>$config_peng['per_page'],
			'order'=>'urut ASC',
			'offset'=>@$offset
			));*/
		//--tutup pengumuman




		$this->load->view('tv/tv_internal_view',$data);
		
	}

	function tv_internal($offset=NULL) {
		$offset = !empty($offset) ? $offset : null;
		$data['title'] = 'TV Info Pelatihan';
		
		$data['app'] = 'TV-Info Pelatihan';
		$data['folder'] = $this->uri->segment(1);
		
		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload'),2);	
		
		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1,'jenis_i'=>1),
			'order' => 'urut'));	
		

		$from_news = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
          
		$data['news'] = $this->general_model->datagrab(array(
			'tabel'=> $from_news,
			'limit' => 10,
			'offset' => 0,
			'where' => array('p.jenis_i'=>1),
			'order' => 'i.urut ASC'));	
		

		$from_informasi = array(
			'tvpeg_widget_informasi p' => '',
             'tvpeg_informasi i' => array('i.id_informasi = p.id_informasi','left')
			);
          
		$data['informasi'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_informasi',
			'limit' => 10,
			'offset' => 0,
			'order' => 'urut ASC'));	
		

		$from_foto = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$data['foto'] = $this->general_model->datagrab(array(
						'tabel'=> array(
								'tvpeg_widget_foto p' => '',
								'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')),
						'limit'=>1,
						'select'=>'*',
						'where' => array('i.status'=>2,'p.jenis_i'=>1),
						'order' => 'i.urut ASC'));		
		
		$data['det'] = $this->general_model->get_param('tvinfo_durasi');

		//tanggal widget

		$tanggal_widget = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'select'=> 'tgl_mulai,tgl_selesai',
			'where' => array('tipe'=>3)
			))->row();

        // PESERTA
	        $from = array(
		              'pes_kelas p' => '',
		              'peserta i' => array('i.id = p.id_peserta','left'),
		              'jadwal_ins j' => array('j.id = p.id_jadwal','left'),
		              'ref_instansi k' => array('k.id_instansi = j.id_instansi','left'),
		              'program l' => array('l.id = j.id_program','left'),
		              'program n' => array('n.id =p.program','left'),
		              'ref_jenis_client m' => array('m.id_jenis_client = j.id_jenis_client','left')
		            );
		          
		     $q_l = $this->general_model->datagrab(array(
		            'tabel' => $from,
		            'order' => 'j.tanggal1 ASC',
		           'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
		            'limit'=>$this->perPage
		          ));
        // ./PESERTA

        $totalRec = $this->general_model->datagrab(array(
        	'tabel'=>$from))->num_rows();

        //pagination configuration
        $config['target']      = '#postPST';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
       	$config['uri_segment'] = '4';
        
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['peserta'] = $q_l->result();

        // ./KIRI

      // GALERI FOTO 1
	      
		          
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);


		$q_galeri1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal1 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>1,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGALin';
        $config_gal['total_rows']  = $totalRec_gal1;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data

        $data['foto'] = $q_galeri1->result();
// ./ GALERI FOTO 1

        // GALERI KANAN
        $q_galeri2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_i'=>1),
		            'order' => 'i.id_foto DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal2 = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
		            'where' => array('i.status'=>2,'p.jenis_i'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal2['target']      = '#postGAL2';
        $config_gal2['base_url']    = base_url().'tv/home/ajaxPaginationGALin2';
        $config_gal2['total_rows']  = $totalRec_gal1;
        $config_gal2['per_page']    = 1;
       	$config_gal2['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal2);
        
        //get the posts data

        $data['foto_kanan'] = $q_galeri2->result();
// ./ GALERI FOTO 1
        // ./GALERI KANAN

        $data['musik'] = $this->general_model->datagrab(array('tabel'=>'tvpeg_sound','order'=>'id_sound asc' ));
        

/*


        $data['video'] = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'order' => 'id_video DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postvideo';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
        $config_gal['total_rows']  = $totalRec_video;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_video->initialize($config_gal);
        */

        // video
        $data['video'] = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'where' =>array('aktif'=>0),
		            'order' => 'id_video DESC'
		          ));
        $totalRec_video = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'where' =>array('aktif'=>0)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postvideo';
        //$config_gal['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
        $config_gal['total_rows']  = $totalRec_video;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
       // $this->ajax_pagination_video->initialize($config_gal);
        //--video tutup---//




		//informasi	
		
        $totalInformasi = $this->general_model->datagrab(array(
			'tabel' => 'tvpeg_informasi',
			'order'=>'urut ASC'
			))->num_rows();

        $config_gali['target']      = '#postInfo';
        $config_gali['base_url']    = base_url().'tv/home/ajaxPaginationinformasi';
        $config_gali['total_rows']  = $totalInformasi;
        $config_gali['per_page']    = $this->informasi;
       	$config_gali['uri_segment'] = '4';

        $this->ajax_pagination_informasi->initialize($config_gali);

        $data['total_rows']= $totalInformasi;
		$data['informasi'] = $this->general_model->datagrabs(array(
			'tabel' => 'tvpeg_informasi',
			'limit'=>$config_gali['per_page'],
			'order'=>'urut ASC',
			'offset'=>@$offset
			));
		//--tutup informasi




 		// rencana Pelatihan
		$from_ren_pel = array(
			'jadwal_ins p' => '',
			'program j' => array('j.id = p.id_program','left'),
			'ref_instansi k' => array('k.id_instansi = p.id_instansi','left'),
			'ref_bidang l' => array('l.id_bidang = p.id_bidang','left')
		);

        $totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_ren_pel, 
					"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
					"order"=>'tanggal1 desc',
					'where'=>array('ket'=>'blm'),
					'offset'=>$offset
			))->num_rows();

        $config['target']      = '#postPelatihan';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationpelatihan';
        $config['total_rows']  = $totalRec;

        $config['per_page']    = $this->RenPel;
       	$config['uri_segment'] = '4';

        $this->ajax_pagination_pelatihan->initialize($config);




		$query = $this->general_model->datagrab(array(
				"tabel" => $from_ren_pel,
				"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
				"order"=>'tanggal1 desc',
				'where'=>array('ket'=>'blm'),
				'limit'=>$config['per_page'],
				'offset'=>$offset
			));
				if ($query->num_rows() != 0) {
					$classy = (in_array(NULL,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed"';
					$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
					$heads = array('No');
					
					if (!in_array(NULL,array('cetak','excel'))) $heads[] = '';
					$heads = array_merge_recursive($heads,array('TANGGAL','INSTANSI','PROGRAM','J.P','PENGAJAR','RUANG','HOTEL'));
					//if (!in_array(NULL,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => 2);
					$this->table->set_heading($heads);
				
					$no = + 1;
					
					foreach($query->result() as $row){
						
						$stat_label = array(
							'prog' => '<span class="label label-success">berlangsung</span>',
							'blm' => '<span class="label label-warning">rencana</span>',
							'sdh' => '<span class="label label-default">selesai</span>'
						);
						
						switch($row->ket) {
							case 'prog' : $warna = 'background-color:#9DF495;color:#0C5106;';
							break;
							case 'blm' : $warna = 'background-color:#FFFFD1;color:#605A01;';
							break;
							case 'sdh' : $warna = 'background-color:#eee;color:#222;';
							break;
						}

						$rows = array(
							array('data' => $no,'style'=>$warna),
							array('data' => @$stat_label[$row->ket],'style' => 'vertical-align: middle;'.$warna)
						);
						
						
						$rows[] = array(
							'data' => tanggal($row->tanggal1).'<br><span class="badge">s.d</span></br>'.tanggal($row->tanggal2),
							'class' => 'text-center','style'=>$warna);

						$rows[] = array(
							'data' => $row->nama_bidang.' '.$row->nama_instansi.' - '.$row->ket_ins,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->nama_program,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->jml_peserta,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->pengajar,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->ruang,
							'class' => 'text-center','style'=>$warna);
						$rows[] = array(
							'data' => $row->hotel,
							'class' => 'text-center','style'=>$warna);

						$this->table->add_row($rows);
						$no++;
					}
			
					$tabel_rencana_pelatihan = $this->table->generate();
					
				}else{
					$tabel_rencana_pelatihan = '<div class="alert alert-confirm bg-green">Belum ada data jadwal pelatihan berlangsung</div><div class="clear"></div>';
				}
				
				$data['rencana_pelatihan']=$tabel_rencana_pelatihan;

		//--tutup renacana pelatihan




 		// berlangsung Pelatihan
		$from_ren_pel = array(
			'jadwal_ins p' => '',
			'program j' => array('j.id = p.id_program','left'),
			'ref_instansi k' => array('k.id_instansi = p.id_instansi','left'),
			'ref_bidang l' => array('l.id_bidang = p.id_bidang','left')
		);

        $totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_ren_pel, 
					"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
					"order"=>'tanggal1 desc',
					'where'=>array('ket'=>'prog'),
					'offset'=>$offset
			))->num_rows();

        $config['target']      = '#postBerlangsung';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationberlangsung';
        $config['total_rows']  = $totalRec;

        $config['per_page']    = $this->BerPel;
       	$config['uri_segment'] = '4';

        $this->ajax_pagination_berlangsung->initialize($config);




		$query = $this->general_model->datagrab(array(
				"tabel" => $from_ren_pel,
				"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
				"order"=>'tanggal1 desc',
				'where'=>array('ket'=>'prog'),
				'limit'=>$config['per_page'],
				'offset'=>$offset
			));
				if ($query->num_rows() != 0) {
					$classy = (in_array(NULL,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed"';
					$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
					$heads = array('No');
					
					if (!in_array(NULL,array('cetak','excel'))) $heads[] = '';
					$heads = array_merge_recursive($heads,array('TANGGAL','INSTANSI','PROGRAM','J.P','PENGAJAR','RUANG','HOTEL'));
					//if (!in_array(NULL,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => 2);
					$this->table->set_heading($heads);
				
					$no = + 1;
					
					foreach($query->result() as $row){
						
						$stat_label = array(
							'prog' => '<span class="label label-success">berlangsung</span>',
							'blm' => '<span class="label label-warning">rencana</span>',
							'sdh' => '<span class="label label-default">selesai</span>'
						);
						
						switch($row->ket) {
							case 'prog' : $warna = 'background-color:#9DF495;color:#0C5106;';
							break;
							case 'blm' : $warna = 'background-color:#FFFFD1;color:#605A01;';
							break;
							case 'sdh' : $warna = 'background-color:#eee;color:#222;';
							break;
						}

						$rows = array(
							array('data' => $no,'style'=>$warna),
							array('data' => @$stat_label[$row->ket],'style' => 'vertical-align: middle;'.$warna)
						);
						
						
						$rows[] = array(
							'data' => tanggal($row->tanggal1).'<br><span class="badge">s.d</span></br>'.tanggal($row->tanggal2),
							'class' => 'text-center','style'=>$warna);

						$rows[] = array(
							'data' => $row->nama_bidang.' '.$row->nama_instansi.' - '.$row->ket_ins,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->nama_program,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->jml_peserta,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->pengajar,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->ruang,
							'class' => 'text-center','style'=>$warna);
						$rows[] = array(
							'data' => $row->hotel,
							'class' => 'text-center','style'=>$warna);

						$this->table->add_row($rows);
						$no++;
					}
			
					$tabel_berlangsung_pelatihan = $this->table->generate();
					
				}else{
					$tabel_berlangsung_pelatihan = '<div class="alert alert-confirm bg-green">Belum ada data jadwal pelatihan berlangsung</div><div class="clear"></div>';
				}
				
				$data['berlangsung_pelatihan']=$tabel_berlangsung_pelatihan;

		//--tutup berlangsung pelatihan
				
		$data['foto_profil'] = $this->general_model->datagrab(array(
						'tabel'=> 'tvpeg_foto ',
						'select'=>'*',
						'where' => array('status'=>3),
						'order' => 'urut ASC'));
		
		$this->load->view('tv/tv_internal_2',$data);
		
	}

	function ajaxPaginationberlangsung(){
		$page = $this->input->post('page', TRUE);
		// cek($page);

        if(empty($page)){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$from_ren_pel = array(
			'jadwal_ins p' => '',
			'program j' => array('j.id = p.id_program','left'),
			'ref_instansi k' => array('k.id_instansi = p.id_instansi','left'),
			'ref_bidang l' => array('l.id_bidang = p.id_bidang','left')
		);

        $totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_ren_pel, 
					"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
					"order"=>'tanggal1 asc',
					'where'=>array('ket'=>'prog'),
					'offset'=>$offset
			))->num_rows();

        $config['target']      = '#postBerlangsung';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationberlangsung';
        $config['total_rows']  = $totalRec;

        $config['per_page']    = $this->BerPel;
       	$config['uri_segment'] = '4';

        $this->ajax_pagination_berlangsung->initialize($config);


		$data['detail_kegiatan_mi'] = $this->general_model->datagrabs(array(
			'tabel' => $from_ren_pel, 
					"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
					"order"=>'tanggal1 asc',
					'where'=>array('ket'=>'prog'),
					'limit'=>$config['per_page'],
					'offset'=>$offset
			));
		 $data['total_rows']  = $totalRec;
			/*	if ($query->num_rows() != 0) {
					$classy = (in_array(NULL,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed"';
					$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
					$heads = array('No');
					
					if (!in_array(NULL,array('cetak','excel')));
					$heads = array_merge_recursive($heads,array('TANGGAL','INSTANSI','PROGRAM','J.P'));
					//if (!in_array(NULL,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => 2);
					$this->table->set_heading($heads);
				
					
			$no = 1+$offset;
					
					foreach($query->result() as $row){
						
						$stat_label = array(
							'prog' => '<span class="label label-success">berlangsung</span>',
							'blm' => '<span class="label label-warning">rencana</span>',
							'sdh' => '<span class="label label-default">selesai</span>'
						);
						
						switch($row->ket) {
							case 'prog' : $warna = 'background-color:#9DF495;color:#0C5106;';
							break;
							case 'blm' : $warna = 'background-color:#FFFFD1;color:#605A01;';
							break;
							case 'sdh' : $warna = 'background-color:#eee;color:#222;';
							break;
						}

						$rows = array(
							array('data' => $no,'style'=>$warna)
						);
						
						
						$rows[] = array(
							'data' => tanggal_indo_y($row->tanggal1,2).' s.d '.date_indox($row->tanggal2,2),
							'class' => 'text-center','style'=>$warna.'width:120px;font-size:10px;');

						$rows[] = array(
							'data' => $row->nama_bidang.' '.$row->nama_instansi.' - '.$row->ket_ins,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->nama_program,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->jml_peserta,
							'style'=>$warna);

						$this->table->add_row($rows);
						$no++;
					}
			
					$tabel = $this->table->generate();
					
				}else{
					$tabel = '<div class="alert alert-confirm bg-green">Belum ada jadwal pelatihan berlangsung</div><div class="clear"></div>';
				}
				
				$data['rencana_pelatihan']=$tabel;

*/

        //load the view
        $this->load->view('tv/widget_jadwal_berlangsung', $data, false);
	}


	function ajaxPaginationpelatihan(){
		$page = $this->input->post('page', TRUE);
		// cek($page);

        if(empty($page)){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$from_ren_pel = array(
			'jadwal_ins p' => '',
			'program j' => array('j.id = p.id_program','left'),
			'ref_instansi k' => array('k.id_instansi = p.id_instansi','left'),
			'ref_bidang l' => array('l.id_bidang = p.id_bidang','left')
		);

        $totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_ren_pel, 
					"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
					"order"=>'tanggal1 asc',
					'where'=>array('ket'=>'blm'),
					'offset'=>$offset
			))->num_rows();

        $config['target']      = '#postPelatihan';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationpelatihan';
        $config['total_rows']  = $totalRec;

        $config['per_page']    = $this->RenPel;
       	$config['uri_segment'] = '4';

        $this->ajax_pagination_pelatihan->initialize($config);


		$query = $this->general_model->datagrabs(array(
			'tabel' => $from_ren_pel, 
					"select" => 'p.*,j.nama_program,k.nama_instansi,l.nama_bidang',
					"order"=>'tanggal1 asc',
					'where'=>array('ket'=>'blm'),
					'limit'=>$config['per_page'],
					'offset'=>$offset
			));

				if ($query->num_rows() != 0) {
					$classy = (in_array(NULL,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed"';
					$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
					$heads = array('No');
					
					if (!in_array(NULL,array('cetak','excel')));
					$heads = array_merge_recursive($heads,array('TANGGAL','INSTANSI','PROGRAM','J.P'));
					//if (!in_array(NULL,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => 2);
					$this->table->set_heading($heads);
				
					
			$no = 1+$offset;
					
					foreach($query->result() as $row){
						
						$stat_label = array(
							'prog' => '<span class="label label-success">berlangsung</span>',
							'blm' => '<span class="label label-warning">rencana</span>',
							'sdh' => '<span class="label label-default">selesai</span>'
						);
						
						switch($row->ket) {
							case 'prog' : $warna = 'background-color:#9DF495;color:#0C5106;';
							break;
							case 'blm' : $warna = 'background-color:#FFFFD1;color:#605A01;';
							break;
							case 'sdh' : $warna = 'background-color:#eee;color:#222;';
							break;
						}

						$rows = array(
							array('data' => $no,'style'=>$warna)
						);
						
						
						$rows[] = array(
							'data' => tanggal_indo_y($row->tanggal1,2).' s.d '.date_indox($row->tanggal2,2),
							'class' => 'text-center','style'=>$warna.'width:120px;font-size:10px;');

						$rows[] = array(
							'data' => $row->nama_bidang.' '.$row->nama_instansi.' - '.$row->ket_ins,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->nama_program,
							'style'=>$warna);
						$rows[] = array(
							'data' => $row->jml_peserta,
							'style'=>$warna);

						$this->table->add_row($rows);
						$no++;
					}
			
					$tabel = $this->table->generate();
					
				}else{
					$tabel = '<div class="alert alert-confirm" style="background: linear-gradient(#dada00, #ffffff)">Belum ada Jadwal Rencana Pelatihan</div><div class="clear"></div>';
				}
				
				$data['rencana_pelatihan']=$tabel;



        //load the view
        $this->load->view('tv/widget_jadwal_view', $data, false);
	}


	function ajaxPaginationinformasi(){
		$page = $this->input->post('page', TRUE);
		// cek($page);

        if(empty($page)){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // pengumuman

        $total_data = $this->general_model->datagrab(array(
		            'tabel' => 'tvpeg_informasi',
					'where' => array('aktif'=>1)
		          ))->num_rows();


        //pagination configuration
        $config_news['target']      = '#postInfo';
        $config_news['base_url']    = base_url().'tv/home/ajaxPaginationinformasi';
        $config_news['total_rows']  = $total_data;
        $config_news['per_page']    = 1;
       	$config_news['uri_segment'] = '4';
        
        $this->ajax_pagination_informasi->initialize($config_news);
        //get the posts data
        //get the posts data
        $data['informasi'] = $this->general_model->datagrab(array(
		            'tabel' => 'tvpeg_informasi',
		            'order' => 'urut',
		            'offset'=>$offset,
					'where' => array('aktif'=>1),
		            'limit'=>1
		           
		          ));
        $data['id_gal'] = 'id_informasi';
        $data['offset'] = $offset;
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);
        if ($total_data > 0) {
        	# code...
        	$dt_row = $data['informasi']->row();
        }
        	$jeda = !empty($dt_row->jeda) ? $dt_row->jeda : 5;
        	$data['jeda'] = $jeda;
        $data['paging'] = $this->ajax_pagination_informasi->create_links($jeda);
        // ./KIRI
        
        //load the view
        $this->load->view('tv/ajax-informasi', $data, false);
	}

	function ajaxPaginationpengumuman(){
		$page = $this->input->post('page', TRUE);
		// cek($page);

        if(empty($page)){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // pengumuman

      /*  $from_pengumuman = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);
        $totalPengumuman = $this->general_model->datagrab(array(
			'tabel' => $from_pengumuman,
			'order'=>'i.urut ASC',
			'where' => array('p.jenis_i'=>1)
			))->num_rows();

        $config_peng['target']      = '#postPengumuman';
        $config_peng['base_url']    = base_url().'tv/home/ajaxPaginationpengumuman';
        $config_peng['total_rows']  = $totalPengumuman;
        $config_peng['per_page']    = $this->pengumuman;
       	$config_peng['uri_segment'] = '4';
*/
       /* $this->ajax_pagination_pengumuman->initialize($config_peng);

        $data['total_rows']= $totalPengumuman;
		$data['pengumuman'] = $this->general_model->datagrabs(array(
			'tabel' => $from_pengumuman,
			'order'=>'i.urut ASC',
			'where' => array('p.jenis_i'=>1),
			'limit'=>$config_peng['per_page'],
			'offset'=>@$offset
			));
*/
	
	$from_pengumuman = array(
			'tvpeg_widget_news p' => '',
             'tvpeg_news i' => array('i.id_news = p.id_news','left')
			);

        $total_peng = $this->general_model->datagrab(array(
					'tabel' => $from_pengumuman,
					'where' => array('p.jenis_i'=>1)
		          ))->num_rows();


        //pagination configuration
        $config_peng['target']      = '#postPengumuman';
        $config_peng['base_url']    = base_url().'tv/home/ajaxPaginationpengumuman';
        $config_peng['total_rows']  = $total_peng;
        $config_peng['per_page']    = 1;
       	$config_peng['uri_segment'] = '4';
        
        $this->ajax_pagination_pengumuman->initialize($config_peng);
        //get the posts data
        //get the posts data
        $data['pengumuman'] = $this->general_model->datagrab(array(
					'tabel' => $from_pengumuman,
					'where' => array('p.jenis_i'=>1),
					'order'=>'p.id_widget_news ASC',
		            'offset'=>$offset,
		            'limit'=>1
		           
		          ));
        $data['id_gal'] = 'id_widget_news';
        $data['offset'] = $offset;
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);
        if ($total_peng > 0) {
        	# code...
        	$dt_row = $data['pengumuman']->row();
        }
        	$jeda = !empty($dt_row->jeda) ? $dt_row->jeda : 5;
        	$data['jeda'] = $jeda;
        	$data['paging'] = $this->ajax_pagination_pengumuman->create_links($jeda);
        // ./KIRI
        
        //load the view
        $this->load->view('tv/ajax-pengumuman', $data, false);
	}


	//--tutup ajax informasi

	function ajaxPaginationvideoc(){
		$page = $this->input->post('page', TRUE);
		//cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'where' =>array('aktif'=>0)
		          ))->num_rows();


        //pagination configuration
        $config_video['target']      = '#postVideo';
        $config_video['base_url']    = base_url().'tv/home/ajaxPaginationvideo';
        $config_video['total_rows']  = $totalRec_gal;
        $config_video['per_page']    = 1;
       	$config_video['uri_segment'] = '4';
        
        $this->ajax_pagination_video->initialize($config_video);
        
        //get the posts data
        $data['video'] = $this->general_model->datagrab(array(
		            'tabel' => 'tv_video',
		            'where' =>array('aktif'=>0),
		            'order' => 'urut',
		            'offset'=>$offset,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
 		$data['id_gal'] = 'id_video';
        $data['offset'] = $offset;
          if ($totalRec_gal > 0) {
        	# code...
        	$dt_row = $data['video']->row();
        }
        	$jeda = !empty($dt_row->jeda) ? $dt_row->jeda : 5;
        //cek($jeda);
        //die();
        $data['paging'] = $this->ajax_pagination_video->create_links($jeda);
        // ./KIRI
        
        //load the view

        $this->load->view('tv/ajax-galeri-video', $data, false);
	}

	function ajax_tgl() {
		$tgl = date_indox(date('Y-m-d'),2);
		$data =array();
		$data[] = array(
			'tgl'=>$tgl
			);
		die(json_encode($data));
	}
	


	function ajaxPaginationGALin(){
		$page = $this->input->post('pageGAL1', TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // galeri
	      
		  
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);

        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_u'=>1),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGALin';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data
        $data['foto'] = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_u'=>1),
		            'order' => 'i.id_foto DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('tv/ajax-galeri-data-in', $data, false);
	}

	function ajaxPaginationGAL1(){
		$page = $this->input->post('pageGAL1', TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // galeri
	      
		  
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);

        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_u'=>1),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGAL1';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data
        $data['foto'] = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>1,'p.jenis_u'=>1),
		            'order' => 'i.id_foto DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('tv/ajax-galeri-data-1', $data, false);
	}

	// galeri kanan
	function ajaxPaginationGAL2(){
		$page = $this->input->post('pageGAL2', TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // galeri
	      
		  
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);

        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_u'=>1),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL2';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGAL2';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal);
        
        //get the posts data
        $data['foto_kanan'] = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_u'=>1),
		            'order' => 'i.id_foto DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('tv/ajax-galeri-data-2', $data, false);
	}
	// ./galeri kanan


	// galeri kanan
	function ajaxPaginationGALin2(){
		$page = $this->input->post('pageGAL2', TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // galeri
	      
		  
		$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);

        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_u'=>1),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL2';
        $config_gal['base_url']    = base_url().'tv/home/ajaxPaginationGALin2';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal);
        
        //get the posts data
        $data['foto_kanan'] = $this->general_model->datagrab(array(
		            'tabel' => $from_foto1,
					'where' => array('i.status'=>2,'p.jenis_u'=>1),
		            'order' => 'i.id_foto DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('tv/ajax-galeri-data-in2', $data, false);
	}
	// ./galeri kanan




	// ajax paginasi
	    function ajaxPaginationData()
    {


        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		$tanggal_widget = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'select'=> 'tgl_mulai,tgl_selesai',
			'where' => array('tipe'=>3)
			))->row();
        // PESERTA
	        $from = array(
		              'pes_kelas p' => '',
		              'peserta i' => array('i.id = p.id_peserta','left'),
		              'jadwal_ins j' => array('j.id = p.id_jadwal','left'),
		              'ref_instansi k' => array('k.id_instansi = j.id_instansi','left'),
		              'program l' => array('l.id = j.id_program','left'),
		              'program n' => array('n.id =p.program','left'),
		              'ref_jenis_client m' => array('m.id_jenis_client = j.id_jenis_client','left')
		            );
		          
		     $q_l = $this->general_model->datagrab(array(
		            'tabel' => $from,
		            'order' => 'j.tanggal1 ASC',
		            'where' => array('j.tanggal1 BETWEEN "'.$tanggal_widget->tgl_mulai.'" AND "'.$tanggal_widget->tgl_selesai.'" '=>null),
		            'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
		            'limit'=>$this->perPage
		          ));
        // ./PESERTA

        $totalRec = $this->general_model->datagrab(array(
        	'tabel'=>$from,'where' => array('j.tanggal1 BETWEEN "'.$tanggal_widget->tgl_mulai.'" AND "'.$tanggal_widget->tgl_selesai.'" '=>null)))->num_rows();
        
        //total rows count
        // $totalRec = count($this->post->getRows());
        
        //pagination configuration
        $config['target']      = '#postPST';
        $config['base_url']    = base_url().'tv/home/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['uri_segment'] = '4';
        
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['peserta'] = $this->general_model->datagrab(array(
		            'tabel' => $from,
		            'order' => 'j.tanggal1 ASC',
		            'where' => array('j.tanggal1 BETWEEN "'.$tanggal_widget->tgl_mulai.'" AND "'.$tanggal_widget->tgl_selesai.'" '=>null),
		            
		            'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
		            'limit'=>$this->perPage,
		            'offset'=>$offset
		          ))->result();
        
        //load the view
        $this->load->view('tv/ajax-peserta-data', $data, false);
    }
	// ./ajax paginasi

	
	function get_durasi($id){

		$row = $this->general_model->datagrab(array(
				'tabel'=> 'tvpeg_widget',
			'where' => array('id_widget'=>$id)
			))->row();
		$durasi  = !empty($row) ? $row->durasi: 0.05;
		die(json_encode($durasi));
	}
	function teksbergerak() {
		$par = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi'),2);
		$mar = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_teks','limit' => 10,'offset' => 0));
		
		echo '
		<marquee class="marquee-box">
			<div >'; 
					$j = 1;
					foreach($mar->result() as $m) { 
						$star = ($j > 1) ? '&nbsp;&nbsp;<img src="'.base_url('uploads/logo/'.$par['pemerintah_logo']).'" height="50">&nbsp;&nbsp; ': null;
						echo ''.$star.'<b>'.$m->teks.'</b> ';
						$j+=1;
					}
			echo '
			</div>
		</marquee>';
		
		
	}
	
	function unitbingkai() {
		
		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1),
			'order' => 'urut'));	
			
		$this->load->view('tv/tv_unitbingkai_view',$data);
		
	}

	function get_durasi_sc($durasi, $st_data = 0, $tot=0){
		
		$data = '<script type="text/javascript">';

		if ($st_data == 1) { 
			$data .='
				var st_data = 1;
				var durasi = 4;
				
				var lf = 2;
				var max_lf = '.$tot.';

				setInterval(
				function() {
					
					if (parseInt(lf) == 1) $(\'#lf\'+max_lf).hide();
					else $(\'#lf\'+parseInt(lf-1)).hide();
					
					$(\'.no_kiri\').html(lf).show();
					$(\'#no_kiri\').attr(\'value\',lf);
					$(\'#lf\'+lf).fadeIn();
					
					if (parseInt(lf) == max_lf) lf = 1;
					else lf+=1;		

					$.ajax({
						url: \''.site_url("tv/home/get_durasi/").'/\'+ lf,
						method: \'GET\',
						dataType:"JSON",
						success: function(msg) {
							durasi = msg;
							store_int(durasi);
							get_durasi_sc(durasi, st_data, max_lf);
							console.log(durasi);
						},error:function(error){
							show_error(\'ERROR : \'+error).show();
						}
					});
				},

				parseFloat('.$durasi.')*60000);

				$(\'#lf1\').fadeIn();
				$(\'.no_kiri\').html(1).show();
			';

		} else {
			
		$data .= "$('#lf1').fadeIn();";
	
		}
	
		$data .='</script>';

		die(json_encode($st_dat));
		
	}
	
}

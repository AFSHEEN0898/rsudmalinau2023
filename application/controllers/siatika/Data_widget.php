<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_widget extends CI_Controller {
	var $dir = 'widget_ids/widget';

	function __construct() {
		parent::__construct();
		$this->in_app = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
		$this->load->library(array(
			'ajax_pagination_duk','ajax_pagination_jadwal','ajax_pagination_jadwal_bs','ajax_pagination_gol_ess_fung','ajax_pagination_unker_gol','ajax_pagination_jenkel_gol',
			'ajax_pagination_gol_ess','ajax_pagination_unit_jenkel','ajax_pagination_pdd_ess','ajax_pagination_pdd_gol','ajax_pagination_satyalencana',
			'ajax_pagination_rkp_pdd','ajax_pagination_rkp_pensiun','ajax_pagination_rkp_ess','ajax_pagination_rkp_usia',
			'ajax_pagination_unker_ess','ajax_pagination_rkp_agama','ajax_pagination_kenpa','ajax_pagination_kgb','ajax_pagination_pensiun'

			));
	}

	public function index() {
		echo "INDEX";
	}

	function lap_duk($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapDuk');
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
					'peg_pegawai vp' => '',
					'ref_agama a' => array('a.id_agama = vp.id_agama','left'),
					'ref_lokasi l' => array('l.id_lokasi = vp.id_tempat_lahir','left'),
					'peg_pangkat vg' => array('vg.id_pegawai = vp.id_pegawai AND vg.status = 1','left'),
					'ref_golru rp' => array('rp.id_golru = vg.id_golru','left'),
					'peg_jabatan j' => array('j.id_pegawai=vp.id_pegawai AND j.status = 1','left'),
					'ref_status_pegawai sp' => 'sp.id_status_pegawai = j.id_status_pegawai AND sp.tipe = 1',
					'ref_jabatan jab' => array('jab.id_jabatan = j.id_jabatan','left'),
					'ref_eselon e' => array('e.id_eselon = jab.id_eselon','left'),
					'ref_bidang b' => array('b.id_bidang = j.id_bidang','left'),
					'ref_unit u' => array('u.id_unit = j.id_unit','left'),
					'peg_formal vpd' => array('vp.id_pegawai=vpd.id_pegawai and vpd.status = 1','left'),
					'ref_jurusan jr' => array('jr.id_jurusan = vpd.id_jurusan','left'),
					'ref_bentuk_pendidikan pnd' => array('pnd.id_bentuk_pendidikan = vpd.id_bentuk_pendidikan','left'),
					'ref_jenjang jj' => array('jj.id_jenjang  = pnd.id_jenjang','left'),
					'peg_diklatpim pd' => array('vp.id_pegawai = pd.id_pegawai AND pd.status = 1','left'),
					'ref_diklatpim rd' => array('pd.id_diklatpim = rd.id_diklatpim','left')	
				);
				$select = 
					'concat(ifnull(vp.gelar_depan,"")," ",vp.nama,if(((vp.gelar_belakang = "") or isnull(vp.gelar_belakang)),"",concat(" ",vp.gelar_belakang))) AS nama_pegawai,
					vp.photo,
					vp.tanggal_lahir,
					a.agama,
					l.lokasi as tempat_lahir,
					vp.nip,
					j.tmt_jabatan,
					jab.nama_jabatan,
					vg.tmt_pangkat as tmt_cp,
					u.unit,
					b.nama_bidang,
					e.id_eselon,
					e.eselon,
					rp.golongan,
					vg.tmt_pangkat,
					vg.mkg_tahun,
					vg.mkg_bulan,
					pnd.singkatan_pendidikan as jenjang,
					sp.tipe,
					IF(jr.jurusan ="","",CONCAT(" - ",jr.jurusan)) jurusan,
					vpd.tahun_selesai,
					YEAR(pd.tanggal_selesai) as tahun_diklat,rd.diklatpim,
					CONCAT(
						TIMESTAMPDIFF(YEAR,vp.tanggal_lahir,CURDATE()),
						" thn ",
						MOD(TIMESTAMPDIFF(MONTH,vp.tanggal_lahir,CURDATE()),12)," bln"
					) AS age
				';

				$order = '
						vg.id_golru desc,
						vg.tmt_pangkat asc,
				
						ISNULL(e.id_eselon) asc, 
						e.id_eselon asc, 
						j.tmt_jabatan asc, 
						
						vp.cpns_tmt asc,
						rd.id_diklatpim desc,
						
						jj.id_jenjang desc,
						vp.tanggal_lahir desc';

				$where = array('u.aktif' => 1, 'vp.id_pegawai not in (
		                    select id_pegawai from peg_pensiun
		                )'=>null);
				if (!empty($data['search']['id'])) {
					
					$un = $this->general_model->datagrab(array(
						'tabel' => 'ref_unit','where' => array('id_unit' => $data['search']['id'])
					))->row();
					
					$data['sgle_unit'] = @$un->unit;
					$data['sgle_id'] = $data['search']['id'];
					$where = array('u.id_unit' => $data['search']['id'], 'vp.id_pegawai not in (
		                    select id_pegawai from peg_pensiun
		                )'=>null);
				}

		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => $select,
							'where' => $where))->num_rows();

		$config_widget['pag_name']      = 'LapDuk';
		$config_widget['target']      = '#postLapDuk';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_duk/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';
		
		$this->ajax_pagination_duk->initialize($config_widget);

		$dtduk = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => $order,
			'where' => $where));
		// cek($offset);

		$border = 'border="1"';

		$this->table->set_template(array('table_open'=>'<table style="'.$te.'" class="table no-fluid table-bordered tabel_print on-fittop" width="100%" '.$border.'>'));
		$head = array(array('data' => 'NO', 'class' => 'add_th bg-gray'));
		$s = 1;
		if (in_array('nama',$data['search']['kolom']) or in_array('ttl',$data['search']['kolom'])) { 
			$head[] = array('data' => 'NAMA PEGAWAI / NIP / TEMPAT TANGGAL LAHIR','class' => 'add_th bg-gray'); $s+=1; } ;
		/*if (in_array('nip',$data['search']['kolom'])) { $head[] = array('data' => 'NIP','rowspan'=> 2,'class' => 'add_th'); $s+=1; }*/
		if (in_array('golru',$data['search']['kolom'])) { $head[] = array('data' => 'GOLRU / TMT','class' => 'add_th bg-gray');$s+=1; }
		if (in_array('jabatan',$data['search']['kolom'])) { $head[] = array('data' => 'ESELON / JABATAN / TMT','class' => 'add_th bg-gray');$s+=1; }
		if (in_array('mkg',$data['search']['kolom'])) { $head[] = array('data' => 'MASA KERJA TAHUN BULAN','class' => 'add_th bg-gray',);$s+=1; }
		if (in_array('diklat',$data['search']['kolom'])) { $head[] = array('data' => 'LATIHAN JABATAN','class' => 'add_th bg-gray');$s+=1; }
		if (in_array('pendidikan',$data['search']['kolom'])) { $head[] = array('data' => 'PENDIDIKAN AKHIR','class' => 'add_th bg-gray');$s+=1; }
		/*if (in_array('usia',$data['search']['kolom'])) { $head[] = array('data' => 'USIA','class' => 'add_th');$s+=1; }*/
		$this->table->set_heading($head);
		
		$re = array();
		for($i = 1; $i <= $s; $i++) { 
		$re[] = array('data' => '<i>'.$i.'</i>','class' => 'add_th bg-gray', 'align'=>'center');
		}
		$this->table->add_row($re);
		
		$no = 1+$offset;
		foreach($dtduk->result() as $row) {
		
			$tmt_cp = (!empty($row->cpns_tmt)?$row->cpns_tmt:(!empty($row->tmt_cp)?$row->tmt_cp:null));
		
			$rows = array(array('data' =>$no.'.','valign' => 'top', 'align'=>'center'));
			$nm = array();
			$tgl_lahir = ($row->tanggal_lahir!=NULL) ? tanggal($row->tanggal_lahir) : NULL;
			
			if (in_array('nama',$data['search']['kolom'])) $nm[] = $row->nama_pegawai;
			if (in_array('nama',$data['search']['kolom'])) $nm[] = $row->nip;
			if (in_array('ttl',$data['search']['kolom'])) $nm[] = $row->tempat_lahir.', '.$tgl_lahir; 

			$rows[] = implode('<br>',$nm);

			/*if (in_array('nip',$data['search']['kolom'])) $rows[] = $row->nip;*/
			if (in_array('golru',$data['search']['kolom'])) {
				$rows[] = $row->golongan.' '.tanggal($row->tmt_pangkat);
				/*$rows[] = tanggal($row->tmt_pangkat);*/
			}
			if (in_array('jabatan',$data['search']['kolom'])) {
					/*$rows[] = $row->eselon;*/
					$rows[] = $row->eselon .'<br>'.strtoupper(merger($row->nama_jabatan,$row->nama_bidang,$row->unit)).'<br>'.tanggal($row->tmt_jabatan);
					/*$rows[] = tanggal($row->tmt_jabatan);*/
			}
			if (in_array('mkg',$data['search']['kolom'])) {
				if (!empty($row->mkg_tahun) and !empty($row->mkg_bulan)) $mkg_tampil = $row->mkg_tahun.' thn '.$row->mkg_bulan.' bln';
				else $mkg_tampil = !empty($tmt_cp)?umur($tmt_cp):'-';
				$rows[] = '<span class="no-wrap">'.$mkg_tampil.'</span>';
			}
			if (in_array('diklat',$data['search']['kolom'])) {
				$rows[] = $row->diklatpim.'<br>'.$row->tahun_diklat;
				/*$rows[] = $row->tahun_diklat;*/
			}
			if (in_array('pendidikan',$data['search']['kolom'])) {
				$rows[] = $row->jenjang.$row->jurusan.'<br>'.$row->tahun_selesai;
				/*$rows[] = $row->tahun_selesai;*/
			}
			/*if (in_array('usia',$data['search']['kolom'])) $rows[] = '<span class="no-wrap">'.@$row->age.'</span>';*/
			
			// Opsional Suku //
			if (!empty($sk) and $sk == 1) {
			
			if (in_array('suku',$data['search']['kolom'])) $rows[] = $row->suku;
			if (in_array('wildat',$data['search']['kolom'])) $rows[] = $row->wilayah_adat;
			if (in_array('suku_tipe',$data['search']['kolom'])) $rows[] = $row->papua_nonpapua;
			
			}
			
			// Opsional Foto Pegawai //
			$ava = (!empty($row->photo) and file_exists('./uploads/kepegawaian/pasfoto/'.$row->photo))?
				base_url().'uploads/kepegawaian/pasfoto/'.$row->photo :
				base_url().'assets/images/avatar.gif'; 
			if (in_array('foto',$data['search']['kolom'])) $rows[] = '
				<div class="pasfoto"><img src="'.$ava.'"></div>
			';

			$this->table->add_row($rows); $no += 1;	
		}

		$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_duk->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_duk_ajax',$data);
	}

	//rincian agenda kegiatan
	function lap_jadwal($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapjadwal');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		$from = array(
				'sch_jadwal a' => '',
				'sch_ref_program b' => array('b.id_ref_program = a.id_ref_program','left'),
				'sch_ref_kegiatan c' => array('c.id_ref_kegiatan = a.id_ref_kegiatan','left'),
				'sch_color d' => array('d.id_color = a.id_color','left'),
				'peg_pegawai e' => array('e.id_pegawai = a.id_pegawai','left'),
				'sch_ref_tahun f' => array('f.id_tahun = a.id_tahun','left')
			);
		$select = '*';
		$select = 'a.*,b.nama_program,c.nama_kegiatan,d.color,e.nama as nama_pegawai,e.photo,f.tahun';
		$where = array('f.tahun = YEAR(NOW())'=>null);
		$order ='a.status ASC,a.tgl_mulai ASC';

	     $total_rows = $this->general_model->datagrab(array(
			'tabel' => $from, 
					'select'=>'a.*,b.nama_program,c.nama_kegiatan,d.color,e.nama as nama_pegawai,e.photo,f.tahun',
					'order'=>'a.status ASC,a.tgl_mulai ASC',
					'select' => $select,
					'order' => $order,
					'where' => $where
			))->num_rows();

	    $config_widget['target']      = '#postPensiun';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		
		$dtjadwal = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => $order,
			'where' => $where));
				
			
		if ($dtjadwal->num_rows() > 0) {
			$heads3[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads3[] = array('data' => 'Rincian Kegiatan','style'=>'background-color: #e8e8e8;width:42%');
			$heads3[] = array('data' => 'Tgl Mulai & Selesai','style'=>'background-color: #e8e8e8;width:30%');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads3);

			$no = 1+$offset;
			foreach ($dtjadwal->result() as $row) {
				$rows = array();
				$jumlah_karakter_keg=strlen($row->nama_kegiatan);
				$rows[] = 	array('data'=>$no,'style'=>'text-align:center;background:'.$row->color.' !important;color:#fff !important;');
				if(strlen($row->nama_kegiatan) >= 30){
					$waktu = currencyToNumber($row->jeda)*10000;
					$rows[] = array('data' => '<marquee scrolldelay="'.$waktu.'">'.$row->nama_kegiatan.'</marquee>');
					//$rows[] = 	'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_kegiatan.'</marquee></div>';
				}else{
					$rows[] = 	array('data'=>$row->nama_kegiatan);
				}
				if($row->tgl_mulai != 0000-00-00 and $row->tgl_mulai != NULL){
					$rows[] = 	array('data'=>
						((substr($row->tgl_mulai,5,2) == date('m')) ? '<span style="color:red; text-align:center;font-weight:bold;font-size:12px !Important">'.tanggal($row->tgl_mulai).'</span>' : tanggal($row->tgl_mulai)).
						'<span class="badgex"> s.d </span> '.((substr($row->tgl_selesai,5,2) == date('m')) ? '<span style="color:red; text-align:center;font-weight:bold;font-size:12px !Important">'.tanggal($row->tgl_selesai).'</span>' : tanggal($row->tgl_selesai)));

				}else{
					$rows[] = 	array('data'=>'Belum ada tanggal','style'=>'text-align:center;');
				}

				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}

	//rincian agenda bulan ini
	function agenda_bulanini($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapjadwal');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		$form_mingguini = array(
			'sch_jadwal a' => '',
			'sch_ref_program b' => array('b.id_ref_program = a.id_ref_program','left'),
			'sch_ref_kegiatan c' => array('c.id_ref_kegiatan = a.id_ref_kegiatan','left'),
			'sch_ref_rincian g' => array('g.id_ref_rincian = a.id_ref_rincian','left'),
			'sch_color d' => array('d.id_color = a.id_color','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_pegawai','left')
		);
		$select ='a.*,b.nama_program,c.nama_kegiatan,d.color,e.nama as nama_pegawai,e.photo,g.nama_rincian';
		$where =array('MONTH(a.tgl_selesai)='.date('m')=>null);
		$order ='a.tgl_mulai ASC';

	    $total_rows = $this->general_model->datagrab(array(
			'tabel' => $form_mingguini, 
					'select'=>$select,
					'select' => $select,
					'order' => $order,
					'where' => $where
			))->num_rows();

	    $config_widget['target']      = '#postPensiun';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		$data['detail_kegiatan_mi']= $this->general_model->datagrab(array(
			'tabel' => $form_mingguini,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => $order,
			'where' => $where));

		$data['paging_sub'] = $this->ajax_pagination_jadwal_bs->create_links(@$jeda_dalam, @$post);
		$this->load->view('widget_ids/widget_bs_ajax',$data);
	}

	//rincian agenda kegiatan
	function agenda_bulandepan($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapjadwal');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		$form_mingguini = array(
			'sch_jadwal a' => '',
			'sch_ref_program b' => array('b.id_ref_program = a.id_ref_program','left'),
			'sch_ref_kegiatan c' => array('c.id_ref_kegiatan = a.id_ref_kegiatan','left'),
			'sch_ref_rincian g' => array('g.id_ref_rincian = a.id_ref_rincian','left'),
			'sch_color d' => array('d.id_color = a.id_color','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_pegawai','left')
		);
		$select ='a.*,b.nama_program,c.nama_kegiatan,d.color,e.nama as nama_pegawai,e.photo,g.nama_rincian';
		
				$where = array('MONTH(a.tgl_mulai)='.date('m', strtotime('+1 months'))=>null);
		$order ='a.tgl_mulai ASC';

	    $total_rows = $this->general_model->datagrab(array(
			'tabel' => $form_mingguini, 
					'select'=>$select,
					'select' => $select,
					'order' => $order,
					'where' => $where
			))->num_rows();

	    $config_widget['target']      = '#postPensiun';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		$data['detail_kegiatan_mi']= $this->general_model->datagrab(array(
			'tabel' => $form_mingguini,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => $order,
			'where' => $where));

		$data['paging_sub'] = $this->ajax_pagination_jadwal_bs->create_links(@$jeda_dalam, @$post);
		$this->load->view('widget_ids/widget_bs_ajax',$data);
	}

	//surat masuk
	function lap_surat_masuk($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapsm');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		 $from = array(
				'tnde_surat_masuk a' => ''
			);


		$select = '*';

	     $total_rows = $this->general_model->datagrab(array(
			'tabel' => $from, 
					'select'=>'*',
					'order'=>'a.tgl_surat_dari ASC',
					'select' => $select
			))->num_rows();


	    $config_widget['target']      = '#postsuratMasuk';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		
		$surat_masuk = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select));
				
			
		if ($surat_masuk->num_rows() > 0) {
			$heads99[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads99[] = array('data' => 'No. Surat','style'=>'background-color: #e8e8e8;width:42%');
			$heads99[] = array('data' => 'Tanggal Masuk','style'=>'background-color: #e8e8e8;width:30%');
			$heads99[] = array('data' => 'Dari','style'=>'background-color: #e8e8e8;width:30%');
			$heads99[] = array('data' => 'Perihal','style'=>'background-color: #e8e8e8;width:30%');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads99);
			
			$no = 1+$offset;
			foreach ($surat_masuk->result() as $row) {
				$rows = array();
				$rows[] = 	array('data'=>$no);
				$rows[] = 	array('data'=>$row->nomor_surat_dari);				
				$rows[] = 	array('data'=>tanggal($row->tgl_surat_dari));
				$jumlah_karakter_keg=strlen($row->dari);
				if(strlen($row->dari) >= 40){
					$waktu = currencyToNumber($row->jeda)*10000;
					$rows[] = array('data' => '<marquee scrolldelay="'.$waktu.'">'.$row->dari.'</marquee>');
					//$rows[] = 	'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_kegiatan.'</marquee></div>';
				}else{
					$rows[] = 	array('data'=>$row->dari);
				}
				$jumlah_karakter_keg=strlen($row->perihal_dari);
				if(strlen($row->perihal_dari) >= 40){
					$waktu = currencyToNumber($row->jeda)*10000;
					$rows[] = array('data' => '<marquee scrolldelay="'.$waktu.'">'.$row->perihal_dari.'</marquee>');
					//$rows[] = 	'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_kegiatan.'</marquee></div>';
				}else{
					$rows[] = 	array('data'=>$row->perihal_dari);
				}

				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}


	//surat masuk
	function lap_surat_keluar($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapsm');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		 $from = array(
				'tnde_surat_keluar a' => ''
			);


		$select = '*';

	     $total_rows = $this->general_model->datagrab(array(
			'tabel' => $from, 
					'select'=>'*',
					'order'=>'a.tgl_surat ASC',
					'select' => $select
			))->num_rows();


	    $config_widget['target']      = '#postsuratMasuk';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		
		$surat_keluar = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select));
		
		if ($surat_keluar->num_rows() > 0) {
			$heads99[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads99[] = array('data' => 'No. Surat','style'=>'background-color: #e8e8e8;width:42%');
			$heads99[] = array('data' => 'Tanggal','style'=>'background-color: #e8e8e8;width:30%');
			$heads99[] = array('data' => 'Kepada','style'=>'background-color: #e8e8e8;width:30%');
			$heads99[] = array('data' => 'Perihal','style'=>'background-color: #e8e8e8;width:30%');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads99);

			$no = 1+$offset;
			foreach ($surat_keluar->result() as $row) {
				$rows = array();
				$rows[] = 	array('data'=>$no);
				$rows[] = 	array('data'=>$row->nomor_surat);				
				$rows[] = 	array('data'=>tanggal($row->tgl_surat));
				$jumlah_karakter_keg=strlen($row->kepada);
				if(strlen($row->kepada) >= 40){
					$waktu = currencyToNumber($row->jeda)*10000;
					$rows[] = array('data' => '<marquee scrolldelay="'.$waktu.'">'.$row->kepada.'</marquee>');
					//$rows[] = 	'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_kegiatan.'</marquee></div>';
				}else{
					$rows[] = 	array('data'=>$row->kepada);
				}
				if(strlen($row->perihal) >= 40){
					$waktu = currencyToNumber($row->jeda)*10000;
					$rows[] = array('data' => '<marquee scrolldelay="'.$waktu.'">'.$row->perihal.'</marquee>');
					//$rows[] = 	'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_kegiatan.'</marquee></div>';
				}else{
					$rows[] = 	array('data'=>$row->perihal);
				}

				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		
		
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}

	//pengumuman
	function pengumuman($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapsm');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		 $from = array(
				'krd_pengumuman a' => ''
			);


		$select = '*';
		$where = array('id_pengumuman'=>$en->param3);

	     $total_rows = $this->general_model->datagrab(array(
			'tabel' => $from, 
					'select'=>'*',
					'order'=>'a.tanggal ASC',
					'select' => $select,
					'where' => $where
			))->num_rows();


	    $config_widget['target']      = '#postsuratMasuk';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		
		$q = $this->general_model->datagrab(array(
			'tabel' => 'krd_pengumuman',
			'order' => 'urut',
					'where' => $where
		));

		if ($q->num_rows() > 0) {
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$heads = array('No','Tanggal','Judul','Konten','Oleh');
			if (!in_array($offset,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => '4');
			$this->table->set_heading($heads);
			
			$no = 1;
			
			$j = 1;
			$sel = array();
			foreach($q->result() as $row){
				if ($j > 1) $sel[] = array('id' => $row->id_pengumuman,'urut' => $row->urut);
 				$j+=1;
			}
			$aft = null;
			foreach($q->result() as $row){
				
				$trn = ($no < $q->num_rows() and $q->num_rows() > 1) ? anchor('simkordani/pengumuman/trade/'.$row->id_pengumuman.'/'.$row->urut.'/'.$sel[$no-1]['id'].'/'.$sel[$no-1]['urut'],'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info"') : null;
				$naik = ($no > 1 and $q->num_rows() > 1)  ? anchor('simkordani/pengumuman/trade/'.$row->id_pengumuman.'/'.$row->urut.'/'.$aft['id'].'/'.$aft['urut'],'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info"') : null;
				$rows = array($no);
			
				$rows[] = tanggal($row->tanggal);
				$rows[] = $row->judul;
				$rows[] = (strlen($row->konten) > 30) ? strip_tags(substr($row->konten,0,100)).' ...': $row->konten;
				$rows[] = $row->oleh;
			
				if (!in_array($offset,array('cetak','excel'))) {
					
					$rows[] = anchor('#', '<i class="fa fa-pen"></i>','class="btn btn-edit btn-xs btn-warning" act="'.site_url('simkordani/pengumuman/form_data/'.$row->id_pengumuman).'"');
					$rows[] = anchor('#','<i class="fa fa-trash"></i>','class="btn-delete btn btn-xs btn-danger" act="'.site_url('simkordani/pengumuman/delete_data/'.$row->id_pengumuman).'" msg="Apakah Anda ingin menghapus data ini?"');
					$rows[] = '<span class="no-wrap">'.$trn.$naik.'</span>';
					$rows[] = 
						anchor('simkordani/pengumuman/detail/'.$row->id_pengumuman,'<i class="fa fa-info fa-btn"></i> Detail','class="btn btn-primary btn-xs btn-edit"').' '.
						anchor('simkordani/pengumuman/bagikan/'.in_de(array('id' => $row->id_pengumuman)),'<i class="fa fa-microphone fa-btn"></i> Koordinasi','class="btn btn-warning btn-xs"');
				}
				
				$this->table->add_row($rows);
				$aft = array('id' => $row->id_pengumuman,'urut' => $row->urut);
				$no+=1;
				
			}
	
			$tabel = $this->table->generate();
		} else {
			$tabel = '<div class="alert">Belum ada pengumuman ...</div>';
		}
		
		
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}

	//galeri Kiri
	function gal_kiri($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapsm');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		 $from = array(
				'krd_galeri a' => ''
			);


		$select = '*';
		$where = array('posisi'=>@$en->param1,'status'=>1);

	     $total_rows = $this->general_model->datagrab(array(
			'tabel' => $from, 
					'select'=>'*',
					'order'=>'a.tanggal ASC',
					'select' => $select,
					'where' => $where
			))->num_rows();


	    $config_widget['target']      = '#postgalkir';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/gal_kiri/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		
		$q = $this->general_model->datagrab(array(
			'tabel' => 'krd_galeri',
			'order' => 'urut',
					'where' => $where
		));

		if ($q->num_rows() > 0) {
			$classy =  'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$heads = array('No','Galeri','Judul','Tanggal');
			if (!in_array($offset,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => '4');
			$this->table->set_heading($heads);
			
			$no = 1;
			
			$j = 1;
			$sel = array();
			foreach($q->result() as $row){
				if ($j > 1) $sel[] = array('id' => $row->id_galeri,'urut' => $row->urut);
 				$j+=1;
			}

			$aft = null; $pos = array(0=>'-',1=>'Kiri', 2=>'Kanan');
			foreach($q->result() as $row){
					$trn = ($no < $q->num_rows() and $q->num_rows() > 1) ? anchor('simkordani/galeri/trade/'.$row->id_galeri.'/'.$row->urut.'/'.$sel[$no-1]['id'].'/'.$sel[$no-1]['urut'],'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info btn-flat"') : null;
					$naik = ($no > 1 and $q->num_rows() > 1)  ? anchor('simkordani/galeri/trade/'.$row->id_galeri.'/'.$row->urut.'/'.$aft['id'].'/'.$aft['urut'],'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info btn-flat"') : null;
					$rows = array($no);
				
					$rows[] = 
						'<img src="'.base_url().'uploads/tvinfo/'.$row->foto.'" style="max-width: 100px; max-height: 50%"/>';
				
					$rows[] = substr($row->judul, 0, 100).'...';
					$rows[] = tanggal($row->tanggal);
				
					if (!in_array($offset,array('cetak','excel'))) {
						
						$rows[] = anchor('#', '<i class="fa fa-pen"></i>','class="btn btn-edit btn-flat btn-xs btn-warning" act="'.site_url('simkordani/galeri/form_data/'.$row->id_galeri).'"');
						$rows[] = anchor('#','<i class="fa fa-trash"></i>','class="btn-delete btn btn-xs btn-flat btn-danger" act="'.site_url('simkordani/galeri/delete_data/'.$row->id_galeri).'" msg="Apakah Anda ingin menghapus data ini?"');
						$rows[] = '<span class="no-wrap">'.$trn.'&nbsp;&nbsp;&nbsp;'.$naik.'</span>';
						$rows[] = anchor('simkordani/galeri/bagikan/'.in_de(array('id' => $row->id_galeri)),'<i class="fa fa-microphone fa-btn"></i> Koordinasi','class="btn btn-warning btn-xs"');
					}
					
					$this->table->add_row($rows);
					$aft = array('id' => $row->id_galeri,'urut' => $row->urut);
					$no+=1;
			}

			$tabel = $this->table->generate();

		} else {
			$tabel = '<div class="alert">Belum ada Galeri ...</div>';
		}
		
		
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}

	//galeri Kiri
	function gal_kanan($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapsm');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		 $from = array(
				'krd_galeri a' => ''
			);


		$select = '*';
		$where = array('posisi'=>@$en->param1,'status'=>1);

	     $total_rows = $this->general_model->datagrab(array(
			'tabel' => $from, 
					'select'=>'*',
					'order'=>'a.tanggal ASC',
					'select' => $select,
					'where' => $where
			))->num_rows();


	    $config_widget['target']      = '#postsuratMasuk';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);

		
		$q = $this->general_model->datagrab(array(
			'tabel' => 'krd_galeri',
			'order' => 'urut'
		));

		if ($q->num_rows() > 0) {
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$heads = array('No','Galeri','Judul','Tanggal','Durasi Tampil','Status');
			if (!in_array($offset,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => '4');
			$this->table->set_heading($heads);
			
			$no = 1;
			
			$j = 1;
			$sel = array();
			foreach($q->result() as $row){
				if ($j > 1) $sel[] = array('id' => $row->id_galeri,'urut' => $row->urut);
 				$j+=1;
			}

			$aft = null; $pos = array(0=>'-',1=>'Kiri', 2=>'Kanan');
			foreach($q->result() as $row){
					$trn = ($no < $q->num_rows() and $q->num_rows() > 1) ? anchor('simkordani/galeri/trade/'.$row->id_galeri.'/'.$row->urut.'/'.$sel[$no-1]['id'].'/'.$sel[$no-1]['urut'],'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info btn-flat"') : null;
					$naik = ($no > 1 and $q->num_rows() > 1)  ? anchor('simkordani/galeri/trade/'.$row->id_galeri.'/'.$row->urut.'/'.$aft['id'].'/'.$aft['urut'],'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info btn-flat"') : null;
					$rows = array($no);
				
					$rows[] = 
						'<img src="'.base_url().'uploads/tvinfo/'.$row->foto.'" style="max-width: 100px; max-height: 50%"/>';
				
					$rows[] = substr($row->judul, 0, 10).'...';
					$rows[] = tanggal($row->tanggal);
					/*$rows[] = (strlen($row->keterangan) > 30) ? substr($row->keterangan,0,30).' ...': $row->keterangan;*/
					$rows[] = array('data'=>@$row->jeda.' Detik');
				
					if (!in_array($offset,array('cetak','excel'))) {
						if(@$row->status==1){
							$rows[] = array('data'=>anchor(site_url($this->dir.'/change_status/'.in_de(array('id_galeri'=>$row->id_galeri,'kd'=>'0')) ), '<i class="fa fa-power-off"></i>', 'class="btn btn-success btn-flat btn-xs" title="Klik Untuk Menon-aktifkan"'), 'align'=>'center');
						}else{
							$rows[] = array('data'=>anchor(site_url($this->dir.'/change_status/'.in_de(array('id_galeri'=>$row->id_galeri,'kd'=>'1')) ), '<i class="fa fa-power-off"></i>', 'class="btn btn-default btn-flat btn-xs" title="Klik Untuk Mengaktifkan"'), 'align'=>'center');
						}
						$rows[] = anchor('#', '<i class="fa fa-pen"></i>','class="btn btn-edit btn-flat btn-xs btn-warning" act="'.site_url('simkordani/galeri/form_data/'.$row->id_galeri).'"');
						$rows[] = anchor('#','<i class="fa fa-trash"></i>','class="btn-delete btn btn-xs btn-flat btn-danger" act="'.site_url('simkordani/galeri/delete_data/'.$row->id_galeri).'" msg="Apakah Anda ingin menghapus data ini?"');
						$rows[] = '<span class="no-wrap">'.$trn.'&nbsp;&nbsp;&nbsp;'.$naik.'</span>';
						$rows[] = anchor('simkordani/galeri/bagikan/'.in_de(array('id' => $row->id_galeri)),'<i class="fa fa-microphone fa-btn"></i> Koordinasi','class="btn btn-warning btn-xs"');
					}
					
					$this->table->add_row($rows);
					$aft = array('id' => $row->id_galeri,'urut' => $row->urut);
					$no+=1;
			}

			$tabel = $this->table->generate();

		} else {
			$tabel = '<div class="alert">Belum ada Galeri ...</div>';
		}
		
		
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}

	//data presensi
	function data_presensi($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapsm');
		// cek($post);
		// cek($page);
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

  		$from = array(
	                "pesta_pegawai_log s"=>'',
	                'pesta_pegawai pp'=>array('pp.id_pegawai=s.id_pegawai','left'),
	                "peg_pegawai p"=>array('p.id_pegawai=pp.id_pegawai','left'),
	                'pesta_ref_status rs'=>array('rs.id_status =s.status','left'),
                );
		$select = '*';
		$where = array('DATE_FORMAT(s.tanggaljam, "%Y-%m-%d")="'.DATE('Y-m-d').'"'=>NULL);
		//$where = NULL;
		$order ='s.id_pesta DESC';

	     $total_rows = $this->general_model->datagrab(array(
			'tabel' => $from,
					'order'=>$order,
					'select' => $select,
					'order' => $order,
					'where' => $where
			))->num_rows();
	    $config_widget['target']      = '#postsuratMasuk';
        $config_widget['base_url']    =  $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_jadwal/'.$id_widget.'/'.$jeda_dalam.'/';
          $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';


		$this->ajax_pagination_jadwal->initialize($config_widget);
$dtjadwal = $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config_widget['per_page'],
			'offset' => $offset,
			'select' => $select,
			'order' => $order,
			'where' => $where));
		//cek($this->db->last_query());
		if ($dtjadwal->num_rows() > 0) {
			$heads3[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads3[] = array('data' => 'Nama Pegawai','style'=>'background-color: #e8e8e8;width:42%');
			$heads3[] = array('data' => 'Hadir','style'=>'background-color: #e8e8e8;width:30%');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads3);

			$no = 1+$offset;
			foreach ($dtjadwal->result() as $row) {
				$rows = array();
				$rows[] = 	array('data'=>$no,'style'=>'text-align:center;');
				$rows[] = 	array('data'=>$row->nama,'style'=>'text-align:center;');
				$rows[] = 	array('data'=>$row->status,'style'=>'text-align:center;');
				
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}

	function lap_stt_unker_ess($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapUnkerEss');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 10;

	    if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		if (@$en->param4!=NULL AND @$en->param5!=NULL) {
			$ess = $this->general_model->datagrab(array('tabel' => 'ref_eselon',
				'where'=>array('(urut BETWEEN '.$en->param4.' AND '.$en->param5.')'=>NULL, 'id_eselon <>' => 9), 'order' => 'urut', ));
		}else{
			$ess =  $this->general_model->datagrab(array(
					'tabel' => 'ref_eselon',
					'order' => 'urut',
					'where' => array('id_eselon <>' => 9)
					));
		}

		$where_un = array('aktif' => 1);
				$where_src = null;
				if (!empty($data['flt_pil']['unit'])) {
					$where_src.= ' AND jb.id_unit = '.$data['flt_pil']['unit'];
					$where_un['id_unit'] = $data['flt_pil']['unit'];
				}

		$total_rows = $this->general_model->datagrab(array(
					'tabel' => 'ref_unit','where' => $where_un
				))->num_rows;
		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 10;
		$config_widget['target']      = '#postLapUnkerEss';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_unker_ess/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';
		
		$this->ajax_pagination_unker_ess->initialize($config_widget);

		$unker = $this->general_model->datagrab(array(
					'tabel' => 'ref_unit','where' => $where_un, 'limit'=>$config_widget['per_page'], 'offset'=>$offset
				));

		$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
						"(select pj.id_pegawai as id_s,pj.id_jabatan, pj.id_unit from peg_jabatan pj join (select id_pegawai as id_peg 
							from peg_jabatan jb
							join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
							where sp.tipe = 1 and tmt_jabatan <= '".$data['flt_pil']['tgl']."' ".$where_src."
							order by tmt_jabatan desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai",
						"ref_jabatan e" => "e.id_jabatan = jbs.id_jabatan"),
					'where'=>array('p.id_pegawai not in (
					                    select id_pegawai from peg_pensiun
					                )'=>null),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,e.id_eselon,jbs.id_unit',
					'group_by' => 'p.id_jeniskelamin, e.id_eselon,jbs.id_unit'
				));

		$this->table->set_template(array('table_open' => '<table class="table table-bordered no-fluid" style="margin: 0px auto; '.$te.'">'));
	    $this->table->set_empty("&nbsp;");

		$i = 0;

		$head = array(array('data' => 'NO','rowspan' => 2,'width' => 40, 'class'=>'bg-gray'));
		$noe = array(array('data' => '<i>'.($i+=1).'</i>', 'class'=>'bg-gray'));
		
		$head[] = array('data' => 'Unit Kerja','rowspan' => 2,'align' => 'center', 'class'=>'bg-gray');
		$noe[] = array('data' => '<i>'.($i+=1).'</i>','align' => 'center', 'class'=>'bg-gray');
		foreach($ess->result() as $es) {
			if ($es->id_eselon != 9) {
				$head[] = array('data' => $es->eselon, 'colspan' => 2,'align' => 'center', 'class'=>'bg-gray');
				
			}
		}
		$head[] = array('data' => 'Total', 'colspan' => 3,'align' => 'center', 'class'=>'bg-gray');
		
		$this->table->add_row($head);
		
		$head = array();
		$l_unit = array();
		$p_unit = array();
		$s = 0;
		foreach($ess->result() as $es) {
				$l_unit[$s] = 0;
				$p_unit[$s] = 0;
				$head[] = array('data' => 'L','width' => 38,'align' => 'center', 'class'=>'bg-gray');
				$head[] = array('data' => 'P','width' => 38,'align' => 'center', 'class'=>'bg-gray');
				$noe = array_merge_recursive($noe,array(
					array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray'),
					array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray') ));
			$s+=1;
		}
		
		$head[] = array('data' => 'L','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
		$head[] = array('data' => 'P','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
		$head[] = array('data' => 'T','width' => 38,'align' => 'center', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		
		$this->table->add_row($head);
		$this->table->add_row($noe);

		$j = 0+$offset;
		$l_seluruh = 0;
		$p_seluruh = 0;
		
		
		foreach($unker->result() as $u) {
			$total = 0;
			$data_tabel = array();
			$data_tabel[] = array('data'=>$j+=1, 'class'=>'bg-gray');
			$data_tabel[] = array('data' => $u->unit, 'class'=>'bg-gray');
			$l_baris = 0;
			$p_baris = 0;
			$s = 0;
			foreach($ess->result() as $es) {
				$l = 0;
				foreach($jumlah->result() as $jum) {
		
					if ($jum->id_unit == $u->id_unit and $es->id_eselon == $jum->id_eselon and $jum->id_jeniskelamin == 1) {
						$l = $jum->total;
						$l_unit[$s] += $jum->total;
						$l_baris += $jum->total;
						$total += $jum->total;
						$l_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $l,'align' => 'center');
				$p = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_unit == $u->id_unit and $es->id_eselon == $jum->id_eselon and $jum->id_jeniskelamin == 2) {
						$p = $jum->total;
						$p_unit[$s] += $jum->total;
						$p_baris += $jum->total;
						$total += $jum->total;
						$p_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $p,'align' => 'center');
				$s+=1;
			}
			
			
			$data_tabel[] = array('data'=>$l_baris,'align'=>'center');
			$data_tabel[] = array('data'=>$p_baris,'align'=>'center');
			$data_tabel[] = array('data'=>$total,'align'=>'center');
			
			$this->table->add_row($data_tabel);
		
		}
		$data_total = array(array('align' => 'right','data' => '<b>TOTAL</b>','colspan' => 2));
		for($i = 0; $i < count($l_unit); $i++) {
			$data_total[] = array('data'=>$l_unit[$i],'align'=>'center');
			$data_total[] = array('data'=>$p_unit[$i],'align'=>'center');
		}
		
		$this->table->add_row(array_merge_recursive($data_total,array(
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'))));

		$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_unker_ess->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_unker_ess_ajax',$data);
	}

	function lap_stt_gol_ess_fung($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		$page = $this->input->post('page_lapGolEssFung');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 10;

	    $where_u = array();
		if(@$en->param3!=NULL){
			$where_u = array('a.id_unit'=>$en->param3);
		}

	    $total_rows = $this->general_model->datagrab(array(
	    	'tabel' => array('peg_jabatan a'=>'',
	    		'ref_jabatan b'=>array('a.id_jabatan=b.id_jabatan','left') ),
	    	'where' => array_merge(array('id_eselon' => 9), $where_u),
	    	'group_by'=>'b.id_jabatan' ))->num_rows();

	    $config_widget['target']      = '#postLapGolEssFung';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_gol_ess_fung/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';
		
		$this->ajax_pagination_gol_ess_fung->initialize($config_widget);

		$jabatan = $this->general_model->datagrab(array(
						'tabel' => array('peg_jabatan a'=>'',
										'ref_jabatan b'=>array('a.id_jabatan=b.id_jabatan','left') ),
						'where' => array_merge(array('b.id_eselon' => 9), $where_u),
						'group_by'=>'b.id_jabatan',
						'limit'=>$config_widget['per_page'],
						'offset'=>$offset
						));
		if (@$en->param4!=NULL AND @$en->param5!=NULL) {
			$gol = $this->general_model->datagrab(array('tabel' => 'ref_golru', 'where'=>array('urut BETWEEN '.$en->param4.' AND '.$en->param5=>NULL) ));
		}else{
			$gol = $this->general_model->datagrab(array('tabel' => 'ref_golru' ));
		}

		$where_j = array();
		if(@$en->param3!=NULL){
			$where_j = array('j.id_unit'=>$en->param3);
		}

		$jumlah = $this->general_model->datagrab(array(
						'tabel' => array(
							'peg_pegawai p' => '',
							'peg_pangkat g' => 'p.id_pegawai = g.id_pegawai and g.status = 1',
							"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
							'peg_jabatan j' => 'j.id_pegawai = p.id_pegawai AND j.status = 1',
							'ref_jabatan jab' => 'jab.id_jabatan = j.id_jabatan',
							'ref_eselon e' => 'e.id_eselon = jab.id_eselon'),
						'select' => 'count(g.id_pegawai) as total,p.id_jeniskelamin,g.id_golru,j.id_jabatan',
						'group_by' => 'p.id_jeniskelamin,g.id_golru,j.id_jabatan',
						'where' => array_merge(array("e.eselon LIKE '%Non%'" => null, 'p.id_pegawai not in (
						                    select id_pegawai from peg_pensiun
						                )'=>null), $where_j)
					));
		
				$this->table->set_template(array('table_open' => '<table class="table table-bordered" style="'.$te.'" >'));
		        $this->table->set_empty("&nbsp;");
			
				$head = array(); $heade = array();
				$head[] = array('data' => 'No','rowspan' => '2', 'class'=>'bg-gray');
				$head[] = array('data' => 'Jabatan','rowspan' => '2', 'class'=>'bg-gray');
				foreach($gol->result() as $gl) {
					$head[] = array('data' => $gl->golongan, 'colspan' => '2','align' => 'center', 'class'=>'bg-gray');
					$heade[] = array('data' => 'L','style' => 'width: 30px','align' => 'center', 'class'=>'bg-gray'); 
					$heade[] = array('data' => 'P','style' => 'width: 30px','align' => 'center', 'class'=>'bg-gray'); 
				}
				$head[] = array('data' => 'L','rowspan' => '2','align' => 'center', 'class'=>'bg-gray');
				$head[] = array('data' => 'P','rowspan' => '2','align' => 'center', 'class'=>'bg-gray');
				$head[] = array('data' => 'Total','rowspan' => '2','align' => 'center', 'class'=>'bg-gray');
				$this->table->add_row($head);
				$this->table->add_row($heade);

				$no = 1+$offset;
				foreach($jabatan->result() as $row) {
					$tot_l = 0;
					$tot_p = 0;
					$ch = array(
						array('data'=>$no, 'class'=>'bg-gray'),
						array('data'=>$row->nama_jabatan, 'class'=>'bg-gray') );
					
					foreach($gol->result() as $g) {
						$l = 0;
						$p = 0;
						foreach($jumlah->result() as $jum) {
							if ($jum->id_jabatan == $row->id_jabatan and $jum->id_golru == $g->id_golru and $jum->id_jeniskelamin == 1) {
								$l = $jum->total;
								$tot_l += $jum->total;
							}
						}
						$ch[] = array('data' => $l,'align' => 'center');
						foreach($jumlah->result() as $jum) {
							if ($jum->id_jabatan == $row->id_jabatan and $jum->id_golru == $g->id_golru and $jum->id_jeniskelamin == 2) {
								$p = $jum->total;
								$tot_p += $jum->total;
							}
						}
						$ch[] = array('data' => $p,'align' => 'center');
					}
					$ch[] = array('data' => $tot_l,'align' => 'center');
					$ch[] = array('data' => $tot_p,'align' => 'center');
					$ch[] = array('data' => ($tot_l + $tot_p),'align' => 'center');
					$this->table->add_row($ch);
					$no += 1;
				}

				$data['tabel'] = $this->table->generate();


	    $data['paging_sub'] = @$this->ajax_pagination_gol_ess_fung->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_gol_ess_fung_ajax',$data);
	}

	function lap_stt_unker_gol($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		if (@$en->param4!=NULL AND @$en->param5!=NULL) {
			$ess =  $this->general_model->datagrab(array(
											'tabel' => 'ref_golru',
											'where' => array('urut BETWEEN '.$en->param4.' AND '.$en->param5=>NULL),
											'order' => 'urut,id_golru' ) );
		}else{
			$ess =  $this->general_model->datagrab(array(
											'tabel' => 'ref_golru',
											'order' => 'urut,id_golru'));
		}

		$page = $this->input->post('page_lapUnkerGol');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 10;

	    $where_un = array('aktif' => 1);
				$where_src = null;
				if (!empty($data['flt_pil']['unit'])) {
					$where_src.= ' AND jb.id_unit = '.$data['flt_pil']['unit'];
					$where_un['id_unit'] = $data['flt_pil']['unit'];
				}
	    $total_rows = $this->general_model->datagrab(array(
					'tabel' => 'ref_unit','where' => $where_un
				))->num_rows();

	    $config_widget['target']      = '#postLapUnkerGol';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_unker_gol/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';
		
		$this->ajax_pagination_unker_gol->initialize($config_widget);

		$unker = $this->general_model->datagrab(array(
					'tabel' => 'ref_unit','where' => $where_un, 'limit'=>$config_widget['per_page'], 'offset'=>$offset
				));

		$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
						"(select pj.id_pegawai as id_s,pj.id_golru,jbt.id_un from peg_pangkat pj join (
							select pkt.id_pegawai as id_peg, jb.id_unit as id_un
							from peg_pangkat pkt
							join peg_jabatan jb on (pkt.id_pegawai = jb.id_pegawai)
							join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
							where sp.tipe = 1 and pkt.tmt_pangkat <= '".$data['flt_pil']['tgl']."' ".$where_src."
							order by tmt_pangkat desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai"),
					'where'=>array('p.id_pegawai not in (
					                    select id_pegawai from peg_pensiun
					                )'=>null),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,jbs.id_golru,jbs.id_un as id_unit',
					'group_by' => 'p.id_jeniskelamin,jbs.id_golru,jbs.id_un'
				));

				$this->table->set_template(array('table_open' => '<table class="table table-bordered" style="'.$te.' width: 100%;">'));
		        $this->table->set_empty("&nbsp;");

				$i = 0;
			
				$head = array(array('data' => 'NO','rowspan' => 2,'width' => 20, 'class'=>'bg-gray'));
				$noe = array(array('data' => '<i>'.($i+=1).'</i>', 'class'=>'bg-gray'));
				
				$head[] = array('data' => 'Unit Kerja','rowspan' => 2,'align' => 'center', 'class'=>'bg-gray');
				$noe[] = array('data' => '<i>'.($i+=1).'</i>','align' => 'center', 'class'=>'bg-gray');
				foreach($ess->result() as $es) {
						$head[] = array('data' => $es->golongan, 'colspan' => 2,'align' => 'center', 'class'=>'bg-gray');
				}
				$head[] = array('data' => 'Total', 'colspan' => 3,'align' => 'center', 'class'=>'bg-gray');
				
				$this->table->add_row($head);
				
				$head = array();
				$l_unit = array();
				$p_unit = array();
				$s = 0;
				foreach($ess->result() as $es) {
						$l_unit[$s] = 0;
						$p_unit[$s] = 0;
						$head[] = array('data' => 'L','width' => 40,'align' => 'center', 'class'=>'bg-gray');
						$head[] = array('data' => 'P','width' => 40,'align' => 'center', 'class'=>'bg-gray');
						$noe = array_merge_recursive(
									$noe,
									array(
										array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray'),
										array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray')
										)
							);
					$s+=1;
				}
				
				$head[] = array('data' => 'L','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
				$head[] = array('data' => 'P','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
				$head[] = array('data' => 'T','width' => 38,'align' => 'center', 'class'=>'bg-gray');
				$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
				$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
				$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
				
				$this->table->add_row($head);
				$this->table->add_row($noe);

				$j = 0+$offset;
				$l_seluruh = 0;
				$p_seluruh = 0;
				
				
				foreach($unker->result() as $u) {
					$total = 0;
					$data_tabel = array(array('data'=>$j+=1, 'class'=>'bg-gray'));
					$data_tabel[] = array('data' => $u->unit, 'class'=>'bg-gray');
					$l_baris = 0;
					$p_baris = 0;
					$s = 0;
					foreach($ess->result() as $es) {
						$l = 0;
						foreach($jumlah->result() as $jum) {
				
							if ($jum->id_unit == $u->id_unit and $es->id_golru == $jum->id_golru and $jum->id_jeniskelamin == 1) {
								$l = $jum->total;
								$l_unit[$s] += $jum->total;
								$l_baris += $jum->total;
								$total += $jum->total;
								$l_seluruh += $jum->total;
							}
						}
						$data_tabel[] = array('data' => $l,'align' => 'center');
						$p = 0;
						foreach($jumlah->result() as $jum) {
							if ($jum->id_unit == $u->id_unit and $es->id_golru == $jum->id_golru and $jum->id_jeniskelamin == 2) {
								$p = $jum->total;
								$p_unit[$s] += $jum->total;
								$p_baris += $jum->total;
								$total += $jum->total;
								$p_seluruh += $jum->total;
							}
						}
						$data_tabel[] = array('data' => $p,'align' => 'center');
						$s+=1;
					}
					
					
					$data_tabel[] = array('data'=>$l_baris,'align'=>'center');
					$data_tabel[] = array('data'=>$p_baris,'align'=>'center');
					$data_tabel[] = array('data'=>$total,'align'=>'center');
					
					$this->table->add_row($data_tabel);
				
				}
				$data_total = array(array('align' => 'right','data' => '<b>TOTAL</b>','colspan' => 2, 'class'=>'bg-gray'));
				for($i = 0; $i < count($l_unit); $i++) {
					$data_total[] = array('data'=>$l_unit[$i],'align'=>'center');
					$data_total[] = array('data'=>$p_unit[$i],'align'=>'center');
				}
				
				$this->table->add_row(array_merge_recursive($data_total,array(
				array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
				array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
				array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'))));

				$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_unker_gol->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_unker_gol_ajax',$data);
	}

	function lap_stt_jenkel_gol($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$page = $this->input->post('page_lapJenkelGol');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 5;

	    $total_rows = $this->general_model->datagrab(array('tabel' => 'ref_golru'))->num_rows();

	    $config_widget['target']      = '#postLapJenkelGol';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_jenkel_gol/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';
		
		$this->ajax_pagination_jenkel_gol->initialize($config_widget);

		$data['h1'] = $this->general_model->datagrab(array(
										'tabel' => 'ref_golru',
										'limit' => $config_widget['per_page'],
										'offset' => $offset
									));
		$data['offset'] = $offset;
		$where_src = null;
				
		if (!empty($data['flt_pil']['unit'])) $where_src.= ' AND jb.id_unit = '.$data['flt_pil']['unit'];
		
		$data['jumlah'] = $this->general_model->datagrab(array(
			'tabel' => array(
				"peg_pegawai p" => "",
				"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
				"(select pj.id_pegawai as id_s,pj.id_golru from peg_pangkat pj join (select pkt.id_pegawai as id_peg 
					from peg_pangkat pkt
					join peg_jabatan jb on (pkt.id_pegawai = jb.id_pegawai)
					join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
					where sp.tipe = 1 and pkt.tmt_pangkat <= '".$data['flt_pil']['tgl']."' ".$where_src."
					order by tmt_pangkat desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai",
					"ref_golru g" => "g.id_golru = jbs.id_golru"),
			'where'=>array('p.id_pegawai not in (
            					select id_pegawai from peg_pensiun
        					)'=>null),
			'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,g.id_golru',
			'group_by' => 'p.id_jeniskelamin,g.id_golru'
		));

		$data['paging_sub'] = @$this->ajax_pagination_jenkel_gol->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_pegawai_jenkel_gol_ajax',$data);
	}

	function lap_stt_gol_ess($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$page = $this->input->post('page_lapGolEss');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 10;
	    $total_rows = $this->general_model->datagrab(array('tabel' => 'ref_eselon'))->num_rows();

	    $config_widget['target']      = '#postLapGolEss';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_gol_ess/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_gol_ess->initialize($config_widget);

       	$eselon = $this->general_model->datagrab(array('tabel' => 'ref_eselon', 'limit'=>$config_widget['per_page'], 'offset'=>$offset ));

       	if (@$en->param4!=NULL AND @$en->param5!=NULL) {
       		$gol = $this->general_model->datagrab(array('tabel' => 'ref_golru', 
       			'where' => array('urut BETWEEN '.$en->param4.' AND '.$en->param5=>NULL)
       			));
       	}else{
       		$gol = $this->general_model->datagrab(array('tabel' => 'ref_golru'));
       	}

       	$where_src = null;
		if (!empty($data['flt_pil']['unit'])) $where_src.= ' AND jb.id_unit = '.$data['flt_pil']['unit'];
		
		$jumlah = $this->general_model->datagrab(array(
			'tabel' => array(
				"peg_pegawai p" => "",
				"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
				"(select pj.id_pegawai as id_s,pj.id_golru from peg_pangkat pj join (select pkt.id_pegawai as id_peg 
					from peg_pangkat pkt
					join peg_jabatan jb on (pkt.id_pegawai = jb.id_pegawai)
					join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
					where sp.tipe = 1 and pkt.tmt_pangkat <= '".$data['flt_pil']['tgl']."' ".$where_src."
					order by tmt_pangkat desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai",
				"(select pj.id_pegawai as id_s, pj.id_jabatan from peg_jabatan pj join (select id_pegawai as id_peg 
					from peg_jabatan jb
					join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
					where sp.tipe = 1 and tmt_jabatan <= '".$data['flt_pil']['tgl']."' ".$where_src."
					order by tmt_jabatan desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbt" => "jbt.id_s = p.id_pegawai",
				"ref_jabatan jab" => array("jab.id_jabatan = jbt.id_jabatan","left")),
			'where'=>array('p.id_pegawai not in (
			                    select id_pegawai from peg_pensiun
			                )'=>null),
			'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,jbs.id_golru,jab.id_eselon',
			'group_by' => 'p.id_jeniskelamin,jbs.id_golru,jab.id_eselon'
		));
		
					$this->table->set_template(array('table_open' => '<table class="table table-bordered no-fluid" style="margin: 0px auto; '.$te.'">'));
			        $this->table->set_empty("&nbsp;");
					
					$head = array(); $heade = array();
					$head[] = array('data' => 'No','rowspan' => '2', 'class'=>'bg-gray','style'=>'');
					$head[] = array('data' => 'Eselon','rowspan' => '2', 'class'=>'bg-gray','style'=>'');
					foreach($gol->result() as $gl) {
						$head[] = array('data' => $gl->golongan, 'colspan' => '2','align' => 'center', 'class'=>'bg-gray');
						$heade[] = array('data' => 'L','style' => 'width: 30px','align' => 'center', 'class'=>'bg-gray'); 
						$heade[] = array('data' => 'P','style' => 'width: 30px','align' => 'center', 'class'=>'bg-gray'); 
					}
					$head[] = array('data' => 'L','rowspan' => '2','align' => 'center', 'class'=>'bg-gray');
					$head[] = array('data' => 'P','rowspan' => '2','align' => 'center', 'class'=>'bg-gray');
					$head[] = array('data' => 'Total','rowspan' => '2','align' => 'center', 'class'=>'bg-gray');
					$this->table->add_row($head);
					$this->table->add_row($heade);

					$no = 1+$offset;
					foreach($eselon->result() as $row) {
						$tot_l = 0;
						$tot_p = 0;
						$ch = array(array('data'=>$no, 'class'=>'bg-gray','style'=>''),
									array('data'=>$row->eselon, 'class'=>'bg-gray','style'=>'') );
						
						foreach($gol->result() as $g) {
							$l = 0;
							$p = 0;
							foreach($jumlah->result() as $jum) {
								if ($jum->id_eselon == $row->id_eselon and $jum->id_golru == $g->id_golru and $jum->id_jeniskelamin == 1) {
									$l = $jum->total;
									$tot_l += $jum->total;
								}
							}
							$ch[] = array('data' => $l,'align' => 'center');
							foreach($jumlah->result() as $jum) {
								if ($jum->id_eselon == $row->id_eselon and $jum->id_golru == $g->id_golru and $jum->id_jeniskelamin == 2) {
									$p = $jum->total;
									$tot_p += $jum->total;
								}
							}
							$ch[] = array('data' => $p,'align' => 'center');
						}
						$ch[] = array('data' => $tot_l,'align' => 'center');
						$ch[] = array('data' => $tot_p,'align' => 'center');
						$ch[] = array('data' => ($tot_l + $tot_p),'align' => 'center');
						$this->table->add_row($ch);
						$no += 1;
					}
					$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_gol_ess->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_gol_ess_ajax',$data);
	}

	function lap_stt_unit_jenkel($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapUnitJenkel');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 10;

	    $total_rows = $this->general_model->datagrab(array(
					'tabel' => 'ref_unit',
					'order' => 'urut'
				))->num_rows();
	    $config_widget['target']      = '#postLapUnitJenkel';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_unit_jenkel/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';
       	$this->ajax_pagination_unit_jenkel->initialize($config_widget);

       	$data['h1'] = $this->general_model->datagrab(array(
					'tabel' => 'ref_unit',
					'limit' => $config_widget['per_page'],
					'offset' => $offset,
					'order' => 'urut'
				));
       	$data['jumlah'] = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
						"(select pj.id_pegawai as id_s,pj.id_unit from peg_jabatan pj join (select id_pegawai as id_peg 
							from peg_jabatan jb
							join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
							where sp.tipe = 1 and tmt_jabatan <= '".$data['flt_pil']['tgl']."'
							order by tmt_jabatan desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai"),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,jbs.id_unit',
					'where'=>array('p.id_pegawai not in (
					                    select id_pegawai from peg_pensiun
					                )'=>null),
					'group_by' => 'p.id_jeniskelamin,jbs.id_unit'
				));

       	$data['paging_sub'] = @$this->ajax_pagination_unit_jenkel->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_pegawai_unit_jenkel_ajax',$data);
	}

	function lap_stt_pdd_ess($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapPddEss');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 10;
	    $total_rows = $this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'order' => 'bentuk_pendidikan'))->num_rows();
	    $config_widget['target']      = '#postLapPddEss';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_pdd_ess/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';
       	$this->ajax_pagination_pdd_ess->initialize($config_widget);

		$pdd =  $this->general_model->datagrab(array(
			'tabel' => 'ref_bentuk_pendidikan', 'limit'=>$config_widget['per_page'], 'offset'=>$offset,
			'order' => 'bentuk_pendidikan'));

       	if (@$en->param4!=NULL AND @$en->param5!=NULL) {
			$ess =  $this->general_model->datagrab(array(
											'tabel' => 'ref_eselon',
											'where' => array('urut BETWEEN '.$en->param4.' AND '.$en->param5=>NULL),
											'order' => 'urut,id_eselon' ) );
		}else{
			$ess =  $this->general_model->datagrab(array(
											'tabel' => 'ref_eselon',
											'order' => 'urut,id_eselon'));
		}

		$where_src = null;
		if (!empty($data['flt_pil']['unit'])) {
			$where_src.= ' AND jb.id_unit = '.$data['flt_pil']['unit'];
		}
		
		$jumlah = $this->general_model->datagrab(array(
			'tabel' => array(
				"peg_pegawai p" => "",
				"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
				"(select pj.id_pegawai as id_s,pj.id_jabatan, pj.id_unit from peg_jabatan pj join (select id_pegawai as id_peg 
					from peg_jabatan jb
					join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
					where sp.tipe = 1 and tmt_jabatan <= '".$data['flt_pil']['tgl']."' ".$where_src."
					order by tmt_jabatan desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai",
				"ref_jabatan jj" => "jj.id_jabatan = jbs.id_jabatan",
				"(select fm.id_pegawai as id_p,fm.id_bentuk_pendidikan from peg_formal fm join(select id_pegawai as id_peg
					from peg_formal fmm where tahun_selesai <= YEAR('".$data['flt_pil']['tgl']."') 
					order by tahun_selesai) frm on (fm.id_pegawai = frm.id_peg) group by id_pegawai) ffm" => "ffm.id_p = p.id_pegawai"),
			'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,ffm.id_bentuk_pendidikan,jj.id_eselon',
			'where'=>array('p.id_pegawai not in (
			                    select id_pegawai from peg_pensiun
			                )'=>null),
			'group_by' => 'p.id_jeniskelamin,ffm.id_bentuk_pendidikan,jj.id_eselon'
		));

		$this->table->set_template(array('table_open' => '<table class="table table-bordered" style="margin: 0px auto; '.$te.'">'));
        $this->table->set_empty("&nbsp;");

		$i = 0+$offset;
	
		$head = array(array('data' => 'NO','rowspan' => 2,'width' => 20, 'class'=>'bg-gray'));
		$noe = array(array('data' => '<i>'.($i+=1).'</i>', 'class'=>'bg-gray'));
		
		$head[] = array('data' => 'Eselon','rowspan' => 2,'align' => 'center', 'class'=>'bg-gray');
		$noe[] = array('data' => '<i>'.($i+=1).'</i>','align' => 'center', 'class'=>'bg-gray');
		foreach($pdd->result() as $pd) {
				$head[] = array('data' => $pd->singkatan_pendidikan, 'colspan' => 2,'align' => 'center', 'class'=>'bg-gray');
		}
		$head[] = array('data' => 'Total', 'colspan' => 3,'align' => 'center', 'class'=>'bg-gray');
		
		$this->table->add_row($head);
		
		$head = array();
		$l_unit = array();
		$p_unit = array();
		$s = 0;
		foreach($pdd->result() as $pd) {
				$l_unit[$s] = 0;
				$p_unit[$s] = 0;
				$head[] = array('data' => 'L','width' => 40,'align' => 'center', 'class'=>'bg-gray');
				$head[] = array('data' => 'P','width' => 40,'align' => 'center', 'class'=>'bg-gray');
				$noe = array_merge_recursive($noe,
											array(	array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray'),
													array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray')
												));
			$s+=1;
		}
		
		$head[] = array('data' => 'L','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
		$head[] = array('data' => 'P','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
		$head[] = array('data' => 'T','width' => 38,'align' => 'center', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		
		$this->table->add_row($head);
		$this->table->add_row($noe);

		$j = 0;
		$l_seluruh = 0;
		$p_seluruh = 0;
		
		
		foreach($ess->result() as $u) {
			$total = 0;
			$data_tabel = array(array('data'=>$j+=1, 'class'=>'bg-gray'));
			$data_tabel[] = array('data' => $u->eselon, 'class'=>'bg-gray');
			$l_baris = 0;
			$p_baris = 0;
			$s = 0;
			foreach($pdd->result() as $pd) {
				$l = 0;
				foreach($jumlah->result() as $jum) {
		
					if ($jum->id_eselon == $u->id_eselon and $pd->id_bentuk_pendidikan == $jum->id_bentuk_pendidikan and $jum->id_jeniskelamin == 1) {
						$l = $jum->total;
						$l_unit[$s] += $jum->total;
						$l_baris += $jum->total;
						$total += $jum->total;
						$l_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $l,'align' => 'center');
				$p = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_eselon == $u->id_eselon and $pd->id_bentuk_pendidikan == $jum->id_bentuk_pendidikan and $jum->id_jeniskelamin == 2) {
						$p = $jum->total;
						$p_unit[$s] += $jum->total;
						$p_baris += $jum->total;
						$total += $jum->total;
						$p_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $p,'align' => 'center');
				$s+=1;
			}
			
			
			$data_tabel[] = array('data'=>$l_baris,'align'=>'center');
			$data_tabel[] = array('data'=>$p_baris,'align'=>'center');
			$data_tabel[] = array('data'=>$total,'align'=>'center');
			
			$this->table->add_row($data_tabel);
		
		}
		
		$data_total = array(array('align' => 'right','data' => '<b>TOTAL</b>','colspan' => 2, 'class'=>'bg-gray'));
		for($i = 0; $i < count($l_unit); $i++) {
			$data_total[] = array('data'=>$l_unit[$i],'align'=>'center');
			$data_total[] = array('data'=>$p_unit[$i],'align'=>'center');
		}
		
		$this->table->add_row(array_merge_recursive($data_total,array(
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'))));

		$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_pdd_ess->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_pdd_ess_ajax',$data);
	}

	function lap_stt_pdd_gol($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapPddGol');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 6;

	    $total_rows =  $this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'order' => 'bentuk_pendidikan'))->num_rows();
	    $config_widget['target']      = '#postLapPddGol';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_pdd_gol/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_pdd_gol->initialize($config_widget);
       	
       	$ess =  $this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'limit' => $config_widget['per_page'],
					'offset' => $offset,
					'order' => 'bentuk_pendidikan'));
       	$where_src = null;
		if (!empty($data['flt_pil']['unit'])) {
			$where_src.= ' AND jb.id_unit = '.$data['flt_pil']['unit'];
		}
		
		if (@$en->param4!=NULL AND @$en->param5!=NULL) {
			$unker = $this->general_model->datagrab(array(
				'tabel' => 'ref_golru','order' => 'urut,id_golru', 'where' => array('urut BETWEEN '.$en->param4.' AND '.$en->param5=>NULL)
			));
		}else{
			$unker = $this->general_model->datagrab(array(
			'tabel' => 'ref_golru','order' => 'urut,id_golru'
			));
		}
		
		$jumlah = $this->general_model->datagrab(array(
			'tabel' => array(
				"peg_pegawai p" => "",
				"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
				"(select pj.id_pegawai as id_s,pj.id_golru from peg_pangkat pj join (select pkt.id_pegawai as id_peg 
					from peg_pangkat pkt
					join peg_jabatan jb on (pkt.id_pegawai = jb.id_pegawai)
					join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
					where sp.tipe = 1 and pkt.tmt_pangkat <= '".$data['flt_pil']['tgl']."' ".$where_src."
					order by tmt_pangkat desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai",
				"(select fm.id_pegawai as id_p,fm.id_bentuk_pendidikan from peg_formal fm join(select id_pegawai as id_peg
					from peg_formal fmm where tahun_selesai <= YEAR('".$data['flt_pil']['tgl']."') 
					order by tahun_selesai) frm on (fm.id_pegawai = frm.id_peg) group by id_pegawai) ffm" => "ffm.id_p = p.id_pegawai"),
			'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,ffm.id_bentuk_pendidikan,jbs.id_golru',
			'where'=>array('p.id_pegawai not in (
			                    select id_pegawai from peg_pensiun
			                )'=>null),
			'group_by' => 'p.id_jeniskelamin,ffm.id_bentuk_pendidikan,jbs.id_golru'
		));
		$this->table->set_template(array('table_open' => '<table class="table table-bordered no-fluid" style="margin: opx auto; '.$te.'">'));
        $this->table->set_empty("&nbsp;");

		$i = 0;
	
		$head = array(array('data' => 'NO','rowspan' => 2,'width' => 20, 'class'=>'bg-gray'));
		$noe = array(array('data' => '<i>'.($i+=1).'</i>', 'class'=>'bg-gray'));
		
		$head[] = array('data' => 'Golongan Ruang/Pangkat','rowspan' => 2,'align' => 'center', 'class'=>'bg-gray');
		$noe[] = array('data' => '<i>'.($i+=1).'</i>','align' => 'center', 'class'=>'bg-gray');
		foreach($ess->result() as $es) {
				$head[] = array('data' => $es->singkatan_pendidikan, 'colspan' => 2,'align' => 'center', 'class'=>'bg-gray');
		}
		$head[] = array('data' => 'Total', 'colspan' => 3,'align' => 'center', 'class'=>'bg-gray');
		
		$this->table->add_row($head);
		
		$head = array();
		$l_unit = array();
		$p_unit = array();
		$s = 0;
		foreach($ess->result() as $es) {
				$l_unit[$s] = 0;
				$p_unit[$s] = 0;
				$head[] = array('data' => 'L','width' => 40,'align' => 'center', 'class'=>'bg-gray');
				$head[] = array('data' => 'P','width' => 40,'align' => 'center', 'class'=>'bg-gray');
				$noe = array_merge_recursive($noe,array(
					array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray'),
					array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray')
					));
			$s+=1;
		}
		
		$head[] = array('data' => 'L','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
		$head[] = array('data' => 'P','width' => 38,'align' => 'center', 'class'=>'bg-gray'); 
		$head[] = array('data' => 'T','width' => 38,'align' => 'center', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		$noe[] = array('data'=>'<i>'.($i+=1).'</i>', 'class'=>'bg-gray');
		
		$this->table->add_row($head);
		$this->table->add_row($noe);

		$j = 0;
		$l_seluruh = 0;
		$p_seluruh = 0;
		
		
		foreach($unker->result() as $u) {
		$total = 0;
		$data_tabel = array(array('data'=>$j+=1, 'class'=>'bg-gray'));
		$data_tabel[] = array('data' => $u->golongan, 'class'=>'bg-gray');
		$l_baris = 0;
		$p_baris = 0;
		$s = 0;
		foreach($ess->result() as $es) {
			$l = 0;
			foreach($jumlah->result() as $jum) {
	
				if ($jum->id_golru == $u->id_golru and $es->id_bentuk_pendidikan == $jum->id_bentuk_pendidikan and $jum->id_jeniskelamin == 1) {
					$l = $jum->total;
					$l_unit[$s] += $jum->total;
					$l_baris += $jum->total;
					$total += $jum->total;
					$l_seluruh += $jum->total;
				}
			}
			$data_tabel[] = array('data' => $l,'align' => 'center');
			$p = 0;
			foreach($jumlah->result() as $jum) {
				if ($jum->id_golru == $u->id_golru and $es->id_bentuk_pendidikan == $jum->id_bentuk_pendidikan and $jum->id_jeniskelamin == 2) {
					$p = $jum->total;
					$p_unit[$s] += $jum->total;
					$p_baris += $jum->total;
					$total += $jum->total;
					$p_seluruh += $jum->total;
				}
			}
			$data_tabel[] = array('data' => $p,'align' => 'center');
			$s+=1;
		}
		
		
		$data_tabel[] = array('data'=>$l_baris,'align'=>'center');
		$data_tabel[] = array('data'=>$p_baris,'align'=>'center');
		$data_tabel[] = array('data'=>$total,'align'=>'center');
		
		$this->table->add_row($data_tabel);
		
		}
		$data_total = array(array('align' => 'right','data' => '<b>TOTAL</b>','colspan' => 2, 'class'=>'bg-gray'));
		for($i = 0; $i < count($l_unit); $i++) {
			$data_total[] = array('data'=>$l_unit[$i],'align'=>'center');
			$data_total[] = array('data'=>$p_unit[$i],'align'=>'center');
		}
		
		$this->table->add_row(array_merge_recursive($data_total,array(
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'))));

		$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_pdd_gol->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_stt_pdd_gol_ajax',$data);
	}

	function lap_rkp_pdd($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_rkpPdd');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 6;

	    $total_rows =$this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'order' => 'bentuk_pendidikan',
					'group_by'=>'singkatan_pendidikan'))->num_rows();
	    $config_widget['target']      = '#postRkpPdd';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_rkp_pdd/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_rkp_pdd->initialize($config_widget);

       	$kiri = $this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'limit' => $config_widget['per_page'],
					'offset' => $offset,
					'order' => 'bentuk_pendidikan',
					'group_by'=>'singkatan_pendidikan'));

       	$jumlah = $this->general_model->datagrab(array(
							'tabel' => array(
								"peg_pegawai p" => "",
								"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
								
								"(select fm.id_pegawai as id_p,fm.id_bentuk_pendidikan 
									from peg_formal fm 
									join(select id_pegawai as id_peg
										from peg_formal fmm 
										order by tahun_selesai) frm on (fm.id_pegawai = frm.id_peg) group by id_pegawai) ffm" => "ffm.id_p = p.id_pegawai"
							),

							'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,ffm.id_bentuk_pendidikan',
							'group_by' => 'p.id_jeniskelamin,ffm.id_bentuk_pendidikan'
						));
       	$this->table->set_template(array('table_open' => '<table class="table table-bordered no-fluid table-center" cellpadding=0 cellspacing=0 border=1 style="margin: 0px auto; '.@$te.'">'));
		$this->table->set_empty("&nbsp;");
		$this->table->add_row(
				array('align' => 'center','data' => '<b>Pendidikan</b>','rowspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Jenis Kelamin</b>','colspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Total</b>','rowspan' => '2', 'class'=>'bg-gray')
				);
		$this->table->add_row(
			array('align' => 'center','width' => '20%','data' => '<b>L</b>', 'class'=>'bg-gray'),
			array('align' => 'center','width' => '20%','data' => '<b>P</b>', 'class'=>'bg-gray'));

	   for($i=1;$i<=4;$i++)$a_index[]=array('data'=>'<i>'.$i.'</i>','class'=>'center', 'class'=>'bg-gray');

	   	$this->table->add_row(
	   		$a_index);

		$l_seluruh = 0;
		$p_seluruh = 0;
		foreach($kiri->result() as $g) {
			$total = 0;
			$data_tabel = array();
			$data_tabel[] = array('data' => $g->singkatan_pendidikan);
			// Jumlah laki :
			$l = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_bentuk_pendidikan == $g->id_bentuk_pendidikan and $jum->id_jeniskelamin == 1) {
						$l = $jum->total;
						$total += $jum->total;
						$l_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $l,'align' => 'center');
			// jumlah perem:
			$p = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_bentuk_pendidikan == $g->id_bentuk_pendidikan and $jum->id_jeniskelamin == 2) {
						$p = $jum->total;
						$total += $jum->total;
						$p_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $p,'align' => 'center');
				// total per data kiri:
				$data_tabel[] = array('data'=>$total,'align'=>'center');

			//store data :
			$this->table->add_row($data_tabel);
		
		}
		//total bawah:
		$this->table->add_row(
		array('align' => 'right','data' => '<b>TOTAL</b>', 'class'=>'bg-gray'),
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>', 'class'=>'bg-gray'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>', 'class'=>'bg-gray'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>', 'class'=>'bg-gray'));

		$data['tabel'] = $this->table->generate();

       	$data['paging_sub'] = @$this->ajax_pagination_rkp_pdd->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_rkp_pns_pdd_ajax',$data);
	}

	function lap_rkp_pensiun($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_rkpPensiun');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 8;

	    $total_rows = $this->general_model->datagrab(array('tabel'=>'ref_golru'))->num_rows();
	    $config_widget['target']      = '#postRkpPensiun';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_rkp_pensiun/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_rkp_pensiun->initialize($config_widget);
       	$kiri = $this->general_model->datagrab(array('tabel'=>'ref_golru', 'limit'=>$config_widget['per_page'], 'offset'=>$offset));
       	$jumlah = $this->general_model->datagrab(array(
							'tabel' => array(
								"peg_pegawai p" => "",
								"peg_pensiun pen" => "pen.id_pegawai=p.id_pegawai",
								"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
								"(select pj.id_pegawai as id_s,pj.id_golru from peg_pangkat pj join (select pkt.id_pegawai as id_peg 
									from peg_pangkat pkt
									join peg_jabatan jb on (pkt.id_pegawai = jb.id_pegawai)
									join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
									where sp.tipe = 1
									order by tmt_pangkat desc) jbt on (jbt.id_peg = pj.id_pegawai) group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai",
									"ref_golru g" => "g.id_golru = jbs.id_golru"),
							'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,g.id_golru',
							'group_by' => 'p.id_jeniskelamin,g.id_golru'
						));
       	$this->table->set_template(array('table_open' => '<table class="table table-bordered table-center no-fluid" cellpadding=0 cellspacing=0 border=1 style="margin: 0px auto; '.$te.'">'));
		$this->table->set_empty("&nbsp;");
		$this->table->add_row(
				array('align' => 'center','data' => '<b>Golongan</b>','rowspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Jenis Kelamin</b>','colspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Total</b>','rowspan' => '2', 'class'=>'bg-gray')
				);
		$this->table->add_row(
			array('align' => 'center','width' => '20%','data' => '<b>L</b>', 'class'=>'bg-gray'),
			array('align' => 'center','width' => '20%','data' => '<b>P</b>', 'class'=>'bg-gray'));

	   for($i=1;$i<=4;$i++)$a_index[]=array('data'=>'<i>'.$i.'</i>','class'=>'center', 'class'=>'bg-gray');
	   	$this->table->add_row(
	   		$a_index);

		$l_seluruh = 0;
		$p_seluruh = 0;
		foreach($kiri->result() as $g) {
			$total = 0;
			$data_tabel = array();
			$data_tabel[] = array('data' => $g->golongan.' - '.$g->pangkat);
			// Jumlah laki :
			$l = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_golru == $g->id_golru and $jum->id_jeniskelamin == 1) {
						$l = $jum->total;
						$total += $jum->total;
						$l_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $l,'align' => 'center');
			// jumlah perem:
			$p = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_golru == $g->id_golru and $jum->id_jeniskelamin == 2) {
						$p = $jum->total;
						$total += $jum->total;
						$p_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $p,'align' => 'center');
				// total per data kiri:
				$data_tabel[] = array('data'=>$total,'align'=>'center');

			//store data :
			$this->table->add_row($data_tabel);
		
		}
		//total bawah:
		$this->table->add_row(
		array('align' => 'right','data' => '<b>TOTAL</b>'),
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'));

		$data['tabel'] = $this->table->generate();
		$data['paging_sub'] = @$this->ajax_pagination_rkp_pensiun->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_rkp_pns_pensiun_ajax',$data);
	}

	function lap_rkp_agama($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_rkpAgama');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 6;
	    $total_rows = $this->general_model->datagrab(array(
					'tabel' => 'ref_agama',
					'order' => 'agama',
					'group_by'=>'agama'))->num_rows();
	    $config_widget['target']      = '#postRkpAgama';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_rkp_agama/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_rkp_agama->initialize($config_widget);
       	$kiri = $this->general_model->datagrab(array(
					'tabel' => 'ref_agama',
					'limit' => $config_widget['per_page'],
					'offset' => $offset,
					'order' => 'agama',
					'group_by'=>'agama'));
       	$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
					),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,p.id_agama',
					'group_by' => 'p.id_jeniskelamin,p.id_agama'
				));
       	$this->table->set_template(array('table_open' => '<table class="table table-bordered no-fluid" style="margin: 0px auto;'.$te.'" cellpadding=0 cellspacing=0 border=1 >'));
		$this->table->set_empty("&nbsp;");
		$this->table->add_row(
					array('align' => 'center','data' => '<b>Agama</b>','rowspan' => '2', 'class'=>'bg-gray'),
					array('align' => 'center','data' => '<b>Jenis Kelamin</b>','colspan' => '2', 'class'=>'bg-gray'),
					array('align' => 'center','data' => '<b>Total</b>','rowspan' => '2', 'class'=>'bg-gray')
					);
		$this->table->add_row(
			array('align' => 'center','width' => '20%','data' => '<b>L</b>', 'class'=>'bg-gray'),
			array('align' => 'center','width' => '20%','data' => '<b>P</b>', 'class'=>'bg-gray'));

	   for($i=1;$i<=4;$i++)$a_index[]=array('data'=>'<i>'.$i.'</i>','class'=>'center', 'class'=>'bg-gray');
	   	$this->table->add_row(
	   		$a_index);

		$l_seluruh = 0;
		$p_seluruh = 0;
		foreach($kiri->result() as $g) {
			$total = 0;
			$data_tabel = array();
			$data_tabel[] = array('data' => $g->agama);
			// Jumlah laki :
			$l = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_agama == $g->id_agama and $jum->id_jeniskelamin == 1) {
						$l = $jum->total;
						$total += $jum->total;
						$l_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $l,'align' => 'center');
			// jumlah perem:
			$p = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_agama == $g->id_agama and $jum->id_jeniskelamin == 2) {
						$p = $jum->total;
						$total += $jum->total;
						$p_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $p,'align' => 'center');
				// total per data kiri:
				$data_tabel[] = array('data'=>$total,'align'=>'center');

			//store data :
			$this->table->add_row($data_tabel);
		}
		//total bawah:
		$this->table->add_row(
		array('align' => 'right','data' => '<b>TOTAL</b>'),
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'));

		$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_rkp_agama->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_rkp_pns_agama_ajax',$data);
	}

	function lap_rkp_ess($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_rkpEss');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 8;
	    $total_rows = $this->general_model->datagrab(array('tabel' => 'ref_eselon'))->num_rows();
	    $config_widget['target']      = '#postRkpEss';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_rkp_ess/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_rkp_ess->initialize($config_widget);
       	$kiri = $this->general_model->datagrab(array('tabel' => 'ref_eselon', 'limit'=>$config_widget['per_page'], 'offset'=>$offset));
       	$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
						"(select pj.id_pegawai as id_s,pj.id_golru,jbt.id_jabatan 
							from 
							peg_pangkat pj 
							join (select pkt.id_pegawai as id_peg,jb.id_jabatan 
							from peg_pangkat pkt
							join peg_jabatan jb on (pkt.id_pegawai = jb.id_pegawai)
							join ref_status_pegawai sp on (sp.id_status_pegawai = jb.id_status_pegawai)
							where sp.tipe = 1
							order by tmt_pangkat desc) jbt on (jbt.id_peg = pj.id_pegawai) 
							group by id_pegawai) jbs" => "jbs.id_s = p.id_pegawai",
						"ref_jabatan jab" => array("jab.id_jabatan = jbs.id_jabatan","left")),

					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin,jab.id_eselon',
					'group_by' => 'p.id_jeniskelamin,jab.id_eselon'
				));
       	$this->table->set_template(array('table_open' => '<table class="table table-bordered table-center no-fluid" cellpadding=0 cellspacing=0 border=1 style="margin: 0px auto; '.$te.'">'));
		$this->table->set_empty("&nbsp;");

		$this->table->add_row(
				array('align' => 'center','data' => '<b>Eselon</b>','rowspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Jenis Kelamin</b>','colspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Total</b>','rowspan' => '2', 'class'=>'bg-gray')
				);
		$this->table->add_row(
			array('align' => 'center','width' => '20%','data' => '<b>L</b>', 'class'=>'bg-gray'),
			array('align' => 'center','width' => '20%','data' => '<b>P</b>', 'class'=>'bg-gray'));

	   for($i=1;$i<=4;$i++)$a_index[]=array('data'=>'<i>'.$i.'</i>','class'=>'center', 'class'=>'bg-gray');
	   	$this->table->add_row(
	   		$a_index);

		$l_seluruh = 0;
		$p_seluruh = 0;
		foreach($kiri->result() as $g) {
			$total = 0;
			$data_tabel = array();
			$data_tabel[] = array('data' => $g->eselon);
			// Jumlah laki :
			$l = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_eselon == $g->id_eselon and $jum->id_jeniskelamin == 1) {
						$l = $jum->total;
						$total += $jum->total;
						$l_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $l,'align' => 'center');
			// jumlah perem:
			$p = 0;
				foreach($jumlah->result() as $jum) {
					if ($jum->id_eselon == $g->id_eselon and $jum->id_jeniskelamin == 2) {
						$p = $jum->total;
						$total += $jum->total;
						$p_seluruh += $jum->total;
					}
				}
				$data_tabel[] = array('data' => $p,'align' => 'center');
				// total per data kiri:
				$data_tabel[] = array('data'=>$total,'align'=>'center');

			//store data :
			$this->table->add_row($data_tabel);
		
		}
		// total bawah:
		$this->table->add_row(
		array('align' => 'right','data' => '<b>TOTAL</b>'),
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'));

		$data['tabel'] = $this->table->generate();
		$data['paging_sub'] = @$this->ajax_pagination_rkp_ess->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_rkp_pns_ess_ajax',$data);
	}

	function lap_rkp_usia($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if(@$en->param1!=NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif(@$en->param1==NULL AND @$en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_rkpUsia');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 9;
	    $total_rows = 9;
	    $config_widget['target']      = '#postRkpUsia';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_rkp_usia/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_rkp_usia->initialize($config_widget);

		$kiri = array('>55'=>55, '51-55'=>array(51,55), '46-50'=>array(46,50), '41-45'=>array(41,45), '36-40'=>array(36,40), '31-35'=>array(31,35), '26-30'=>array(26,30), '21-25'=>array(21,25), '<20'=>20);

		$this->table->set_template(array('table_open' => '<table class="table table-bordered no-fluid table-center" cellpadding=0 cellspacing=0 border=1 style="margin:0px auto; '.$te.'">'));
		$this->table->set_empty("&nbsp;");
		$this->table->add_row(
				array('align' => 'center','data' => '<b>Usia</b>','rowspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Jenis Kelamin</b>','colspan' => '2', 'class'=>'bg-gray'),
				array('align' => 'center','data' => '<b>Total</b>','rowspan' => '2', 'class'=>'bg-gray')
				);
		$this->table->add_row(
			array('align' => 'center','width' => '20%','data' => '<b>L</b>', 'class'=>'bg-gray'),
			array('align' => 'center','width' => '20%','data' => '<b>P</b>', 'class'=>'bg-gray'));

	   for($i=1;$i<=4;$i++)$a_index[]=array('data'=>'<i>'.$i.'</i>','class'=>'center','class'=>'bg-gray');
	   	$this->table->add_row($a_index);

		$l_seluruh = 0;
		$p_seluruh = 0;
		foreach($kiri as $g) {
			$total = 0;
			$data_tabel = array();
			if (is_array($g)) {
					$k_isi = $g[0].'-'.$g[1];
				$data_tabel[] = array('data' => $k_isi);

				$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
					),
					'where'=>array('(FLOOR( TIMESTAMPDIFF( YEAR, p.`tanggal_lahir`, NOW() ) BETWEEN '.$g[0].' AND '.$g[1].'))'=>null, 'p.id_jeniskelamin'=>1),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin',
					'group_by' => 'p.id_jeniskelamin'
				))->row();
				
				$l = 0;
				
				$l = !empty($jumlah->total)? $jumlah->total : 0;
				$total += !empty($jumlah->total)? $jumlah->total : 0;
				$l_seluruh += !empty($jumlah->total)? $jumlah->total : 0;

				$data_tabel[] = array('data' => $l,'align' => 'center');
			
				$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
					),
					'where'=>array('(FLOOR( TIMESTAMPDIFF( YEAR, p.`tanggal_lahir`, NOW() ) BETWEEN '.$g[0].' AND '.$g[1].'))'=>null, 'p.id_jeniskelamin'=>2),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin',
					'group_by' => 'p.id_jeniskelamin'
				))->row();
				$p = 0;
			
				$p = !empty($jumlah->total)? $jumlah->total : 0;
				$total += !empty($jumlah->total)? $jumlah->total : 0;
				$p_seluruh += !empty($jumlah->total)? $jumlah->total : 0;

				$data_tabel[] = array('data' => $p,'align' => 'center');
				$data_tabel[] = array('data'=>$total,'align'=>'center');
			}else if($g == 55){
				$data_tabel[] = array('data' => '>'.$g);

				$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
					),
					'where'=>array('(FLOOR( TIMESTAMPDIFF( YEAR, p.`tanggal_lahir`, NOW() ) > '.$g.'))'=>null, 'p.id_jeniskelamin'=>1),
					'select' => 'IFNULL(count(p.id_pegawai),0) as total,p.id_jeniskelamin',
					'group_by' => 'p.id_jeniskelamin'
				))->row();
				$l = 0;
				
				$l = !empty($jumlah->total)? $jumlah->total : 0;
				$total += !empty($jumlah->total)? $jumlah->total : 0;
				$l_seluruh += !empty($jumlah->total)? $jumlah->total : 0;

				$data_tabel[] = array('data' => $l,'align' => 'center');
			
				$p = 0;
					$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
					),
					'where'=>array('(FLOOR( TIMESTAMPDIFF( YEAR, p.`tanggal_lahir`, NOW() ) > '.$g.'))'=>null, 'p.id_jeniskelamin'=>2),
					'select' => 'IFNULL(count(p.id_pegawai),0) as total,p.id_jeniskelamin',
					'group_by' => 'p.id_jeniskelamin'
				))->row();

				$p = !empty($jumlah->total)? $jumlah->total : 0;
				$total += !empty($jumlah->total)? $jumlah->total : 0;
				$p_seluruh += !empty($jumlah->total)? $jumlah->total : 0;

				$data_tabel[] = array('data' => $p,'align' => 'center');
				$data_tabel[] = array('data'=>$total,'align'=>'center');
			}else if($g == 20){
				$data_tabel[] = array('data' => '<'.$g);

				$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
					),
					'where'=>array('(FLOOR( TIMESTAMPDIFF( YEAR, p.`tanggal_lahir`, NOW() ) < '.$g.'))'=>null, 'p.id_jeniskelamin'=>1),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin',
					'group_by' => 'p.id_jeniskelamin'
				))->row();

				$l = 0;

				$l = !empty($jumlah->total)? $jumlah->total : 0;
				$total += !empty($jumlah->total)? $jumlah->total : 0;
				$l_seluruh += !empty($jumlah->total)? $jumlah->total : 0;
				
				$data_tabel[] = array('data' => $l,'align' => 'center');
			
				$jumlah = $this->general_model->datagrab(array(
					'tabel' => array(
						"peg_pegawai p" => "",
						"ref_tipe_pegawai rp" => "rp.id_tipe_pegawai = p.id_tipe_pegawai AND rp.jenis = 1",
					),
					'where'=>array('(FLOOR( TIMESTAMPDIFF( YEAR, p.`tanggal_lahir`, NOW() ) < '.$g.'))'=>null, 'p.id_jeniskelamin'=>2),
					'select' => 'count(p.id_pegawai) as total,p.id_jeniskelamin',
					'group_by' => 'p.id_jeniskelamin'
				))->row();

				$p = !empty($jumlah->total)? $jumlah->total : 0;
				$total += !empty($jumlah->total)? $jumlah->total : 0;
				$p_seluruh += !empty($jumlah->total)? $jumlah->total : 0;
				$data_tabel[] = array('data' => $p,'align' => 'center');
				$data_tabel[] = array('data'=>$total,'align'=>'center');
			}
			$this->table->add_row($data_tabel);
		}
		
		$this->table->add_row(
		array('align' => 'right','data' => '<b>TOTAL</b>'),
		array('align' => 'center','data' => '<b>'.$l_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.$p_seluruh.'</b>'),
		array('align' => 'center','data' => '<b>'.($l_seluruh + $p_seluruh).'</b>'));
						
		$data['tabel'] = $this->table->generate();

		$data['paging_sub'] = @$this->ajax_pagination_rkp_usia->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_tb_rkp_pns_usia_ajax',$data);
	}

	function lap_stt_unker_pdd($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}

		if($en->param1!=NULL AND $en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => tanggal_php($en->param1),
				'unit_pil' => null,
				'unit' => $en->param3
			);
		}elseif($en->param1==NULL AND $en->param3!=NULL){
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => null,
				'unit' =>$en->param3
			);
		}else{
			$data['flt_pil'] = array(
				'tgl' => date('Y-m-d'),
				'unit_pil' => 1,
				'unit' => null
			);
		}

		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapUnkerPdd');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }
	    $data['offset'] = $offset;
	    $total_rows =$this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'order' => 'bentuk_pendidikan',
					'group_by'=>'singkatan_pendidikan'))->num_rows();
	    $per_page = (@$en->per_page!=NULL) ? $en->per_page : 7;
	    $config_widget['target']      = '#postLapUnkerPdd';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/lap_stt_unker_pdd/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_lap_unker_pdd->initialize($config_widget);

       	$ess = $this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'limit' => $config_widget['per_page'],
					'offset' => $offset,
					'order' => 'bentuk_pendidikan',
					'group_by'=>'singkatan_pendidikan'));

       	$where_un = array('aktif' => 1);
		$where_src = null;
		if (!empty($data['flt_pil']['unit'])) {
			$where_src.= ' AND jb.id_unit = '.$data['flt_pil']['unit'];
			$where_un['id_unit'] = $data['flt_pil']['unit'];
		}
		
		if (@$en->param4!=NULL AND @$en->param5!=NULL) {
			$unker = $this->general_model->datagrab(array(
				'tabel' => 'ref_unit','order' => 'urut,id_unit', 'where' => array_merge(array('urut BETWEEN '.$en->param4.' AND '.$en->param5=>NULL), $where_un)
			));
		}else{
			$data['unker'] = $this->general_model->datagrab(array(
				'tabel' => 'ref_unit','where' => $where_un
			));
		}
	}

	function kenpa($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		$bulandata = array('' =>  'Seluruh Bulan','01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei',
						'06'=>'Juni','07'=>'Juli','08'=>'Agustu','09'=>'September' ,'10'=>'Oktober','11'=>'November','12'=>'Desember');
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}
		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapKenpa');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $tahun = (@$en->param4!=NULL) ? $en->param4 : NULL;
		$bulan = (@$en->param1!=NULL) ? $en->param1 : NULL;
		$unit = (@$en->param3!=NULL) ? $en->param3 : NULL;

		if(!empty($bulan) or !empty($tahun) or !empty($unit)) {
			$vse = array('tahun' => $tahun, 'bulan' => $bulan,'unit' => $unit);
		} else {
			if (!empty($searching)) {
				$vse = un_de($searching);
			} else {
				$vse = array('tahun' => null,'bulan' => null,'unit' => null);
			}
		}

		$from = array(
					'peg_pegawai p' => '',
					'peg_pangkat g' => array('g.id_pegawai = p.id_pegawai AND g.status = 1','left'),
					'peg_jabatan jj' => array('jj.id_pegawai = p.id_pegawai AND jj.status = 1','left'),
					'ref_status_pegawai rs' => array('rs.id_status_pegawai = jj.id_status_pegawai AND rs.tipe = 1','left'),
					'ref_bidang rb'=> array('jj.id_bidang = rb.id_bidang','left'),
					'ref_unit u' => array('u.id_unit = rb.id_unit','left'),
					'ref_golru rg' => array('rg.id_golru = g.id_golru','left')
				);
		$where = array();
		if (!empty($tahun) or !empty($searching)) {
			$bulanhari = !empty($vse['bulan']) ? $vse['bulan'].'-01' : '12-31';
			$tgl = $vse['tahun'].'-'.$bulanhari;
			$where = array(
				"CONCAT(YEAR(g.tmt_pangkat),'-',MONTH(g.tmt_pangkat),'-01') + INTERVAL 4 YEAR <= '".$tgl."'" => null,
				'u.aktif' => 1);
		}
		$unit_ok = FALSE;
		$data['unit_selected'] = $vse['unit'];
		$data['cb_unit'] = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit','where' => array('aktif != 2' => null),'val' => array('unit'),'key' => 'id_unit','pilih' => ' -- Pilih Unit Kerja -- '));

		if ($vse['unit'] != NULL) $where['u.id_unit'] = $vse['unit'];
		$unit_ok = TRUE;

		$total_rows = $this->general_model->datagrab(array('tabel' => $from,
			'select' => 'p.*,g.tmt_pangkat,(g.tmt_pangkat + INTERVAL 4 YEAR) as tmt_lanjut,rg.id_golru,CONCAT(rg.golongan," - ",rg.pangkat) as pangkat,u.unit',
			'where'=>$where))->num_rows();
		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 7;
		$config_widget['target']      = '#postKenpa';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/kenpa/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_kenpa->initialize($config_widget);

       	$dtgolru = $this->general_model->datagrab(array('tabel' => $from,'limit' => $config_widget['per_page'],'offset' => $offset,
       		'select' => 'p.*,g.tmt_pangkat,(g.tmt_pangkat + INTERVAL 4 YEAR) as tmt_lanjut,rg.id_golru,CONCAT(rg.golongan," - ",rg.pangkat) as pangkat,u.unit',
       		'where'=>$where));
		$tanggal = (!empty($tahun) or !empty($searching)) ? "Pegawai yang akan mendapatkan kenaikan pangkat untuk bulan <strong>".$bulandata[$vse['bulan']]."</strong> tahun <strong>".$vse['tahun']."</strong>" : null;
		if ($dtgolru->num_rows() > 0) {
			
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid" style="margin:0px auto; '.$te.'"';
			
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			
			$header = array('No','Nama / NIP','Golru/Pangkat','TMT','Golru/Pangkat Naik','TMT Naik');
			if ($vse['unit'] == NULL) $header[] = 'Unit Kerja';
			$this->table->set_heading($header);
	
			$no = 1 + $offset;
			foreach($dtgolru->result() as $row){
				$gelar_depan = ''; if(!empty($row->gelar_depan)) $gelar_depan = $row->gelar_depan.' ';
				$gelar_belakang = ''; if(!empty($row->gelar_belakang)) $gelar_belakang = ', '.$row->gelar_belakang;
				
				$naek = $this->general_model->datagrab(array('tabel' => 'ref_golru',
					'where' => array('id_golru' => $row->id_golru+1)))->row();
				$naik_pangkat = (!empty($naek)) ? $naek->golongan.' - '.$naek->pangkat : 'Pangkat Puncak';
				
				$rows = array(
					$no,
					$gelar_depan.''.$row->nama.''.$gelar_belakang.
					'<br> &nbsp; '.$row->nip,
					$row->pangkat,
					tanggal($row->tmt_pangkat),
					$naik_pangkat,
					tanggal($row->tmt_lanjut)
				);
				
				if ($vse['unit'] == NULL) $rows[] = $row->unit;
				
				if ($offset != "print" and $offset != "excel" and $vse['tahun'] == date('Y') and !empty($naek)) {
					$jaga = array(
						'id_golru' => $row->id_golru + 1,
						'tmt_lanjut' => tanggal($row->tmt_lanjut));
					
					/*$rows[] = anchor('#','<i class="fa fa-check-circle"></i> Proses','class="btn-edit btn-sm btn btn-default" act="'.site_url('kepegawaian/golru/form/'.$row->id_pegawai.'/null/'.in_de($jaga)).'"');*/
				}
				$this->table->add_row($rows);
				$no+=1;
			}
			
			$btn_print = anchor('penjagaan/kenpa/list_kenpa/'.in_de($vse).'/print','<i class="fa fa-print"></i> Cetak','class="btn btn-info" target="_blank"');
			$btn_excel = anchor('penjagaan/kenpa/list_kenpa/'.in_de($vse).'/excel','<i class="fa fa-file-excel-o"></i> Excel','class="btn btn-warning" target="_blank"');
			$btn_add = ($offset == "print" or $offset == "excel") ? null : $btn_print.' '.$btn_excel;
			$this->table->add_row(array('data'=>'Total : '.$total_rows, 'class'=>'text-right', 'colspan' => '8'));
			
			if (!empty($tahun) or !empty($searching)) {
				$t = $this->table->generate();
				$tabel = '<h5 style="margin-left: 10px;">'.$tanggal.'</h5><br>'.$t;
			} else {
				$tabel = '<div class="alert">Tentukan bulan dan tahun penjagaan ...</div>';
			}
			
		} else {
			$tabel = '<div class="alert">'. $tanggal.'<br>Tidak ada data kenaikan golongan ruang/pangkat ...</div>';
		}
		$data['tabel'] = $tabel;

		$data['paging_sub'] = @$this->ajax_pagination_kenpa->create_links($jeda_dalam);

		$this->load->view('widget_ids/widget_kenpa_ajax',$data);
	}

	function kgb($id_widget=NULL, $jeda_dalam=NULL, $offset=0){

		$bulandata = array('' =>  'Seluruh Bulan','01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei',
						'06'=>'Juni','07'=>'Juli','08'=>'Agustu','09'=>'September' ,'10'=>'Oktober','11'=>'November','12'=>'Desember');
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}
		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapKgb');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $tahun = (@$en->param4!=NULL) ? $en->param4 : NULL;
		$bulan = (@$en->param1!=NULL) ? $en->param1 : NULL;
		$unit = (@$en->param3!=NULL) ? $en->param3 : NULL;

		if(!empty($bulan) or !empty($tahun) or !empty($unit)) {
			$vse = array('tahun' => $tahun, 'bulan' => $bulan,'unit' => $unit);
		} else {
			if (!empty($searching)) {
				$vse = un_de($searching);
			} else {
				$vse = array('tahun' => null,'bulan' => null,'unit' => null);
			}
		}
		$from = array(
				'peg_pegawai p' => '',
				'peg_kgb g' => array('g.id_pegawai = p.id_pegawai AND g.status = 1','left'),
				'peg_jabatan jj' => array('jj.id_pegawai = p.id_pegawai AND jj.status = 1','left'),
				'ref_status_pegawai rs' => array('rs.id_status_pegawai = jj.id_status_pegawai AND rs.tipe = 1','left'),
				'ref_bidang rb'=> array('jj.id_bidang = rb.id_bidang','left'),
				'ref_unit u' => array('u.id_unit = rb.id_unit','left'),
				'ref_golru gol' => array('gol.id_golru = g.id_golru','left')
			);
		$where = array();
		if (!empty($tahun) or !empty($searching)) {
			$bulanhari = !empty($vse['bulan']) ? $vse['bulan'].'-01' : '12-31';
			$tgl = $vse['tahun'].'-'.$bulanhari;
			$where = array(
					"CONCAT(YEAR(g.tmt_kgb),'-',MONTH(g.tmt_kgb),'-01') + INTERVAL 2 YEAR <= '".$tgl."'" => null,
					'u.aktif' => 1);
		}
		$unit_ok = FALSE;
		$data['unit_selected'] = $vse['unit'];
		$data['cb_unit'] = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit','where' => array('aktif != 2' => null),'val' => array('unit'),'key' => 'id_unit','pilih' => ' -- Pilih Unit Kerja -- '));
		if ($vse['unit'] != NULL) $where['u.id_unit'] = $vse['unit'];
		$unit_ok = TRUE;
		$total_rows = $this->general_model->datagrab(array('tabel' => $from,
			'select' => 'p.*,g.id_peg_kgb,g.mkg,g.id_golru,g.gaji,g.tmt_kgb,(g.tmt_kgb + INTERVAL 2 YEAR) as tmt_lanjut,CONCAT(gol.golongan," - ",gol.pangkat) as pangkat, u.unit',
			'where'=>$where))->num_rows();
		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 7;
		$config_widget['target']      = '#postKgb';
        $config_widget['base_url']    = base_url().'widget_ids/data_widget/kgb/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_kgb->initialize($config_widget);

       	$dtgolru = $this->general_model->datagrab(array('tabel' => $from,'limit' => $config_widget['per_page'],'offset' => $offset,
       		'select' => 'p.*,g.id_peg_kgb,g.mkg,g.id_golru,g.gaji,g.tmt_kgb,(g.tmt_kgb + INTERVAL 2 YEAR) as tmt_lanjut,CONCAT(gol.golongan," - ",gol.pangkat) as pangkat, u.unit',
       		'where'=>$where));
       	$tanggal = (!empty($tahun) or !empty($searching)) ? "Pegawai yang akan Mendapatkan (KGB) untuk bulan <b>".$bulandata[$vse['bulan']]."</b> tahun <b>".$vse['tahun']."</b>" : null;
       	if ($dtgolru->num_rows() > 0) {
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid" style="margin:0px auto; '.$te.'"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$headers = array('No','Nama / NIP','Golongan','TMT','Gaji Sekarang','TMT KGB Selanjutnya');
			if ($vse['unit'] == NULL) $headers[] = 'Unit Kerja';
			/*if ($offset != "print" and $offset != "excel" and $vse['tahun'] == date('Y')) $headers[] = array('data' => 'Aksi','width' => 90);*/
			$this->table->set_heading($headers);
			$no = 1 + $offset;
			foreach($dtgolru->result() as $row){
				$gelar_depan = ''; if(!empty($row->gelar_depan)) $gelar_depan = $row->gelar_depan.' ';
				$gelar_belakang = ''; if(!empty($row->gelar_belakang)) $gelar_belakang = ', '.$row->gelar_belakang;
				
				$rows = array(
					$no,
					$gelar_depan.''.$row->nama.''.$gelar_belakang.
					'<br> &nbsp; '.$row->nip,
					$row->pangkat.' (MKG : '.$row->mkg.' Tahun)',
					date_indo($row->tmt_kgb,2),
					rupiah($row->gaji,1),
					date_indo($row->tmt_lanjut,2)
				);
				
				if ($vse['unit'] == NULL) $rows[] = $row->unit;

				$this->table->add_row($rows);
				$no++;
			}
			$btn_print = anchor('penjagaan/kgb/list_kgb/'.in_de($vse).'/print','<i class="fa fa-print"></i> Cetak','class="btn btn-info" target="_blank"');
			$btn_excel = anchor('penjagaan/kgb/list_kgb/'.in_de($vse).'/excel','<i class="fa fa-file-excel-o"></i> Excel','class="btn btn-warning" target="_blank"');
			$btn_add = ($offset == "print" or $offset == "excel") ? null : $btn_print.' '.$btn_excel;
			$this->table->add_row(array('data'=>'Total : '.$config_widget['total_rows'], 'class'=>'text-right', 'colspan' => '8'));
			if (!empty($tahun) or !empty($searching)) {
				$t = $this->table->generate();
				$tabel = '<h5 style="margin-left: 10px;">'.$tanggal.'</h5><br>'.$t; 
			}else{
				$tabel = '<div class="alert">Tentukan bulan dan tahun penjagaan</div>';
			}
		} else {
			$tabel = '<div class="alert">'. $tanggal.'<br>Tidak ada data Penjagaan Kenaikan Gaji Berkala</div>';
		}
		$data['tabel'] = $tabel;

		$data['paging_sub'] = @$this->ajax_pagination_duk->create_links($jeda_dalam, $post);

		$this->load->view('widget_ids/widget_kgb_ajax',$data);
	}

	function pensiun($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		$bulandata = array('' =>  'Seluruh Bulan','01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei',
						'06'=>'Juni','07'=>'Juli','08'=>'Agustu','09'=>'September' ,'10'=>'Oktober','11'=>'November','12'=>'Desember');
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}
		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapPensiun');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $tahun = (@$en->param4!=NULL) ? $en->param4 : NULL;
		$bulan = (@$en->param1!=NULL) ? $en->param1 : NULL;
		$unit = (@$en->param3!=NULL) ? $en->param3 : NULL;
		if(!empty($bulan) or !empty($tahun) or !empty($unit)) {
			$vse = array('tahun' => $tahun, 'bulan' => $bulan,'unit' => $unit);
		} else {
			if (!empty($searching)) {
				$vse = un_de($searching);
			} else {
				$vse = array('tahun' => null,'bulan' => null,'unit' => null);
			}
		}
		$from = array(
					'peg_pegawai p' => '',
					'peg_jabatan j' => array('j.id_pegawai = p.id_pegawai and j.status = 1','left'),
					'ref_jabatan jab' => array('jab.id_jabatan = j.id_jabatan','left'),
					'ref_bidang rb'=> array('j.id_bidang = rb.id_bidang','left'),
					'ref_unit u' => array('u.id_unit = rb.id_unit','left'),
					'peg_pangkat go' => array('go.id_pegawai = p.id_pegawai and go.status = 1','left'),
					'ref_golru g' => array('g.id_golru = go.id_golru','left')
				);
		$where = array();
		if (!empty($tahun) or !empty($searching)) {
			$bulanhari = !empty($vse['bulan']) ? $vse['bulan'].'-01' : '12-31';
			$tgl = $vse['tahun'].'-'.$bulanhari;
			$where = array(
				"datediff('".$tgl."', p.tanggal_lahir)/364.25 >= jab.bup" => null,
				'u.aktif' => 1);
		} else {
			$tgl = date('Y-m-d');
		}
		$unit_ok = FALSE;
		$data['unit_selected'] = $vse['unit'];
		$data['cb_unit'] = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit','where' => array('aktif != 2' => null),'val' => array('unit'),'key' => 'id_unit','pilih' => ' -- Pilih Unit Kerja -- '));
		if ($vse['unit'] != NULL) $where['u.id_unit'] = $vse['unit'];
		$unit_ok = TRUE;
		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => "p.*,jab.nama_jabatan uraian_jabatan,datediff('".$tgl."', p.tanggal_lahir)/364.25 as usia,CONCAT(g.golongan,' - ',g.pangkat) as pangkat,u.unit",
							'where'=>$where
						))->num_rows();
		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 7;
		$config_widget['target']      = '#postPensiun';
        $config_widget['base_url']    = base_url().'ids/data_wisget/pensiun/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_pensiun->initialize($config_widget);
       	$dtgolru = $this->general_model->datagrab(array(
				'tabel' => $from, 'limit' => $config_widget['per_page'],'offset' => $offset,
				'select' => "p.*,jab.nama_jabatan uraian_jabatan,datediff('".$tgl."', p.tanggal_lahir)/364.25 as usia,CONCAT(g.golongan,' - ',g.pangkat) as pangkat,u.unit",
				'where'=>$where
			));
		$tanggal = (!empty($vse['tahun']) or !empty($vse['bulan']) or !empty($searching)) ? "Pegawai yang akan pensiun bulan <b>".$bulandata[$vse['bulan']]."</b> tahun <b>".$vse['tahun']."</b>" : null;
		
	
		if ($dtgolru->num_rows() > 0) {
			
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid" style="margin:0px auto; '.$te.'"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$header = array('No','Nama / NIP','Gol/Pangkat','Jabatan','Usia');
			if ($vse['unit'] == NULL) $header[] = 'Unit Kerja';
			$this->table->set_heading($header);
			
			$no = 1 + $offset;
			foreach($dtgolru->result() as $row){
				$gelar_depan = ''; if(!empty($row->gelar_depan)) $gelar_depan = $row->gelar_depan.' ';
				$gelar_belakang = ''; if(!empty($row->gelar_belakang)) $gelar_belakang = ', '.$row->gelar_belakang;
				
				$rows = array(
					$no,
					$gelar_depan.''.$row->nama.''.$gelar_belakang.
					'<br> &nbsp; '.$row->nip,
					$row->pangkat,
					$row->uraian_jabatan,
					floor($row->usia).' tahun');
				
				if ($vse['unit'] == NULL) $rows[] = $row->unit;
				
				$this->table->add_row($rows);
				$no++;
			}

			$btn_print = anchor('penjagaan/pensiun/list_pensiun/'.in_de($vse).'/print','<i class="fa fa-print"></i> Cetak','class="btn btn-info" target="_blank"');
			$btn_excel = anchor('penjagaan/pensiun/list_pensiun/'.in_de($vse).'/excel','<i class="fa fa-file-excel-o"></i> Excel','class="btn btn-warning" target="_blank"');
			$btn_add = ($offset == "print" or $offset == "excel") ? null : $btn_print.' '.$btn_excel;
			$this->table->add_row(array('data'=>'Total : '.$config_widget['total_rows'].' &nbsp; ', 'class'=>'text-right', 'colspan' => '7'));
			
			if (!empty($tahun) or !empty($searching)) {
				$t = $this->table->generate();
				$tabel = '<h5 style="margin-left: 10px;">'.$tanggal.'</h5><br>'.$t;
			} else {
				$tabel = '<div class="alert">Tentukan bulan dan tahun penjagaan</div>';
			}
			
		} else {
			$tabel = '<div class="alert">'. $tanggal.'<br>Tidak ada data pegawai pensiun</div>';
		}
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);
		$this->load->view('widget_ids/widget_pensiun_ajax',$data);
	}
	function satya_lencana($id_widget=NULL, $jeda_dalam=NULL, $offset=0){
		
		$bulandata = array('' =>  'Seluruh Bulan','01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei',
						'06'=>'Juni','07'=>'Juli','08'=>'Agustu','09'=>'September' ,'10'=>'Oktober','11'=>'November','12'=>'Desember');
		if($id_widget!=NULL){
			$en = $this->general_model->datagrab(array(
				'tabel' => 'ids_konten',
				'where' => array('id_konten' => $id_widget)
			))->row();
		}else{
			$en = NULL;
		}
		$te = 'font-size: 12px;';
		if (@$en->param2!=NULL) {
			$te = 'font-size: '.$en->param2.'px;';
		}
		$data['te'] = $te;

		$page = $this->input->post('page_lapPensiun');
		if(!$page){
	        $offset = 0;
	    }else{
	        $offset = $page;
	    }

	    $tahun = (@$en->param4!=NULL) ? $en->param4 : NULL;
		$bulan = (@$en->param1!=NULL) ? $en->param1 : NULL;
		$unit = (@$en->param3!=NULL) ? $en->param3 : NULL;
		if(!empty($bulan) or !empty($tahun) or !empty($unit)) {
			$vse = array('tahun' => $tahun, 'bulan' => $bulan,'unit' => $unit);
		} else {
			if (!empty($searching)) {
				$vse = un_de($searching);
			} else {
				$vse = array('tahun' => null,'bulan' => null,'unit' => null);
			}
		}
		$from = array(
			'peg_pegawai p' => '',
			'peg_jabatan j' => array('j.id_pegawai = p.id_pegawai and j.status = 1','left'),
			'ref_jabatan jab' => array('jab.id_jabatan = j.id_jabatan','left'),
			'ref_bidang rb'=> array('j.id_bidang = rb.id_bidang','left'),
			'ref_unit u' => array('u.id_unit = rb.id_unit','left'),
			'peg_pangkat go' => array('go.id_pegawai = p.id_pegawai and go.status = 1','left'),
			'ref_golru g' => array('g.id_golru = go.id_golru','left')
		);
		$where = array();
		if (!empty($tahun) or !empty($searching)) {
			$bulanhari = !empty($vse['bulan']) ? $vse['bulan'].'-01' : '12-31';
			$tgl = $vse['tahun'].'-'.$bulanhari;
			$where = array(
				"datediff('".$tgl."', p.tanggal_lahir)/364.25 >= jab.bup" => null,
			'u.aktif' => 1);
		} else {
			$tgl = date('Y-m-d');
		}
		$unit_ok = FALSE;
		$data['unit_selected'] = $vse['unit'];
		$data['cb_unit'] = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit','where' => array('aktif != 2' => null),'val' => array('unit'),'key' => 'id_unit','pilih' => ' -- Pilih Unit Kerja -- '));
		if ($vse['unit'] != NULL) $where['u.id_unit'] = $vse['unit'];
		$unit_ok = TRUE;
		$total_rows = $this->general_model->datagrab(array(
							'tabel' => $from,
							'select' => "p.*,jab.nama_jabatan uraian_jabatan,datediff('".$tgl."', p.tanggal_lahir)/364.25 as usia,CONCAT(g.golongan,' - ',g.pangkat) as pangkat,u.unit",
							'where'=>$where
						))->num_rows();
		$per_page = (@$en->per_page!=NULL) ? $en->per_page : 7;
		$config_widget['target']      = '#postSatyalencana';
        $config_widget['base_url']    = base_url().'ids/data_wisget/satya_lencana/'.$id_widget.'/'.$jeda_dalam.'/';
        $config_widget['total_rows']  = $total_rows;
        $config_widget['per_page']    = $per_page;
       	$config_widget['uri_segment'] = '6';

       	$this->ajax_pagination_pensiun->initialize($config_widget);
       	$dtgolru = $this->general_model->datagrab(array(
				'tabel' => $from, 'limit' => $config_widget['per_page'],'offset' => $offset,
				'select' => "p.*,jab.nama_jabatan uraian_jabatan,datediff('".$tgl."', p.tanggal_lahir)/364.25 as usia,CONCAT(g.golongan,' - ',g.pangkat) as pangkat,u.unit",
				'where'=>$where
			));
		$tanggal = (!empty($vse['tahun']) or !empty($vse['bulan']) or !empty($searching)) ? "Pegawai yang akan pensiun bulan <b>".$bulandata[$vse['bulan']]."</b> tahun <b>".$vse['tahun']."</b>" : null;
		
	
		if ($dtgolru->num_rows() > 0) {
			
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid" style="margin:0px auto; '.$te.'"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$header = array('No','Nama / NIP','Gol/Pangkat','Jabatan','Usia');
			if ($vse['unit'] == NULL) $header[] = 'Unit Kerja';
			$this->table->set_heading($header);
			
			$no = 1 + $offset;
			foreach($dtgolru->result() as $row){
				$gelar_depan = ''; if(!empty($row->gelar_depan)) $gelar_depan = $row->gelar_depan.' ';
				$gelar_belakang = ''; if(!empty($row->gelar_belakang)) $gelar_belakang = ', '.$row->gelar_belakang;
				
				$rows = array(
					$no,
					$gelar_depan.''.$row->nama.''.$gelar_belakang.
					'<br> &nbsp; '.$row->nip,
					$row->pangkat,
					$row->uraian_jabatan,
					floor($row->usia).' tahun');
				
				if ($vse['unit'] == NULL) $rows[] = $row->unit;
				
				$this->table->add_row($rows);
				$no++;
			}

			$btn_print = anchor('penjagaan/pensiun/list_pensiun/'.in_de($vse).'/print','<i class="fa fa-print"></i> Cetak','class="btn btn-info" target="_blank"');
			$btn_excel = anchor('penjagaan/pensiun/list_pensiun/'.in_de($vse).'/excel','<i class="fa fa-file-excel-o"></i> Excel','class="btn btn-warning" target="_blank"');
			$btn_add = ($offset == "print" or $offset == "excel") ? null : $btn_print.' '.$btn_excel;
			$this->table->add_row(array('data'=>'Total : '.$config_widget['total_rows'].' &nbsp; ', 'class'=>'text-right', 'colspan' => '7'));
			
			if (!empty($tahun) or !empty($searching)) {
				$t = $this->table->generate();
				$tabel = '<h5 style="margin-left: 10px;">'.$tanggal.'</h5><br>'.$t;
			} else {
				$tabel = '<div class="alert">Tentukan bulan dan tahun penjagaan</div>';
			}
			
		} else {
			$tabel = '<div class="alert">'. $tanggal.'<br>Tidak ada data pegawai pensiun</div>';
		}
		$data['tabel'] = $tabel;
		$data['paging_sub'] = @$this->ajax_pagination_pensiun->create_links($jeda_dalam);
		$this->load->view('widget_ids/widget_satyalencana_ajax',$data);
	}
}
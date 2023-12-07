<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Display extends CI_Controller
{

	function __construct()
	{

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

	function in_app()
	{
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi', 'where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
	}

	public function index()
	{

		login_check($this->session->userdata('login_state'));

		$data['title'] = 'Dasbor';
		$data['breadcrumb'] = array('' => $this->in_app(), $this->uri->segment(1) . '/home' => 'Dasbor');
		/*
		$data['jml_teks'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_teks','select' => 'count(id_teks) as jml'
		))->row();
		
		$data['widget_aktif'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_widget','select' => 'count(id_widget) as jml'
		))->row();*/


		$data['jml_teks'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_teks', 'select' => 'count(id_teks) as jml'
		))->row();

		// $data['widget_aktif'] = $this->general_model->datagrab(array(
		// 	'tabel' => 'sitika_widget', 'select' => 'count(id_widget) as jml'
		// ))->row();



		$from_news = array(
			'sitika_widget_news p' => '',
			'sitika_news i' => array('i.id_news = p.id_news', 'left')
		);

		$data['widget_new_i'] = $this->general_model->datagrab(array(
			'tabel' => $from_news, 'select' => 'count(p.id_news) as jml', 'where' => array('jenis_i' => 1)
		))->row();

		$data['widget_new_u'] = $this->general_model->datagrab(array(
			'tabel' => $from_news, 'select' => 'count(p.id_news) as jml', 'where' => array('jenis_u' => 1)
		))->row();



		$from_foto = array(
			'sitika_widget_foto p' => '',
			'sitika_foto i' => array('i.id_foto = p.id_foto', 'left')
		);

		$data['widget_foto_i'] = $this->general_model->datagrab(array(
			'tabel' => $from_foto, 'select' => 'count(p.id_foto) as jml', 'where' => array('jenis_i' => 1)
		))->row();

		$data['widget_foto_u'] = $this->general_model->datagrab(array(
			'tabel' => $from_foto, 'select' => 'count(p.id_foto) as jml', 'where' => array('jenis_u' => 1)
		))->row();


		$data['content'] = $this->uri->segment(1) . "/dashboard_view";
		$this->load->view('home', $data);
	}



	function tv_umum()
	{

		$data['title'] = 'TV Info Pelatihan';

		$data['app'] = 'TV-Info Pelatihan';
		$data['folder'] = $this->uri->segment(1);

		$data['par'] = $this->general_model->get_param(array(
			'pemerintah_logo', 'pemerintah', 'instansi', 'all_reload', 'header_image',
			'refresh_time_1', 'color_basic_1',
			'color_header_1', 'color_text_header_1',
			'color_footer_1', 'color_text_footer_1',
			'color_time_1', 'color_text_time_1',
			'color_date_1', 'color_text_date_1',
			'color_pengumuman_1', 'color_title_pengumuman_1', 'color_box_pengumuman_1', 'color_text_pengumuman_1', 'height_pengumuman_1', 'font_pengumuman_1',
			'color_informasi_1', 'color_title_informasi_1', 'color_box_informasi_1', 'color_text_informasi_1', 'height_informasi_1', 'font_informasi_1',
			'color_berlangsung_1', 'color_title_berlangsung_1', 'color_box_berlangsung_1', 'color_text_berlangsung_1', 'height_berlangsung_1', 'font_berlangsung_1',
			'color_rencana_1', 'color_title_rencana_1', 'color_box_rencana_1', 'color_text_rencana_1', 'height_rencana_1', 'font_rencana_1',
			'color_foto_1', 'color_title_foto_1', 'color_box_foto_1', 'color_text_foto_1', 'height_foto_1',
			'color_video_1', 'color_title_video_1', 'color_box_video_1', 'color_text_video_1', 'height_video_1',
			'color_foto_pegawai', 'height_foto_pegawai', 'slide_foto_pegawai',
			'mode_video_umum',
		), 2);

		$data['foto'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'limit' => 10,
			'offset' => 0,
			'where' => array('status' => 2, 'tipe' => 2),

		));

		$data['det'] = $this->general_model->get_param('tvinfo_durasi');

		$q_galeri1 = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 1),
			'order' => 'id_foto DESC',
			// 'limit' => 1
		));

		$data['foto_kiri'] = $q_galeri1;
		// ./ GALERI FOTO 1

		// GALERI KANAN
		$q_galeri2 = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 2),
			'order' => 'id_foto DESC',
			// 'limit' => 1
		));

		$data['foto_kanan'] = $q_galeri2;

		$config_gal['target']      = '#postvideo';
		$config_gal['base_url']    = base_url() . 'siatika/display/ajaxPaginationvideo';
		// $config_gal['total_rows']  = $totalRec_video;
		$config_gal['per_page']    = 1;
		$config_gal['uri_segment'] = '4';

		$this->ajax_pagination_video->initialize($config_gal);


		$par = $this->general_model->get_param(array('mode_video_umum'), 2);
		if ($par['mode_video_umum'] == 1) {
			$data['video'] = $this->general_model->datagrab(array(
				'tabel' => 'sitika_video',
				'order' => 'id_video DESC',
				'where' => array('status' => 2, 'video_source' => 1),

			));
		} else {
			$data['video'] = $this->general_model->datagrab(array(
				'tabel' => 'sitika_video',
				'order' => 'id_video DESC',
				'where' => array('status' => 2, 'video_source' => 2),
				'limit' => 1

			))->row();
		}
		$data['mode_video'] = $par['mode_video_umum'];

		$data['musik'] = $this->general_model->datagrab(array('tabel' => 'sitika_backsound', 'order' => 'id_backsound asc'));
		$data['running_text']  = $this->general_model->datagrab(array(
			'tabel' => 'sitika_running_text', 'limit' => 10, 'offset' => 0
		));

		$now = date("Y-m-d ");
		$data['now'] = $now;

		$from = array(
			'sitika_articles tj' => '',
			'sitika_categories td' => array('td.id_cat = tj.id_cat', 'left'),
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);
		$where_pelatihan = array('tj.code' => 3, 'date(tj.date_start) >= "' . $now . '" OR date(tj.date_end) >= "' . $now . '"' => null, 'tj.status' => 1);
		$data['pelatihan'] = $this->general_model->datagrab(array(
			'tabel' => $from,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_pelatihan,
		));

		$where_agenda = array('tj.code' => 3, 'date(tj.date_start) <= ' => $now, ' date(tj.date_end) >= ' => $now, 'tj.status' => 1);
		$data['agenda'] = $this->general_model->datagrab(array(
			'tabel' => $from,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
		));
		// cek($this->db->last_query());
		$where_pengumuman = array('tj.code' => 4, 'date(tj.date_start) <=' => $now, 'tj.id_kategori' => 1, 'tj.status' => 1);
		$data['pengumuman'] = $this->general_model->datagrab(array(
			'tabel' => $from,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_pengumuman,
		));
		$where_informasi = array('tj.code' => 1, 'date(tj.date_start) <=' => $now, 'tj.id_kategori' => 1, 'tj.status' => 1);
		$data['informasi']  = $this->general_model->datagrab(array(
			'tabel' => $from,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_informasi,

		));

		$this->load->view('siatika/tv_umum_view', $data);
	}



	function ajax_musik()
	{
		$musik = $this->general_model->datagrab(array('tabel' => 'sitika_sound', 'order' => 'id_sound asc'))->row();
	}

	function ajax_fotokiri()
	{
		$gal_foto = array(
			'sitika_widget_foto p' => '',
			'sitika_foto i' => array('i.id_foto = p.id_foto', 'left')
		);


		$fotoxx = $this->general_model->datagrab(array(
			'tabel' => $gal_foto,
			'where' => array('i.status' => 1, 'p.jenis_u' => 1),
			'order' => 'i.id_foto desc'
		));
		$data = '';
		$data .= '<script type="text/javascript" src="' . base_url('assets/js/wowslider.js') . '"></script>
				<script type="text/javascript" src="' . base_url('assets/js/script.js') . '"></script>';
		foreach ($fotoxx->result() as $f) {
			$jmlx = strlen($f->judul);
			$kata = strlen($f->judul);
			if ($kata > 50) {
				$judul = "<marquee>" . $f->judul . "</marquee>";
			} else {
				$judul = $f->judul;
			}
			$data .=
				'
													<li style="width: 10%;">
					<img src="' . base_url('uploads/tvinfo/' . $f->foto) . '"  title="' . $judul . '" id="wows1_0" style="visibility: visible;">
				</li>
				';
		}

		die(json_encode($data));
	}



	function tv_internal($offset = NULL)
	{
		$offset = !empty($offset) ? $offset : null;
		$data['title'] = 'TV Info Pelatihan';

		$data['app'] = 'TV-Info Pelatihan';
		$data['folder'] = $this->uri->segment(1);

		$data['par'] = $this->general_model->get_param(array(
			'pemerintah_logo', 'pemerintah', 'instansi', 'all_reload', 'header_image',
			'refresh_time_2', 'color_basic_2',
			'color_header_2', 'color_text_header_2',
			'color_footer_2', 'color_text_footer_2',
			'color_time_2', 'color_text_time_2',
			'color_date_2', 'color_text_date_2',
			'color_pengumuman_2', 'color_title_pengumuman_2', 'color_box_pengumuman_2', 'color_text_pengumuman_2', 'height_pengumuman_2', 'font_pengumuman_2',
			'color_informasi_2', 'color_title_informasi_2', 'color_box_informasi_2', 'color_text_informasi_2', 'height_informasi_2', 'font_informasi_2',
			'color_foto_2', 'color_title_foto_2', 'color_box_foto_2', 'color_text_foto_2', 'height_foto_2',
			'color_profil_1', 'color_title_profil_1', 'color_box_profil_1', 'color_text_profil_1', 'height_profil_1', 'font_profil_1',

		), 2);



		$data['foto'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'limit' => 10,
			'offset' => 0,
			'where' => array('status' => 2, 'tipe' => 2),

		));

		$data['det'] = $this->general_model->get_param('tvinfo_durasi');

		$q_galeri1 = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 1),
			'order' => 'id_foto DESC',
			// 'limit' => 1
		));


		$data['foto_kiri'] = $q_galeri1;
		// ./ GALERI FOTO 1

		// GALERI KANAN
		$q_galeri2 = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 2),
			'order' => 'id_foto DESC',
			// 'limit' => 1
		));


		$data['foto_kanan'] = $q_galeri2;
		// ./ GALERI FOTO 1
		// ./GALERI KANAN

		$data['musik'] = $this->general_model->datagrab(array('tabel' => 'sitika_backsound', 'order' => 'id_backsound asc', 'where' => array('status' => 2)));

		$from = array(
			'peg_pegawai a' => '',
			'ref_unit b' => array('b.id_unit = a.id_unit', 'left'),
			'ref_bidang c' => array('c.id_bidang = a.id_bidang', 'left'),
			'ref_jabatan d' => array('d.id_jabatan = a.id_jabatan', 'left'),
			'ref_eselon e' => array('e.id_eselon = a.id_eselon', 'left'),
			'ref_jenis_kelamin f' => array('f.id_jeniskelamin = a.id_jeniskelamin', 'left'),
			'ref_agama g' => array('g.id_agama = a.id_agama', 'left'),
			'ref_status_pegawai h' => array('h.id_status_pegawai = a.id_status_pegawai', 'left'),
		);
		$select = '*,a.alamat as lamat,h.tipe';
		$where = array('h.tipe = 1  AND a.id_status_pegawai !=0' => NULL);
		$data['pegawai']  = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'a.id_pegawai DESC', 'select' => $select, 'where' => $where));
		$data['running_text']  = $this->general_model->datagrab(array(
			'tabel' => 'sitika_running_text', 'limit' => 10, 'offset' => 0
		));

		$now = date("Y-m-d ");
		$data['now'] = $now;

		$from = array(
			'sitika_articles tj' => '',
			'sitika_categories td' => array('td.id_cat = tj.id_cat', 'left'),
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);


		$where_pengumuman = array('tj.code' => 4, 'date(tj.date_start) <=' => $now, 'tj.id_kategori' => 2, 'tj.status' => 1);
		$data['pengumuman'] = $this->general_model->datagrab(array(
			'tabel' => $from,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_pengumuman,
		));
		$where_informasi = array('tj.code' => 1, 'date(tj.date_start) <=' => $now, 'tj.id_kategori' => 2, 'tj.status' => 1);
		$data['informasi']  = $this->general_model->datagrab(array(
			'tabel' => $from,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_informasi,

		));

		$this->load->view('siatika/tv_internal_view', $data);
		// $this->load->view('tv/test_tv_internal', $data);
	}

	function ajaxPaginationberlangsung()
	{
		$page = $this->input->post('page', TRUE);
		// cek($page);

		if (empty($page)) {
			$offset = 0;
		} else {
			$offset = $page;
		}


		$from_agenda = array(
			'sitika_articles tj' => '',
			'sitika_categories td' => array('td.id_cat = tj.id_cat', 'left'),
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);
		$now = date("Y-m-d");
		$where_agenda = array('tj.code' => 3, 'tj.date_start <= ' => $now, 'tj.date_end >= ' => $now,);
		$totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_agenda,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset
		))->num_rows();

		$config['target']      = '#postBerlangsung';
		$config['base_url']    = base_url() . 'siatika/display/ajaxPaginationberlangsung';
		$config['total_rows']  = $totalRec;

		$config['per_page']    = $this->BerPel;
		$config['uri_segment'] = '4';

		$this->ajax_pagination_berlangsung->initialize($config);

		$data['detail_kegiatan_mi'] = $this->general_model->datagrab(array(
			'tabel' => $from_agenda,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset
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
							'data' => tanggal_indo($row->tanggal1,2).' s.d '.date_indox($row->tanggal2,2),
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
		$this->load->view('siatika/widget_jadwal_berlangsung', $data, false);
	}


	function ajaxPaginationpelatihan()
	{
		$page = $this->input->post('page', TRUE);
		// cek($page);

		if (empty($page)) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		$from_agenda = array(
			'sitika_articles tj' => '',
			'sitika_categories td' => array('td.id_cat = tj.id_cat', 'left'),
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);
		$now = date("Y-m-d ");
		$where_agenda = array('tj.code' => 3, 'tj.date_start >= "' . $now . '" OR tj.date_end >= "' . $now . '"' => null,);
		$totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_agenda,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset
		))->num_rows();


		$config['target']      = '#postPelatihan';
		$config['base_url']    = base_url() . 'siatika/display/ajaxPaginationpelatihan';
		$config['total_rows']  = $totalRec;

		$config['per_page']    = $this->RenPel;
		$config['uri_segment'] = '4';

		$this->ajax_pagination_pelatihan->initialize($config);


		$query = $this->general_model->datagrab(array(
			'tabel' => $from_agenda,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset
		));
		// cek($this->db->last_query());
		if ($query->num_rows() != 0) {
			$classy = (in_array(NULL, array("cetak", "excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid" style="font-size:10px"';
			$this->table->set_template(array('table_open' => '<table ' . $classy . '>'));
			$heads = array('No');

			if (!in_array(NULL, array('cetak', 'excel')));
			$heads = array_merge_recursive($heads, array('TANGGAL', 'AGENDA', 'TEMPAT', 'CP'));
			//if (!in_array(NULL,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => 2);
			$this->table->set_heading($heads);


			$no = 1 + $offset;

			foreach ($query->result() as $row) {
				if ($row->date_start > $now) {
					$warna = 'background-color:#FFFFD1;color:#605A01;padding:5px';
				} else {
					$warna = 'background-color:#9DF495;color:#0C5106;padding:5px';
				}


				$size = 'font-size:10px;';
				$jumlahkata = strlen($row->title);

				$rows = array(
					array('data' => $no, 'style' => $warna)
				);


				$rows[] = array(
					'data' =>	tanggal_indo(date('Y-m-d', strtotime($row->date_start))) . ' s.d ' .  tanggal_indo(date('Y-m-d', strtotime($row->date_end))),
					'class' => 'text-center', 'style' => $warna . 'width:120px;font-size:10px;'
				);

				$rows[] = array(
					'data' => $row->title,
					'style' => $warna . $size
				);
				$rows[] = array(
					'data' => $row->tempat,
					'style' => $warna . $size
				);
				$rows[] = array(
					'data' => $row->kontak,
					'style' => $warna  . $size
				);

				$this->table->add_row($rows);
				$no++;
			}

			$tabel = $this->table->generate();
		} else {
			$tabel = '<div class="alert alert-confirm" style="background: linear-gradient(#dada00, #ffffff)">Belum ada Jadwal Rencana Pelatihan</div><div class="clear"></div>';
		}

		$data['rencana_pelatihan'] = $tabel;



		//load the view
		$this->load->view('siatika/widget_jadwal_view', $data, false);
	}


	function ajaxPaginationinformasi()
	{
		$page = $this->input->post('page', TRUE);
		// cek($page);

		if (empty($page)) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		$from_agenda = array(
			'sitika_articles tj' => '',
			'sitika_categories td' => array('td.id_cat = tj.id_cat', 'left'),
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);
		$now = date("Y-m-d ");
		$where_agenda = array('tj.code' => 1,);
		$total_data = $this->general_model->datagrab(array(
			'tabel' => $from_agenda,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset
		))->num_rows();




		//pagination configuration
		$config_news['target']      = '#postInfo';
		$config_news['base_url']    = base_url() . 'siatika/display/ajaxPaginationinformasi';
		$config_news['total_rows']  = $total_data;
		$config_news['per_page']    = 1;
		$config_news['uri_segment'] = '4';

		$this->ajax_pagination_informasi->initialize($config_news);
		//get the posts data
		//get the posts data
		$data['informasi'] = $this->general_model->datagrab(array(
			'tabel' => $from_agenda,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset
		));
		$data['id_gal'] = 'id_article';
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
		$this->load->view('siatika/ajax-informasi', $data, false);
	}

	function ajaxPaginationpengumuman()
	{
		$page = $this->input->post('page', TRUE);
		// cek($page);

		if (empty($page)) {
			$offset = 0;
		} else {
			$offset = $page;
		}


		$from_pengumuman = array(
			'sitika_articles tj' => '',
			'sitika_categories td' => array('td.id_cat = tj.id_cat', 'left'),
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);
		$now = date("Y-m-d ");
		$where_agenda = array('tj.code' => 4, 'tj.date_start >=' => $now);



		$total_peng = $this->general_model->datagrab(array(
			'tabel' => $from_pengumuman,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset
		))->num_rows();


		//pagination configuration
		$config_peng['target']      = '#postPengumuman';
		$config_peng['base_url']    = base_url() . 'siatika/display/ajaxPaginationpengumuman';
		$config_peng['total_rows']  = $total_peng;
		$config_peng['per_page']    = 1;
		$config_peng['uri_segment'] = '4';

		$this->ajax_pagination_pengumuman->initialize($config_peng);
		//get the posts data
		//get the posts data
		$data['pengumuman'] = $this->general_model->datagrab(array(
			'tabel' => $from_pengumuman,
			"select" => 'td.*,tj.*,te.*',
			"order" => 'tj.date_start asc',
			'where' => $where_agenda,
			'offset' => $offset,
			'limit' => 1

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
		$this->load->view('siatika/ajax-pengumuman', $data, false);
	}


	//--tutup ajax informasi

	function ajaxPaginationvideo()
	{
		$page = $this->input->post('page', TRUE);
		//cek($page);

		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}



		$totalRec_gal = $this->general_model->datagrab(array(
			'tabel' => 'sitika_video',
			'where' => array('status' => 2)
		))->num_rows();


		//pagination configuration
		$config_video['target']      = '#postVideo';
		$config_video['base_url']    = base_url() . 'siatika/display/ajaxPaginationvideo';
		$config_video['total_rows']  = $totalRec_gal;
		$config_video['per_page']    = 1;
		$config_video['uri_segment'] = '4';

		$this->ajax_pagination_video->initialize($config_video);

		//get the posts data
		$data['video'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_video',
			'where' => array('status' => 2),
			'offset' => $offset,
			'limit' => 1,

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

		$this->load->view('siatika/ajax-galeri-video', $data, false);
	}

	function ajax_tgl()
	{
		$tgl = date_indox(date('Y-m-d'), 2);
		$data = array();
		$data[] = array(
			'tgl' => $tgl
		);
		die(json_encode($data));
	}



	function ajaxPaginationGALin()
	{
		$page = $this->input->post('pageGAL1', TRUE);
		// cek($page);

		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}


		// galeri


		$from_foto1 = array(
			'sitika_widget_foto p' => '',
			'sitika_foto i' => array('i.id_foto = p.id_foto', 'left')
		);

		// ./galeri

		$totalRec_gal = $this->general_model->datagrab(array(
			'tabel' => $from_foto1,
			'where' => array('i.status' => 1, 'p.jenis_u' => 1),
		))->num_rows();


		//pagination configuration
		$config_gal['target']      = '#postGAL1';
		$config_gal['base_url']    = base_url() . 'tv/home/ajaxPaginationGALin';
		$config_gal['total_rows']  = $totalRec_gal;
		$config_gal['per_page']    = 1;
		$config_gal['uri_segment'] = '4';

		$this->ajax_pagination_gal1->initialize($config_gal);

		//get the posts data
		$data['foto'] = $this->general_model->datagrab(array(
			'tabel' => $from_foto1,
			'where' => array('i.status' => 1, 'p.jenis_u' => 1),
			'order' => 'i.id_foto DESC',
			'offset' => $offset,
			// 'offset'=>6,
			'limit' => 1,

		));
		// cek($data['foto']->num_rows());
		// cek($this->db->last_query());
		// cek($page);

		// ./KIRI

		//load the view
		$this->load->view('tv/ajax-galeri-data-in', $data, false);
	}

	function ajaxPaginationGAL1()
	{
		$page = $this->input->post('pageGAL1', TRUE);
		// cek($page);

		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}


		// galeri



		// ./galeri

		$totalRec_gal = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 1),
		))->num_rows();


		//pagination configuration
		$config_gal['target']      = '#postGAL1';
		$config_gal['base_url']    = base_url() . 'siatika/display/ajaxPaginationGAL1';
		$config_gal['total_rows']  = $totalRec_gal;
		$config_gal['per_page']    = 1;
		$config_gal['uri_segment'] = '4';

		$this->ajax_pagination_gal1->initialize($config_gal);

		//get the posts data
		$data['foto'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 1),
			'order' => 'id_foto DESC',
			'offset' => $offset,
			// 'offset'=>6,
			'limit' => 1,

		));
		// cek($data['foto']->num_rows());
		// cek($this->db->last_query());
		// cek($page);

		// ./KIRI
		$data['offset'] = $offset;
		// cek($data['foto']->num_rows());
		// cek($this->db->last_query());
		// cek($page);

		// $jeda = 10;
		// $data['jeda'] = $jeda;
		// $data['paging'] = $this->ajax_pagination_gal1->create_links($jeda);
		// ./KIRI

		//load the view
		$this->load->view('siatika/ajax-galeri-data-1', $data, false);
	}

	// galeri kanan
	function ajaxPaginationGAL2()
	{
		$page = $this->input->post('pageGAL2', TRUE);
		// cek($page);

		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}


		// galeri



		// ./galeri

		$totalRec_gal = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 2),
		))->num_rows();


		//pagination configuration
		$config_gal['target']      = '#postGAL2';
		$config_gal['base_url']    = base_url() . 'siatika/display/ajaxPaginationGAL2';
		$config_gal['total_rows']  = $totalRec_gal;
		$config_gal['per_page']    = 1;
		$config_gal['uri_segment'] = '4';

		$this->ajax_pagination_gal2->initialize($config_gal);

		//get the posts data
		$data['foto_kanan'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_foto',
			'where' => array('status' => 2, 'tipe' => 1, 'posisi' => 2),
			'order' => 'id_foto DESC',
			'offset' => $offset,
			// 'offset'=>6,
			'limit' => 1,

		));
		// cek($data['foto']->num_rows());
		// cek($this->db->last_query());
		// cek($page);

		// ./KIRI

		//load the view
		$this->load->view('siatika/ajax-galeri-data-2', $data, false);
	}
	// ./galeri kanan


	// galeri kanan
	function ajaxPaginationGALin2()
	{
		$page = $this->input->post('pageGAL2', TRUE);
		// cek($page);

		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}


		// galeri


		$from_foto1 = array(
			'sitika_widget_foto p' => '',
			'sitika_foto i' => array('i.id_foto = p.id_foto', 'left')
		);

		// ./galeri

		$totalRec_gal = $this->general_model->datagrab(array(
			'tabel' => $from_foto1,
			'where' => array('i.status' => 2, 'p.jenis_u' => 1),
		))->num_rows();


		//pagination configuration
		$config_gal['target']      = '#postGAL2';
		$config_gal['base_url']    = base_url() . 'tv/home/ajaxPaginationGALin2';
		$config_gal['total_rows']  = $totalRec_gal;
		$config_gal['per_page']    = 1;
		$config_gal['uri_segment'] = '4';

		$this->ajax_pagination_gal2->initialize($config_gal);

		//get the posts data
		$data['foto_kanan'] = $this->general_model->datagrab(array(
			'tabel' => $from_foto1,
			'where' => array('i.status' => 2, 'p.jenis_u' => 1),
			'order' => 'i.id_foto DESC',
			'offset' => $offset,
			// 'offset'=>6,
			'limit' => 1,

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
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		$tanggal_widget = $this->general_model->datagrab(array(
			'tabel' => 'sitika_widget',
			'select' => 'tgl_mulai,tgl_selesai',
			'where' => array('tipe' => 3)
		))->row();
		// PESERTA
		$from = array(
			'pes_kelas p' => '',
			'peserta i' => array('i.id = p.id_peserta', 'left'),
			'jadwal_ins j' => array('j.id = p.id_jadwal', 'left'),
			'ref_instansi k' => array('k.id_instansi = j.id_instansi', 'left'),
			'program l' => array('l.id = j.id_program', 'left'),
			'program n' => array('n.id =p.program', 'left'),
			'ref_jenis_client m' => array('m.id_jenis_client = j.id_jenis_client', 'left')
		);

		$q_l = $this->general_model->datagrab(array(
			'tabel' => $from,
			'order' => 'j.tanggal1 ASC',
			'where' => array('j.tanggal1 BETWEEN "' . $tanggal_widget->tgl_mulai . '" AND "' . $tanggal_widget->tgl_selesai . '" ' => null),
			'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
			'limit' => $this->perPage
		));
		// ./PESERTA

		$totalRec = $this->general_model->datagrab(array(
			'tabel' => $from, 'where' => array('j.tanggal1 BETWEEN "' . $tanggal_widget->tgl_mulai . '" AND "' . $tanggal_widget->tgl_selesai . '" ' => null)
		))->num_rows();

		//total rows count
		// $totalRec = count($this->post->getRows());

		//pagination configuration
		$config['target']      = '#postPST';
		$config['base_url']    = base_url() . 'tv/home/ajaxPaginationData';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['uri_segment'] = '4';

		$this->ajax_pagination->initialize($config);

		//get the posts data
		$data['peserta'] = $this->general_model->datagrab(array(
			'tabel' => $from,
			'order' => 'j.tanggal1 ASC',
			'where' => array('j.tanggal1 BETWEEN "' . $tanggal_widget->tgl_mulai . '" AND "' . $tanggal_widget->tgl_selesai . '" ' => null),

			'select' => 'k.*,p.*,p.id as id_p,j.id as id_j,j.instansi as instansi_baru,j.program as program_baru,j.tanggal1 as tgl1_baru,j.tanggal2 as tgl2_baru,l.nama_program as xx,n.nama_program as e,i.id as id_pes,m.nama_client,i.foto,i.nama as nama_peserta,p.alamat_inst',
			'limit' => $this->perPage,
			'offset' => $offset
		))->result();

		//load the view
		$this->load->view('tv/ajax-peserta-data', $data, false);
	}
	// ./ajax paginasi


	function get_durasi($id)
	{

		$row = $this->general_model->datagrab(array(
			'tabel' => 'sitika_widget',
			'where' => array('id_widget' => $id)
		))->row();
		$durasi  = !empty($row) ? $row->durasi : 0.05;
		die(json_encode($durasi));
	}
	function teksbergerak()
	{
		$par = $this->general_model->get_param(array('pemerintah_logo', 'pemerintah', 'instansi'), 2);
		$mar = $this->general_model->datagrab(array(
			'tabel' => 'sitika_running_text', 'limit' => 10, 'offset' => 0
		));
		$ava = file_exists('./uploads/logo/' . @$par['pemerintah_logo']) ? base_url() . 'uploads/logo/' . $par['pemerintah_logo'] : base_url() . 'assets/logo/brand.png';
		$img = '<img src="' . $ava . '" height="50">';
		echo '
		<marquee class="marquee-box">
			<div >';
		$j = 1;
		foreach ($mar->result() as $m) {
			$star = ($j > 1) ? '&nbsp;&nbsp;' . $img . '&nbsp;&nbsp; ' : null;
			echo '' . $star . '<b>' . $m->teks_bergerak . '</b> ';
			$j += 1;
		}
		echo '
			</div>
		</marquee>';
	}

	function unitbingkai()
	{

		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1),
			'order' => 'urut'
		));

		$this->load->view('tv/tv_unitbingkai_view', $data);
	}

	function get_durasi_sc($durasi, $st_data = 0, $tot = 0)
	{

		$data = '<script type="text/javascript">';

		if ($st_data == 1) {
			$data .= '
				var st_data = 1;
				var durasi = 4;
				
				var lf = 2;
				var max_lf = ' . $tot . ';

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
						url: \'' . site_url("tv/home/get_durasi/") . '/\'+ lf,
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

				parseFloat(' . $durasi . ')*60000);

				$(\'#lf1\').fadeIn();
				$(\'.no_kiri\').html(1).show();
			';
		} else {

			$data .= "$('#lf1').fadeIn();";
		}

		$data .= '</script>';

		die(json_encode($st_dat));
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db extends CI_Controller {
	var $dir = 'ids';
	var $init = array(
		'judul' => 'IDS',
		'deskripsi' => 'Information Display System (IDS) Modul program dari aplikasi siap yang berfungsi untuk mengelola penyajian informasi dalam bentuk IDS',
		'folder' => 'ids',
		'warna' => '#ffeb0f',
		'kode' => 'ids'
	);

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->set_db();
	}
	function init() {
		return $this->init;
	}
	function set_db($n = null) {
		$app = array(
			null,
			$this->init['kode'],
			$this->init['judul'],
			$this->init['deskripsi'],
			$this->init['folder'],
			$this->init['warna']
		);
		$nav = array(
			array(NULL,1,NULL,2,'Pengaturan IDS', NULL, $this->dir.'/pengaturan','desktop'),
			// array(NULL,1,NULL,2,'Referensi Konten',NULL, $this->dir.'/ref_konten','newspaper-o'),
			array(NULL,1,NULL,2,'IDS',NULL, $this->dir.'/list_ids','laptop'),
			// array(NULL,1,NULL,2,'Galeri',NULL, $this->dir.'/galeri','laptop'),
			// array(NULL,1,NULL,2,'Teks Bergerak',NULL, $this->dir.'/text','laptop')
			);
		$tabel = array(
			'ref_font' => array(
				array('id_font', 'int', 11, FALSE, 1),
				array('font', 'int', 11, FALSE)
				),
			'ids' => array(
				array('id_ids','int',11,FALSE,1),
				array('id_theme','int',11,FALSE),
				array('nama_ids','varchar',255,FALSE),
				array('status','int',1,FALSE),
				array('permalink','varchar',255,FALSE),
				array('all_reload','float',NULL,FALSE)
				),
			'ids_konten' => array(
				array('id_konten', 'int', 11, FALSE, 1),
				array('id_tipe_konten', 'int', 11, FALSE),
				array('id_ids', 'int', 11, FALSE),
				array('posisi', 'int', 11, FALSE),
				array('judul','varchar',255,FALSE),
				array('id_data', 'int', 11, TRUE),
				array('id_font', 'int', 11, TRUE),
				array('data_img', 'varchar', 255, TRUE),
				array('status', 'int', 1, FALSE),
				array('urut', 'int', 11, FALSE),
				array('durasi', 'varchar', 50, TRUE),
				array('per_page', 'int', 11, TRUE),
				array('param1', 'varchar', 255, TRUE),
				array('param2', 'varchar', 255, TRUE),
				array('param3', 'varchar', 255, TRUE),
				array('param4', 'varchar', 255, TRUE),
				array('mulai_tayang', 'date', null, TRUE),
				array('selesai_tayang', 'date', null, TRUE)
				),
			'ids_tipe_konten' => array(
				array('id_tipe_konten', 'int',11, FALSE, 1),
				array('tipe_konten', 'varchar', 255, FALSE),
				array('kode_konten', 'varchar', 50, FALSE),
				array('id_aplikasi', 'int', 11, FALSE)
				),
			'ids_ref_konten' =>array(
				array('id_ref_konten','int',11,FALSE,1),
				array('id_tipe_konten','int',11,FALSE),
				array('code','varchar',50,FALSE),
				array('ref_konten','varchar',255,FALSE)
				),
			'ids_ref_theme' => array(
				array('id_theme','int',11,FALSE,1),
				array('theme','varchar',255,FALSE)
				),
			'ids_setting' => array(
				array('id_setting', 'int', 11, FALSE, 1),
				array('id_ids', 'int', 11, FALSE),
				array('posisi', 'int', 11, FALSE),
				array('tinggi','float',NULL,FALSE),
				array('background_title', 'varchar', 20, TRUE),
				array('color_title', 'varchar', 20, TRUE)
				),
			
			'ids_teks' => array(
				array('id_teks','int',11,FALSE,1),
				array('teks','TEXT',null,FALSE),
				array('urut','int',11,FALSE),
				array('status','int',1,FALSE),
				array('op','int',11,FALSE)
				),
			// galeri
			'ids_galeri'=>array(
				array('id_galeri', 'int', 11, FALSE, 1),
				array('urut', 'int', 2, TRUE),
				array('judul', 'varchar', 255, TRUE),
				array('foto', 'varchar', 255, TRUE),
				array('keterangan', 'text', null, TRUE),
				array('tanggal', 'date', null, TRUE),
				array('jeda', 'int', 12, TRUE),
				array('posisi', 'int', 1, TRUE),
				array('status', 'int', 1, TRUE)
				),
			// ./galeri
			);
		$odie = load_controller('inti','builder','process_db',$app,$tabel,$nav);

		$data_db = array(
			// 'ids_ref_theme' => array(
			// 	array('theme'=>'2 Kolom'),
			// 	array('theme'=>'3 Kolom')
			// 	),
			/*'parameter' => array(
				array('param'=>'reload_konten', 'val'=>'5'),
				array('param'=>'reload_pengumuman', 'val'=>'8'),
				array('param'=>'reload_slide1', 'val'=>'6'),
				array('param'=>'reload_slide2', 'val'=>'5'),
				array('param'=>'speed_run_text', 'val'=>'100'),
				array('param'=>'height_konten', 'val'=>'586'),
				array('param'=>'height_sidebar_1', 'val'=>'345'),
				array('param'=>'height_sidebar_2', 'val'=>'230'),
				array('param'=>'header_color', 'val'=>'#500380'),
				array('param'=>'color_text_header', 'val'=>'#fff'),
				array('param'=>'basic_color', 'val'=>'#b781cb'),
				array('param'=>'color_text_basic', 'val'=>'#000'),
				array('param'=>'title_color', 'val'=>'#000'),
				array('param'=>'color_text_title', 'val'=>'#f8c300'),
				array('param'=>'column_color', 'val'=>'#fff'),
				array('param'=>'color_text_column', 'val'=>'#000'),
				array('param'=>'galeri_color', 'val'=>'#000'),
				array('param'=>'color_text_galeri', 'val'=>'#fff'),
				array('param'=>'time_color', 'val'=>'#f8c300'),
				array('param'=>'color_text_time', 'val'=>'#fff'),
				array('param'=>'date_color', 'val'=>'#ff0000'),
				array('param'=>'color_text_date', 'val'=>'#fff'),
				array('param'=>'marquee_color', 'val'=>'#000'),
				array('param'=>'color_text_marquee', 'val'=>'#fff')
				),*/
			// 'ids_tipe_konten' => array(
			// 	array('tipe_konten'=>'Informasi Kepegawaian'),
			// 	array('tipe_konten'=>'Informasi Kegiatan'),
			// 	array('tipe_konten'=>'Informasi Surat Masuk dan Surat Keluar'),
			// 	array('tipe_konten'=>'Informasi Pengumuman'),
			// 	array('tipe_konten'=>'Informasi Buku Tamu (Pejabat yang menerima tamu)')
			// 	),

			// 'ids_ref_konten' => array(
			// 	array('id_tipe_konten'=>'1', 'code'=>'duk', 'ref_konten'=>'Daftar Urut Kepangkatan (DUK)'),
			// 	array('id_tipe_konten'=>'1', 'code'=>'kenpa', 'ref_konten'=>'Penjagaan Kenaikan Pangkat Reguler'),
			// 	array('id_tipe_konten'=>'1', 'code'=>'kgb', 'ref_konten'=>'Penjagaan Kenaikan Gaji Berkala (KGB)'),
			// 	array('id_tipe_konten'=>'1', 'code'=>'pensiun', 'ref_konten'=>'Penjagaan Pensiun'),
			// 	array('id_tipe_konten'=>'1', 'code'=>'lencana', 'ref_konten'=>'Penjagaan Satyalencana'),
			// 	array('id_tipe_konten'=>'2', 'code'=>'sch', 'ref_konten'=>'Jadwal Kegiatan'),
			// 	array('id_tipe_konten'=>'3', 'code'=>'letter_in', 'ref_konten'=>'Surat Masuk'),
			// 	array('id_tipe_konten'=>'3', 'code'=>'letter_out', 'ref_konten'=>'Surat Keluar'),
			// 	array('id_tipe_konten'=>'4', 'code'=>'peng', 'ref_konten'=>'Pengumuman dari Sikordani'),
			// 	array('id_tipe_konten'=>'5', 'code'=>'hadir', 'ref_konten'=>'Hadir'),
			// 	array('id_tipe_konten'=>'5', 'code'=>'tidak_hadir', 'ref_konten'=>'Tidak Di Tempat')
			// 	),

			// 'ref_font' => array(
			// 	array('font'=>'8'),
			// 	array('font'=>'9'),
			// 	array('font'=>'10'),
			// 	array('font'=>'11'),
			// 	array('font'=>'12'),
			// 	array('font'=>'13'),
			// 	array('font'=>'14'),
			// 	array('font'=>'15'),
			// 	array('font'=>'16'),
			// 	array('font'=>'17'),
			// 	array('font'=>'18'),
			// 	array('font'=>'19'),
			// 	array('font'=>'20'),
			// 	array('font'=>'21'),
			// 	array('font'=>'22'),
			// 	array('font'=>'23')
			// 	)
			);

		load_controller('inti','builder','data_db',$data_db);

		if (!empty($n)) {
			$this->session->set_flashdata('ok','Aplikasi berhasil dipasang ...');
			redirect('inti/aplikasi');
		} else {
			die($odie);
		}
	}

	function scaff_db() {
		return array('prefix' => 'ids_');
	}
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Umum extends CI_Controller
{

	var $dir = 'siatika/umum';

	function __construct()
	{

		parent::__construct();
		login_check($this->session->userdata('login_state'));
	}

	public function index()
	{
	}

	function ke($tipe, $search = null, $offset = null)
	{

		$key = $this->input->post('search');

		$modex = "list_data";
		$search_param = null;
		$filter_param = null;
		if (!empty($key)) {
			$search_param = $key;
		} else if (!empty($search)) {
			$o = un_de($search);
			$modex = !empty($o['modex']) ? $o['modex'] : "list_data";
			$form_id = @$o['form_id'];
			$search_param = !empty($o['search']) ? $o['search'] : null;
			$filter_param = isset($o['filter_sc']) ? $o['filter_sc'] : null;
		}

		/* -- Info -- 
			
			Tombol
				1. Tambah
				2. Normal
			
			Form
				1. Input teks
				2. Dropdown
				3. Textarea
				
			*/


		switch ($tipe) {

			case "ktj":

				$com_ess = $this->general_model->combo_box(array('tabel' => 'ref_eselon', 'key' => 'id_eselon', 'val' => array('eselon')));

				$param = array(
					'inti' => 'ktj',
					'breadcrumb' => array($this->dir . '/ke/ktj/' => 'Kegiatan Tugas Jabatan'),
					'title' => 'Kegiatan Tugas Jabatan',
					'tabel' => array('ref_ktj k' => '', 'ref_eselon e' => array('e.id_eselon = k.id_eselon', 'left')),
					'tabel_save' => 'ref_ktj',
					'select' => 'k.*,e.eselon',
					'kolom' => array('Kode', 'Nama KTJ', 'Eselon', 'Bobot'),
					'kolom_tampil' => array('kode', 'nama_ktj', 'eselon', 'bobot'),
					'kolom_data' => array('kode', 'nama_ktj', 'id_eselon', 'bobot'),
					'order' => 'nama_ktj',
					'id' => 'id_ktj',
					'tombol' => array(array('1', 'Tambah KTJ')),
					'form' => array(
						array(2, TRUE, 'Eselon', 'id_eselon', $com_ess, null),
						array(1, FALSE, 'Kode', 'kode', 'input-small', null),
						array(3, TRUE, 'Nama KTJ', 'nama_ktj', 'input-xlarge'),
						array(1, FALSE, 'Bobot Pekerjaan', 'bobot', 'input-small', 'formatnumber')
					)

				);

				break;

			case "penetap":


				$param = array(

					'inti' => 'penetap',
					'title' => 'Pejabat Penetap',
					'tabel' => 'ref_penetap',
					'kolom' => array('Penetap'),
					'kolom_tampil' => array('penetap'),
					'kolom_data' => array('penetap'),
					'order' => 'penetap',
					'id' => 'id_penetap',
					'tombol' => array(array('1', 'Tambah Penetap')),
					'form' => array(
						array(1, TRUE, 'Nama Penetap', 'penetap', 'input-xlarge')
					)
				);

				break;

			case "penandatangan":

				//$combo_peg = $this->general_model->combo_box(array('tabel' => 'peg_pegawai','key' => 'id_pegawai','val' => array('nama')));

				$combo_peg = $this->general_model->combo_box(array(
					'tabel' =>	'view_pegawai p', 'key' => '',
					'view_jabatan j' => 'j.id_pegawai = p.id_pegawai',
					'key' => 'id_pegawai', 'val' => array('nip', 'nama')
				));
				$combo_atasan = $this->general_model->combo_box(array(
					'tabel' =>	'view_pegawai p', 'key' => '',
					'view_jabatan j' => 'j.id_pegawai = p.id_pegawai',
					'key' => 'id_pegawai', 'val' => array('nip', 'nama')
				));
				$param = array(

					'inti' => 'penandatangan',
					'title' => 'Penandatangan',
					'tabel' => array(
						'ref_penandatangan r' => '',
						'view_pegawai p' => 'p.id_pegawai = r.penandatangan',
						'view_pegawai pe' => array('pe.id_pegawai = r.pengatasnama', 'left')
					),
					'tabel_save' => 'ref_penandatangan',
					'kolom' => array('Penandatangan', 'Wakil'),
					'select' => 'r.id_penandatangan, CONCAT(p.nama," <br>NIP.",p.nip) as nama_penandatangan, CONCAT(pe.nama," <br>NIP.",pe.nip) as nama_pengatasnama',
					'kolom_tampil' => array('nama_penandatangan', 'nama_pengatasnama'),
					'kolom_data' => array('penandatangan', 'pengatasnama'),
					'order' => 'penandatangan',
					'id' => 'id_penandatangan',
					'tombol' => array(array('1', 'Tambah Penandatangan')),
					'form' => array(
						array(2, TRUE, 'Nama Penandatangan', 'penandatangan', $combo_peg, 'input-xlarge combo-box'),
						array(2, TRUE, 'Nama Pengatasnama', 'pengatasnama', $combo_atasan, 'input-xlarge combo-box')
					)

				);

				break;

			case "jenis_kelamin":

				$param = array(

					'inti' => 'jenis_kelamin',
					'title' => 'Jenis Kelamin',
					'tabel' => 'ref_jenis_kelamin',
					'kolom' => array('Jenis Kelamin'),
					'kolom_tampil' => array('jenis_kelamin'),
					'kolom_data' => array('jenis_kelamin'),
					'order' => 'jenis_kelamin',
					'id' => 'id_jeniskelamin',
					'tombol' => array(array('1', 'Tambah Jenis Kelamin')),
					'form' => array(
						array(3, TRUE, 'Jenis Kelamin', 'jenis_kelamin', 'input-xlarge')
					)
				);

				break;

			case "kompetensi":

				$param = array(

					'inti' => 'kompetensi',
					'title' => 'Ujian Kompetensi',
					'tabel' => 'ref_kompetensi',
					'kolom' => array('Kode', 'Ujian Kompetensi'),
					'kolom_tampil' => array('kode_ujian_kompetensi', 'ujian_kompetensi'),
					'kolom_data' => array('kode_ujian_kompetensi', 'ujian_kompetensi'),
					'order' => 'ujian_kompetensi',
					'id' => 'id_kompetensi',
					'tombol' => array(array('1', 'Tambah Ujian Kompetensi')),
					'form' => array(
						array(1, TRUE, 'Kode', 'kode_ujian_kompetensi', null),
						array(3, TRUE, 'Nama Ujian Kompetensi', 'ujian_kompetensi', null)
					)
				);

				break;

			case "golongan_darah":


				$param = array(

					'inti' => 'golongan_darah',
					'title' => 'Golongan Darah',
					'tabel' => 'ref_gol_darah',
					'kolom' => array('Golongan Darah'),
					'kolom_tampil' => array('gol_darah'),
					'kolom_data' => array('gol_darah'),
					'order' => 'gol_darah',
					'id' => 'id_gol_darah',
					'tombol' => array(array('1', 'Tambah Golongan Darah')),
					'form' => array(
						array(3, TRUE, 'Golongan Darah', 'gol_darah', 'input-xlarge')
					)
				);

				break;


			case "keluarga_status":


				$param = array(

					'inti' => 'keluarga_status',
					'title' => 'Status Keluarga',
					'tabel' => 'ref_status_keluarga',
					'kolom' => array('Status Keluarga'),
					'kolom_tampil' => array('statuskeluarga'),
					'kolom_data' => array('statuskeluarga'),
					'order' => 'statuskeluarga',
					'id' => 'id_statuskeluarga',
					'tombol' => array(array('1', 'Tambah Status Keluarga')),
					'form' => array(
						array(3, TRUE, 'Status Keluarga', 'statuskeluarga', 'input-xlarge')
					)
				);

				break;


			case "status_anak":

				$param = array(

					'inti' => 'status_anak',
					'title' => 'Status Anak',
					'tabel' => 'ref_status_anak',
					'kolom' => array('Status Anak'),
					'kolom_tampil' => array('status_anak'),
					'kolom_data' => array('status_anak'),
					'order' => 'status_anak',
					'id' => 'id_statusanak',
					'tombol' => array(array('1', 'Tambah Status Anak')),
					'form' => array(
						array(3, TRUE, 'Status Anak', 'status_anak', 'input-xlarge')
					)
				);

				break;

			case "pekerjaan":

				$param = array(

					'inti' => 'pekerjaan',
					'title' => 'Pekerjaan',
					'tabel' => 'ref_pekerjaan',
					'kolom' => array('Kode', 'Pekerjaan'),
					'kolom_tampil' => array('kode_pekerjaan', 'pekerjaan'),
					'kolom_data' => array('kode_pekerjaan', 'pekerjaan'),
					'order' => 'kode_pekerjaan',
					'id' => 'id_pekerjaan',
					'tombol' => array(array('1', 'Tambah Pekerjaan')),
					'form' => array(
						array(1, FALSE, 'Kode Pekerjaan', 'kode_pekerjaan', 'input-xlarge'),
						array(3, TRUE, 'Pekerjaan', 'pekerjaan', 'input-xlarge')
					)
				);

				break;


			case "keluarga":


				$param = array(

					'inti' => 'keluarga',
					'title' => 'Keluarga',
					'tabel' => 'ref_keluarga',
					'kolom' => array('Kode', 'Keluarga'),
					'kolom_tampil' => array('kode_keluarga', 'keluarga'),
					'kolom_data' => array('kode_keluarga', 'keluarga'),
					'order' => 'kode_keluarga',
					'id' => 'id_keluarga',
					'tombol' => array(array('1', 'Tambah Keluarga')),
					'form' => array(
						array(1, FALSE, 'Kode Keluarga', 'kode_keluarga', 'input-xlarge'),
						array(3, TRUE, 'Keluarga', 'keluarga', 'input-xlarge')
					)
				);

				break;

			case "kawin_status":

				$param = array(

					'inti' => 'kawin_status',
					'title' => 'Status Kawin',
					'tabel' => 'ref_status_kawin',
					'kolom' => array('Status Kawin'),
					'kolom_tampil' => array('statuskawin'),
					'kolom_data' => array('statuskawin'),
					'order' => 'statuskawin',
					'id' => 'id_statuskawin',
					'tombol' => array(array('1', 'Tambah Status Kawin')),
					'form' => array(
						array(3, TRUE, 'Status Kawin', 'statuskawin', 'input-xlarge')
					)
				);

				break;

			case "agama":


				$param = array(

					'inti' => 'agama',
					'title' => 'Agama',
					'tabel' => 'ref_agama',
					'kolom' => array('Agama'),
					'kolom_tampil' => array('agama'),
					'kolom_data' => array('agama'),
					'order' => 'agama',
					'id' => 'id_agama',
					'tombol' => array(array('1', 'Tambah Agama')),
					'form' => array(
						array(3, TRUE, 'Agama', 'agama', 'input-xlarge')
					)
				);

				break;

			case "gelar":


				$param = array(

					'inti' => 'gelar',
					'title' => 'Gelar',
					'tabel' => 'ref_gelar',
					'kolom' => array('Gelar'),
					'kolom_tampil' => array('gelar'),
					'kolom_data' => array('gelar'),
					'order' => 'gelar',
					'id' => 'id_gelar',
					'tombol' => array(array('1', 'Tambah Gelar')),
					'form' => array(
						array(3, TRUE, 'Gelar', 'gelar', 'input-xlarge')
					)
				);

				break;

			case "propinsi":

				$param = array(
					'inti' => 'propinsi',
					'title' => 'Propinsi',
					'tabel' => 'ref_propinsi',
					'kolom' => array('Kode', 'Propinsi', 'Ibukota'),
					'kolom_tampil' => array('kode_propinsi', 'propinsi', 'ibukota'),
					'kolom_data' => array('kode_propinsi', 'propinsi', 'ibukota'),
					'order' => 'kode_propinsi',
					'id' => 'id_propinsi',
					'tombol' => array(array('1', 'Tambah Propinsi')),
					'form' => array(
						array(1, FALSE, 'Kode Propinsi', 'kode_propinsi', 'input-xlarge'),
						array(3, TRUE, 'Propinsi', 'propinsi', 'input-xlarge'),
						array(1, FALSE, 'Ibukota', 'ibukota', '')
					)
				);

				break;

			case "kabupaten":

				$combo_prop = $this->general_model->combo_box(array('tabel' => 'ref_propinsi', 'key' => 'id_propinsi', 'val' => array('propinsi')));
				$param = array(

					'inti' => 'kabupaten',
					'title' => 'Kabupaten',
					'tabel' => array(
						'ref_kabupaten j' => '',
						'ref_propinsi e' => 'e.id_propinsi = j.id_propinsi'
					),
					'tabel_save' => 'ref_kabupaten',
					'select' => 'j.kode_kabupaten,IF(j.jenis = "1","Kabupaten","Kota") jenis,j.kabupaten,e.propinsi,j.luas,j.id_kabupaten',
					'kolom' => array('Kode', 'Jenis', 'Kabupaten', 'Propinsi', 'Luas Wilayah'),
					'kolom_tampil' => array('kode_kabupaten', 'jenis', 'kabupaten', 'propinsi', 'luas'),
					'kolom_data' => array('id_propinsi', 'kode_kabupaten', 'jenis', 'kabupaten', 'luas'),
					'kolom_cari' => array('kode_kabupaten', 'jenis', 'kabupaten', 'luas'),
					'order' => 'e.id_propinsi',
					'id' => 'id_kabupaten',
					'tombol' => array(array('1', 'Tambah Kabupaten')),
					'form' => array(
						array(2, TRUE, 'Propinsi', 'id_propinsi', $combo_prop, 'input-xlarge combo-box'),
						array(2, TRUE, 'Jenis', 'jenis', array('1' => 'Kabupaten', '2' => 'Kota'), 'input-xlarge combo-box'),
						array(1, FALSE, 'Kode Kabupaten', 'kode_kabupaten', 'input-xlarge'),
						array(3, TRUE, 'Kabupaten', 'kabupaten', 'input-xlarge'),
						array(1, FALSE, 'Luas Wilayah', 'luas', 'input-small')
					)
				);

				break;


			case "kecamatan":


				$combo_kab = $this->general_model->combo_box(array('tabel' => 'ref_kabupaten', 'key' => 'id_kabupaten', 'val' => array('kabupaten')));

				$param = array(

					'inti' => 'kecamatan',
					'title' => 'Kecamatan',
					'tabel' => array(
						'ref_kecamatan j' => '',
						'ref_kabupaten e' => 'e.id_kabupaten = j.id_kabupaten',
						'ref_propinsi p' => 'p.id_propinsi = e.id_propinsi'
					),
					'tabel_save' => 'ref_kecamatan',
					'select' => 'j.*,IF(e.jenis = "1",CONCAT("Kabupaten ",e.kabupaten),CONCAT("Kota ",e.kabupaten)) kabupaten,p.propinsi',
					'kolom' => array('Kode', 'Kecamatan', 'Kabupaten', 'Propinsi'),
					'kolom_tampil' => array('kode_kecamatan', 'kecamatan', 'kabupaten', 'propinsi'),
					'kolom_cari' => array('kode_kecamatan', 'kecamatan'),
					'kolom_data' => array('id_kabupaten', 'kode_kecamatan', 'kecamatan'),
					'order' => 'p.propinsi, e.kabupaten',
					'id' => 'id_kecamatan',
					'tombol' => array(array('1', 'Tambah Kecamatan')),
					'form' => array(
						array(2, TRUE, 'Kabupaten', 'id_kabupaten', $combo_kab, 'input-xlarge combo-box'),
						array(1, FALSE, 'Kode Kecamatan', 'kode_kecamatan', 'input-xlarge'),
						array(3, TRUE, 'Kecamatan', 'kecamatan', 'input-xlarge')
					)
				);

				break;

			case "kelurahan":

				$combo_kec = $this->general_model->combo_box(array('tabel' => 'ref_kecamatan', 'key' => 'id_kecamatan', 'val' => array('kecamatan')));

				$param = array(

					'inti' => 'kelurahan',
					'title' => 'Kelurahan/Desa/Kampung',
					'tabel' => array(
						'ref_kelurahan j' => '',
						'ref_kecamatan e' => 'e.id_kecamatan = j.id_kecamatan'
					),
					'tabel_save' => 'ref_kelurahan',
					'select' => 'j.*,IF(j.jenis = "1",CONCAT("Kelurahan ",j.kelurahan),(IF(j.jenis = "2",CONCAT("Desa ",j.kelurahan),CONCAT("Kampung ",j.kelurahan)))) jenise,e.kecamatan',
					'kolom' => array('Kode', 'Kelurahan/Desa/Kampung', 'Kecamatan', 'Kodepos'),
					'kolom_tampil' => array('kode_kelurahan', 'jenise', 'kecamatan', 'kodepos'),
					'kolom_data' => array('id_kecamatan', 'kode_kelurahan', 'jenis', 'kelurahan', 'kodepos'),
					'kolom_cari' => array('kode_kelurahan', 'kelurahan', 'kodepos'),
					'duplikat' => array('kelurahan', 'jenis'),
					'order' => 'e.kecamatan',
					'id' => 'id_kelurahan',
					'tombol' => array(array('1', 'Tambah Kelurahan/Desa/Kampung')),
					'form' => array(
						array(2, TRUE, 'Kecamatan', 'id_kecamatan', $combo_kec, 'input-xlarge combo-box'),
						array(1, FALSE, 'Kode', 'kode_kelurahan', 'input-xlarge'),
						array(3, TRUE, 'Nama Kelurahan/Desa/Kampung', 'kelurahan', 'input-xlarge'),
						array(2, TRUE, 'Jenis', 'jenis', array('1' => 'Kelurahan', '2' => 'Desa', '3' => 'Kampung'), null)
					)
				);

				break;

				// -- Otsus Papua -- //

			case "suku":

				$param = array(

					'inti' => 'suku',
					'title' => 'Suku',
					'tabel' => 'ref_suku',
					'kolom' => array('Kode', 'Suku'),
					'kolom_tampil' => array('kode_suku', 'suku'),
					'kolom_data' => array('kode_suku', 'suku'),
					'excel_impor' => array('kode_suku', 'suku'),
					'order' => 'suku',
					'id' => 'id_suku',
					'tombol' => array(array('1', 'Tambah Suku')),
					'form' => array(
						array(1, FALSE, 'Kode Suku', 'kode_suku', 'input-xlarge'),
						array(3, TRUE, 'Suku', 'suku', 'input-xlarge')
					)
				);

				break;

			case "wilayah_adat":

				$param = array(

					'inti' => 'wilayah_adat',
					'title' => 'Wilayah Adat',
					'tabel' => 'ref_wilayah_adat',
					'kolom' => array('Wilayah Adat', 'Letak Geografis'),
					'kolom_tampil' => array('wilayah_adat', 'letak_geografis'),
					'kolom_data' => array('wilayah_adat', 'letak_geografis'),
					'excel_impor' => array('wilayah_adat', 'letak_geografis'),
					'order' => 'wilayah_adat',
					'id' => 'id_wilayah_adat',
					'tombol' => array(array('1', 'Wilayah Adat')),
					'form' => array(
						array(1, FALSE, 'Wilayah Adat', 'wilayah_adat', null),
						array(3, TRUE, 'Letak Geografis', 'letak_geografis', null)
					)
				);

				break;

			case "pemerintah_adat":

				$cb_wildat = $this->general_model->combo_box(array('tabel' => 'ref_wilayah_adat', 'key' => 'id_wilayah_adat', 'val' => array('wilayah_adat')));

				$param = array(

					'inti' => 'pemerintah_adat',
					'title' => 'Pemerintah Adat',
					'tabel' => array(
						'ref_pemerintah_adat a' => '',
						'ref_wilayah_adat wa' => array('a.id_wilayah_adat = wa.id_wilayah_adat', 'left')
					),
					'select' => 'a.*,wa.wilayah_adat',
					'tabel_save' => 'ref_pemerintah_adat',
					'kolom' => array('Wilayah Adat', 'Pemerintah Adat'),
					'kolom_tampil' => array('wilayah_adat', 'pemerintah_adat'),
					'kolom_data' => array('id_wilayah_adat', 'pemerintah_adat'),
					'excel_impor' => array(
						array('tabel' => 'ref_wilayah_adat', 'kolom' => 'wilayah_adat', 'id_kolom' => 'id_wilayah_adat'),
						'pemerintah_adat'
					),
					'order' => 'pemerintah_adat',
					'id' => 'id_pemerintah_adat',
					'tombol' => array(array('1', 'Pemerintah Adat')),
					'form' => array(
						array(2, TRUE, 'Wilayah Adat', 'id_wilayah_adat', $cb_wildat, null),
						array(1, FALSE, 'Pemerintah Adat', 'pemerintah_adat', null)
					)
				);

				break;

				// -- Otsus Papua -- //

			case "kementerian":

				$param = array(

					'inti' => 'kementerian',
					'title' => 'Kementerian',
					'tabel' => 'ref_kementerian',
					'kolom' => array('Kode', 'Kementerian', 'Singkatan'),
					'kolom_tampil' => array('kode_kementerian', 'kementerian', 'singkatan'),
					'kolom_data' => array('kode_kementerian', 'kementerian', 'singkatan'),
					'order' => 'kode_kementerian',
					'id' => 'id_kementerian',
					'tombol' => array(array('1', 'Tambah Kementerian')),
					'form' => array(
						array(1, FALSE, 'Kode Kementerian', 'kode_kementerian', 'input-xlarge'),
						array(3, TRUE, 'Kementerian', 'kementerian', 'input-xlarge'),
						array(1, FALSE, 'Singkatan', 'singkatan', null)
					)
				);

				break;

			case "unit":

				$combo_peg = $this->general_model->combo_box(array('tabel' => 'peg_pegawai', 'key' => 'id_pegawai', 'val' => array('nama')));

				$param = array(

					'inti' => 'unit',
					'title' => 'Unit',
					'tabel' => array(
						'ref_unit j' => '',
						'view_pegawai e' => array('e.id_pegawai = j.id_kepala', 'left')
					),
					'tabel_save' => 'ref_unit',
					'kolom' => array('Kode', 'Unit', 'Kepala'),
					'select' => 'e.nama_pegawai,id_unit,kode_unit,unit',
					'kolom_tampil' => array('kode_unit', 'unit', 'nama_pegawai'),
					'kolom_data' => array('id_kepala', 'kode_unit', 'unit'),
					'order' => 'id_unit',
					'id' => 'id_unit',
					'tombol' => array(array('1', 'Tambah Unit')),
					'form' => array(
						array(2, TRUE, 'Kepala', 'id_kepala', $combo_peg, 'input-xlarge combo-box'),
						array(1, FALSE, 'Kode Unit', 'kode_unit', 'input-xlarge'),
						array(3, TRUE, 'Unit', 'unit', 'input-xlarge')
					)
				);

				break;

			case "akreditasi":

				$param = array(
					'inti' => 'akreditasi',
					'title' => 'Akreditasi',
					'tabel' => 'ref_akreditasi',
					'kolom' => array('Akreditasi'),
					'kolom_tampil' => array('akreditasi'),
					'kolom_data' => array('id_akreditasi', 'akreditasi'),
					'order' => 'akreditasi',
					'id' => 'id_akreditasi',
					'tombol' => array(array('1', 'Tambah Akreditasi')),
					'form' => array(
						array(1, TRUE, 'Akreditasi', 'akreditasi', '')
					)
				);

				break;

			case "sertifikasi":

				$param = array(
					'inti' => 'sertifikasi',
					'title' => 'Sertifikasi',
					'tabel' => 'ref_sertifikasi',
					'kolom' => array('Akreditasi', 'Keterangan'),
					'kolom_tampil' => array('sertifikasi', 'keterangan'),
					'kolom_data' => array('id_sertifikasi', 'sertifikasi', 'keterangan'),
					'order' => 'sertifikasi',
					'id' => 'id_sertifikasi',
					'tombol' => array(array('1', 'Tambah Akreditasi')),
					'form' => array(
						array(1, TRUE, 'Akreditasi', 'sertifikasi', ''),
						array(3, FALSE, 'Keterangan', 'keterangan', '')
					)
				);

				break;

			case "studi_lembaga":

				$param = array(

					'inti' => 'studi_lembaga',
					'title' => 'Studi Lembaga',
					'tabel' => 'ref_lembaga',
					'kolom' => array('Kode', 'lembaga'),
					'kolom_tampil' => array('kode_lembaga', 'lembaga_pendidikan'),
					'kolom_data' => array('kode_lembaga', 'lembaga_pendidikan'),
					'order' => 'kode_lembaga',
					'id' => 'id_lembaga',
					'tombol' => array(array('1', 'Tambah Lembaga')),
					'form' => array(
						array(1, FALSE, 'Kode Lembaga', 'kode_lembaga', 'input-xlarge'),
						array(3, TRUE, 'Lembaga', 'lembaga_pendidikan', 'input-xlarge')
					)
				);

				break;

			case "fakultas":

				$param = array(

					'inti' => 'fakultas',
					'title' => 'Fakultas',
					'tabel' => 'ref_fakultas',
					'kolom' => array('Kode', 'fakultas'),
					'kolom_tampil' => array('kode_fakultas', 'fakultas'),
					'kolom_data' => array('kode_fakultas', 'fakultas'),
					'order' => 'kode_fakultas',
					'id' => 'id_fakultas',
					'tombol' => array(array('1', 'Tambah Fakultas')),
					'form' => array(
						array(1, FALSE, 'Kode Fakultas', 'kode_fakultas', 'input-xlarge'),
						array(3, TRUE, 'Fakultas', 'fakultas', 'input-xlarge')
					)
				);

				break;

			case "prodi":

				$param = array(

					'inti' => 'prodi',
					'title' => 'Program Studi',
					'tabel' => 'ref_prodi',
					'kolom' => array('Kode', 'Nama Program Studi'),
					'kolom_tampil' => array('kode_prodi', 'prodi'),
					'kolom_data' => array('kode_prodi', 'prodi'),
					'order' => 'prodi',
					'id' => 'id_prodi',
					'tombol' => array(array('1', 'Tambah Program Studi')),
					'form' => array(
						array(1, FALSE, 'Kode Prodi', 'kode_prodi', null),
						array(3, TRUE, 'Nama Prodi', 'prodi', null)
					)
				);

				break;

			case "jurusan":

				$param = array(

					'inti' => 'jurusan',
					'title' => 'Jurusan',
					'tabel' => 'ref_jurusan',
					'kolom' => array('Kode', 'jurusan'),
					'kolom_tampil' => array('kode_jurusan', 'jurusan'),
					'kolom_data' => array('kode_jurusan', 'jurusan'),
					'order' => 'kode_jurusan',
					'id' => 'id_jurusan',
					'tombol' => array(array('1', 'Tambah Jurusan')),
					'form' => array(
						array(1, FALSE, 'Kode Jurusan', 'kode_jurusan', 'input-xlarge'),
						array(3, TRUE, 'Jurusan', 'jurusan', 'input-xlarge')
					)
				);

				break;

			case "studi_jenjang":

				$param = array(

					'inti' => 'studi_jenjang',
					'title' => 'Jenjang',
					'tabel' => 'ref_jenjang',
					'kolom' => array('Kode', 'Jenjang', 'Singkatan'),
					'kolom_tampil' => array('kode_jenjang', 'jenjang', 'singkatan_jenjang'),
					'kolom_data' => array('kode_jenjang', 'jenjang', 'singkatan_jenjang'),
					'order' => 'kode_jenjang',
					'id' => 'id_jenjang',
					'tombol' => array(array('1', 'Tambah Jenjang')),
					'form' => array(
						array(1, FALSE, 'Kode Jenjang', 'kode_jenjang', 'input-xlarge'),
						array(3, TRUE, 'Jenjang', 'jenjang', 'input-xlarge'),
						array(1, TRUE, 'Singkatan', 'singkatan_jenjang', '')
					)
				);

				break;

			case "studi_bentuk":

				$combo_jen = $this->general_model->combo_box(array('tabel' => 'ref_jenjang', 'key' => 'id_jenjang', 'val' => array('jenjang')));
				$combo_kem = $this->general_model->combo_box(array('tabel' => 'ref_kementerian', 'key' => 'id_kementerian', 'val' => array('kementerian')));

				$param = array(

					'inti' => 'studi_bentuk',
					'title' => 'Studi Bentuk',
					'tabel' => array(
						'ref_bentuk_pendidikan j' => '',
						'ref_jenjang e' => array('e.id_jenjang = j.id_jenjang', 'left'),
						'ref_kementerian f' => array('f.id_kementerian = j.id_kementerian', 'left')
					),
					'select' => 'j.*,e.jenjang,e.singkatan_jenjang,f.kementerian',
					'tabel_save' => 'ref_bentuk_pendidikan',
					'kolom' => array('Kode', 'Bentuk Pendidikan', 'Singkatan', 'Jenjang', 'Kementerian'),
					'kolom_tampil' => array('kode_bentuk_pendidikan', 'bentuk_pendidikan', 'singkatan_pendidikan', 'jenjang', 'kementerian'),
					'kolom_data' => array('kode_bentuk_pendidikan', 'bentuk_pendidikan', 'singkatan_pendidikan', 'id_jenjang', 'id_kementerian'),
					'kolom_cari' => array('kode_bentuk_pendidikan', 'bentuk_pendidikan', 'singkatan_pendidikan'),
					'order' => 'e.id_jenjang',
					'id' => 'id_bentuk_pendidikan',
					'tombol' => array(array('1', 'Tambah Bentuk pendidikan')),
					'form' => array(
						array(2, FALSE, 'Jenjang', 'id_jenjang', $combo_jen, 'input-xlarge combo-box'),
						array(2, FALSE, 'Kementerian', 'id_kementerian', $combo_kem, 'input-xlarge combo-box'),
						array(1, FALSE, 'Kode Bentuk Pendidikan', 'kode_bentuk_pendidikan', 'input-xlarge'),
						array(1, TRUE, 'Singkatan', 'singkatan_pendidikan', 'input-xlarge'),
						array(3, TRUE, 'Bentuk Pendidikan', 'bentuk_pendidikan', 'input-xlarge')
					)

				);

				break;

			case "status_pegawai":

				//$status_usul = array('0' => 'Reguler','1' => 'Penilaian Langsung','2' => 'Penilaian Berhenti','3' => 'Pensiun');
				//IF(status_usul=0,"Reguler",IF(status_usul=1,"Penilaian Langsung",IF(status_usul=2,"Penilaian Berhenti","Pensiun"))) as status_usul,

				$tipe_peg = array('1' => 'Tampil', '2' => 'Tersembunyi');

				$param = array(
					'inti' => 'status_pegawai',
					'title' => 'Status Pegawai',
					'tabel' => 'ref_status_pegawai',
					'kolom' => array('Deskripsi', 'Tampil Pegawai'),

					'select' => 'tipe,id_status_pegawai,
						IF(tipe="1","Tampil","Tersembunyi") as tipe_tampil,
						nama_status',

					'kolom_tampil' => array('nama_status', 'tipe_tampil'), //,'status_usul'
					'kolom_data' => array('nama_status', 'tipe', 'keterangan'), //'status_usul',
					'order' => 'tipe asc, urut',
					'id' => 'id_status_pegawai',
					'tombol' => array(array('1', 'Tambah Status Pegawai')),
					'form' => array(
						array(2, TRUE, 'Tipe', 'tipe', $tipe_peg, 'input-xlarge combo-box'),
						array(3, TRUE, 'Nama Status', 'nama_status', 'input-xlarge'),
						//array(2,TRUE,'Tipe','status_usul',$status_usul,'input-xlarge combo-box'),
						array(3, FALSE, 'Keterangan', 'keterangan', 'input-xlarge')
					)
				);

				break;

			case "pangkat":

				$param = array(

					'inti' => 'pangkat',
					'title' => 'Pangkat',
					'tabel' => 'ref_golru',
					'kolom' => array('Golongan', 'Pangkat'),
					'kolom_tampil' => array('golongan', 'pangkat'),
					'kolom_data' => array('golongan', 'pangkat'),
					'order' => 'urut',
					'urut' => 'urut',
					'id' => 'id_golru',
					'tombol' => array(array('1', 'Tambah Golru/Pangkat')),
					'form' => array(
						array(1, TRUE, 'Pangkat', 'pangkat', 'input-xlarge'),
						array(3, TRUE, 'Golongan', 'golongan', 'input-xlarge')
					)
				);

				break;


			case "pangkat_jenis":

				$param = array(

					'inti' => 'pangkat_jenis',
					'title' => 'Jenis Kenaikkan Pangkat',
					'tabel' => 'ref_golru_jenis',
					'kolom' => array('Kode', 'Deskripsi'),
					'kolom_tampil' => array('kode', 'golru_jenis'),
					'kolom_data' => array('kode', 'golru_jenis'),
					'order' => 'kode',
					'id' => 'id_golru_jenis',
					'tombol' => array(array('1', 'Tambah JKP')),
					'form' => array(
						array(1, FALSE, 'Kode JKP', 'kode', 'input-xlarge'),
						array(3, TRUE, 'Nama JKP', 'golru_jenis', 'input-xlarge')
					)
				);

				break;

			case "kelas_jabatan":

				$param = array(

					'inti' => 'kelas_jabatan',
					'title' => 'Kelas Jabatan',
					'tabel' => 'ref_kelas_jabatan',
					'kolom' => array('Kelas Jabatan'),
					'kolom_tampil' => array('kelas_jabatan'),
					'kolom_data' => array('kelas_jabatan'),
					'order' => 'kelas_jabatan',
					'id' => 'id_kelas_jabatan',
					// 'urut' => 'jenis_jabatan',
					'tombol' => array(array('1', 'Tambah Kelas Jabatan')),
					'form' => array(
						array(1, TRUE, 'Nama Kelas Jebatan', 'kelas_jabatan', 'input-xlarge')
					)
				);

				break;

			case "jabatan":

				$where_unit = (!empty($o['form_id']) ? null : array('aktif' => 1));
				$cb_unit = $this->general_model->combo_box(array(
					'tabel' => 'ref_unit', 'key' => 'id_unit', 'val' => array('unit'),
					'select' => 'id_unit,CONCAT(unit,IF(aktif = 2," (Non Aktif)","")) unit',
					'where' => $where_unit
				));


				if (!empty($o['form_id'])) {

					$de = $this->general_model->datagrab(array(
						'tabel' => array(
							'ref_jabatan j' => '',
							'ref_bidang b' => 'b.id_bidang = j.id_bidang'
						),
						'where' => array('j.id_jabatan' => $o['form_id']),
						'select' => 'b.id_unit'
					))->row();

					$where_unit = (isset($def->id_unit)) ? array('id_unit' => $de->id_unit) : null;

					$cb_bidang = $this->general_model->combo_box(array(
						'tabel' => 'ref_bidang', 'key' => 'id_bidang',
						'select' => 'id_bidang,CONCAT(nama_bidang,IF(aktif = 2," (Non Aktif)","")) nama_bidang',
						'val' => array('nama_bidang')
					));
				}

				$combo_jab = $this->general_model->combo_box(array('tabel' => 'ref_jabatan_jenis', 'key' => 'id_jab_jenis', 'val' => array('jenis_jabatan')));
				$combo_ese = $this->general_model->combo_box(array('tabel' => 'ref_eselon', 'key' => 'id_eselon', 'val' => array('eselon')));
				$combo_status = array('1' => 'Jabatan, Bidang, Unit Kerja', '2' => 'Jabatan, Unit Kerja');
				$param = array(
					'inti' => 'jabatan',
					'title' => 'Jabatan',
					'filter' => array(
						'id_unit' => array('ref_unit', 'u.id_unit', 'unit', ' -- Filter Unit Kerja --', array('url' => $this->dir . '/ajax_bidang', 'class' => 'cb_bidang', 'dom' => 'set_bidang', 'set' => 'onchange="set_bidang(this.value)"')),
						'id_bidang' => array('ajax', 'b.id_bidang', 'nama_bidang', ' -- Filter Unit Organisasi --', 'cb_bidang', 'ref_bidang')
					),
					'tabel' => array(
						'ref_jabatan j' => '',
						'ref_jabatan_jenis e' => array('e.id_jab_jenis = j.id_jab_jenis', 'left'),
						'ref_eselon f' => array('f.id_eselon = j.id_eselon', 'left'),
						'ref_bidang b' => array('b.id_bidang = j.id_bidang', 'left'),
						'ref_unit u' => array('u.id_unit = b.id_unit', 'left')
					),
					'tabel_save' => 'ref_jabatan',
					'kolom' => array('Jabatan', 'Eselon', 'Jenis', 'BUP', 'Unit Organisasi', 'Unit/SKPD'),

					'select' => 'jenis_jabatan,j.id_jab_jenis,id_jabatan,f.id_eselon,eselon,bup,
						nama_jabatan,b.id_bidang,b.nama_bidang,u.id_unit,u.unit',

					'kolom_tampil' => array('nama_jabatan', 'eselon', 'jenis_jabatan', 'bup', 'nama_bidang', 'unit'),
					'kolom_cari' => array('jenis_jabatan', 'nama_jabatan', 'unit', 'nama_bidang'),
					'kolom_data' => array('jenis_jabatan', 'id_jab_jenis', 'id_eselon', 'nama_jabatan', 'bup', 'id_bidang', 'stat_jab'),
					// 'where' => array('u.id_unit' => $this->session->userdata('id_unit')),
					'order' => 'f.urut,ISNULL(f.id_eselon) asc, f.id_eselon asc,ISNULL(b.id_bidang), b.id_bidang',
					'id' => 'id_jabatan',
					'tombol' => array(array('1', 'Tambah Jabatan')),
					'form' => array(
						array(2, TRUE, 'Nama Jenis Jabatan', 'id_jab_jenis', $combo_jab, 'input-xlarge combo-box'),
						array(2, TRUE, 'Eselon', 'id_eselon', $combo_ese, 'input-xlarge combo-box'),
						array(1, TRUE, 'Nama Jabatan', 'nama_jabatan', 'input-xlarge'),
						array(1, TRUE, 'BUP', 'bup', 'col-xs-6'),
						array(2, TRUE, 'Unit Kerja', 'id_unit', $cb_unit, 'input-large combo-box', 'id="id_unit"'),
						array(2, TRUE, 'Unit Organisasi', 'id_bidang', !empty($cb_bidang) ? $cb_bidang : array('' => ' -- Pilih --'), 'input-large combo-box', 'id="id_bidang"'),
						array(2, TRUE, 'Status Jabatan', 'stat_jab', array(1 => 'Tampil'), null)
					)
				);
				$param['form_script'] = "
					
						$('#id_unit').change(function(){
							$.ajax({
								type 	: 'GET', 
								url  	: '" . site_url('siatika/Umum/combo_unit/') . "/'+$(this).val(),
								success	: function(data){
									$('#id_bidang').html(data);
								}
							});
						}); ";

				break;


			case "jabatan_jenis":

				$param = array(

					'inti' => 'jabatan_jenis',
					'title' => 'Jenis Jabatan',
					'tabel' => 'ref_jabatan_jenis',
					'kolom' => array('Deskripsi'),
					'kolom_tampil' => array('jenis_jabatan'),
					'kolom_data' => array('jenis_jabatan'),
					'order' => 'jenis_jabatan',
					'id' => 'id_jab_jenis',
					'tombol' => array(array('1', 'Tambah Jenis Jabatan')),
					'form' => array(
						array(1, TRUE, 'Nama Jenis Jabatan', 'jenis_jabatan', 'input-xlarge')
					)
				);
				// cek($param);
				break;


			case "eselon":

				$param = array(

					'inti' => 'eselon',
					'title' => 'Eselon',
					'tabel' => 'ref_eselon',
					'kolom' => array('Eselon'),
					'kolom_tampil' => array('eselon'),
					'kolom_data' => array('eselon'),
					'order' => 'urut',
					'id' => 'id_eselon',
					'urut' => 'urut',
					'tombol' => array(array('1', 'Tambah Eselon')),
					'form' => array(
						array(1, TRUE, 'Nama Eselon', 'eselon', 'input-xlarge'),
					)
				);

				break;

			case "verifikasi":

				$param = array(

					'inti' => 'verifikasi',
					'title' => 'Verifikasi',
					'tabel' => 'ref_verifikasi',
					'kolom' => array('Nama', 'Jabatan', 'Urut'),
					'kolom_tampil' => array('nama', 'jabatan', 'urut'),
					'kolom_data' => array('nama', 'jabatan', 'urut'),
					'order' => 'urut',
					'id' => 'id_verifikasi',
					'urut' => 'urut',
					'tombol' => array(array('1', 'Tambah Verifikasi')),
					'form' => array(
						array(1, TRUE, 'Nama Pegawai', 'eselon', 'input-xlarge'),
						array(1, TRUE, 'Jabatan', 'eselon', 'input-xlarge'),
						array(1, TRUE, 'Urut', 'eselon', 'input-xlarge'),
					)
				);

				break;

			case "cuti":

				$combo_tahunan = array('1' => 'Tidak', '2' => 'Tahunan');
				$param = array(

					'inti' => 'cuti',
					'title' => 'Cuti',
					'tabel' => 'ref_cuti',
					'kolom' => array('Cuti', 'Tipe'),
					'select' => 'cuti,id_cuti,
						IF(status_cuti="1","Tidak","Tahunan") as status_cuti_tampil,
						',


					'kolom_tampil' => array('cuti', 'status_cuti_tampil'),
					'kolom_data' => array('cuti', 'status_cuti'),
					'order' => 'cuti',
					'id' => 'id_cuti',
					'tombol' => array(array('1', 'Tambah Cuti')),
					'form' => array(
						array(1, TRUE, 'Nama Cuti', 'cuti', 'input-xlarge'),
						array(2, TRUE, 'Tahunan', 'status_cuti', $combo_tahunan, 'input-xlarge combo-box')
					)
				);

				break;


			case "gaji":

				$combo_gol = $this->general_model->combo_box(array('tabel' => 'ref_golru', 'key' => 'id_golru', 'val' => array('golongan')));

				$param = array(

					'inti' => 'gaji',
					'title' => 'Gaji',
					'tabel' => array(
						'ref_gaji j' => '',
						'ref_golru e' => 'e.id_golru = j.id_golru'
					),
					'tabel_save' => 'ref_gaji',
					'kolom' => array('Golongan', 'MKG', 'Gaji', 'Tahunan'),
					'kolom_tampil' => array('golongan', 'mkg', 'gaji', 'tahun'),
					'kolom_data' => array('id_golru', 'mkg', 'gaji', 'tahun'),
					'kolom_cari' => array('e.golongan', 'e.pangkat', 'j.mkg', 'j.tahun', 'j.gaji'),
					'order' => 'e.id_golru',
					'id' => 'id_gaji',
					'tombol' => array(array('1', 'Tambah Gaji')),
					'form' => array(
						array(2, TRUE, 'Nama Jenis Golongan', 'id_golru', $combo_gol, 'input-xlarge combo-box'),
						array(1, TRUE, 'MKG', 'mkg', 'input-xlarge'),
						array(1, TRUE, 'Gaji', 'gaji', 'input-xlarge', 'formatnumber'),
						array(1, TRUE, 'Tahun', 'tahun', 'input-small')
					)
				);

				break;

			case "penghargaan":

				$combo_berkala = array('1' => 'Tidak', '2' => 'Ya');
				$param = array(

					'inti' => 'penghargaan',
					'title' => 'Penghargaan',
					'tabel' => 'ref_penghargaan',
					'kolom' => array('penghargaan', 'Berkala'),
					'select' => 'penghargaan,id_penghargaan,
						IF(berkala="1","Tidak","Ya") as berkala_tampil,
						',

					'kolom_tampil' => array('penghargaan', 'berkala_tampil'),
					'kolom_data' => array('penghargaan', 'berkala'),
					'order' => 'penghargaan',
					'id' => 'id_penghargaan',
					'tombol' => array(array('1', 'Tambah Penghargaan')),
					'form' => array(
						array(1, TRUE, 'Nama Penghargaan', 'penghargaan', 'input-xlarge'),
						array(2, FALSE, 'Berkala', 'berkala', $combo_berkala, 'input-xlarge combo-box')
					)
				);

				break;

			case "diklatpim":

				$combo_berkala = array('1' => 'Tidak', '2' => 'Ya');
				$param = array(

					'inti' => 'diklatpim',
					'title' => 'Diklatpim',
					'tabel' => 'ref_diklatpim',
					'kolom' => array('Diklatpim'),
					'kolom_tampil' => array('diklatpim'),
					'kolom_data' => array('diklatpim'),
					'order' => 'diklatpim',
					'id' => 'id_diklatpim',
					'tombol' => array(array('1', 'Tambah Diklatpim')),
					'form' => array(
						array(1, TRUE, 'Nama Diklatpim', 'diklatpim', 'input-xlarge')
					)
				);

				break;


			case "diklatteknis":

				$param = array(

					'inti' => 'diklatteknis',
					'title' => 'Diklat Teknis & Fungsional',
					'tabel' => 'ref_diklatteknis',
					'kolom' => array('Kode', 'Jenis Diklat'),
					'kolom_tampil' => array('kode_diklat', 'nama_diklat'),
					'kolom_data' => array('kode_diklat', 'nama_diklat'),
					'order' => 'kode_diklat',
					'id' => 'id_diklatteknis',
					'tombol' => array(array('1', 'Tambah Diklat Teknis & Fungsional')),
					'form' => array(
						array(1, FALSE, 'Kode Diklat', 'kode_diklat', 'input-xlarge'),
						array(3, TRUE, 'Nama Diklat', 'nama_diklat', 'input-xlarge')
					)
				);

				break;

			case "hukdis":

				$combo_huk_lev = $this->general_model->combo_box(array('tabel' => 'ref_hukdis_level', 'key' => 'id_hukdis_level', 'val' => array('hukdis_level')));

				$param = array(

					'inti' => 'hukdis',
					'title' => 'Hukdis',
					'tabel' => array(
						'ref_hukdis j' => '',
						'ref_hukdis_level e' => 'e.id_hukdis_level = j.id_hukdis_level'
					),
					'tabel_save' => 'ref_hukdis',
					'kolom' => array('Nama Hukuman Disiplin', 'Level'),
					'kolom_tampil' => array('hukdis', 'hukdis_level'),
					'kolom_data' => array('id_hukdis_level', 'hukdis'),
					'kolom_cari' => array('j.hukdis', 'e.hukdis_level'),
					'order' => 'e.id_hukdis_level',
					'id' => 'id_hukdis',
					'tombol' => array(array('1', 'Tambah Hukdis')),
					'form' => array(
						array(3, TRUE, 'Nama Hukdis', 'hukdis', 'input-xlarge'),
						array(2, TRUE, 'Level', 'id_hukdis_level', $combo_huk_lev, 'input-xlarge combo-box')
					)
				);

				break;

			case "hukdis_level":

				$param = array(

					'inti' => 'hukdis_level',
					'title' => 'Hukdis Level',
					'tabel' => 'ref_hukdis_level',
					'kolom' => array('Hukdis Level'),
					'kolom_tampil' => array('hukdis_level'),
					'kolom_data' => array('hukdis_level'),
					'order' => 'hukdis_level',
					'id' => 'id_hukdis_level',
					'tombol' => array(array('1', 'Tambah Hukdis Level')),
					'form' => array(
						array(1, TRUE, 'Nama Hukdis Level', 'hukdis_level', 'input-xlarge')
					)
				);

				break;

			case "kartu":

				$param = array(

					'inti' => 'kartu',
					'title' => 'Kartu',
					'tabel' => 'ref_kartu',
					'kolom' => array('Kode', 'kartu'),
					'kolom_tampil' => array('kode_kartu', 'kartu'),
					'kolom_data' => array('kode_kartu', 'kartu'),
					'order' => 'kode_kartu',
					'id' => 'id_kartu',
					'tombol' => array(array('1', 'Tambah Kartu')),
					'form' => array(
						array(1, FALSE, 'Kode Kartu', 'kode_kartu', 'input-xlarge'),
						array(3, TRUE, 'Nama Kartu', 'kartu', 'input-xlarge')
					)
				);

				break;

			case "status_pensiun":

				$combo_tip = array('1' => 'Reguler', '2' => 'Perpanjangan');
				$param = array(

					'inti' => 'status_pensiun',
					'title' => 'Pensiun',
					'tabel' => 'ref_pensiun',
					'kolom' => array('Kode', 'Tipe pensiun'),
					'kolom_tampil' => array('kode_pensiun', 'nama_pensiun'),
					'kolom_data' => array('kode_pensiun', 'nama_pensiun', 'tipe_pensiun'),
					'order' => 'kode_pensiun',
					'id' => 'id_pensiun',
					'tombol' => array(array('1', 'Tambah Pensiun')),
					'form' => array(
						array(1, FALSE, 'Kode Pensiun', 'kode_pensiun', 'input-xlarge'),
						array(3, TRUE, 'Status Pensiun', 'nama_pensiun', 'input-xlarge'),
						array(2, TRUE, 'Tipe', 'tipe_pensiun', $combo_tip, 'input-xlarge combo-box')
					)
				);

				break;

			case "ekstensi":

				$param = array(
					'inti' => 'ekstensi',
					'title' => 'Ekstensi Arsip',
					'tabel' => 'ref_arsip_ekstensi',
					'kolom' => array('Ekstensi'),
					'kolom_tampil' => array('ekstensi', 'keterangan'),
					'kolom_data' => array('ekstensi', 'keterangan'),
					'order' => 'ekstensi',
					'id' => 'id_ekstensi',
					'tombol' => array(array('1', 'Ekstensi')),
					'form' => array(
						array(1, TRUE, 'Ekstensi', 'ekstensi', null),
						array(3, FALSE, 'Keterangan', 'keterangan', null)
					)
				);

				break;


			case "ruang":

				$param = array(
					'inti' => 'ruang',
					'title' => 'Ruang',
					'tabel' => 'ref_ruang',
					'kolom' => array('Kode', 'Deskripsi'),
					'kolom_tampil' => array('kode', 'deskripsi'),
					'kolom_data' => array('kode', 'deskripsi'),
					'order' => 'kode',
					'id' => 'id_ruang',
					'tombol' => array(array('1', 'Tambah Ruang')),
					'form' => array(
						array(1, FALSE, 'Kode Ruang', 'kode', 'input-xlarge'),
						array(3, TRUE, 'Nama Ruang', 'deskripsi', 'input-xlarge')
					)
				);

				break;


			case "lemari":

				$param = array(
					'inti' => 'lemari',
					'title' => 'Lemari',
					'tabel' => 'ref_lemari',
					'kolom' => array('Kode', 'Deskripsi'),
					'kolom_tampil' => array('kode', 'deskripsi'),
					'kolom_data' => array('kode', 'deskripsi'),
					'order' => 'kode',
					'id' => 'id_lemari',
					'tombol' => array(array('1', 'Tambah Lemari')),
					'form' => array(
						array(1, FALSE, 'Kode Lemari', 'kode', 'input-xlarge'),
						array(3, TRUE, 'Nama Lemari', 'deskripsi', 'input-xlarge')
					)
				);

				break;


			case "rak":

				$param = array(
					'inti' => 'rak',
					'title' => 'Rak',
					'tabel' => 'ref_rak',
					'kolom' => array('Kode', 'Deskripsi'),
					'kolom_tampil' => array('kode', 'deskripsi'),
					'kolom_data' => array('kode', 'deskripsi'),
					'order' => 'kode',
					'id' => 'id_rak',
					'tombol' => array(array('1', 'Tambah Rak')),
					'form' => array(
						array(1, FALSE, 'Kode Rak', 'kode', 'input-xlarge'),
						array(3, TRUE, 'Nama Rak', 'deskripsi', 'input-xlarge')
					)
				);

				break;

			case "satuan";
				$param = array(
					'inti' => 'satuan',
					'title' => 'Satuan',
					'tabel' => 'ref_satuan',
					'kolom' => array('Nama Satuan'),
					'kolom_tampil' => array('nama_satuan'),
					'kolom_data' => array('nama_satuan'),
					'order' => 'nama_satuan',
					'id' => 'id_satuan',
					'tombol' => array(array('1', 'Tambah Satuan')),
					'form' => array(
						array(3, TRUE, 'Nama Satuan', 'nama_satuan', 'input-xlarge')
					)
				);

				break;


			case "tipe_pegawai":

				$param = array(

					'inti' => 'tipe_pegawai',
					'title' => 'Tipe Pegawai',
					'tabel' => 'ref_tipe_pegawai',
					'select' => 'tipe_pegawai,IF(jenis = 1,"PNS","Non PNS") as jenis,id_tipe_pegawai',
					'kolom' => array('Tipe Pegawai', 'Jenis'),
					'kolom_tampil' => array('tipe_pegawai', 'jenis'),
					'kolom_data' => array('tipe_pegawai', 'jenis'),
					'order' => 'tipe_pegawai',
					'id' => 'id_tipe_pegawai',
					'tombol' => array(array('1', 'Tipe Pegawai')),
					'form' => array(
						array(1, TRUE, 'Tipe Pegawai', 'tipe_pegawai', 'input-xlarge'),
						array(2, TRUE, 'Jenis', 'jenis', array('1' => 'PNS', '2' => 'Non PNS'), 'input-xlarge combo-box')
					)
				);

				/* -- Pengadaan -- */

			case "supplier":

				$param = array(

					'inti' => 'supplier',
					'title' => 'Suplier',
					'tabel' => 'ref_supplier',
					'kolom' => array('Supplier', 'Kontak', 'Alamat', 'Email'),
					'kolom_tampil' => array('nama', 'telp', 'alamat', 'email'),
					'kolom_data' => array('nama', 'alamat', 'telp', 'email'),
					'order' => 'nama',
					'id' => 'id_supplier',
					'tombol' => array(array('1', 'Supplier')),
					'form' => array(
						array(1, TRUE, 'Nama Supplier', 'nama', null),
						array(3, TRUE, 'Alamat', 'alamat', null),
						array(1, TRUE, 'Telepon', 'telp', null),
						array(1, TRUE, 'E-mail', 'email', null)
					)
				);

				break;

			case "tipe_anggaran":

				$param = array(

					'inti' => 'tipe_anggaran',
					'title' => 'Tipe Anggaran',
					'tabel' => 'ref_anggaran_tipe',
					'kolom' => array('Kode', 'Tipe Anggaran'),
					'kolom_tampil' => array('kode_anggaran_tipe', 'anggaran_tipe'),
					'kolom_data' => array('kode_anggaran_tipe', 'anggaran_tipe'),
					'order' => 'anggaran_tipe',
					'id' => 'id_anggaran_tipe',
					'tombol' => array(array('1', 'Tipe Anggaran')),
					'form' => array(
						array(1, TRUE, 'Kode', 'kode_anggaran_tipe', null),
						array(3, TRUE, 'Tipe Anggaran', 'anggaran_tipe', null)
					)
				);

				break;

			case "status_pengadaan":

				$param = array(

					'inti' => 'status_pengadaan',
					'title' => 'Status Pengadaan',
					'tabel' => 'ref_status_pengadaan',
					'kolom' => array('Status Pengadaan'),
					'kolom_tampil' => array('status_pengadaan'),
					'kolom_data' => array('status_pengadaan'),
					'order' => 'status_pengadaan',
					'id' => 'id_status_pengadaan',
					'tombol' => array(array('1', 'Status Pengadaan')),
					'form' => array(
						array(1, TRUE, 'Status', 'status_pengadaan', null)
					)
				);

				break;


			case "jenis_pengadaan":

				$param = array(

					'inti' => 'jenis_pengadaan',
					'title' => 'Jenis Pengadaan',
					'tabel' => 'ref_tipe_pengadaan',
					'kolom' => array('Status Pengadaan'),
					'kolom_tampil' => array('tipe_pengadaan'),
					'kolom_data' => array('tipe_pengadaan'),
					'order' => 'id_tipe_pengadaan',
					'id' => 'id_tipe_pengadaan',
					'tombol' => array(array('1', 'Jenis Pengadaan')),
					'form' => array(
						array(1, TRUE, 'Jenis', 'tipe_pengadaan', null)
					)
				);

				break;

			case "kategori":

				$param = array(

					'inti' => 'kategori',
					'title' => 'Kategori',
					'tabel' => 'ref_kategori_barang',
					'kolom' => array('Nama Kategori'),
					'kolom_tampil' => array('kategori'),
					'kolom_data' => array('kategori'),
					'order' => 'id_kategori',
					'id' => 'id_kategori',
					'tombol' => array(array('1', 'Kategori')),
					'form' => array(
						array(1, TRUE, 'Nama Kategori', 'kategori', null)
					)
				);

				break;

				//pppk
			case "golongan_pppk":

				$param = array(

					'inti' => 'golongan_pppk',
					'title' => 'Golongan PPPK',
					'tabel' => 'pppk_ref_golongan',
					'kolom' => array('Golongan PPPK'),
					'kolom_tampil' => array('gol_p3k'),
					'kolom_data' => array('gol_p3k'),
					'order' => 'gol_p3k',
					'id' => 'id_gol',
					'tombol' => array(array('1', 'Tambah Golongan PPPK')),
					'form' => array(
						array(1, FALSE, 'Golongan PPPK', 'gol_p3k', 'input-xlarge')
					)
				);

				break;

			case "putus_kontrak_pppk":

				$param = array(

					'inti' => 'putus_kontrak',
					'title' => 'Sebab Pemutusan Kontrak Kerja',
					'tabel' => 'ref_putus_kontrak',
					'kolom' => array('Sebab Pemutusan Kontrak Kerja'),
					'kolom_tampil' => array('putus_kontrak'),
					'kolom_data' => array('putus_kontrak'),
					'order' => 'id_putus_kontrak',
					'id' => 'id_putus_kontrak',
					'tombol' => array(array('1', 'Sebab Pemutusan Kontrak Kerja')),
					'form' => array(
						array(1, TRUE, 'Sebab Pemutusan Kontrak Kerja', 'putus_kontrak', null)
					)
				);

				break;

			case "jabatan_pppk":

				// $combo_unit = $this->general_model->combo_box(array(
				// 	'tabel' => 'ref_unit',
				// 	'key' => 'id_unit',
				// 	'select' => 'CONCAT(UPPER(unit),IF(aktif = 2," (Non Aktif)","")) as unit,id_unit',
				// 	'val' => array('unit'),
				// 	'order' => 'urut,unit'
				// ));
				$combo_jenis_jab = $this->general_model->combo_box(array('tabel' => 'pppk_ref_jenis_jabatan', 'key' => 'id_jenis_jab', 'val' => array('jenis_jab')));
				$where_unit = (!empty($o['form_id']) ? null : array('aktif' => 1));
				$cb_unit = $this->general_model->combo_box(array(
					'tabel' => 'ref_unit', 'key' => 'id_unit', 'val' => array('unit'),
					'select' => 'id_unit,CONCAT(unit,IF(aktif = 2," (Non Aktif)","")) unit',
					'where' => $where_unit
				));

				// cek($o['form_id']);
				// die();

				if (!empty($o['form_id'])) {

					$de = $this->general_model->datagrab(array(
						'tabel' => array(
							'ref_jabatan j' => '',
							'ref_bidang b' => 'b.id_bidang = j.id_bidang'
						),
						'where' => array('j.id_jabatan' => $o['form_id']),
						'select' => 'b.id_unit'
					))->row();

					$where_unit = (isset($de->id_unit)) ? array('id_unit' => $de->id_unit) : null;
				}

				$param = array(

					'inti' => 'jabatan_pppk',
					'title' => 'Daftar Jabatan PPPK',
					'filter' => array(
						'id_unit' => array('ref_unit', 'u.id_unit', 'unit', ' -- Filter Unit Kerja --', array('url' => $this->dir . '/ajax_bidang', 'class' => 'cb_bidang', 'dom' => 'set_bidang', 'set' => 'onchange="set_bidang(this.value)"')),
					),
					'tabel' => array(
						'pppk_ref_jabatan j' => '',
						'pppk_ref_jenis_jabatan e' => 'e.id_jenis_jab = j.id_jenis_jab',
						'ref_unit u' => 'u.id_unit = j.id_unit'
					),
					'select' => 'CONCAT(UPPER(u.unit),IF(aktif = 2," (Non Aktif)","")) as unit, e.jenis_jab, j.*',
					'tabel_save' => 'pppk_ref_jabatan',
					'kolom' => array('Jabatan PPPK', 'Jenis Jabatan', 'Instansi/OPD'),
					'kolom_tampil' => array('jabatan', 'jenis_jab', 'unit'),
					'kolom_data' => array('id_jenis_jab', 'jabatan', 'bup', 'id_unit'),
					'kolom_cari' => array('j.jabatan'),
					'order' => 'j.jabatan, u.unit',
					'id' => 'id_jabatan',
					'tombol' => array(array('1', 'Tambah Jabatan PPPK')),
					'form' => array(
						array(2, TRUE, 'Jenis Jabatan', 'id_jenis_jab', $combo_jenis_jab, 'input-xlarge combo-box'),
						array(1, TRUE, 'Jabatan', 'jabatan', 'input-xlarge'),
						array(1, TRUE, 'BUP', 'bup', 'input-xlarge', 'formatnumber'),
						array(2, TRUE, 'Unit', 'id_unit', $cb_unit, 'input-xlarge combo-box')
					)
				);

				break;

			case "jenis_jabatan_pppk":

				$param = array(

					'inti' => 'jenis_jabatan_pppk',
					'title' => 'Jenis Jabatan PPPK',
					'tabel' => 'pppk_ref_jenis_jabatan',
					'kolom' => array('Jenis Jabatan PPPK'),
					'kolom_tampil' => array('jenis_jab'),
					'kolom_data' => array('jenis_jab'),
					'order' => 'jenis_jab',
					'id' => 'id_jenis_jab',
					'tombol' => array(array('1', 'Tambah Jenis Jabatan PPPK')),
					'form' => array(
						array(1, FALSE, 'Jenis Jabatan PPPK', 'jenis_jab', 'input-xlarge')
					)
				);

				break;
		}

		$param = array_merge_recursive(array(
			'search' => $search_param,
			'filter_sc' => $filter_param,
			'module' => $this->dir . '/ke/'
		), $param);

		switch ($modex) {
			case "list_data":
				$this->list_data($param, $offset);
				break;
			case "form_mode":
				// cek($param);
				$this->form_data($param, $search . '~' . (isset($offset) ? $offset : '0'), $form_id);
				break;
			case "save_mode":
				$this->save_data($param);
				break;
			case "excel_impor":
				$this->impor_data($param, $search, $offset);
				break;
			case "save_impor":
				$this->save_impor($param, $search, $offset);
				break;
			case "hapus_data":
				$this->hapus_data($param, $offset);
				break;
		}
	}

	function list_data($o = null, $offset = null)
	{

		$data['breadcrumb'] = array('' => 'Referensi', $o['module'] . $o['inti'] => $o['title']);
		if (!empty($o['breadcrumb'])) $data['breadcrumb'] = array_merge($data['breadcrumb'], $o['breadcrumb']);

		$offset = !empty($offset) ? $offset : null;

		$search = null;

		if (!empty($o['search'])) {
			$search = array();

			if (!empty($o['kolom_cari'])) {
				foreach ($o['kolom_cari'] as $ks) {
					$search[$ks] = $o['search'];
				}
			} else {
				foreach ($o['kolom_data'] as $ks) {
					$search[$ks] = $o['search'];
				}
			}
		}
		$se = !empty($o['search']) ? array('search' => $o['search']) : array('search' => null);

		$where_filter = array();
		$flt = array();
		if (isset($o['filter'])) {
			foreach ($o['filter'] as $a => $b) {

				if (isset($o['filter_sc'][$a]) and $o['filter_sc'][$a] != NULL) $sf = $o['filter_sc'][$a];
				else $sf = $this->input->post($a);
				if ($sf != NULL) {
					$flt[$a] = $sf;
					$where_filter[$b[1]] = $sf;
				}
			}
			$se['filter_sc'] = $flt;
		}

		$where = (isset($o['where'])) ? $o['where'] : array();
		$where = array_merge_recursive($where, $where_filter);

		$config['base_url']	= site_url($o['module'] . $o['inti'] . '/' . in_de($se));
		$config['total_rows'] = $this->general_model->datagrab(array(
			'select' => 'count(*) as jml',
			'tabel' => $o['tabel'],
			'search' => $search,
			'where' => $where
		))->row()->jml;
		$config['per_page']	= '10';
		$config['uri_segment'] = '6';

		$this->pagination->initialize($config);

		$data['links']	= $this->pagination->create_links();

		$offs = (!in_array($offset, array("cetak", "excel"))) ?  $offset : null;
		$lim = (!in_array($offset, array("cetak", "excel"))) ? $config['per_page'] : null;

		$query = $this->general_model->datagrab(array(
			'tabel' => $o['tabel'],
			'offset' => $offs,
			'limit' => $lim,
			'order' => @$o['order'],
			'select' => @$o['select'],
			'search' => $search,
			'where' => $where,
			'group_by' => @$o['group_by']
		));
		// cek($this->db->last_query());
		if ($query->num_rows() != 0) {
			$classy = (in_array($offset, array("cetak", "excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-sm table-bordered table-condensed table-nonfluid"';


			$this->table->set_template(array('table_open' => '<table ' . $classy . '>'));
			$heads = array_merge_recursive(array(
				'No',
				array('data' => '<input type="checkbox" name="cek_all" id="cek_all" class="cek-all" ', 'class' => 'center', 'style' => 'width:30px')
			), $o['kolom']);
			if (!in_array($offset, array('cetak', 'excel'))) $heads[] = array('data' => 'Aksi', 'colspan' => '2');
			$this->table->set_heading($heads);

			$no = 1 + floatval($offset);

			foreach ($query->result() as $row) {
				$rows = array($no);
				$id_ = $o['id'];
				$idx = $row->{$id_}; // ini
				// cek($o);
				$case = $o['inti'];
				if ($case == 'jabatan_jenis') {
					$cek_status = $this->general_model->datagrab(array('tabel' => 'ref_jabatan',  'where' => array($id_ => $idx)))->num_rows();
				} else {
					$cek_status = $this->general_model->datagrab(array('tabel' => 'peg_pegawai',  'where' => array($id_ => $idx)))->num_rows();
				}
				// cek($this->db->last_query());
				if ($cek_status > 0) {
					$rows[] = array('data' => '<input type="checkbox" name="no_cek[]" class="no_cek" value="' . $idx . '" disabled>', 'style' => 'text-align: center');
					$disabled = 'disabled';
				} else {
					$rows[] = array('data' => '<input type="checkbox" name="cek[]" class="cek" value="' . $idx . '" >', 'style' => 'text-align: center');
					$disabled = '';
				}
				foreach ($o['kolom_tampil'] as $kol) {
					$rows[] = $row->$kol;
				}

				$tabel_del = is_array($o['tabel']) ? $o['tabel_save'] : $o['tabel'];

				$link1 = anchor('#', '<i class="fas fa-edit"></i>', 'class="btn btn-edit btn-xs btn-warning" act="' . site_url($o['module'] . $o['inti'] . '/' . in_de(array('modex' => 'form_mode', 'form_id' => $idx, 'search' => (isset($o['search']) ? $o['search'] : null))) . '/' . $offset) . '"');
				$link2 = anchor('#', '<i class="fa fa-trash"></i>', 'class="btn btn-delete btn-xs btn-danger ' . $disabled . '"  act="' . site_url('home/general_delete/' . in_de(array('id' => $idx, 'redirect' => $this->dir . '/ke/' . $o['inti'] . '/' . in_de(array('modex' => 'list_data', 'search' => (isset($o['search']) ? $o['search'] : null))) . '/' . $offset, 'tabel' => $tabel_del, 'kolom' => $id_))) . '" msg="Apakah Anda ingin menghapus data ini?"');

				if (!in_array($offset, array('cetak', 'excel'))) {

					$rows[] = array('data' => $link1, 'style' => 'text-align:center');
					$rows[] = array('data' => $link2, 'style' => 'text-align:center');
				}

				$this->table->add_row($rows);
				$no++;
			}

			$tabel =
				form_open($this->dir . '/ke/' . $o['inti'] . '/' . in_de(array('modex' => 'hapus_data', 'search' => (isset($o['search']) ? $o['search'] : null))) . '/' . $offset, 'id="form_delete"') .
				anchor('#', '<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang', 'class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-bottom: 10px"') .
				$this->table->generate() .
				anchor('#', '<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang', 'class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-top: 10px"') .
				form_close();
		} else {
			$tabel = '<div class="alert">Tidak ditemukan data ...</div>';
		}

		$btn_cetak = ($query->num_rows() > 0) ?
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-print fa-btn"></i> Cetak</a>
			<div class="dropdown-menu role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, 37px, 0px);">
			<li>' . anchor($o['module'] . $o['inti'] . '/' . in_de($se) . '/cetak', 'Cetak', 'target="_blank" class="dropdown-item"') . '</li>
			<li>' . anchor($o['module'] . $o['inti'] . '/' . in_de($se) . '/excel', 'Ekspor Excel', 'target="_blank" class="dropdown-item"') . '</li>
			</div>
			</div>' : null;

		$tombol = array();
		$t_no = 1;
		foreach ($o['tombol'] as $t) {

			switch ($t[0]) {
				case "0":
					$c_btn = null;
					$icn = null;
					break;
				case "1":
					$c_btn = "btn-success";
					$icn = '<i class="fa fa-plus-square"></i>';
					break;
			}
			$tombol[] = anchor($t_no, $icn . ' &nbsp; ' . $t[1], 'class="btn-edit btn btn-success" act="' . site_url($o['module'] . $o['inti'] . '/' . in_de(array('modex' => 'form_mode'))) . '"');
		}


		// -- Tombol Impor -- //
		$btn_impor = null;
		if (!empty($o['excel_impor'])) {
			$s = un_de($se);
			$s['modex'] = 'excel_impor';
			$btn_impor = anchor(
				$o['module'] . $o['inti'] . '/' . in_de($s),
				'<i class="fa fa-file-excel-o fa-btn"></i> Impor Data',
				'class="btn btn-primary" style="margin-left: 5px"'
			);
		}


		$data['total'] = $config['total_rows'];
		$data['tombol'] = implode(' ', $tombol) . ' ' . $btn_cetak . ' ' . $btn_impor;

		$data['script'] = "$(document).ready(function(){
							$('.combo-box').select2();
						});";

		$form_filter = null;
		$btn_search = null;
		if (isset($o['filter'])) {

			foreach ($o['filter'] as $a => $b) {

				if ($b[0] == "ajax") {

					if (isset($flt[$a])) {

						$cb_ajax = $this->general_model->datagrab(array(
							'tabel' => $b[5], 'select' => $a . ',' . $b[2], 'where' => array($a => $flt[$a])
						))->row();
					}

					@$b_2 = $b[2];
					@$bo2 = $cb_ajax->{$b_2};


					$form_filter .= '<p>' . form_dropdown($a, (isset($cb_ajax) ? array($cb_ajax->$a => @$bo2) : array('' => $b[3])), @$flt[$a], 'class="form-control combo-box ' . $b[4] . '"') . '</p>';
				} else {
					$cb_filter = $this->general_model->combo_box(array('tabel' => $b[0], 'key' => $a, 'val' => array($b[2]), 'pilih' => $b[3]));
					if (isset($b[4]['set'])) {

						$form_filter .= "<script type='text/javascript'>
								function " . $b[4]['dom'] . "(a) {
								$(document).ready(function(){
									$('." . $b[4]['class'] . "').select2({
										ajax: {
										url: '" . site_url($b[4]['url']) . "/'+(a?a:''),
										dataType: 'json',
										type: 'POST',
										delay: 250,
										cache: true,
										data: function (params) {
												console.log(params);
											  return {
												q: params.term, 
												page: params.page
											  };
											},
										processResults: function (data, params) {
											params.page = params.page || 1;
											return {
												results: $.map(data, function (item) {
													return {
														text: item.data,
														id: item.id
													}
												})
											};
										},
									} 
								});
								});
								
								}
								
								" . ((isset($flt[$a]) and $flt[$a] != NULL) ? $b[4]['dom'] . "(" . $flt[$a] . ")" : null) . "
							</script>";
						$form_filter .= '<p>' . form_dropdown($a, $cb_filter, @$flt[$a], 'class="form-control combo-box" ' . (isset($b[4]['set']) ? $b[4]['set'] : null)) . '</p>';
					}
				}
			}
			$btn_search = ' Filter';
		}

		$data['extra_tombol'] =
			form_open($o['module'] . $o['inti'], 'id="form_search"') .
			$form_filter .
			'<div class="input-group">
                      <input name="search" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="' . @$o['search'] . '">
                      <div class="input-group-btn">
                        <button class="btn btn-default"><i class="fa fa-search"></i>' . $btn_search . '</button>
                      </div>
                    </div>' . form_close();

		$data['tabel']	= $tabel;

		if ($offset == "cetak") {
			$data['title'] = '<h3>' . $o['title'] . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print', $data);
		} else if ($offset == "excel") {
			$data['file_name'] = str_replace(" ", "_", strtolower($o['title'])) . '.xls';
			$data['title'] = '<h3>' . $o['title'] . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel', $data);
		} else {
			if (!empty($o['urut'])) $this->urutan($o['tabel'], $o['urut'], $o['id']);
			$data['tabel'] = $tabel;
			$data['title'] = $o['title'];
			$data['content'] = "umum/standard_view";
			$this->load->view('home', $data);
		}
	}

	function form_data($o, $sc, $id = null)
	{

		$t = empty($id) ? 'Tambah ' : 'Ubah ';
		$data['title'] = $t . $o['title'];

		$data['form_link'] = $o['module'] . $o['inti'] . '/' . in_de(array('modex' => 'save_mode'));

		$def = !empty($id) ? $this->general_model->datagrab(array('tabel' => $o['tabel'], 'where' => array($o['id'] => $id), 'select' => @$o['select']))->row() : null;
		$se = explode('~', $sc);
		$s = un_de($se[0]);
		$s['modex'] = 'list_data';

		$data['form_data'] =
			form_hidden('sc', in_de($s)) .
			form_hidden('offs', $se[1]) .
			form_hidden($o['id'], @$def->{$o['id']}); //

		$to_datepicker = array();

		foreach ($o['form'] as $fo) {
			@$id_ = $fo[3];
			@$fo3 = $def->{$id_};
			$extra_form = null;
			$req = ($fo[1] == TRUE) ? 'required' : null;
			switch ($fo[0]) {
				case 0:
					$fr = form_hidden($fo[3], !empty($def->$fo[3]) ? $def->$fo[3] : $fo[4]);
					break;

				case 1:
					if (!empty($fo[5])) {
						switch ($fo[5]) {
							case "formatnumber":
								$form_data = !empty($def->$fo[3]) ? numberToCurrency($def->$fo[3]) : null;
								$extra_form = ' onkeyup="formatNumber(this)"';
								break;
							case "datepicker":
								$to_datepicker[] = $fo[3];
								$form_data = !empty($def->$fo[3]) ? tanggal($def->$fo[3]) : null;
								break;
						}
					} else {
						$form_data = @$fo3;
					}

					if (!empty($fo[6])) $extra_form = $fo[6];
					$fr = '<p>' . form_label($fo[2]) . form_input($fo[3], $form_data, 'class="' . $fo[4] . ' form-control" ' . $req . $extra_form) . '</p>';
					break;
				case 2:
					$fr = '<p>' . form_label($fo[2]) . form_dropdown($fo[3], $fo[4], @$fo3, 'class="' . $fo[5] . ' form-control" style="width: 100%" ' . $req . ' ' . @$fo[6]) . '</p>';
					break;
				case 3:
					$fr = '<p>' . form_label($fo[2]) . form_textarea($fo[3], @$fo3, 'class="' . $fo[4] . ' form-control" style="height: 75px" ' . $req) . '</p>';
					break;
			}

			$data['form_data'] .= $fr;
		}
		$data['script'] = null;
		if (!empty($o['form_script'])) $data['script'] = $o['form_script'];


		foreach ($to_datepicker as $dt) {
			$data['script'] .= "
					$('." . $dt . "').datepicker({
						format  : 'dd/mm/yyyy', todayBtn: 'linked', language: 'id'
					  }).on('changeDate', function(){ $('." . $dt . "').datepicker('hide');
					});
				";
		}

		$data['def'] = $def;
		if (!empty($param['form_khusus'])) $this->load->view($param['form_khusus'], $data);
		else $this->load->view('umum/form_view', $data);
	}

	function save_data($o = null)
	{

		$id = $this->input->post($o['id']);

		$simpan = array();

		foreach ($o['form'] as $kol) {
			if (!empty($kol[3])) {

				if ((!empty($o['kolom_data']) and in_array($kol[3], $o['kolom_data'])) or (empty($o['kolom_data']))) {
					$f_simpan = $this->input->post($kol[3]);

					if ($kol[0] == 1 and !empty($kol[5])) {
						switch ($kol[5]) {
							case "datepicker":
								$simpan[$kol[3]] = tanggal_php($f_simpan);
								break;
							case "formatnumber":
								$simpan[$kol[3]] = currencyToNumber($f_simpan);
								break;
						}
					} else {
						if ($f_simpan != NULL) $simpan[$kol[3]] = $f_simpan;
					}
				}
			}
		}

		$tbl = is_array($o['tabel']) ? $o['tabel_save'] : $o['tabel'];

		// -- Cek Duplikat --//

		if (isset($o['duplikat'])) {
			$cek = array();
			foreach ($o['duplikat'] as $dup) {

				$cek[$dup] = $simpan[$dup];
			}

			if (!empty($id)) $cek[$o['id'] . ' <> ' . $id] = null;

			$cek_dup = $this->general_model->datagrab(array('tabel' => $tbl, 'where' => $cek, 'select' => 'count(' . $o['id'] . ') as jml'))->row();
			if ($cek_dup->jml > 0) $this->session->set_flashdata('fail', 'Data duplikat ... !');
			else {
				$this->general_model->save_data($tbl, $simpan, $o['id'], $id);
				$this->session->set_flashdata('ok', 'Data berhasil disimpan');
			}
		} else {

			$this->general_model->save_data($tbl, $simpan, $o['id'], $id);
		}
		if (isset($o['urut'])) $this->urutan($o['tabel'], $o['urut'], $o['id']);
		$this->session->set_flashdata('ok', 'Data berhasil disimpan');
		redirect($o['module'] . $o['inti'] . '/' . $this->input->post('sc') . '/' . $this->input->post('offs'));
	}

	function urutan($tbl, $urut, $id)
	{

		$tb = $this->general_model->datagrab(array(
			'tabel' => $tbl,
			'order' => $urut . ',' . $id
		));
		$no = 1;
		foreach ($tb->result() as $t) {
			$this->general_model->save_data($tbl, array($urut => $no), $id, $t->$id);
			$no += 1;
		}
	}

	function impor_data($o, $search = null, $offset = null)
	{

		$data['breadcrumb'] = array('' => 'Referensi', $o['module'] . $o['inti'] => $o['title']);
		if (!empty($o['breadcrumb'])) $data['breadcrumb'] = array_merge($data['breadcrumb'], $o['breadcrumb']);

		$s = un_de($search);
		$s['modex'] = 'list_data';

		$data['tombol'] = anchor(
			$o['module'] . $o['inti'] . '/' . in_de($s) . '/' . $offset,
			'<i class="fa fa-arrow-left fa-btn"></i> Kembali',
			'class="btn btn-default"'
		);

		$s = un_de($search);
		$s['modex'] = 'save_impor';

		$this->table->set_template(array('table_open' => '<table class="tabel_print" border=1>'));
		$head = array('x');
		for ($i = 0; $i < count($o['excel_impor']); $i++) {
			$head[] = is_array($o['excel_impor'][$i]) ? $o['excel_impor'][$i]['kolom'] : $o['excel_impor'][$i];
		}
		$this->table->set_heading($head);
		$rows = array(array('data' => 1, 'class' => 'add_th'));
		for ($i = 0; $i < count($o['excel_impor']); $i++) {
			$rows[] = array('data' => 'xxxxx', 'class' => 'reg');
		}
		$this->table->add_row($rows);
		$rows = array(array('data' => 2, 'class' => 'add_th'));
		for ($i = 0; $i < count($o['excel_impor']); $i++) {
			$rows[] = array('data' => 'xxxxx', 'class' => 'reg');
		}
		$this->table->add_row($rows);
		$data['tabel'] =

			'
			<style>
				th, .add_th { padding: 5px 10px; background: #eee; font-size: 120%; font-weight: bold; }
				.reg { padding: 5px 10px; font-size: 120%; }
			</style>
			<div class="row">
				<div class="col-lg-7">
				<p>Format File Excel untuk impor data ini adalah Microsoft Excel 2003-2007 (.xls).<br>
				Buat format data seperti di bawah ini dengan <b>mengabaikan sel berwarna abu-abu</b>.<br>
				Pastikan urutan sudah benar akan tidak terjadi kesalahan input</p><br>
				' .
			$this->table->generate() . '<br><p>
				Data yang sama untuk tiap baris akan di seleksi dan tidak akan di masukkan.</p>'
			. '</div><div class="col-lg-5">' .
			form_open_multipart($o['module'] . $o['inti'] . '/' . in_de($s) . '/' . $offset, 'id="form_impor"') .
			'<p>' . form_label('Pilih File Excel') . form_upload('excel_impor', 'class="form-control"') . '</p>' .
			'<p>' . form_label('') . form_submit('', 'Unggah Data Impor', 'class="btn btn-success"') . '</p>' .
			form_close() .
			'</div>
			</div>';

		$data['title'] = 'Impor Data ' . $o['title'];
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
	}

	function save_impor($o, $search = null, $offset = null)
	{

		$ign = 0;
		$pss = 0;

		if (empty($_FILES['excel_impor']['name'])) {
			$errors = 'Pilih dokumen Excel yang akan di-unggah ...';
		} else {
			$this->load->library('upload');
			$this->upload->initialize(array(
				'upload_path' => './uploads/',
				'allowed_types' => '*'
			));
			if (!$this->upload->do_upload('excel_impor')) {
				$en = $this->upload->display_errors();
				switch ($en) {
					case 'The uploaded file exceeds the maximum allowed size in your PHP configuration file.':
						$errors = 'Unggah berkas lebih dari batas maksimum diperbolehkan ...';
						break;
					default:
						$error = $en;
				}
			} else {
				$data_up = $this->upload->data();
				$this->load->library('excel_reader');
				$this->excel_reader->setOutputEncoding('CP1251');
				$rslt_read = $this->excel_reader->read('./uploads/' . $data_up['file_name']);
				if ($rslt_read != 404) {
					$brs = $this->input->post('baris');
					$data = $this->excel_reader->sheets[0];

					// -- Kumpulkan Kolom Rujukan -- //

					for ($n = 1; $n <= $data['numRows']; $n++) {

						for ($i = 0; $i < count($o['excel_impor']); $i++) {

							if (is_array($o['excel_impor'][$i])) {

								$cek = $this->general_model->datagrab(array(
									'tabel' => $o['excel_impor'][$i]['tabel'],
									'where' => array($o['excel_impor'][$i]['kolom'] => $data['cells'][$n][$i + 1]),
									'select' => 'count(*) as jml,' . $o['excel_impor'][$i]['id_kolom']
								))->row();
								if ($cek->jml > 0) $id_s = $cek->$o['excel_impor'][$i]['id_kolom'];
								else $id_s = $this->general_model->save_data($o['excel_impor'][$i]['tabel'], array($o['excel_impor'][$i]['kolom'] => $data['cells'][$n][$i + 1]));
							}
						}

						$saving = array();
						for ($e = 0; $e <= count($o['excel_impor']) - 1; $e++) {


							if (is_array($o['excel_impor'][$e])) {
								$saving[$o['excel_impor'][$e]['id_kolom']] = $id_s;
							} else {
								$saving[$o['excel_impor'][$e]] = (isset($data['cells'][$n][$e + 1])) ? $data['cells'][$n][$e + 1] : null;
							}
						}

						$t_save = (isset($o['tabel_save']) ? $o['tabel_save'] : $o['tabel']);
						$c_save = $this->general_model->datagrab(array('tabel' => $t_save, 'where' => $saving, 'select' => 'count(*) jml'))->row();
						if ($c_save->jml != NULL and $c_save->jml > 0) {
							$ign += 1;
						} else {

							$pss += 1;
							$this->general_model->save_data($t_save, $saving);
						}
					}
				} else {
					$errors = 'File excel tersebut tak dapat terbaca ...<br>harus File dengan ektensi <b>xls</b> atau format Ms.Excel 2003/2007';
				}
			}

			unlink(FCPATH . 'uploads/' . $data_up['file_name']);
		}

		if (!empty($errors)) $this->session->set_flashdata('fail', 'Terjadi kesalahan<br>' . $errors);
		else $this->session->set_flashdata('ok', 'Impor <b>' . $pss . ' data</b> berhasil disimpan,<br><b>' . $ign . ' data duplikat</b> tidak ikut dimasukkan...');

		$s = un_de($search);
		$s['modex'] = 'excel_impor';
		redirect($o['module'] . $o['inti'] . '/' . in_de($s) . '/' . $offset);
	}

	function hapus_data($o = null, $offset = null)
	{

		$cek = $this->input->post('cek');

		foreach ($cek as $c) {
			$this->general_model->delete_data((isset($o['tabel_save']) and !is_array($o['tabel'])) ? $o['tabel_save'] : $o['tabel'], $o['id'], $c);
		}
		$this->session->set_flashdata('ok', 'Data ' . $o['title'] . ' berhasil dihapus ...');

		redirect($o['module'] . $o['inti'] . '/' . in_de(array('search' => $o['search'], 'modex' => 'list_data')) . '/' . $offset);
	}

	function combo_unit($id)
	{
		$data_comb = $this->general_model->combo_box(array(
			'tabel' => array('ref_bidang' => ''),
			'key' => 'id_bidang', 'val' => array('nama_bidang'),
			'where' => array('id_unit' => $id, '(aktif IS NULL or aktif = 1)' => null)
		));
		$combo = null;
		foreach ($data_comb as $k => $v) {
			$combo .= '<option value="' . $k . '">' . $v . '</option>';
		}
		echo $combo;
	}

	function ajax_bidang($id)
	{

		$res = $this->general_model->datagrab(array(
			'tabel' => 'ref_bidang',
			'where' => array('id_unit' => $id),
			'search' => array('nama_bidang' => $this->input->post('q')),
			'select' => 'id_bidang id,nama_bidang data',
			'limit' => 10, 'offset' => 0
		));

		die(json_encode($res->result()));
	}
}

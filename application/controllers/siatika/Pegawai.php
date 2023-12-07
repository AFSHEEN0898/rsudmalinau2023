<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends CI_Controller
{

	var $folder = 'siatika';
	var $dir = 'siatika/pegawai';
	var $kelola;
	var $arsip;
	var $drh;
	var $status;
	var $judul = 'Data Dasar';
	var $extended;
	var $basis = array(
		'nip_lama',
		'jenis_kelamin',
		'gelar',
		'lahir',
		'kawin',
		'agama',
		'nik',
		'npwp',
		'foto'
	);

	function __construct()
	{

		parent::__construct();
		login_check($this->session->userdata('login_state'));

		$this->kelola = $this->cr('PEG50');
		$this->arsip = FALSE;
		$this->drh = TRUE;
		$this->status = TRUE;
		$this->extended = TRUE;
	}

	public function index()
	{
		$this->list_pegawai();
	}

	function in_app()
	{

		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi', 'where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
	}

	function cr($e)
	{
		return $this->general_model->check_role($this->session->userdata('id_pegawai'), $e);
	}


	function list_pegawai($status = 1, $search = null, $offset = null)
	{
		$id_operator = $this->session->userdata('id_pegawai');
		$in = $this->input->post();
		if ($status == null) {
			// if ($this->general_model->check_role($this->session->userdata('id_pegawai'),'PEG51')) $tb = 1;
			// else $tb = 3;
			$status = 1;
		}
		if (@$_POST['key'] != '') {
			$key = $_POST['key'];
			$this->session->set_userdata('kunci', $key);
		} else {
			if ($offset != '') $key = $this->session->userdata('kunci');
			else $this->session->unset_userdata('kunci');
			$key = '';
		}
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama'         => $search_key,
				'nip'       => $search_key,
			);
			$data['for_search'] = $fcari['nama'];
			$data['for_search'] = $fcari['nip'];
		} else if ($search) {
			$fcari = array(
				'nama'         => @un_de($search),
				'nip'       => @un_de($search),
			);
			$data['for_search'] = $fcari['nama'];
			$data['for_search'] = $fcari['nip'];
		}
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
		$select = 'a.*,a.alamat as lamat,h.tipe,h.nama_status,d.nama_jabatan,c.nama_bidang,b.unit,f.jenis_kelamin';

		if ($status == 1) {
			$where = array('h.tipe = 1  AND a.id_status_pegawai !=0' => NULL);
		} else {
			$where = array('h.tipe != 1 AND a.id_status_pegawai !=0' => NULL);
		}
		$where1 = array('h.tipe = 1 AND a.id_status_pegawai !=0' => NULL);
		$where2 = array('h.tipe != 1 AND a.id_status_pegawai !=0' => NULL);

		$config['base_url'] = site_url($this->dir . '/list_pegawai/' . $status);
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'a.id_pegawai DESC', 'select' => $select, 'search' => $fcari, 'where' => $where,))->num_rows();
		$total = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'a.id_pegawai DESC', 'select' => $select, 'search' => $fcari, 'where' => $where1))->num_rows();
		$total_sampah = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'a.id_pegawai DESC', 'select' => $select, 'search' => $fcari, 'where' => $where2))->num_rows();
		$data['total']  = $config['total_rows'];
		$config['per_page']     = '10';
		$config['uri_segment']  = '6';
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$st = get_stationer();

		$data_article = $this->general_model->datagrabs(array('tabel' => $from, 'order' => 'a.id_pegawai DESC', 'select' => $select, 'where' => $where, 'limit' => $lim, 'offset' => $offs, 'search' => $fcari));
		// cek($this->db->last_query());
		if ($data_article->num_rows() > 0) {
			$this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed table-nonfluid" id="tbl_data">'));


			$this->table->set_heading(
				array('data' => 'No', 'width' => '20', 'style' => 'text-align:center'),
				array('data' => 'Nama/NIP', 'style' => 'text-align:center'),
				array('data' => 'Status ', 'style' => 'text-align:center'),
				array('data' => 'Jabatan', 'style' => 'text-align:center'),
				array('data' => 'Unit Organisasi', 'style' => 'text-align:center'),
				array('data' => 'Unit Kerja', 'style' => 'text-align:center'),
				array('data' => 'Jenis Kelamin', 'style' => 'text-align:center'),
				array('data' => 'TTL', 'style' => 'text-align:center'),
				array('data' => 'Alamat', 'style' => 'text-align:center'),
				array('data' => 'Aksi', 'width' => '70', 'style' => 'text-align:center', 'colspan' => 2)
			);
			$bln = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
			$no = 1 + floatval($offset);
			foreach ($data_article->result() as $row) {
				// cek($row);

				$res_edit = anchor($this->folder . '/pegawai/form_add/' . $row->id_pegawai . '/' . $status, '<i class="fa fa-pen"></i>', 'class="btn btn-warning btn-xs"');
				$statusx = anchor(site_url($this->dir . '/aktif/' . $row->id_pegawai . '/' . $status), '<i class="fa fa-power-off">&nbsp;&nbsp;Tidak Tampil</i>', 'class="btn btn-xs btn-default"');
				$res_del = ' <a class="btn btn-xs btn-flat btn-danger btn-delete" href="#" act="' . site_url($this->dir . '/delete_pegawai/' . $row->id_pegawai) . '" title="Buang' . $row->nama . '" msg="Apakah anda yakin ingin membuang data ini ?"><i class="fa fa-trash"></i></a>';
				$cont = '';
				$this->table->add_row(
					array('style' => 'text-align:center', 'data' => $no),
					$row->nama . '<br>' . $row->nip,
					$row->nama_status,
					$row->nama_jabatan,
					$row->nama_bidang,
					$row->unit,
					$row->jenis_kelamin,
					$row->tempat_lahir . '<br>' . tanggal($row->tanggal_lahir),
					$row->lamat,
					array(
						'style' => 'text-align:center',
						'data'    => $res_edit
					),
					array(
						'style' => 'text-align:center',
						'data'    => $res_del
					)
				);
				$no++;
			}
			$tabel = '<div class="table-responsive">' . $this->table->generate() . '</div>';
		} else {
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}


		$btn_tambah = anchor($this->folder . '/pegawai/form_add', '<i class="fa fa-plus-square fa-btn"></i>&nbsp;  Pegawai Baru', 'class="btn btn-success"');
		if (($data_article->num_rows() > 0) && ($status == 1 || $status == null)) {
			$btn_cetak =
				'<div class="btn-group" style="margin-left: 5px;">
                <a class="btn btn-warning dropdown-toggle " data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
                <i class="fa fa-print"></i> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu pull-right">
                <li class="dropdown-item">' . anchor($this->dir . '/list_pegawai/' . @$status . '/cetak/' . @$id . '/' . in_de($search_key) . '', '<i class="fa fa-print"></i> Cetak', 'target="_blank"') . '</li>
                <li class="dropdown-item">' . anchor($this->dir . '/list_pegawai/' . @$status . '/excel/' . @$id . '/' . in_de($search_key) . '', '<i class="fa fa-file-excel"></i> Excel', 'target="_blank"') . '</li>
                </ul>
                </div>';
		}
		$data['extra_tombol'] =
			form_open($this->dir . '/list_pegawai/', 'id="form_search" role="form"') .
			'<div class="input-group">
                    <input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="' . @$search_key . '">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div>' .
			form_close();
		$data['tombol'] = $btn_tambah . ' ' . @$btn_cetak;
		$title = 'Data Pegawai';
		if ($offset == "cetak") {
			$data['title'] = '<h3>' . $title . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print', $data);
		} else if ($offset == "excel") {
			$data['file_name'] = $title . '.xls';
			$data['title'] = '<h3>' . $data['title'] . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel', $data);
		} else {
			$data['title']      = $title;
			if ($status == 1) {
				$tab1 = array('text' => 'Pegawai Aktif (' . $total . ')', 'on' => 1);
				$tab2 = array('text' => 'Pegawai Non Aktif (' . $total_sampah . ')', 'on' => null, 'url' => site_url($this->dir . '/list_pegawai/0'), 'style' => 'background:red;');
			} else {
				$tab1 = array('text' => 'Pegawai Aktif (' . $total . ')', 'on' => null, 'url' => site_url($this->dir . '/list_pegawai/1'), 'style' => 'background:green;');
				$tab2 = array('text' => 'Pegawai Non Aktif (' . $total_sampah . ')', 'on' => 1);
			}

			$data['title']      = $title;
			$data['tabs'] = array($tab1, $tab2);
			$data['tabel'] = $tabel;

			$data['content'] = 'umum/standard_view';
			$this->load->view('home', $data);
		}
	}

	function form_add($id = null, $status = null)
	{

		$data['breadcrumb'] = array('' => $this->in_app(), $this->folder . '/pegawai/form_add/' . $id => 'Formulir ' . $this->judul);
		$data['dir'] = $this->dir;
		$sk = $this->general_model->get_param('peg_suku');

		$select = 'p.*,l.nama_jabatan,klrh.eselon,m.*,n.*';
		if (!empty($sk) and $sk == 1) {

			$from = array(
				'peg_pegawai p' => '',
				'ref_unit sk' => array('sk.id_unit = p.id_unit', 'left'),
				'ref_bidang ad' => array('ad.id_bidang = p.id_bidang', 'left')
			);
			$select .= ',sk.unit,ad.nama_bidang';
		} else {

			$from = array('peg_pegawai p' => '');
		}

		$from = array_merge_recursive(
			$from,
			array(
				'ref_jabatan l' => array('l.id_jabatan = p.id_jabatan', 'left'),
				'ref_jenis_kelamin m' => array('m.id_jeniskelamin = p.id_jeniskelamin', 'left'),
				'ref_agama n' => array('n.id_agama = p.id_agama', 'left'),
				'ref_eselon klrh' => array('klrh.id_eselon = p.id_eselon', 'left')
			)
		);

		$data['row'] = !empty($id) ? $this->general_model->datagrab(array(
			'tabel' => $from,
			'select' => $select,
			'where' => array('p.id_pegawai' => $id)
		))->row() : null;

		if (in_array('jenis_kelamin', $this->basis)) $data['combo_gender'] = $this->general_model->combo_box(array('tabel' => 'ref_jenis_kelamin', 'key' => 'id_jeniskelamin', 'val' => array('jenis_kelamin')));
		if (in_array('kawin', $this->basis)) $data['combo_kawin'] = $this->general_model->combo_box(array('tabel' => 'ref_status_kawin', 'key' => 'id_statuskawin', 'val' => array('statuskawin')));
		if (in_array('agama', $this->basis)) $data['combo_agama'] = $this->general_model->combo_box(array('tabel' => 'ref_agama', 'key' => 'id_agama', 'val' => array('agama'), 'order' => 'id_agama'));


		$data['combo_unit'] = $this->general_model->combo_box(array('tabel' => 'ref_unit', 'key' => 'id_unit', 'val' => array('unit')));
		$data['combo_bidang'] = $this->general_model->combo_box(array('tabel' => 'ref_bidang', 'key' => 'id_bidang', 'val' => array('nama_bidang')));
		$data['combo_jabatan'] = $this->general_model->combo_box(array('tabel' => 'ref_jabatan', 'key' => 'id_jabatan', 'val' => array('nama_jabatan')));
		$data['combo_eselon'] = $this->general_model->combo_box(array('tabel' => 'ref_eselon', 'key' => 'id_eselon', 'val' => array('eselon')));
		$data['combo_golru'] = $this->general_model->combo_box(array('tabel' => 'ref_golru', 'key' => 'id_golru', 'val' => array('golongan')));
		$data['combo_status_pegawai'] = $this->general_model->combo_box(array('tabel' => 'ref_status_pegawai', 'key' => 'id_status_pegawai', 'val' => array('nama_status')));



		$data['dir'] = $this->uri->segment(1);
		$data['extended'] = $this->extended;
		$data['basis'] = $this->basis;

		$data['title'] = !empty($id) ? 'Ubah ' . $this->judul : 'Tambah ' . $this->judul;
		$data['content']     = $this->folder . "/datadasar_form";
		$this->load->view('home', $data);
	}

	function combo_kab($id)
	{
		$dat = $this->general_model->datagrab(array('tabel' => 'ref_bidang', 'where' => array('id_unit' => $id)));
		$ret = '<option value=""> -- Pilih Bidang --</option>';
		foreach ($dat->result() as $row) {
			$ret .= '<option value="' . $row->id_bidang . '">' . $row->nama_bidang . '</option>';
		}
		echo $ret;
	}

	function cek_status($id)
	{
		$dt = $this->general_model->datagrab(array('tabel' => 'ref_status_pegawai',  'where' => array('id_status_pegawai' => $id)))->row();

		$data = array(
			'id' => $dt->id_status_pegawai,
			'text' => $dt->nama_status,
		);
		echo json_encode($data);
	}
	function auto_lokasi()
	{
		$q = $this->input->get('query');

		$res = $this->general_model->datagrab(array(
			'tabel' => 'ref_lokasi',
			'search' => array('lokasi' => $q),
			'select' => 'id_jabatan as id, lokasi',
			'limit' => 10, 'offset' => 0
		));

		die(json_encode($res->result()));
	}

	function save_pegawai()
	{
		if (@$this->input->post('id_unit') == NULL) {
			/*propinsi kosong, lalu cek post manualnya*/
			if (@$this->input->post('unit') != NULL) {
				/*cek propinsi*/
				$cek_pro = $this->general_model->datagrab(array('tabel' => 'ref_unit', 'select' => 'id_unit', 'where' => array('unit' => $this->input->post('unit'))));
				if ($cek_pro->num_rows() > 0) {
					$id_unit = $cek_pro->row('id_unit');
				} else {
					$par_pro = array('propinsi' => $this->input->post('mn_propinsi'));
					$sev_pro = $this->general_model->save_data('unit', $par_pro);
					$id_unit = $sev_pro;
				}
			} else {
				$id_unit = '0';
			}
		} else {
			$id_unit = $this->input->post('id_unit');
		}

		if (@$this->input->post('id_bidang') == NULL) {
			/*kabupaten kosong, lalu cek post manualnya*/
			if (@$this->input->post('nama_bidang') != NULL) {
				/*cek kabupaten*/
				$cek_kab = $this->general_model->datagrab(array(
					'tabel' => 'ref_bidang', 'select' => 'id_bidang',
					'where' => array('nama_bidang' => $this->input->post('nama_bidang'), 'id_unit' => $propinsi)
				));
				if ($cek_kab->num_rows() > 0) {
					$id_bidang = $cek_kab->row('id_bidang');
				} else {
					$par_kab = array('nama_bidang' => $this->input->post('nama_bidang'), 'id_unit' => $propinsi);
					$sev_kab = $this->general_model->save_data('ref_bidang', $par_kab);
					$id_bidang = $sev_kab;
				}
			} else {
				$id_bidang = '0';
			}
		} else {
			$id_bidang = $this->input->post('id_bidang');
		}

		$tmp = (!empty($_FILES['berkas']['tmp_name'])) ? $_FILES['berkas']['tmp_name'] : null;
		$pasfoto = $_FILES['foto']['tmp_name'];

		$id_pegawai    = $this->input->post('id_pegawai');
		$id_e = $id_pegawai;

		$ruang = $this->input->post('pil_ruang');
		$lemari = $this->input->post('pil_lemari');
		$rak = $this->input->post('pil_rak');
		$map = $this->input->post('pil_map');

		$nip = $this->input->post('nip');

		$mkg_tahun = $this->input->post('mkg_tahun');
		$mkg_bulan = $this->input->post('mkg_bulan');

		$tempat_lahir = $this->input->post('tempat_lahir');

		/* check NIP */
		$where = array('nip' => $nip);
		if (!empty($id_pegawai)) $where['id_pegawai !='] = $id_pegawai;

		$cek = $this->general_model->datagrab(array('tabel' => 'peg_pegawai', 'where' => $where));
		$id_red = null;
		if ($cek->num_rows() > 0) {
			$this->session->set_flashdata('fail', 'NIP tidak boleh dobel');
		} else {

			/* -- Tempat Lahir -- */

			// $c_tempat = $this->general_model->datagrab(array(
			// 	'tabel' => 'ref_lokasi', 'where' => array('lokasi' => @$tmpt), 'select' => 'count(id_lokasi) as jml,id_lokasi', 'group_by' => 'id_lokasi'
			// ))->row();
			// if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => @$tmpt));
			// else $id_tmpt = $c_tempat->id_lokasi;

			$nipp = !empty($nip) ? $nip : $this->input->post('nip_lama');


			$jns_kelamin = $this->input->post('id_jeniskelamin');
			$id_agama = $this->input->post('id_agama');
			$sts_kawin = $this->input->post('id_statuskawin');
			$gol_darah = $this->input->post('id_gol_darah');
			$tinggi = $this->input->post('tinggi');
			$berat = $this->input->post('berat');
			
			$simpan = array(
				'nip' => $nipp,
				'id_unit' => $id_unit,
				'id_bidang' => $id_bidang,
				'id_jabatan' => $this->input->post('id_jabatan'),
				'id_eselon' => $this->input->post('id_eselon'),
				'id_golru' => (!empty($this->input->post('id_golru'))) ? $this->input->post('id_golru') : null,
				'id_status_pegawai' => $this->input->post('id_status_pegawai'),
				'nip_lama' => $this->input->post('nip_lama'),
				'nama' => $this->input->post('nama'),
				'id_tipe_pegawai' => $this->input->post('id_tipe_pegawai'),
				'gelar_depan' => $this->input->post('gelar_depan'),
				'gelar_belakang' => $this->input->post('gelar_belakang'),
				'id_agama' => ($id_agama != NULL ? $id_agama : 0),
				'id_jeniskelamin' => ($jns_kelamin != NULL ? $jns_kelamin : 0),
				'id_statuskawin' => ($sts_kawin != NULL ? $sts_kawin : 0),
				'tempat_lahir' => ($tempat_lahir != NULL ? $tempat_lahir : 0),
				'tanggal_lahir' => tanggal_php($this->input->post('tanggal_lahir')),
				'hobi' => $this->input->post('hobi'),
				'id_gol_darah' => ($gol_darah != NULL ? $gol_darah : 0),
				'tinggi' => ($tinggi != NULL ? $tinggi : 0),
				'berat' => ($berat != NULL ? $berat : 0),
				'rambut' => $this->input->post('rambut'),
				'bentuk_muka' => $this->input->post('bentuk_muka'),
				'warna_kulit' => $this->input->post('warna_kulit'),
				'ciri_khas' => $this->input->post('ciri_khas'),
				'cacat' => $this->input->post('cacat'),
				'alamat' => $this->input->post('alamat'),
				// 'id_kelurahan' => ($kelurahan != NULL ? $kelurahan : 0),
				'kodepos' => $this->input->post('kodepos'),
				'telepon' => $this->input->post('telepon'),
				'email' => $this->input->post('email'),
				'pin' => $this->input->post('pin'),
				'website' => $this->input->post('website'),
				'cpns_berkas' => (!empty($ruang) and !empty($lemari) and !empty($rak) and !empty($map)) ? $this->input->post('cpns_berkas') : null,
				'cpns_no' => $this->input->post('cpns_no'),
				'cpns_tanggal' => tanggal_php($this->input->post('cpns_tanggal')),
				'cpns_tmt' => tanggal_php($this->input->post('cpns_tmt')),
				'status' => 1
			);

			$sk = $this->general_model->get_param('peg_suku');

			if (!empty($sk) and $sk == 1) {

				$id_suku = $this->input->post('id_suku');
				$id_wildat = $this->input->post('id_wilayah_adat');
				$id_pemdat = $this->input->post('id_pemerintah_adat');
				$inp_suku = $this->input->post('suku');
				$inp_wildat = $this->input->post('wildat');
				$inp_pemdat = $this->input->post('pemdat');

				if ($inp_suku != NULL and $id_suku == NULL) {
					/* -- Suku -- */
					$c_suku = $this->general_model->datagrab(array('tabel' => 'ref_suku', 'where' => array('UPPER(suku)' => strtoupper($inp_suku)), 'select' => 'count(id_suku) as jml,id_suku'))->row();
					if (empty($c_suku->jml)) $id_suku  = $this->general_model->save_data('ref_suku', array('suku' => $inp_suku));
					else $id_suku = $c_suku->id_suku;
				}

				if ($inp_wildat != NULL and $id_wildat == NULL) {
					/* -- Wilayah Adat -- */
					$c_wildat = $this->general_model->datagrab(array('tabel' => 'ref_wilayah_adat', 'where' => array('UPPER(wilayah_adat)' => strtoupper($inp_wildat)), 'select' => 'count(id_wilayah_adat) as jml,id_wilayah_adat'))->row();
					if (empty($c_wildat->jml)) $id_wildat  = $this->general_model->save_data('ref_wilayah_adat', array('wilayah_adat' => $inp_wildat));
					else $id_wildat = $c_wildat->id_wilayah_adat;
				}

				if ($inp_pemdat != NULL and $id_pemdat == NULL) {
					/* -- Pemerintah Adat -- */
					$c_pemdat = $this->general_model->datagrab(array('tabel' => 'ref_pemerintah_adat', 'where' => array('UPPER(wilayah_adat)' => strtoupper($inp_pemdat)), 'select' => 'count(id_wilayah_adat) as jml,id_wilayah_adat'))->row();
					$cont_pemdat = array('wilayah_adat' => $inp_pemdat);
					if ($id_wildat != NULL) $cont_pemdat['id_pemerintah_adat'] = $id_wilayah_adat;
					if (empty($c_pemdat->jml)) $id_pemdat  = $this->general_model->save_data('ref_pemerintah_adat', $cont_pemdat);
					else $id_pemdat = $c_pemdat->id_wilayah_adat;
				}

				$simpan = array_merge_recursive(
					$simpan,

					array(
						'id_suku' => $id_suku,
						'id_wilayah_adat' => $id_wildat,
						'id_pemerintah_adat' => $id_pemdat,
						'papua' => $this->input->post('papua')
					)

				);
			}

			if (!empty($mkg_tahun)) $simpan['mkg_tahun'] = $mkg_tahun;
			if (!empty($mkg_bulan)) $simpan['mkg_bulan'] = $mkg_bulan;

			if (!empty($tmp)) {

				if (!empty($id_pegawai)) {
					$file = $this->general_model->datagrab(array('tabel' => 'peg_pegawai', 'where' => array('id_pegawai' => $id_pegawai), 'select' => 'nip, berkas_simpan'))->row();
					$location = './uploads/berkas/' . $file->nip . '/' . $file->berkas_simpan;
					if (file_exists($location)) unlink($location);
					$nip = $file->nip;
				}

				$path = './uploads/berkas/' . $nip;
				if (!is_dir($path)) mkdir($path, 0777, TRUE);

				$file = renameFile($_FILES['berkas']['name']);

				if (!file_exists('./uploads/berkas/' . $nip . '/' . $file)) {
					$config['upload_path']    = './uploads/berkas/' . $nip . '/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|word';

					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('berkas');
				}

				$simpan['berkas_simpan'] = $file;
			}


			if (!empty($pasfoto)) {

				$path = './uploads/kepegawaian/pasfoto';
				if (!is_dir($path)) mkdir($path, 0777, TRUE);

				if (!empty($id_pegawai)) {

					$prev = $this->input->post('foto_prev');
					$path_pasfoto = $path . '/' . $prev;
					if (file_exists($path_pasfoto)) unlink($path_pasfoto);
				}

				$nama_file   = $nip . '.jpg';

				if (!file_exists($path . '/' . $nama_file)) {

					$this->load->library('upload');

					$this->upload->initialize(array(
						'upload_path' => $path,
						'allowed_types' => 'jpg|jpeg|png|gif|pdf|word',
						'file_name' => $nama_file
					));
					$this->upload->do_upload('foto');
				}

				$simpan['photo'] = $nama_file;
			}

			if (!empty($id_pegawai)) {

				if ($this->input->post('nip_sebelum') != $nipp) {
					$pesan = '
                Data pegawai berhasil disimpan<br>Akun kembali di pulihkan ke NIP karena perubahan NIP...<br><br>
                Akun : <b>' . $nip . '</b>, Password: <b>' . $nip . '</b>';
					$simpan['username'] = $nipp;
				} else {
					$pesan = 'Ubah Data pegawai berhasil dilakukan';
				}
			} else {
				$simpan['username'] = $nipp;
				$simpan['password'] = md5($nipp);
				$pesan = 'Data pegawai berhasil disimpan...<br><br>Akun masuk : <b>' . $nip . '</b>, password: <b>' . $nip . '</b>';
			}

			$save = $this->general_model->save_data('peg_pegawai', $simpan, 'id_pegawai', $id_pegawai);

			$id_red = (!empty($id_pegawai)) ? $id_pegawai : $this->db->insert_id();

			$op = $this->session->userdata('id_pegawai');

			$e = array(
				'op' => $op,
				'date_act' => date('Y-m-d H:i:s'),
				'kode' => 'datainduk',
				'action' => !empty($id_e) ? 2 : 1,
				'kait' => $id_red
			);

			$this->general_model->save_data('log_book', $e);
			$this->session->set_flashdata('ok', $pesan);
		}
		redirect($this->folder . '/pegawai/form_add/' . $id_red);
	}

	function drh($id, $cetak = null)
	{

		$data['breadcrumb'] = array('' => 'siatika', $this->folder . '/pegawai/drh/' . $id => 'DRH');
		$sk = $this->general_model->get_param('peg_suku');
		$data['title'] = 'Daftar Riwayat Hidup';

		$red_kelurahan = $this->general_model->get_param('red_kelurahan');
		$red_kecamatan = $this->general_model->get_param('red_kecamatan');

		$data['cetak'] = $cetak;

		$this->table->set_template(array('table_open' => '<table class="tabel_non_border">'));

		$this->table->add_row(
			array('data' => '<p>ANAK LAMPIRAN</p>', 'rowspan' => 3, 'valign' => 'top', 'style' => 'padding-right: 20px'),
			array('data' => '<p class="no-wrap">KEPUTUSAN KEPALA BADAN KEPEGAWAIAN NEGARA</p>', 'colspan' => '2')
		);
		$this->table->add_row('<p>NOMOR</p>', '<p> : 11 TAHUN 2002</p>');
		$this->table->add_row('<p>TANGGAL</p>', '<p> : 17 JUNI 2002</p>');

		$data['tabel_uu'] = $this->table->generate();

		$from_dasar = array(
			'peg_pegawai p' => '',
			'ref_lokasi l' => array('l.id_lokasi = p.id_tempat_lahir', 'left'),
			'ref_jenis_kelamin k' => array('k.id_jeniskelamin = p.id_jeniskelamin', 'left'),
			'ref_gol_darah gol' => array('gol.id_gol_darah = p.id_gol_darah', 'left'),
			'ref_agama ag' => array('ag.id_agama = p.id_agama', 'left'),
			'ref_kelurahan klrh' => array('klrh.id_kelurahan = p.id_kelurahan', 'left'),
			'ref_kecamatan kec' => array('kec.id_kecamatan = klrh.id_kecamatan', 'left'),
			'ref_kabupaten kab' => array('kab.id_kabupaten = kec.id_kabupaten', 'left'),
			'ref_propinsi prop' => array('prop.id_propinsi = kab.id_propinsi', 'left'),
			'ref_status_kawin kw' => array('kw.id_statuskawin = p.id_statuskawin', 'left')
		);

		if (!empty($sk) and $sk == 1) {

			$from_dasar = array_merge_recursive(
				$from_dasar,
				array(
					'ref_suku sk' => array('sk.id_suku = p.id_suku', 'left'),
					'ref_wilayah_adat ad' => array('ad.id_wilayah_adat = p.id_wilayah_adat', 'left')
				)
			);
		}

		$select_dasar = '
            p.id_pegawai,
            concat(ifnull(p.gelar_depan,"")," ",p.nama,if(((p.gelar_belakang = "") or isnull(p.gelar_belakang)),"",concat(" ",p.gelar_belakang))) AS nama_pegawai,
            p.tanggal_lahir,p.nip,p.photo,p.alamat,p.rambut,p.ciri_khas,p.cacat,p.warna_kulit,p.bentuk_muka,p.tinggi,p.berat,
            p.telepon,p.email,p.pin,
            l.lokasi as tempat_lahir,
            k.jenis_kelamin,
            gol.gol_darah,
            ag.agama,
            IF(klrh.jenis = "1",CONCAT("Kelurahan ",klrh.kelurahan),(IF(klrh.jenis = "2",CONCAT("Desa ",klrh.kelurahan),CONCAT("Kampung ",klrh.kelurahan)))) kelurahan,
            kec.kecamatan,
            kab.kabupaten,
            prop.propinsi,
            kw.statuskawin as kawin';

		if (!empty($sk) and $sk == 1) {
			$select_dasar .= ' ,IF(p.papua = 1,"Papua","Non Papua") papua_nonpapua,sk.suku,ad.wilayah_adat';
		}

		$peg = $this->general_model->datagrab(array(
			'tabel' => $from_dasar,
			'select' => $select_dasar,
			'where' => array('id_pegawai' => $id)
		))->row();

		$gol = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_pangkat p' => '',
				'ref_golru g' => 'g.id_golru = p.id_golru'
			),
			'select' => 'g.golongan,g.pangkat',
			'where' => array(
				'p.id_pegawai' => $id,
				'p.status' => 1
			)
		))->row();

		$golru = !empty($gol->golongan) ? $gol->golongan . ' - ' . $gol->pangkat : null;
		$data['link_cetak'] = $this->folder . '/pegawai/drh/' . $peg->id_pegawai;

		$classy = (isset($cetak) and $cetak == "excel") ? '' : 'class="tabel_non_border"';

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));

		$no_dasar = 0;

		$pembuat = '( ' . $peg->nama_pegawai . ' )<br>NIP.' . $peg->nip;
		$this->table->add_row(
			array('data' => ($no_dasar += 1) . '.', 'width' => 25),
			'Nama Lengkap',
			array('data' => ':', 'width' => 10),
			$peg->nama_pegawai
		);
		$this->table->add_row(($no_dasar += 1) . '.', 'NIP', ' : ', array('data' => $peg->nip . '&nbsp; ', 'colspan' => 10));
		$this->table->add_row(($no_dasar += 1) . '.', 'Pangkat & Golongan Ruang', ':', array('data' => $golru, 'colspan' => 10));
		$this->table->add_row(($no_dasar += 1) . '.', 'Tempat / Tanggal Lahir', ':', array('data' => $peg->tempat_lahir . ', ' . tanggal($peg->tanggal_lahir), 'colspan' => 10));
		$this->table->add_row(($no_dasar += 1) . '.', 'Jenis Kelamin', ':', array('data' => $peg->jenis_kelamin, 'colspan' => 10));
		$this->table->add_row(($no_dasar += 1) . '.', 'Agama', ':', array('data' => $peg->agama, 'colspan' => 10));
		$this->table->add_row(($no_dasar += 1) . '.', 'Status Perkawinan', ':', array('data' => $peg->kawin, 'colspan' => 10));
		$this->table->add_row(($no_dasar += 1) . '.', 'Alamat Lengkap', '', '');
		$this->table->add_row('    ', 'Alamat', ': ', array('data' => $peg->alamat, 'colspan' => 10));
		$this->table->add_row('    ', (!empty($red_kelurahan) ? $red_kelurahan : ''), ': ', array('data' => $peg->kelurahan, 'colspan' => 10));
		$this->table->add_row('    ', (!empty($red_kecamatan) ? $red_kecamatan : ''), ': ', array('data' => $peg->kecamatan, 'colspan' => 10));
		$this->table->add_row('    ', 'Kabupaten', ': ', array('data' => $peg->kabupaten, 'colspan' => 10));
		$this->table->add_row('    ', 'Provinsi', ': ', array('data' => $peg->propinsi, 'colspan' => 10));
		$this->table->add_row('    ', 'No Telepon', ': ', array('data' => $peg->telepon, 'colspan' => 10));
		$this->table->add_row('    ', 'Email', ':', array('data' => $peg->email, 'colspan' => 10));
		$this->table->add_row('    ', 'PIN', ':', array('data' => $peg->pin, 'colspan' => 10));
		$this->table->add_row(($no_dasar += 1) . '.', 'Keterangan Badan', '', '');
		$this->table->add_row('    ', 'Golongan Darah', ':', array('data' => $peg->gol_darah, 'colspan' => 10));
		$this->table->add_row('    ', 'Tinggi Badan (cm)', ':', array('data' => !empty($peg->tinggi) ? $peg->tinggi . ' cm' : '-', 'colspan' => 10));
		$this->table->add_row('    ', 'Berat Badan (kg)', ':', array('data' => !empty($peg->berat) ? $peg->berat . ' kg' : '-', 'colspan' => 10));
		$this->table->add_row('    ', 'Rambut', ':', array('data' => $peg->rambut, 'colspan' => 10));
		$this->table->add_row('    ', 'Bentuk Wajah', ':', array('data' => $peg->bentuk_muka, 'colspan' => 10));
		$this->table->add_row('    ', 'Warna Kulit', ':', array('data' => $peg->warna_kulit, 'colspan' => 10));
		$this->table->add_row('    ', 'Ciri Khas', ':', array('data' => $peg->ciri_khas, 'colspan' => 10));
		$this->table->add_row('    ', 'Cacat Tubuh', ':', array('data' => $peg->cacat, 'colspan' => 10));
		//$this->table->add_row(($no_dasar+=1).'.','Hobi / Kegemaran',':',$peg->hobi);


		if (!empty($sk) and $sk == 1) {

			$this->table->add_row(($no_dasar += 1) . '.', 'Suku dan Wilayah Adat', '', '');
			$this->table->add_row('    ', 'Papua/Non Papua', ':', array('data' => $peg->papua_nonpapua, 'colspan' => 10));
			$this->table->add_row('    ', 'Suku', ':', array('data' => $peg->suku, 'colspan' => 10));
			$this->table->add_row('    ', 'Wilayah Adat', ':', array('data' => $peg->wilayah_adat, 'colspan' => 10));
		}

		$data['foto'] = $peg->photo;

		$folder = $this->session->userdata('aplikasi');
		$data['dir'] = $folder[$this->uri->segment(1)]['direktori'];

		$data['tabel_dasar'] = $this->table->generate();

		/* -- Riwayat Pangkat -- */
		$classy = (isset($cetak) and $cetak == "excel") ? 'border=1' : 'class="tabel_print"';

		$pangkat = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_pangkat p' => '',
				'ref_penetap pe' => array('pe.id_penetap = p.id_penetap', 'left'),
				'ref_golru g' => array('g.id_golru = p.id_golru', 'left'),
				'ref_golru_jenis j' => array('j.id_golru_jenis = p.id_golru_jenis', 'left')
			),
			'select' => 'p.*,g.golongan,g.pangkat,j.golru_jenis, pe.penetap as pejabat',
			'order' => 'p.tmt_pangkat',
			'where' => array('p.id_pegawai' => $id), 'order' => 'tmt_pangkat'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'rowspan' => 2, 'class' => 'add_th', 'width' => 10),
			array('data' => 'PANGKAT', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'GOL RUANG PENGGAJIAN', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'BERLAKU TERHITUNG MULAI TANGGAL', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'GAJI POKOK', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'SURAT KEPUTUSAN', 'colspan' => 3, 'class' => 'add_th'),
			array('data' => 'PERATURAN YANG DIJADIKAN DASAR', 'rowspan' => 2, 'class' => 'add_th')
		);

		$this->table->add_row(
			array('data' => 'PEJABAT', 'class' => 'add_th'),
			array('data' => 'NOMOR', 'class' => 'add_th'),
			array('data' => 'TANGGAL', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 9; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($pangkat->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->pangkat,
				$row->golongan,
				tanggal($row->tmt_pangkat),
				array('data' => numberToCurrency($row->gaji_pokok), 'style' => 'text-align: right'),
				$row->pejabat,
				$row->no_sk,
				tanggal($row->tgl_sk),
				$row->nota_persetujuan_nomor
			);
			$no += 1;
		}

		$data['tabel_pangkat'] = $this->table->generate();


		/* -- Riwayat Pendidikan Informal/Kursus-- */

		$pend_informal = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_informal i' => '',
				'ref_lokasi lo' => array('lo.id_lokasi = i.tempat', 'left'),
				'ref_diklatteknis t' => 't.id_diklatteknis = i.id_diklatteknis',
				'ref_lembaga l' => array('l.id_lembaga = i.id_lembaga', 'left')
			),
			'select'     => 'i.*,t.nama_diklat, lo.lokasi tempat, IF(i.lembaga IS NULL or i.lembaga = "",l.lembaga_pendidikan,i.lembaga) penyelenggara',
			'where'     => array('i.id_pegawai' => $id),
			'order'     => 'i.tahun'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'NAMA KURSUS LATIHAN', 'class' => 'add_th'),
			array('data' => 'LAMA', 'class' => 'add_th'),
			array('data' => 'IJAZAH/TANDA LULUS/SURAT KETERANGAN', 'class' => 'add_th'),
			array('data' => 'TEMPAT', 'class' => 'add_th'),
			array('data' => 'PENYELENGGARA', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 6; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($pend_informal->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->nama_diklat,
				array('data' => number_format($row->jam, 0), 'style' => 'text-align: center'),
				$row->no_sttpl,
				$row->tempat,
				$row->penyelenggara
			);
			$no += 1;
		}
		$data['tabel_pend_informal'] = $this->table->generate();

		/* -- Riwayat Pendidikan dan Pelatihan Kepemimpinan -- */

		$diklatpim = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_diklatpim d'    => '',
				'ref_diklatpim r'     => array('d.id_diklatpim=r.id_diklatpim', 'left'),
				'ref_lembaga l'     => array('d.id_lembaga=l.id_lembaga', 'left'),
			),
			'select'     => 'd.*,r.diklatpim,l.lembaga_pendidikan',
			'where'     => array('d.id_pegawai' => $id),
			'order'     => 'd.tanggal_sttpl'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'rowspan' => 2, 'class' => 'add_th', 'width' => 10),
			array('data' => 'NAMA DIKLAT', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'TEMPAT DAN PENYELENGGARA DIKLAT', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'ANGKATAN/TAHUN', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'LAMA PENDIDIKAN', 'rowspan' => 2, 'class' => 'add_th'),
			array('data' => 'STTPL', 'colspan' => 2, 'class' => 'add_th')
		);

		$this->table->add_row(
			array('data' => 'NOMOR', 'class' => 'add_th'),
			array('data' => 'TANGGAL', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 7; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($diklatpim->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->diklatpim,
				$row->lembaga_pendidikan,
				$row->angkatan,
				numberToCurrency($row->jam) . ' jam',
				$row->no_sttpl,
				tanggal($row->tanggal_sttpl)
			);
			$no += 1;
		}
		$data['tabel_diklatpim'] = $this->table->generate();

		/* -- Riwayat Tanda Jasa/Penghargaan -- */

		$penghargaan = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_penghargaan p'    => '',
				'ref_penghargaan r'     => array('p.id_penghargaan=r.id_penghargaan', 'left'),
			),
			'select'     => 'p.*,r.penghargaan',
			'where'     => array('p.id_pegawai' => $id),
			'order'     => 'p.tanggal_peroleh'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'NAMA BINTANG/SATYA LENCANA PENGHARGAAN', 'class' => 'add_th'),
			array('data' => 'TAHUN PEROLEHAN', 'class' => 'add_th'),
			array('data' => 'NAMA NEGARA/INSTANSI YANG MEMBERIKAN', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 4; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($penghargaan->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->penghargaan,
				tanggal($row->tanggal_peroleh),
				$row->keterangan
			);
			$no += 1;
		}
		$data['tabel_penghargaan'] = $this->table->generate();

		/* -- Suami Istri -- */

		$istri = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_perkawinan k'        => '',
				'ref_status_istri s'     => array('k.id_status_istri=s.id_status_istri', 'left'),
				'ref_bentuk_pendidikan bp'     => array('k.id_bentuk_pendidikan=bp.id_bentuk_pendidikan', 'left'),
				'ref_pekerjaan ker' => array('ker.id_pekerjaan = k.id_pekerjaan', 'left')
			),
			'select'     => '
                k.*,
                s.status_istri,
                bp.singkatan_pendidikan formal,
                ker.pekerjaan,
                IF (k.jenis IS NULL or k.jenis = 0,"",(IF(k.jenis = 1,"Istri","Suami"))) jenis',
			'where'     => array('k.id_pegawai' => $id),
			'order'     => 'k.tanggal_kawin'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'NAMA/TEMPAT TANGGAL LAHIR', 'class' => 'add_th'),
			array('data' => 'TANGGAL NIKAH', 'class' => 'add_th'),
			array('data' => 'PENDIDIKAN', 'class' => 'add_th'),
			array('data' => 'PEKERJAAN', 'class' => 'add_th'),
			array('data' => 'STATUS SAAT DINIKAHI', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 6; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($istri->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->nama_istri_suami,
				tanggal($row->tanggal_kawin),
				$row->formal,
				$row->pekerjaan,
				$row->status_istri
			);
			$no += 1;
		}
		$data['tabel_suami_istri'] = $this->table->generate();

		/* -- Anak-- */

		$tabel_anak = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_anak an' => '',
				'ref_lokasi lok' => array('lok.id_lokasi=an.id_tempat_lahir', 'left'),
				'ref_status_anak sta' => array('sta.id_statusanak=an.id_statusanak', 'left'),
				'ref_jenis_kelamin k' => array('k.id_jeniskelamin=an.id_jeniskelamin', 'left'),
				'ref_bentuk_pendidikan bp' => array('bp.id_bentuk_pendidikan=an.id_bentuk_pendidikan', 'left'),
			),
			'select' => 'CONCAT(IF(lok.lokasi IS NULL,"",CONCAT(lok.lokasi,", ")),IF(an.tgl_lahir IS NULL or an.tgl_lahir = "0000-00-00","",DATE_FORMAT(an.tgl_lahir,"%d/%m/%Y"))) as ttl,
                        an.*, lok.lokasi, k.jenis_kelamin, sta.status_anak, 
                        CONCAT(bp.singkatan_pendidikan,IF(bp.bentuk_pendidikan IS NULL or bp.bentuk_pendidikan = "","",CONCAT(" (",bp.bentuk_pendidikan,")"))) as bentuk_pendidikan',
			'where'     => array('an.id_pegawai' => $id),
			'order'     => 'an.tgl_lahir'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'NAMA', 'class' => 'add_th'),
			array('data' => 'JENIS KELAMIN', 'class' => 'add_th'),
			array('data' => 'TEMPAT/TANGGAL LAHIR', 'class' => 'add_th'),
			array('data' => 'STATUS', 'class' => 'add_th'),
			array('data' => 'ANAK KE', 'class' => 'add_th'),
			array('data' => 'PENDIDIKAN', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 7; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($tabel_anak->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->nama,
				$row->jenis_kelamin,
				$row->ttl,
				$row->status_anak,
				$row->anak_ke,
				$row->bentuk_pendidikan
			);
			$no += 1;
		}
		$data['tabel_anak'] = $this->table->generate();

		/* -- Keluarga -- */

		$tabel_keluarga = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_keluarga k'                => '',
				'ref_jenis_kelamin kl'             => array('k.id_jeniskelamin=kl.id_jeniskelamin', 'left'),
				'ref_status_keluarga sk'         => array('k.id_statuskeluarga=sk.id_statuskeluarga', 'left'),
				'ref_pekerjaan pk'                 => array('k.id_pekerjaan=pk.id_pekerjaan', 'left'),
				'ref_lokasi l'                     => array('k.id_tempat_lahir=l.id_lokasi', 'left')
			),
			'select'     => 'k.*,kl.jenis_kelamin,sk.statuskeluarga,pk.pekerjaan,l.lokasi',
			'where'     => array('k.id_pegawai' => $id),
			'order'     => 'k.tgl_lahir'
		));


		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'NAMA', 'class' => 'add_th'),
			array('data' => 'JENIS KELAMIN', 'class' => 'add_th'),
			array('data' => 'HUBUNGAN KELUARGA', 'class' => 'add_th'),
			array('data' => 'TEMPAT/TANGGAL LAHIR', 'class' => 'add_th'),
			array('data' => 'PEKERJAAN', 'class' => 'add_th'),
			array('data' => 'KETERANGAN', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 7; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($tabel_keluarga->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->nama,
				$row->jenis_kelamin,
				$row->statuskeluarga,
				$row->lokasi . ', ' . tanggal($row->tgl_lahir),
				$row->pekerjaan,
				$row->keterangan
			);
			$no += 1;
		}
		$data['tabel_keluarga'] = $this->table->generate();

		/* -- Organisasi -- */

		$tab = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_organisasi o'    => '',
			),
			'where'     => array('o.id_pegawai' => $id),
			'order'     => 'o.thn_mulai'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'NAMA ORGANISASI', 'class' => 'add_th'),
			array('data' => 'KEDUDUKAN DALAM ORGANISASI', 'class' => 'add_th'),
			array('data' => 'PERIODE (TAHUN sd TAHUN)', 'class' => 'add_th'),
			array('data' => 'TEMPAT', 'class' => 'add_th'),
			array('data' => 'PIMPINAN ORGANISASI', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 6; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);
		$no = 1;
		foreach ($tab->result() as $row) {
			$this->table->add_row(
				$no . '.',
				$row->nama_organisasi,
				$row->kedudukan_di_organisasi,
				$row->thn_mulai . ' - ' . $row->thn_selesai,
				$row->tempat,
				$row->nama_pimpinan
			);
			$no += 1;
		}
		$data['tabel_organisasi'] = $this->table->generate();

		/* -- SKP/DP3 -- */

		$hukdis = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_nilai n' => '',
				'peg_pegawai p' => array('n.id_penilai = p.id_pegawai', 'left'),
			),
			'select'     => 'n.*,ifnull(n.total, n.jumlah) total, concat(ifnull(p.gelar_depan,"")," ",p.nama,if(((p.gelar_belakang = "") or isnull(p.gelar_belakang)),"",concat(", ",p.gelar_belakang))) as nama_p, p.nip as nip_p',
			'where'     => array(
				'n.id_pegawai' => $id,
				// 'n.status' => 1
			),
			'order'     => 'n.tanggal'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'TAHUN', 'class' => 'add_th'),
			array('data' => 'PEJABAT PENILAI', 'class' => 'add_th'),
			array('data' => 'NILAI', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 4; $i++) {
			$re[] = array('data' => $i, 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($hukdis->result() as $row) {
			$this->table->add_row(
				$no . '.',
				substr($row->tanggal, 0, 4),
				$row->nama_p . '<br>NIP.' . $row->nip_p,
				numberToCurrency($row->total)
			);
			$no += 1;
		}
		$data['tabel_skp'] = $this->table->generate();

		/* -- Hukdis -- */

		$hukdis = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_hukdis h'                => '',
				'ref_hukdis rh'             => array('h.id_hukdis=rh.id_hukdis', 'left'),
				'ref_hukdis_level rhl'         => array('h.id_hukdis_level=rhl.id_hukdis_level', 'left')
			),
			'select'     => 'h.*,rh.hukdis,rhl.hukdis_level',
			'where'     => array('h.id_pegawai' => $id),
			'order'     => 'h.tmt_hukdis'
		));

		$this->table->set_template(array('table_open' => '<table ' . $classy . ' width="100%">'));
		$this->table->add_row(
			array('data' => 'NO', 'class' => 'add_th', 'width' => 10),
			array('data' => 'TAHUN', 'class' => 'add_th'),
			array('data' => 'TINGKAT HUKUMAN DISIPLIN', 'class' => 'add_th'),
			array('data' => 'JENIS HUKUMAN DISIPLIN', 'class' => 'add_th'),
			array('data' => 'KASUS', 'class' => 'add_th')
		);

		$re = array();
		for ($i = 1; $i <= 5; $i++) {
			$re[] = array('data' => '<i>' . $i . '</i>', 'class' => 'add_th');
		}
		$this->table->add_row($re);

		$no = 1;
		foreach ($hukdis->result() as $row) {
			$this->table->add_row(
				$no . '.',
				substr($row->tanggal_sk, 0, 4),
				$row->hukdis_level,
				$row->hukdis,
				$row->kasus
			);
			$no += 1;
		}
		$data['tabel_hukdis'] = $this->table->generate();


		$pendidikan = $this->general_model->datagrab(array('tabel' => 'peg_formal', 'where' => array('id_pegawai' => $id), 'order' => 'tanggal_ijazah'));
		$informal = $this->general_model->datagrab(array('tabel' => 'peg_informal', 'where' => array('id_pegawai' => $id), 'order' => 'tanggal_selesai'));
		$diklatpim = $this->general_model->datagrab(array('tabel' => 'peg_diklatpim', 'where' => array('id_pegawai' => $id), 'order' => 'tanggal_selesai'));
		$penghargaan = $this->general_model->datagrab(array('tabel' => 'peg_penghargaan', 'where' => array('id_pegawai' => $id), 'order' => 'tanggal_peroleh'));
		$kawin = $this->general_model->datagrab(array('tabel' => 'peg_perkawinan', 'where' => array('id_pegawai' => $id), 'order' => 'tanggal_kawin'));
		$anak = $this->general_model->datagrab(array('tabel' => 'peg_anak', 'where' => array('id_pegawai' => $id), 'order' => 'anak_ke'));
		$keluarga = $this->general_model->datagrab(array('tabel' => 'peg_keluarga', 'where' => array('id_pegawai' => $id)));


		if ($cetak != NULL) {
			$data['ibukota'] = $this->general_model->get_param('ibukota');
			$data['pembuat'] = $pembuat;
			$this->load->view($this->dir . "/drh_view", $data);
		} else {
			$data['overflow'] = 1;
			$data['content'] = $this->dir . "/drh_view";
			$this->load->view('home', $data);
		}
	}

	function delete_pegawai($id_pegawai)
	{

		$id = $this->session->userdata('id');

		if ($id == $id_pegawai) {
			$this->session->set_flashdata('fail', 'Data pegawai tersebut terhubung dengan pengguna LOGIN sehingga tidak dapat dihapus...');
		} else {
			/*$file = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>$id_pegawai),'select'=>'nip, berkas_simpan'))->row();
        $location = './uploads/berkas/'.$file->nip.'/'.$file->berkas_simpan;
        if(file_exists($location)) unlink($location);
        
        if(checkFolderEmpty('./uploads/berkas/'.$file->nip) == '0') rmdir('./uploads/berkas/'.$file->nip);
        */
			$delete = $this->general_model->delete_data('peg_pegawai', 'id_pegawai', $id_pegawai);

			if ($delete) $this->session->set_flashdata('ok', 'Data pegawai berhasil dihapus...');
			else $this->session->set_flashdata('fail', 'Data pegawai gagal dihapus...');
		}

		redirect($this->dir);
	}

	function tipe($id)
	{
		$a = $this->general_model->datagrab(array('tabel' => 'ref_tipe_pegawai', 'where' => array('id_tipe_pegawai' => $id)))->row();
		die(json_encode(array('tipe' => $a->jenis)));
	}

	function riwayat($o, $sc_peg, $tipe = null, $page = null)
	{
		// cek($page);
		$p = un_de($o);
		// cek($p);
		// cek($off);

		$data['peg'] = $this->general_model->datagrab(array(
			'tabel' => 'peg_pegawai',
			'select' => '
                concat(ifnull(gelar_depan,"")," ",nama,if(((gelar_belakang = "") or isnull(gelar_belakang)),"",concat(" ",gelar_belakang))) AS nama_pegawai,
                nip,id_pegawai',
			'where' => array('id_pegawai' => $p['id'])
		))->row();
		$data['tipe'] = $tipe;

		$data['sc_peg'] = $sc_peg;
		$data['t'] = $p['t'];
		$data['o'] = $o;
		$data['page'] = $page;
		// cek(un_de($o));
		$data['link_riwayat'] = $this->folder . '/pegawai/riwayat/' . $o . '/' . $sc_peg;
		$data['link_back'] = $this->folder . '/pegawai/list_pegawai/' . $p['t'] . '/' . str_replace('~', '/', $sc_peg);
		$data['content'] = $this->dir . "/riwayat_view";
		// cek($data['link_riwayat']);
		$this->load->view('home', $data);
	}
}

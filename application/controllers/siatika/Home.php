<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller
{
	var $dir = 'siatika/home';
	var $folder = 'siatika';
	var $xx = 'siatika';
	function __construct()
	{
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string())) redirect('login');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$tabel = '';
		$data['tabel'] = $tabel;
		$from = array(
			'ids a' => '',
			'ids_ref_theme b' => array('a.id_theme=b.id_theme', 'left')
		);
		$data['dt'] = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'a.id_ids asc'));
		$data['bg'] = array(1 => 'bg-aqua', 'bg-green', 'bg-red', 'bg-purple', 'bg-light-blue', 'bg-yellow', 'bg-gray', 'bg-navy', 'bg-teal', 'bg-orange', 'bg-maroon', 'bg-black');

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
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'), "operator_sitika")) {
			$where = array('b.tipe = 1 AND a.id_status_pegawai !=0' => NULL);
		} else {
			$where = array('h.tipe = 1  AND a.id_status_pegawai !=0' => NULL);
		}
		$data['t_pegawai'] = $this->general_model->datagrab(array('tabel' => $from, 'order' => 'a.id_pegawai DESC', 'select' => $select, 'where' => $where))->num_rows();

		$id_operator = $this->session->userdata('id_pegawai');
		$from1 = array(
			'sitika_articles tj' => '',
			'sitika_categories td' => array('td.id_cat = tj.id_cat', 'left'),
			'ref_kategori te' => array('te.id_kategori = tj.id_kategori', 'left')
		);
		$select1 = 'td.*,tj.*,te.*';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'), "operator_sitika")) {

			$where1 = array('tj.status !=' => 2, 'tj.code' => 1);
			$where2 = array('tj.status !=' => 2, 'tj.code' => 4);
			$where3 = array('tj.status !=' => 2, 'tj.code' => 3);
		} else {
			$where1 = array('tj.status !=' => 2, 'tj.code' => 1, 'tj.id_operator' => $id_operator);
			$where2 = array('tj.status !=' => 2, 'tj.code' => 4, 'tj.id_operator' => $id_operator);
			$where3 = array('tj.status !=' => 2, 'tj.code' => 3, 'tj.id_operator' => $id_operator);
		}
		$data['t_informasi'] = $this->general_model->datagrab(array('tabel' => $from1,  'select' => $select1, 'where' => $where1))->num_rows();
		$data['t_pengumuman'] = $this->general_model->datagrab(array('tabel' => $from1,  'select' => $select1, 'where' => $where2))->num_rows();
		$data['t_agenda'] = $this->general_model->datagrab(array('tabel' => $from1,  'select' => $select1, 'where' => $where3))->num_rows();

		$data['video'] = $this->general_model->datagrab(array(
			'tabel' => 'sitika_video',
			'order' => 'id_video DESC',
			'where' => array('status' => 2),

		));
		
		$data['content'] = $this->folder . '/dashboard';
		$this->load->view('home', $data);
	}
}

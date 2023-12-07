<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{

	function __construct()
	{

		parent::__construct();
	}

	public function index()
	{
		$this->init();
	}

	function init()
	{

		$log = $this->session->userdata('login_state');

		if (!empty($log)) {
			if ($log == 'root') {
				redirect('inti/pengaturan/parameter');
			} else {
				$a = $this->general_model->datagrab(array(
					'tabel' => array(
						'pegawai_role r' => '',
						'ref_role ro' => 'ro.id_role = r.id_role',
						'ref_aplikasi a' => 'a.id_aplikasi = ro.id_aplikasi'
					),
					'select' => 'count(ro.id_aplikasi) as jml,a.folder',
					'group_by' => 'ro.id_aplikasi',
					'where' => array('r.id_pegawai' => $this->session->userdata('id_pegawai'))
				));

				if ($a->num_rows() > 1) redirect('login/role_choice');
				else redirect($a->row()->folder . '/home');
			}
		} else {

			if ($this->general_model->check_tab('ref_aplikasi')) {

				redirect('Login');
			} else {

				redirect('inti/builder/inisialisasi');
			}
		}
	}

	function aplikasi($dir)
	{
		redirect($dir . '/home');
	}

	function general_delete($par)
	{

		login_check($this->session->userdata('login_state'));

		$p = un_de($par);

		$this->general_model->delete_data($p['tabel'], $p['kolom'], $p['id']);
		$this->session->set_flashdata('ok', 'Data berhasil dihapus');

		redirect($p['redirect']);
	}

	function akun($folder = NULL)
	{

		login_check($this->session->userdata('login_state'));
		$data['title'] = 'Ubah Profil & Password';
		if (!$this->general_model->check_role($this->session->userdata('id_pegawai'), 'OPRTT')) {
			$id = $this->session->userdata('id_pegawai');
			$data['row'] = $this->general_model->datagrab(array('tabel' => 'peg_pegawai', 'where' => array('id_pegawai' => $id)))->row();
			$data['link_foto'] = 'home/save_foto';
			$data['link_base'] = $folder;
			// cek($data['link_base']);
			// die();
		}
		#new config no_edit_foto_akun
		$no_edit_foto_config = $this->config->item('no_edit_foto_akun');
		$data['edit_foto'] = 1;
		if ($no_edit_foto_config) $data['edit_foto'] = 0;
		#---e new
		$this->load->view('umum/akun_form', $data);
	}

	function update_akun()
	{

		$id	= $this->input->post('id_pegawai');

		$a = $this->input->post('username');
		$al = $this->input->post('username_lama');
		$pwd_lama = $this->input->post('pwd_lama');
		$pb = $this->input->post('pwd_baru');
		$pb2 = $this->input->post('pwd_baru2');

		if (!empty($pwd_lama) and !empty($pb) and !empty($pb2)) {

			$cek = $this->general_model->datagrab(array('tabel' => 'peg_pegawai', 'where' => array('id_pegawai' => $id, 'password' => md5($pwd_lama))));

			if ($pb === $pb2) {

				if ($cek->num_rows() > 0) {
					$this->general_model->save_data('peg_pegawai', array('password' => md5($pb)), 'id_pegawai', $id);
					die(json_encode(array('sign' => '1', 'teks' => 'Password berhasil diubah!')));
				} else {
					die(json_encode(array('sign' => '404', 'teks' => 'Password lama salah!')));
				}
			} else {

				die(json_encode(array('sign' => '404', 'teks' => 'Password baru dan ulangnya tidak sama!')));
			}
		} else if ($al != $a) {
			if (!empty($pwd_lama)) {
				$cek = $this->general_model->datagrab(array(
					'tabel' => 'peg_pegawai',
					'where' => array(
						'id_pegawai' => $id,
						'password' => md5($pwd_lama)
					)
				));
				if ($cek->num_rows() > 0) {
					$this->general_model->save_data('peg_pegawai', array('username' => $a), 'id_pegawai', $id);
					die(json_encode(array('sign' => '1', 'teks' => 'Akun berhasil diubah!')));
				} else {
					die(json_encode(array('sign' => '404', 'teks' => 'Password lama salah!')));
				}
			} else {

				die(json_encode(array('sign' => '404', 'teks' => 'Password lama harus dimasukkan!')));
			}
		}
	}


	function save_foto()
	{

		$id_pegawai = $this->input->post('id_pegawai');

		$offs = $this->input->post('offs');
		$pasfoto = $_FILES['foto']['tmp_name'];
		$namaFoto = $_FILES['foto']['name'];

		// cek($namaFoto);
		// die();

		if (!empty($pasfoto)) {
			$path = './uploads/kepegawaian/pasfoto';
			if (!is_dir($path)) mkdir($path, 0777, TRUE);

			if (!empty($id_pegawai)) {

				$prev = $this->input->post('foto_prev');
				$path_pasfoto = $path . '/' . $prev;
				if (file_exists($path_pasfoto)) unlink($path_pasfoto);
			}

			//$nama_file   = $id . '.jpg';

			if (!file_exists($path . '/' . $namaFoto)) {

				$this->load->library('upload');

				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => 'jpg|jpeg|png|gif|pdf|word',
					'file_name' => $namaFoto
				));
				$this->upload->do_upload('foto');
			}

			// cek($namaFoto);
			// die();

			$this->general_model->save_data(
				'peg_pegawai',
				array('photo' => $namaFoto),
				'id_pegawai',
				$id_pegawai
			);

			$this->session->set_flashdata('ok', 'Foto berhasil disimpan ...');
		} else {

			$this->session->set_flashdata('fail', 'Foto belum dipilih ...');
		}

		redirect($this->input->post('link_base') . '/Home');
	}
}

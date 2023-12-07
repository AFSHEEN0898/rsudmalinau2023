<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Get_konten extends CI_Controller {
	var $dir = 'siatika/get_konten';
	var $folder = 'siatika';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		$in = $this->input->post();
		$dt = $this->general_model->combo_box(array('tabel'=>'ids_ref_konten', 'key'=>'id_ref_konten', 'val'=>array('ref_konten'), 'where'=>array('id_tipe_konten'=>$in['id_tipe_konten']) ));
		$e = form_dropdown('id_data', $dt, NULL,'class="form-control combo-box" id="id_data" style="width: 100%;" required');
		echo $e;
	}
}
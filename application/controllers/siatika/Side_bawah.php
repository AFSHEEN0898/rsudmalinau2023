<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Side_bawah extends CI_Controller {
	var $dir = 'siatika/bawah';
	var $folder = 'siatika';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL){
		$data['breadcrumb'] = array($this->dir => 'Sidebar Bawah');
		$data['title'] = 'Sidebar Bawah';
		$this->load->view('home', $data);
	}
}
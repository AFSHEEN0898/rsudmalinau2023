<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	var $dir = 'siatika/pengaturan';
	var $folder = 'siatika';
	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
	}

	public function index() {
		
		$this->paging();
		
	}
	
	function simpan_param($par,$dat) {
		$this->general_model->save_data('parameter',array('param' => $par,'val'=> $dat));
	}
	
	function ubah_param($par,$dat) {
		$this->general_model->save_data('parameter',array('val' => $dat),'param',$par);
	}
	
	
	function save_data() {

		foreach($this->param as $o) {
			
			$g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $o)));
			if ($g->num_rows() > 0) $this->ubah_param($o,$this->input->post($o));
			else $this->simpan_param($o,$this->input->post($o));
			
		}
	
	}
	
	function paging() {
		
		$data['breadcrumb'] = array($this->dir => 'Pengaturan');
		$data['title'] = 'Pengaturan Umum';
		$data['link'] = $this->dir.'/simpan';
		
		$data['vals'] = $this->general_model->get_param(array(
			'tvinfo_durasi','all_reload', 'reload_konten', 'reload_pengumuman', 'reload_slide1', 'reload_slide2', 'speed_run_text',
			'height_konten', 'height_sidebar_1','height_sidebar_2','header_color','basic_color','color_text_header','color_text_basic',
			'title_color','color_text_title','column_color','color_text_column','galeri_color','color_text_galeri','time_color',
			'color_text_time','date_color','color_text_date','marquee_color','color_text_marquee'),2);

		$data['content'] = $this->folder.'/pengaturan_view';
		$this->load->view('home',$data);
		
	}
	
	function simpan() {
		
		$keys = $this->input->post('keys');
		$vals = $this->input->post('vals');
		
		for ($i = 0; $i < count($keys); $i++) {
			$g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $keys[$i])));
			if ($g->num_rows() > 0) $this->ubah_param($keys[$i],$vals[$i]);
			else $this->simpan_param($keys[$i],$vals[$i]);
		}
		
		$this->session->set_flashdata('ok','Pengaturan umum berhasil disimpan ...');
		redirect($this->dir);
		
	}
	
}

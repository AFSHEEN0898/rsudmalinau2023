<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Get_api extends CI_Controller{

	var $dir = 'sitika/get_api';
	var $folder = 'sitika';

	function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->get_data_json();
	}

	public function get_data_json(){
		$query = $this->general_model->datagrab(array(
			'select' => '*',
			'tabel'	=> array(
				'sitika_articles' => ''
			),
			'order' => 'date_start, title ASC'
			)
		);
	    $response = array();
	    $posts = array();
		foreach ($query->result() as $i => $key) {
			$posts[$i] = array(
				'id_article' => $key->id_article,
				'id_cat' => $key->id_cat,
				'date_start' => $key->date_start,
				'title' => $key->title,
				'content' => $key->content,
				'foto' => base_url().'uploads/sitika/konten/'.$key->foto
			);
		}
		// response json
	    $response['article'] = $posts;
	    echo json_encode($response,TRUE);
	}

	public function get_detail_article(){
		$kd = $this->input->get('id_article');
		$query = $this->general_model->datagrab(array(
			'select' => '*',
			'tabel'	=> array(
				'sitika_articles' => ''
			),
			'where' => array(
				'id_article' => $kd
			),
			'order' => 'date_start, title ASC'
			)
		);
	    $response = array();
	    $posts = array();
	    foreach ($query->result() as $i => $key){
		$posts[$i] = array(
				'id_article' => $key->id_article,
				'id_cat' => $key->id_cat,
				'date_start' => $key->date_start,
				'title' => $key->title,
				'content' => $key->content,
				'foto' => base_url().'uploads/sitika/konten/'.$key->foto
			);
	    }
		// response json
	    $response['article'] = $posts;
	    echo json_encode($response,TRUE);	
	} 
}
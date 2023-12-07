<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Video extends CI_Controller
{

	var $dir = 'siatika/video';
	var $folder = 'siatika';

	function __construct()
	{
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		/*
		Video source :
		1. Upload video manual.
		2. Youtube
		*/
	}

	public function index()
	{
		$this->list_data();
	}

	// index
	function list_data($search = null, $offset = null)
	{

		$data['breadcrumb'] = array('' => 'Galeri', '' => 'Gallery', 'siatika/video/list_data' => 'Video');
		// define offfset
		$offset = !empty($offset) ? $offset : null;
		$in = $this->input->post();
		$vse = null;
		$fcari = null;
		if (!empty($in)) {
			$vse = array(
				'status' => $in['status'],
				'judul' => $in['judul'],
			);
			if (!empty($in['judul'])) {
				$fcari = array(
					'judul' => $in['judul'],
				);
			} else {
				$fcari = un_de($search);
			}
		} else if ($search) {
			$vse = un_de($search);
			$fcari = un_de($search);
		}
		// $search = !empty($vse) ? $se = array('teks_bergerak' => $vse['text_search']) : null;
		$where = array();
		if (isset($vse['status']) && $vse['status'] != '') $where['status'] = $vse['status'];
		$array_status = array(
			'' => 'Semua Status',
			1 => 'Tidak Tampil',
			2 => 'Tampil'
		);
		$data['combo_status'] = $array_status;
		// define offfset
		$data['graph_area'] = form_open('siatika/video', 'id="form_search" class="form-horizontal"') . '
	                  <div class="box-body">
		              	<div class="col-md-6">
			                <div class="form-group">
			                  <label class="col-sm-4 control-label">Status</label>
			                  <div class="col-sm-8">
			                    ' . form_dropdown("status", $data['combo_status'], @$vse['status'], "id='filter_status' class='form-control' style='width:100%'") . '
			                  </div>
			                </div>
			                
		              	</div>
		              	<div class="col-md-6">
			                <div class="form-group">
			                  	<label class="col-sm-4 control-label">Pencarian</label>
				                  	<div class="col-sm-8">
								<div class="input-group">
		                      	<input name="judul" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="' . @$vse['judul'] . '">
		                    			<div class="input-group-btn">
	                        				<button class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
	                      				</div>
	                    			</div>
			                	</div>
			                </div>
		              	</div>
		              </div>
		              ' . form_close();

		$param_total = array(
			'select' => '*',
			'tabel'	=> array(
				'sitika_video' => ''
			),
			'where' => $where,
			'search' => $fcari
		);

		$config['base_url']	= site_url($this->dir . '/list_data/' . in_de($vse));
		$config['total_rows'] = $this->general_model->datagrabs($param_total)->num_rows();
		$config['per_page']	= '10';
		$config['uri_segment'] = '5';
		$this->pagination->initialize($config);
		$data['links']	= $this->pagination->create_links();
		// cetak excel dan html
		$offs = (!in_array($offset, array("cetak", "excel"))) ?  $offset : NULL;
		$lim = (!in_array($offset, array("cetak", "excel"))) ? $config['per_page'] : NULL;

		$query = $this->general_model->datagrabs(array(
			'select' => '*',
			'tabel'	=> array(
				'sitika_video' => ''
			),
			'where' => $where,
			'search' => $fcari,
			'offset' => $offs,
			'order' => 'tanggal DESC, judul, keterangan ASC',
			'limit' => $lim
		));
		if ($query->num_rows() != 0) {
			$classy = (in_array($offset, array("cetak", "excel"))) ? 'class="tabel_print" border=1' : 'class="table table-bordered table-condensed no-fluid" ';
			$this->table->set_template(array('table_open' => '<table ' . $classy . '>'));
			$heads = array('No');
			if (!in_array($offset, array('cetak', 'excel'))) $heads[] = '';
			$heads = array_merge_recursive(
				array(
					'NO',
					'',
					'SUMBER',
					'KETERANGAN VIDEO',
					'TANGGAL UPLOAD'
				)
			);
			if (!in_array($offset, array('cetak', 'excel'))) {
				$heads[] = array('data' => 'AKSI', 'colspan' => 3);
			}
			$this->table->set_heading($heads);
			$no = $offset + 1;
			// Meng-list usulan 
			foreach ($query->result() as $row) {
				// me-list data yang akan ditampilkan
				if ($row->video_source == '1') {
					$sumber = 'Upload Manual';
					$video = '<a class="fancybox" target="_blank" href="' . base_url() . 'uploads/siatika/galeri/video/' . $row->video . '" title="' . @$row->judul . '"><i class="fa fa-video"></i></a>';
				} else {
					$sumber = 'Youtube';
					$video = '<a target="_blank" href="' . $row->youtube_link . '" title="' . @$row->judul . '"><i class="fa fa-video text-red"></i></a>';
				}
				$rows = array(
					array('data' => $no, 'style' => 'text-align:center'),
					array('data' => @$video ?: '-', 'style' => 'text-align:center'),
					array('data' => @$sumber ?: '-', 'style' => 'text-align:left'),
					array('data' => @$row->judul ?: '-', 'style' => 'text-align:left'),
					array('data' => tanggal_indo(@$row->tanggal) ?: '-', 'style' => 'text-align:left')
				);
				// tambbah tombol edit dan delete
				if ($row->status == '1') {
					$link_power = anchor(site_url($this->dir . '/power_on/' . in_de(array('id_video' => $row->id_video))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-default" ');
				} elseif ($row->status == '2') {
					$link_power = anchor(site_url($this->dir . '/power_off/' . in_de(array('id_video' => $row->id_video))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-success" ');
				}
				$link_edit = anchor('#', '<i class="fa fa-pen"></i>', 'act="' . site_url($this->dir . '/add_data/' . in_de(array('id_video' => $row->id_video))) . '" class="btn btn-xs btn-warning btn-edit" title="Klik untuk edit data."');
				$link_delete = '<div class="text-center"><a href="' . site_url($this->dir . '/delete_aset/' . in_de(array('id_video' => $row->id_video))) . '" class="btn btn-xs btn-danger btn-delete" title="Hapus Data" msg="Yakin untuk menghapus data ini"><i class="fa fa-trash"></i></a></div>';
				// meng-assign data ke tabel
				if (!in_array($offset, array('cetak', 'excel'))) {
					// add edit and delete button
					$rows[] = array('data' => $link_power, 'style' => 'text-align:center');
					$rows[] = array('data' => $link_edit, 'style' => 'text-align:center');
					$rows[] = array('data' => $link_delete, 'style' => 'text-align:center');
				}
				$this->table->add_row($rows);
				$no++;
			}
			$tabel = '<div class="table-responsive">' . $this->table->generate() . '</div>';
		} else {
			$tabel = '<div class="alert alert-confirm pull-left">Belum ada data</div><div class="clear"></div>';
		}

		$btn_cetak = ($query->num_rows() > 0) ?
			'<div class="btn-group"  tyle="margin-left: 5px;">
		<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
		<i class="fa fa-print"></i> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu pull-right">
		<li class="dropdown-item">' . anchor('siatika/video/list_data/' . in_de($vse) . '/cetak', '<i class="fa fa-print"></i> Cetak', 'target="_blank"') . '</li>
		<li class="dropdown-item">' . anchor('siatika/video/list_data/' . in_de($vse) . '/excel', '<i class="fa fa-file-excel"></i> Ekspor Excel', 'target="_blank"') . '</li>
		</ul>
		</div>' : null;
		$data['script'] = "
		$(document).ready(function(){
			$(\".fancybox\").fancybox();
			$('select.cbox').select2();
			$('.tanggal').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true
			});
		});
		";
		$j = 'Galeri Video';
		$data['box'] = 'box-success';
		$data['tombol'] = anchor('#', '<i class="fa fa-plus-square fa-btn"></i> &nbsp;  Tambah Data ', 'class="btn btn-success  btn-edit" act="' . site_url($this->dir . '/add_data') . '" title="Klik untuk Tambah Data Video"') . ' ' . $btn_cetak;
		$data['total'] = $config['total_rows'];
		$data['tabel']	= $tabel;
		if ($offset == "cetak") {
			$data['title'] = '<h3>' . $j . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print', $data);
		} else if ($offset == "excel") {
			$data['file_name'] = str_replace(" ", "_", strtolower('jenis_arsip')) . '.xls';
			$data['title'] = '<h3>' . $j . '</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel', $data);
		} else {
			$data['tabel'] = $tabel;
			$data['title'] = $j;
			$data['content'] = "umum/standard_view";
			$this->load->view('home', $data);
		}
	}

	function add_data($id = null)
	{
		if ($id != NULL) {
			$p = un_de($id);
			$data['dt'] = $this->general_model->datagrab(
				array(
					'select' => '*',
					'tabel'	=> array(
						'sitika_video' => ''
					),
					'where' => array(
						'id_video' => $p['id_video']
					)
				)
			)->row();
		}
		$data['title']	= (!empty($id) ? 'Ubah' : 'Entri') . ' Data Video';
		$combo_status = array(
			'2' => 'Tampil',
			'1' => 'Tidak Tampil',

		);
		$combo_video_source = array(
			'' => 'Pilih Sumber Video',
			'1' => 'Upload Video Manual',
			'2' => 'Link youtube'
		);
		$data['form_link'] = $this->dir . '/save_data/' . $id;
		$data['multi'] = 1;

		$data['script'] = "
		   $('.tanggal').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 1901,
                    maxYear: parseInt(moment().format('YYYY'), 10) + 10,
                    autoApply: false,
                    locale: {
                        format: 'DD/MM/YYYY'
                    } 
                });

		  $('.video_source').on('change', function(){
		  	id_video_source = $(this).val();
			console.log(id_video_source);
		    if (id_video_source === '1') {
		    	data = '<input type=\"file\" name=\"video\" class=\"form-control\" accept=\"video/*\" required/><span>* Catatan : Ukuran file maksimal 10 MB dengan ektensi MP4.</span>';
		    }else if (id_video_source === '2') {
		    	data = '<input type=\"text\" name=\"youtube_link\" class=\"form-control\" required placeholder=\"Link Youtube\" value=" . @$data['dt']->youtube_link . " />';
		    }else{
		    	data = null;
		    }
		    $('.data_video_source').html(data);
		  });
		";
		$data['form_data'] = '
				<input type="hidden" name="id_video" value="' . @$data['dt']->id_video . '" />
					<div class="form-group">
					' . form_label('Judul Video <code>*</code>') . form_input('judul', @$data['dt']->judul, 'class="form-control" placeholder="Judul Video" required') . '
					</div>
					<div class="form-group">' .
			form_label('Tanggal Buat') . '
						
						<div class="input-group mb-3">
										' . form_input('tanggal', !empty(@$data['dt']->tanggal) ? tanggal(@$data['dt']->tanggal) : date('d/m/Y'), 'class="form-control tanggal"') . '
						 
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
					</div>
					<div class="form-group">
						' . form_label('Status <code>*</code>') . form_dropdown("status", $combo_status, @$data['dt']->status, "id='status' class='combo-box' style='width:100%'") . '
					</div>
					
					<div class="form-group"><p>' . form_label('Sumber Video <code>*</code>') . form_dropdown("video_source", $combo_video_source, @$data['dt']->video_source, "id='video_source' class='combo-box video_source' style='width:100%' required='required'") . '<p></p></div>
					<div class="form-group">
						
					</div>';
		if (!empty(@$data['dt']->video) && (@$data['dt']->video_source == 1)) {
			// untuk video manual
			$data['form_data'] .=
				form_hidden('video_prev', @$data['dt']->video) .
				'<div class="form-group"><a class="fancybox btn btn-success" target="_blank" href="' . base_url() . 'uploads/siatika/galeri/video/' . @$data['dt']->video . '" title="' . @$data['dt']->judul . '"><i class="fa fa-file-camera-o "></i> Play Video ' . @$data['dt']->judul . '</a></div>';
			$source_result = '<input type="file" name="video" class="form-control" accept="video/*" /><span>* Catatan : Ukuran file maksimal 10 MB dengan ektensi MP4.</span>';
		} else if (!empty(@$data['dt']->youtube_link) && (@$data['dt']->video_source == 2)) {
			$data['form_data'] .= 'Menampilkan video dari youtube (berupa link)';
			$source_result = '<input type="text" name="youtube_link" value="' . @$data['dt']->youtube_link . '" class="form-control" placeholder="Link Youtube" />';
		} else {
			$data['form_data'] .= null;
		}
		$data['form_data'] .= '<div class="form-group"><div class="data_video_source">' . @$source_result . '</div></p>
					</div>
		';
		$this->load->view('umum/form_view', $data);
	}

	function save_data($id = null)
	{
		// cek('hai');
		// die();
		// deklarasikan id dan nama foto yang lama
		$id_video = $this->input->post('id_video', TRUE);
		$video_prev = $this->input->post('video_prev', TRUE);
		$video_source = $this->input->post('video_source', TRUE);
		$file_video = null;
		$link = null;
		$vid_youtube = null;
		// cek($this->input->post('video_source'));
		// cek($_FILES);
		// die();
		// jika id = null maka lakukan insert
		if ($this->input->post('video_source') == 1) {
			$video = $_FILES['video']['name'];

			// jika udah disimpan lakukan penyimpanan video dan update tabel
			if ($video != NULL) {

				$new_name = 'video_' . date('Ymd') . '_' . date('His');

				$path = './uploads/siatika/galeri/video';
				if (!is_dir($path)) mkdir($path, 0777, TRUE);
				$prev = $this->input->post('video_prev');
				if (!empty($prev)) {
					$path_pasvideo = $path . '/' . $prev;
					if (file_exists($path_pasvideo)) unlink($path_pasvideo);
				}

				$this->load->library('upload');
				$this->upload->initialize(array(
					'file_name' => $new_name,
					'upload_path' => $path,
					'allowed_types' => 'mp4',
					'max_size' => '10000'
				));

				$upload = $this->upload->do_upload('video');
				// $data_upload = $this->upload->data();
				// $onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				// cek($data_upload);
				if ($upload) {
					// lakukan update tabel
					$data_upload = $this->upload->data();
					$file_video = $data_upload['file_name'];
				} else {

					$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
					// cek($onerror);
					// cek($this->input->post());
					// die();
					$this->session->set_flashdata('fail', 'File video gagal diunggah ! <br>' . $onerror);
					redirect($this->dir);
				}
			} else {
				$file_video = !empty($video_prev) ? $video_prev : null;
			}
		} else {
			# code...
			$yt = $this->input->post('youtube_link');
			if ($yt != '/') {
				$str1 = explode("?", $yt);
				// cek($str1);
				if (count($str1) > 1) {
					$str2 = explode("//", $str1[0]);
					// cek($str2);
					$str3 = explode("/", $str2[1]);
					// cek($str3);
					$vid_youtube = $str3[2];
					$link = $str1[0];
				} else {
					$str2 = explode("//", $str1[0]);
					// cek($str2);
					$str3 = explode("/", $str2[1]);
					// cek($str3);
					$vid_youtube = $str3[2];
					$link = $yt;
				}
			}else {
				$this->session->set_flashdata('fail', 'Link youtube tidak sesuai ! ');
				redirect($this->dir);
			}

			// cek(count($str3));

			// die();
		}
		// cek($this->input->post());
		// die();
		$param = array(
			'tabel' => 'sitika_video',
			'data' => array(
				'judul' => $this->input->post('judul'),
				'keterangan' => $this->input->post('keterangan'),
				'tanggal' => tanggal_php($this->input->post('tanggal')),
				'status' => $this->input->post('status') ?: 0,
				'video_source' => $this->input->post('video_source'),
				// 'jeda' => $this->input->post('jeda')
				'video' => $file_video,
				'youtube_link' => $link,
				'vid_youtube' => $vid_youtube,

			)
		);
		if ($id_video == NULL) {
			$get_save = $this->general_model->save_data($param);
			$id = $this->db->insert_id();
		} else {
			// jika tidak maka lakukan update
			if ($id_video != NULL) {
				$param['where'] = array('id_video' => $id_video);
			}
			// lakukan update tabel terlebih dahulu
			$get_save = $this->general_model->save_data($param);
		}
		if ($get_save) {
			$this->session->set_flashdata('ok', 'Data Video Berhasil Disimpan');
			redirect($this->dir);
		} else {
			$this->session->set_flashdata('fail', 'Data Video Gagal Disimpan');
			redirect($this->dir);
		}
	}

	function save_data_cp($id = null)
	{
		// deklarasikan id dan nama video yang lama
		$id_video = $this->input->post('id_video', TRUE);
		$video_prev = $this->input->post('video_prev', TRUE);
		$video_source = $this->input->post('video_source', TRUE);
		// jika id = null maka lakukan insert
		$param = array(
			'tabel' => 'sitika_video',
			'data' => array(
				'judul' => $this->input->post('judul'),
				'keterangan' => $this->input->post('keterangan'),
				'tanggal' => tanggal_php($this->input->post('tanggal')),
				'status' => $this->input->post('status') ?: 0,
				'video_source' => $this->input->post('video_source'),
				// 'jeda' => $this->input->post('jeda')
			)
		);
		if ($video_source == 1) { // dari upload manual
			$video = $_FILES['video']['tmp_name'];
			if ($id_video == NULL) {
				// jika udah disimpan lakukan penyimpanan video dan update tabel
				if ($video != NULL) {
					$get_save = $this->general_model->save_data($param);
					$id = $this->db->insert_id();
					$path = './uploads/siatika/galeri/video';
					if (!is_dir($path)) mkdir($path, 0777, TRUE);
					$this->load->library('upload');
					$this->upload->initialize(array(
						'upload_path' => $path,
						'allowed_types' => 'mp4',
						'max_size' => '5000'
					));

					$upload = $this->upload->do_upload('video');
					$data_upload = $this->upload->data();
					$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
					// cek($data_upload);
					if ($upload) {
						// lakukan update tabel
						$param = array(
							'tabel' => 'sitika_video',
							'data' => array(
								'video' => $data_upload['file_name']
							)
						);
						$param['where'] = array('id_video' => $id);
						$this->general_model->save_data($param);
					}
				}
				$this->session->set_flashdata('ok', 'Data Video Berhasil Disimpan');
				redirect($this->dir);
			} else {
				// jika tidak maka lakukan update
				if ($id_video != NULL) {
					$param['where'] = array('id_video' => $id_video);
				}
				// lakukan update tabel terlebih dahulu
				$get_save = $this->general_model->save_data($param);
				// jika sudah cek apakah dia upload video atau ngga,
				if ($video != null) {
					// jika upload video maka lakukan penghapusan video berdasarkan nama filenya
					$path = './uploads/siatika/galeri/video';
					$prev = $this->input->post('video_prev');
					if (!empty($prev)) {
						$path_pasvideo = $path . '/' . $prev;
						if (file_exists($path_pasvideo)) unlink($path_pasvideo);
					}
					// kemudian upload file baru
					$this->load->library('upload');
					$this->upload->initialize(array(
						'upload_path' => $path,
						'allowed_types' => 'mp4',
						'max_size' => '5000'
					));
					$upload = $this->upload->do_upload('video');
					$data_upload = $this->upload->data();
					$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
					// cek($data_upload);
					if ($upload) {
						// lakukan update tabel
						$param = array(
							'tabel' => 'sitika_video',
							'data' => array(
								'video' => $data_upload['file_name']
							)
						);
						$param['where'] = array('id_video' => $id_video);
						$this->general_model->save_data($param);
					}
				}
				// 
				$this->session->set_flashdata('ok', 'Data Video Berhasil Diubah');
				redirect('siatika/video');
			}
		} elseif ($video_source == 2) { // dari youtube
			if ($id_video == NULL) {
				$get_save = $this->general_model->save_data($param);
				$id = $this->db->insert_id();
				// lakukan update tabel
				$param = array(
					'tabel' => 'sitika_video',
					'data' => array(
						'youtube_link' => $this->input->post('youtube_link')
					)
				);
				$param['where'] = array('id_video' => $id);
				$this->general_model->save_data($param);
			} else {
				// jika tidak maka lakukan update
				if ($id_video != NULL) {
					$param['where'] = array('id_video' => $id_video);
				}
				// lakukan update tabel terlebih dahulu
				$get_save = $this->general_model->save_data($param);
				if ($this->input->post('youtube_link') != null) {
					// jika tidak maka lakukan update
					// hapus video dr direktori
					$path = './uploads/siatika/galeri/video';
					$prev = $this->input->post('video_prev');
					if (!empty($prev)) {
						$path_pasvideo = $path . '/' . $prev;
						if (file_exists($path_pasvideo)) unlink($path_pasvideo);
					}
					if ($id_video != NULL) {
						$param = array(
							'tabel' => 'sitika_video',
							'data' => array(
								'video' => null,
								'youtube_link' => $this->input->post('youtube_link')
							)
						);
						$param['where'] = array('id_video' => $id_video);
					}
					// lakukan update tabel terlebih dahulu
					$get_save = $this->general_model->save_data($param);
				}
			}
			$this->session->set_flashdata('ok', 'Data Video Berhasil Disimpan');
			redirect($this->dir);
		}
	}


	function delete_aset($code = NULL)
	{
		$p = un_de($code);
		// dilist daftar file dengan id_penghapusan $code
		$result = $this->general_model->datagrab(
			array(
				'select' => '*',
				'tabel' => 'sitika_video',
				'where' => array(
					'id_video' => $p['id_video']
				)
			)
		)->row();
		$this->general_model->delete_data('sitika_video', 'id_video', $p['id_video']);
		$file_name = $result->video;
		$path =  base_url() . 'uploads/siatika/galeri/video/' . $file_name;
		if (is_file('uploads/siatika/galeri/video/' . $file_name)) {
			unlink('uploads/siatika/galeri/video/' . $file_name);
		}
		$this->session->set_flashdata('ok', 'Data Video berhasil dihapus.');
		redirect($this->dir);
	}

	public function power_off($id = null)
	{
		$data = un_de($id);
		$id_video = $data['id_video'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_video',
			'data' => array(
				'status' => '1'
			)
		);
		$param['where'] = array('id_video' => $id_video);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Video yang dipilih berubah menjadi tidak tampil.');
			redirect($this->dir);
		}
	}

	public function power_on($id = null)
	{
		$data = un_de($id);
		$id_video = $data['id_video'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_video',
			'data' => array(
				'status' => '2'
			)
		);
		$param['where'] = array('id_video' => $id_video);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Video yang dipilih berubah menjadi tampil.');
			redirect($this->dir);
		}
	}
}

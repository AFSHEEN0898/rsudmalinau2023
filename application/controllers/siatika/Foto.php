<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Foto extends CI_Controller
{

	var $dir = 'siatika/foto';
	var $folder = 'siatika';

	function __construct()
	{
		parent::__construct();
		login_check($this->session->userdata('login_state'));
	}

	public function index()
	{
		$this->list_data();
	}

	// index
	function list_data($search = null, $offset = null)
	{

		$data['breadcrumb'] = array('' => 'Galeri', '' => 'Gallery', 'siatika/foto/list_data' => 'Foto');
		// define offfset
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
		$data['graph_area'] = form_open('siatika/foto', 'id="form_search" class="form-horizontal"') . '
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
				'sitika_foto' => ''
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
				'sitika_foto' => ''
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
					'TIPE',
					'JUDUL',
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


				$foto = '<a class="fancybox" href="' . base_url() . 'uploads/siatika/galeri/foto/' . $row->foto . '" title="' . @$row->judul . '"><i class="fa fa-image"></i></a>';
				$rows = array(
					array('data' => $no, 'style' => 'text-align:center'),
					array('data' => @$foto ?: '-', 'style' => 'text-align:left'),
					array('data' => (@$row->tipe == 2) ? 'Profil Pegawai' : 'Kegiatan', 'style' => 'text-align:left'),
					array('data' => @$row->judul ?: '-', 'style' => 'text-align:left'),
					array('data' => tanggal_indo(@$row->tanggal) ?: '-', 'style' => 'text-align:left')
				);
				// tambbah tombol edit dan delete
				if ($row->status == '1') {
					$link_power = anchor(site_url($this->dir . '/power_on/' . in_de(array('id_foto' => $row->id_foto))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-default" ');
				} elseif ($row->status == '2') {
					$link_power = anchor(site_url($this->dir . '/power_off/' . in_de(array('id_foto' => $row->id_foto))), '<i class="fa fa-power-off"></i>', ' class="btn btn-xs btn-success" ');
				}
				$link_edit = anchor('#', '<i class="fa fa-pen"></i>', 'act="' . site_url($this->dir . '/add_data/' . in_de(array('id_foto' => $row->id_foto))) . '" class="btn btn-xs btn-warning btn-edit" title="Klik untuk edit data."');
				$link_delete = '<div class="text-center"><a href="' . site_url($this->dir . '/delete_aset/' . in_de(array('id_foto' => $row->id_foto))) . '" class="btn btn-xs btn-danger btn-delete" title="Hapus Data" msg="Yakin untuk menghapus data ini"><i class="fa fa-trash"></i></a></div>';
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
		<li class="dropdown-item">' . anchor('siatika/foto/list_data/' . in_de($vse) . '/cetak', '<i class="fa fa-print"></i> Cetak', 'target="_blank"') . '</li>
		<li class="dropdown-item">' . anchor('siatika/foto/list_data/' . in_de($vse) . '/excel', '<i class="fa fa-file-excel"></i> Ekspor Excel', 'target="_blank"') . '</li>
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
		$j = 'Galeri Foto';
		$data['box'] = 'box-success';
		$data['tombol'] = anchor('#', '<i class="fa fa-plus-square fa-btn"></i> &nbsp;  Tambah Data ', 'class="btn btn-success  btn-edit" act="' . site_url($this->dir . '/add_data') . '" title="Klik untuk Tambah Data Foto"') . ' ' . $btn_cetak;
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
		$rq = 'required';
		if ($id != NULL) {
			$p = un_de($id);
			$data['dt'] = $this->general_model->datagrab(
				array(
					'select' => '*',
					'tabel'	=> array(
						'sitika_foto' => ''
					),
					'where' => array(
						'id_foto' => $p['id_foto']
					)
				)
			)->row();
			$rq = '';
		}
		$data['title']	= (!empty($id) ? 'Ubah' : 'Entri') . ' Data Foto';
		$combo_status = array(
			'2' => 'Tampil',
			'1' => 'Tidak Tampil',

		);
		$combo_tipe = array(
			'' => 'Pilih Tipe',
			'1' => 'Kegiatan',
			'2' => 'Profil Pegawai'
		);
		$combo_posisi = array(
			'1' => 'Kiri',
			'2' => 'Kanan'
		);
		$data['form_link'] = $this->dir . '/save_data/' . $id;
		$data['multi'] = 1;
		$disabled = '';
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
		";
		$data['form_data'] = '
				<input type="hidden" name="id_foto" value="' . @$data['dt']->id_foto . '" />
				<div class="form-group">
						' . form_label('Tipe <code>*</code>') . form_dropdown("tipe", $combo_tipe, @$data['dt']->tipe, "id='tipe' class='combo-box' style='width:100%' required") . '
					</div>
					<div class="form-group" id="posisi">
						' . form_label('Posisi ') . form_dropdown("posisi", $combo_posisi, @$data['dt']->posisi, " class='combo-box' style='width:100%' ") . '
					</div>
					<div class="form-group">
					' . form_label('Judul <code>*</code>') . form_input('judul', @$data['dt']->judul, 'class="form-control" placeholder="Judul Foto" required') . '
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
						' . form_label('Status <code>*</code>') . form_dropdown("status", $combo_status, @$data['dt']->status, "id='status' class='combo-box' style='width:100%' required") . '
					</div>
					<div class="form-group"><p>' . form_label('Upload Foto <code>*</code>') . '<p></p>';
		if (!empty(@$data['dt']->foto)) {
			$data['form_data'] .=
				form_hidden('foto_prev', @$data['dt']->foto) .
				'<p><img src="' . base_url() . 'uploads/siatika/galeri/foto/' . @$data['dt']->foto . '" style="max-width: 100px; max-height: 50%"/></p>
				';
		}
		$data['form_data'] .= '<input type="file" name="foto" class="form-control" accept="image/*" ' . $rq . ' ></p>
		<span>* Catatan : Ukuran file maksimal 2 MB dengan ektensi JPG, JPEG, atau PNG.</span>
					</div>
		';
		if (!empty($id)) {
			$pos = "$('#posisi').show();";
		} else {
			$pos = "$('#posisi').hide();";
		}

		$data['script'] .= $pos . "
    
         $('#tipe').change(function() {
			  var tipe =  $(this).val();
            if(tipe==1){
				 $('#posisi').show();
			}else{
				   $('#posisi').hide();
			}
        });
		";
		$this->load->view('umum/form_view', $data);
	}

	function save_data($id = null)
	{
		// deklarasikan id dan nama foto yang lama
		$id_foto = $this->input->post('id_foto', TRUE);
		$foto_prev = $this->input->post('foto_prev', TRUE);
		$foto = $_FILES['foto']['name'];
		$file_foto = null;
		// cek($foto);
		// die();
		// jika id = null maka lakukan insert
		if ($foto != null) {
			$new_name = 'foto_' . date('Ymd') . '_' . date('His');
			// jika upload foto maka lakukan penghapusan foto berdasarkan nama filenya
			$path = './uploads/siatika/galeri/foto';
			$prev = $this->input->post('foto_prev');
			if (!empty($prev)) {
				$path_pasfoto = $path . '/' . $prev;
				if (file_exists($path_pasfoto)) unlink($path_pasfoto);
			}
			// kemudian upload file baru
			$this->load->library('upload');
			$this->upload->initialize(array(
				'file_name' => $new_name,
				'upload_path' => $path,
				'allowed_types' => 'jpg|png|jpeg',
				'max_size' => '2000',
			));
			$upload = $this->upload->do_upload('foto');
			// $data_upload = $this->upload->data();
			// $onerror = $this->upload->display_errors('&nbsp', '&nbsp');
			// cek($data_upload);
			if ($upload) {
				$data_upload = $this->upload->data();
				$file_foto = $data_upload['file_name'];
			} else {
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				# code...
				$this->session->set_flashdata('fail', 'File foto gagal diunggah ! <br>' . $onerror);
				redirect($this->dir);
			}
		} else {
			# code...
			$file_foto = !empty($foto_prev) ? $foto_prev : null;
		}

		$param = array(
			'tabel' => 'sitika_foto',
			'data' => array(
				'judul' => $this->input->post('judul'),
				'keterangan' => $this->input->post('keterangan'),
				'tanggal' => tanggal_php($this->input->post('tanggal')),
				// 'jeda' => $this->input->post('jeda'),
				'status' => $this->input->post('status') ?: 0,
				'tipe' => $this->input->post('tipe') ?: 1,
				'posisi' => $this->input->post('posisi') ?: 1,
				'foto' => $file_foto,
			)
		);
		if ($id_foto == NULL) {
			$get_save = $this->general_model->save_data($param);
			$id = $this->db->insert_id();
		} else {
			// jika tidak maka lakukan update
			if ($id_foto != NULL) {
				$param['where'] = array('id_foto' => $id_foto);
			}
			// lakukan update tabel terlebih dahulu
			$get_save = $this->general_model->save_data($param);
		}
		if ($get_save) {
			$this->session->set_flashdata('ok', 'Data Foto Berhasil Disimpan');
			redirect($this->dir);
		} else {
			$this->session->set_flashdata('fail', 'Data Foto Gagal Disimpan');
			redirect($this->dir);
		}
	}

	function save_data_cp($id = null)
	{
		// deklarasikan id dan nama foto yang lama
		$id_foto = $this->input->post('id_foto', TRUE);
		$foto_prev = $this->input->post('foto_prev', TRUE);
		$foto = $_FILES['foto']['tmp_name'];
		// jika id = null maka lakukan insert
		$param = array(
			'tabel' => 'sitika_foto',
			'data' => array(
				'judul' => $this->input->post('judul'),
				'keterangan' => $this->input->post('keterangan'),
				'tanggal' => tanggal_php($this->input->post('tanggal')),
				// 'jeda' => $this->input->post('jeda'),
				'status' => $this->input->post('status') ?: 0,
				'tipe' => $this->input->post('tipe') ?: 1,
				'posisi' => $this->input->post('posisi') ?: 1,

			)
		);
		if ($id_foto == NULL) {
			$get_save = $this->general_model->save_data($param);
			$id = $this->db->insert_id();
			// jika udah disimpan lakukan penyimpanan foto dan update tabel
			if ($foto != NULL) {
				$path = './uploads/siatika/galeri/foto';
				if (!is_dir($path)) mkdir($path, 0777, TRUE);
				$this->load->library('upload');
				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => 'jpg|png|jpeg',
					'max_size' => '2000',
				));
				$upload = $this->upload->do_upload('foto');
				$data_upload = $this->upload->data();
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				cek($data_upload);
				if ($upload) {
					// lakukan update tabel
					$param = array(
						'tabel' => 'sitika_foto',
						'data' => array(
							'foto' => $data_upload['file_name']
						)
					);
					$param['where'] = array('id_foto' => $id);
					$this->general_model->save_data($param);
				}
			}
			$this->session->set_flashdata('ok', 'Data Foto Berhasil Disimpan');
			redirect($this->dir);
		} else {
			// jika tidak maka lakukan update
			if ($id_foto != NULL) {
				$param['where'] = array('id_foto' => $id_foto);
			}
			// lakukan update tabel terlebih dahulu
			$get_save = $this->general_model->save_data($param);
			// jika sudah cek apakah dia upload foto atau ngga,
			if ($foto != null) {
				// jika upload foto maka lakukan penghapusan foto berdasarkan nama filenya
				$path = './uploads/siatika/galeri/foto';
				$prev = $this->input->post('foto_prev');
				if (!empty($prev)) {
					$path_pasfoto = $path . '/' . $prev;
					if (file_exists($path_pasfoto)) unlink($path_pasfoto);
				}
				// kemudian upload file baru
				$this->load->library('upload');
				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => 'jpg|png|jpeg',
					'max_size' => '2000',
				));
				$upload = $this->upload->do_upload('foto');
				$data_upload = $this->upload->data();
				$onerror = $this->upload->display_errors('&nbsp', '&nbsp');
				cek($data_upload);
				if ($upload) {
					// lakukan update tabel
					$param = array(
						'tabel' => 'sitika_foto',
						'data' => array(
							'foto' => $data_upload['file_name']
						)
					);
					$param['where'] = array('id_foto' => $id_foto);
					$this->general_model->save_data($param);
				}
			}
			// 
			$this->session->set_flashdata('ok', 'Data Foto Berhasil Diubah');
			redirect('siatika/foto');
		}
	}


	function delete_aset($code = NULL)
	{
		$p = un_de($code);
		// dilist daftar file dengan id_penghapusan $code
		$result = $this->general_model->datagrab(
			array(
				'select' => '*',
				'tabel' => 'sitika_foto',
				'where' => array(
					'id_foto' => $p['id_foto']
				)
			)
		)->row();
		$this->general_model->delete_data('sitika_foto', 'id_foto', $p['id_foto']);
		$file_name = $result->foto;
		$path =  base_url() . 'uploads/siatika/galeri/foto/' . $file_name;
		if (is_file('uploads/siatika/galeri/foto/' . $file_name)) {
			unlink('uploads/siatika/galeri/foto/' . $file_name);
		}
		$this->session->set_flashdata('ok', 'Data Aset berhasil di hapus.');
		redirect($this->dir);
	}

	public function power_off($id = null)
	{
		$data = un_de($id);
		$id_foto = $data['id_foto'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_foto',
			'data' => array(
				'status' => '1'
			)
		);
		$param['where'] = array('id_foto' => $id_foto);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Foto yang dipilih berubah menjadi tidak tampil.');
			redirect($this->dir);
		}
	}

	public function power_on($id = null)
	{
		$data = un_de($id);
		$id_foto = $data['id_foto'];
		// lakukan update tabel
		$param = array(
			'tabel' => 'sitika_foto',
			'data' => array(
				'status' => '2'
			)
		);
		$param['where'] = array('id_foto' => $id_foto);
		$save = $this->general_model->save_data($param);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data Status Foto yang dipilih berubah menjadi tampil.');
			redirect($this->dir);
		}
	}
}

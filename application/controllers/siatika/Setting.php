<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller
{

    var $dir = 'siatika/setting';
    var $folder = 'siatika';

    function __construct()
    {

        parent::__construct();
        login_check($this->session->userdata('login_state'));
    }

    public function index()
    {

        $this->paging();
    }

    function simpan_param($par, $dat)
    {
        $this->general_model->save_data('parameter', array('param' => $par, 'val' => $dat));
    }

    function ubah_param($par, $dat)
    {
        $this->general_model->save_data('parameter', array('val' => $dat), 'param', $par);
    }


    function save_data()
    {

        foreach ($this->param as $o) {

            $g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $o)));
            if ($g->num_rows() > 0) $this->ubah_param($o, $this->input->post($o));
            else $this->simpan_param($o, $this->input->post($o));
        }
        $this->session->set_flashdata('ok', 'Simpan Pengaturan berhasil');
        redirect($this->dir);
    }

    function paging()
    {

        $data['breadcrumb'] = array('' => 'Pengaturan', $this->folder . '/setting' => 'Parameter');
        $data['title'] = 'Pengaturan Umum';

        $data['vals'] = $this->general_model->get_param(array(
            'main_title', 'description', 'alamat', 'instansi_telp',
            'pemerintah', 'pemerintah_logo', 'pemerintah_s', 'instansi', 'instansi_code', 'instansi_s',
             'copyright'
        ), 2);

        $title = 'Pengaturan Umum';
        $tab1 = array('text' => 'Umum', 'on' => 1, 'url' => site_url($this->folder . '/setting/paging/'));
        $tab2 = array('text' => 'Logo', 'on' => NULL, 'url' => site_url($this->folder . '/setting/layout/'));
        // $tab3 = array('text' => 'Sosial Media', 'on' => NULL, 'url' => site_url($this->folder . '/setting/sosmed/'));
        $data['title']         = $title;
        $data['tabs'] = array($tab1, $tab2);
        $data['content'] = $this->folder . '/setting_umum';
        $this->load->view('home', $data);
    }

    function layout()
    {

        $data['breadcrumb'] = array('' => 'Pengaturan', $this->folder . '/setting' => 'Parameter');
        $data['title'] = 'Pengaturan Layout';

        $data['vals'] = $this->general_model->get_param(array(
            'header_image', 'logo_image', 'background_color', 'link_color', 'nav', 'hal', 'pemerintah_logo'
        ), 2);

        $title = 'Pengaturan Umum';
        $tab1 = array('text' => 'Umum', 'on' => NULL, 'url' => site_url($this->folder . '/setting/paging/'));
        $tab2 = array('text' => 'Logo', 'on' => 1, 'url' => site_url($this->folder . '/setting/layout/'));
        // $tab3 = array('text' => 'Sosial Media', 'on' => null, 'url' => site_url($this->folder . '/setting/sosmed/'));
        $data['title']         = $title;
        $data['tabs'] = array($tab1, $tab2);



        //$data['combo_nav'] = $this->general_model->combo_box(array('tabel'=>'pinta_ref_tipe_kapal','key'=>'id_ref_tipe_kapal','val'=>array('nama_tipe_kapal')));
        $data['combo_nav'] = '';




        $data['content'] = $this->folder . '/setting_logo';
        $this->load->view('home', $data);
    }

   
    function simpan()
    {

        $keys = $this->input->post('keys');
        $vals = $this->input->post('vals');

        for ($i = 0; $i < count($keys); $i++) {
            $g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $keys[$i])));
            if ($g->num_rows() > 0) $this->ubah_param($keys[$i], $vals[$i]);
            else $this->simpan_param($keys[$i], $vals[$i]);
        }

        $this->session->set_flashdata('ok', 'Pengaturan umum berhasil disimpan ...');
        redirect($this->folder . '/setting');
    }



    function save_header()
    {

        $keys = $this->input->post('keys');
        $vals = $this->input->post('vals');


        if ($_FILES['vals']['name'] != '') {
            $files = $_FILES;

            $cpt = count($_FILES['vals']['name']);
            $config['upload_path'] = './uploads/logo/';
            $config['allowed_types'] = '*';
            $config['max_size']    = '1000000';
            $config['max_width']  = '1024000';
            $config['max_height']  = '7680000';
            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('vals')) {
                $data = $this->upload->data();
                $foto = $data['file_name'];

                //tabel
                $file_gambar = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $keys)))->row();

                $path = './uploads/logo/' . $file_gambar->val;
                if (file_exists($path)) unlink($path);
                $this->general_model->delete_data('parameter', 'param', $keys);

                $this->simpan_param($keys, $foto);
                /*else $this->simpan_param($keys,$foto);
*/
            } else {
                $data['error'] = $this->upload->display_errors();
                $this->session->set_flashdata('fail', 'File tidak bisa diupload<br>' . $data['error']);
            }
        }
        $this->session->set_flashdata('ok', 'Simpan pengaturan layout berhasil');
        redirect($this->dir . '/layout');
    }
}

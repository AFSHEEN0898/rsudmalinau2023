<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Parameter extends CI_Controller
{

    var $dir = 'siatika/parameter';
    var $folder = 'siatika';

    function __construct()
    {

        parent::__construct();
        login_check($this->session->userdata('login_state'));
    }

    public function index()
    {

        $this->umum();
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

    function umum()
    {

        $data['breadcrumb'] = array('' => 'Pengaturan', $this->folder . '/parameter' => 'Parameter');
        $data['title'] = 'Pengaturan TV Umum';

        $data['vals'] = $this->general_model->get_param(
            array(
                'refresh_time_1', 'color_basic_1',
                'color_header_1', 'color_text_header_1',
                'color_footer_1', 'color_text_footer_1',
                'color_time_1', 'color_text_time_1',
                'color_date_1', 'color_text_date_1',
                'color_pengumuman_1', 'color_title_pengumuman_1', 'color_box_pengumuman_1', 'color_text_pengumuman_1', 'height_pengumuman_1', 'font_pengumuman_1',
                'color_informasi_1', 'color_title_informasi_1', 'color_box_informasi_1', 'color_text_informasi_1', 'height_informasi_1', 'font_informasi_1',
                'color_berlangsung_1', 'color_title_berlangsung_1', 'color_box_berlangsung_1', 'color_text_berlangsung_1', 'height_berlangsung_1', 'font_berlangsung_1',
                'color_rencana_1', 'color_title_rencana_1', 'color_box_rencana_1', 'color_text_rencana_1', 'height_rencana_1', 'font_rencana_1',
                'color_foto_1', 'color_title_foto_1', 'color_box_foto_1', 'color_text_foto_1', 'height_foto_1', 
                'color_video_1', 'color_title_video_1', 'color_box_video_1', 'color_text_video_1', 'height_video_1', 
                'color_foto_pegawai', 'height_foto_pegawai', 'slide_foto_pegawai',
                 'mode_video_umum',

            ),
            2
        );

        $data['cb_mode']    = array(
            '' => '--Pilih--',
            '1' => 'Video',
            '2' => 'Youtube'
        );
 
        $title = 'Pengaturan TV Umum';
        $tab1 = array('text' => 'Umum', 'on' => 1, 'url' => site_url($this->folder . '/parameter/umum/'));
        $tab2 = array('text' => 'Internal', 'on' => NULL, 'url' => site_url($this->folder . '/parameter/internal/'));
        $data['title']         = $title;
        $data['tabs'] = array($tab1, $tab2);
        $data['content'] = $this->folder . '/umum_view';
        $this->load->view('home', $data);
    }

    function internal()
    {

        $data['breadcrumb'] = array('' => 'Pengaturan', $this->folder . '/parameter' => 'Parameter');
        $data['title'] = 'Pengaturan TV Internal';

        $data['vals'] = $this->general_model->get_param(
            array(
                'refresh_time_2', 'color_basic_2',
                'color_header_2', 'color_text_header_2',
                'color_footer_2', 'color_text_footer_2',
                'color_time_2', 'color_text_time_2',
                'color_date_2', 'color_text_date_2',
                'color_pengumuman_2', 'color_title_pengumuman_2', 'color_box_pengumuman_2', 'color_text_pengumuman_2', 'height_pengumuman_2', 'font_pengumuman_2',
                'color_informasi_2', 'color_title_informasi_2', 'color_box_informasi_2', 'color_text_informasi_2', 'height_informasi_2', 'font_informasi_2',
                'color_foto_2', 'color_title_foto_2', 'color_box_foto_2', 'color_text_foto_2', 'height_foto_2', 
                'color_profil_1', 'color_title_profil_1', 'color_box_profil_1', 'color_text_profil_1', 'height_profil_1', 'font_profil_1',


            ),
            2
        );

        $title = 'Pengaturan TV Internal';
        $tab1 = array('text' => 'Umum', 'on' => NULL, 'url' => site_url($this->folder . '/parameter/umum/'));
        $tab2 = array('text' => 'Internal', 'on' => 1, 'url' => site_url($this->folder . '/parameter/internal/'));
        $data['title']         = $title;
        $data['tabs'] = array($tab1, $tab2,);
        $data['content'] = $this->folder . '/internal_view';
        $this->load->view('home', $data);
    }

    function simpan_umum()
    {

        $keys = $this->input->post('keys');
        $vals = $this->input->post('vals');

        for ($i = 0; $i < count($keys); $i++) {
            $g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $keys[$i])));
            if ($g->num_rows() > 0) $this->ubah_param($keys[$i], $vals[$i]);
            else $this->simpan_param($keys[$i], $vals[$i]);
        }

        $this->session->set_flashdata('ok', 'Pengaturan TV Umum berhasil disimpan ...');
        redirect($this->folder . '/parameter');
    }

    function simpan_internal()
    {

        $keys = $this->input->post('keys');
        $vals = $this->input->post('vals');

        for ($i = 0; $i < count($keys); $i++) {
            $g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $keys[$i])));
            if ($g->num_rows() > 0) $this->ubah_param($keys[$i], $vals[$i]);
            else $this->simpan_param($keys[$i], $vals[$i]);
        }

        $this->session->set_flashdata('ok', 'Pengaturan TV Internal berhasil disimpan ...');
        redirect($this->dir . '/internal');
    }
}

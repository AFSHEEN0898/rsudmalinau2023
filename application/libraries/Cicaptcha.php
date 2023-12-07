<?php 

class Cicaptcha 
{
  function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->helper('cicaptcha');
  }  

  function show() {

    $vals = array(
        'img_path'	=> FCPATH.'cicaptcha/captcha/',
        'img_url'	=> base_url('cicaptcha/captcha').'/',
        'font_path'  => FCPATH . 'cicaptcha/fonts/calibri.ttf',
        'img_width'	=> 100,
        'img_height' => 25,
        'expiration' => 7200,
        'word_length' => 5
    );

    $cap = create_captcha($vals);

    $data = array(
        'captcha_time'	=> $cap['time'],
        'ip_address'	=> $this->ci->input->ip_address(),
        'word'	=> $cap['word']
        );

    $query = $this->ci->db->insert_string('captcha', $data);
    $this->ci->db->query($query);

    return $cap['image'];
  
  }
  

  
  
  
}


?>
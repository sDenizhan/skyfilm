<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function index() {
		$this->load->view('admin/login');
	}
	
	public function login(){
				
		$this->form_validation->set_rules('frmKullaniciAdi', 'Kullanıcı Adı', 'required');
        $this->form_validation->set_rules('frmSifre', 'Şifre', 'required');
        
        $this->form_validation->set_message('required', '%s alanını girmek zorundasınız.');
 
		if ($this->form_validation->run() == false ) {
			$this->load->view('admin/login');
		} else {
			$_kullaniciAdi = $this->input->post('frmKullaniciAdi', TRUE);
			$_sifre = $this->input->post('frmSifre', TRUE);
			
			$this->load->library('uye');
			$uye = $this->uye->giris_yap($_kullaniciAdi, $_sifre);
			
			if ($this->uye->giris_kontrol()) {

				redirect('admin/panel/index');		
				
			} else {
				$this->session->set_flashdata("hata",$uye);
				redirect('admin/index');
			}

		}
		
	}

}
?>
<?php
if (!defined('BASEPATH')) die('Hadi Başka Kapıyaa');

class Adminprofil extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('SD_Admin');
		$this->load->library('SD_Logger', array("UserID" => $this->session->userdata("KullaniciID"), "UserName" => $this->session->userdata("KullaniciAdi")));
		if (!$this->sd_admin->loginControl(array("GirenKim" => "Admin", "NeIstiyor" => "Yönetmek"))) {
			$this->sd_admin->logout();
		}
		$this->load->model('dbtools_model', 'dbt');
		
	}
	
	public function index() {
		redirect(site_url('AdminProfil/ProfilGoster/'.$this->session->userdata('KullaniciID').'/'.$this->session->userdata('KullaniciAdi')));
	}
	
	
	public function ProfilGoster() {
		$_p = $this->dbt->is_ok('t_admin', $this->uri->segment(3)); 
		
		if ($_p != FALSE) {
			$_data['_profil'] = $_p->row();
			$this->load->view('admin/Profil',$_data);	
		} else {
			$_data["_hata"] = "Kullanıcı Bulunamadı";
			$this->load->view('admin/Profil', $_data);
		}
		
		
	}
	
	public function ProfilKaydet(){
		$_profilID = $this->uri->segment(3);
		
		if (!is_numeric($_profilID) || empty($_profilID) ) {
			redirect('AdminPanel');
		} else {
			
			$this->form_validation->set_rules('frmAd', 'Ad Soyad', 'required|xss_clean');
			$this->form_validation->set_rules('frmAdres', 'Adres', 'required|xss_clean');
			$this->form_validation->set_rules('frmIlce', 'İlçe', 'required|xss_clean');
			$this->form_validation->set_rules('frmSehir', 'Şehir', 'required|xss_clean');
			$this->form_validation->set_rules('frmCep', 'Cep Telefonu', 'required|xss_clean');
			
			$this->form_validation->set_message('required', '%s alanını girmek zorundasınız.');
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('admin/ajax_formvalidation_error');
			} else {
				$_adSoyad = $this->input->post('frmAd', TRUE);
				$_adres = $this->input->post('frmAdres', TRUE);
				$_ilce = $this->input->post('frmIlce', TRUE);
				$_sehir = $this->input->post('frmSehir', TRUE);
				$_cep = $this->input->post('frmCep', TRUE);
				
				$_update = $this->dbt->update('t_admin', $_profilID, array("f_AdSoyad" => $_adSoyad, "f_Adres" => $_adres, "f_Ilce" => $_ilce, "f_Sehir" => $_sehir, "f_CepTelefonu" => $_cep));
				
				if ($_update) {
					$this->load->view('admin/ajax_ok', array("_mesaj" => "Bilgiler Güncellendi."));
					$this->sd_logger->_insert("Kullanıcı Profil Bilgileri Güncellendi");
				} else {
					$this->load->view('admin/ajax_error', array("_mesaj" => "Bilgiler Güncellenemedi."));
					$this->sd_logger->_insert("Kullanıcı Profil Bilgileri Güncellenemedi");
				}
				
			}
			
			
		}
	}
	
	
public function GirisBilgileriKaydet(){
		$_profilID = $this->uri->segment(3);
		
		if (!is_numeric($_profilID) || empty($_profilID) ) {
			redirect('AdminPanel');
		} else {
			
			$this->form_validation->set_rules('frmKullaniciAdi', 'Kullanıcı Adı', 'trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('frmSifre', 'Şifre', 'trim|matches[frmSifreTekrar]|min_length[5]|max_length[12]|required');
			$this->form_validation->set_rules('frmSifreTekrar', 'Şifre Tekrarı', 'trim|required');
			$this->form_validation->set_rules('frmEmail', 'Email Adresi', 'trim|valid_email|required|xss_clean');

			$this->form_validation->set_message('required', '<b>%s</b> alanını girmek zorundasınız.');
			$this->form_validation->set_message('valid_email', '<b>%s</b> alanına doğru bir email adresi giriniz.');
			$this->form_validation->set_message('min_length', '<b>%s</b> alanı en az <b>%d</b> karakter olmalıdır.');
			$this->form_validation->set_message('max_length', '<b>%s</b> alanı en fazla <b>%d</b> karakter olmalıdır.');
			$this->form_validation->set_message('matches', '<b>%s</b> alanı ile <b>%s</b> alanı aynı olmalıdır.');
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('admin/ajax_formvalidation_error');
			} else {
				$_KullaniciAdi = $this->input->post('frmKullaniciAdi', TRUE);
				$_Sifre = $this->input->post('frmSifre', TRUE);
				$_Email = $this->input->post('frmEmail', TRUE);
				
				$_update = $this->dbt->update('t_admin', $_profilID, array("f_KullaniciAdi" => $_KullaniciAdi, "f_Sifre" => do_hash($_Sifre), "f_Email" => $_Email));
				
				if ($_update) {
					$this->load->view('admin/ajax_ok', array("_mesaj" => "Bilgiler Güncellendi."));
					$this->sd_logger->_insert("Kullanıcı Giriş Bilgileri Güncellendi");
				} else {
					$this->load->view('admin/ajax_error', array("_mesaj" => "Bilgiler Güncellenemedi."));
					$this->sd_logger->_insert("Kullanıcı Firiş Bilgileri Güncellenemedi");
				}
				
			}
			
			
		}
	}
	
}

?>
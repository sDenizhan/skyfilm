<?php
if (!defined('BASEPATH')) exit('No direct allow');

class SSS extends AdminController {

	function __construct() {
		parent::__construct();
	}

	public function index(){
		$_sorular= $this->db->get('siksorulansorular');
		
		if ($_sorular->num_rows() > 0) {

			 $_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
		
			$config["base_url"] = base_url("admin/sss/index");
			$config["total_rows"] = $_sorular->num_rows();
			$config["per_page"] = 25;
			$config["uri_segment"] = 4;

			include APPPATH.'/config/admin-pagination.php';
		
			$this->pagination->initialize($config);

			$_data['_sorular'] = $this->db->get('siksorulansorular', $config['per_page'], $_page);
            $_data['_pages'] = $this->pagination->create_links();
			$this->render('sss_index', $_data);
		
		
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/sss/soruekle").'"> Soru Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}
	}
	
	public function soruekle(){
		
		$this->js['nolink'] = 'jquery.tagsinput.min.js';
		$this->styles = array('jquery.tagsinput.css');
	
		$this->render('sss_soruekle');
	}
	
	public function sorukaydet(){
		
		$this->form_validation->set_rules('frmSoru', 'Soru', 'trim|required|xss_clean');
		$this->form_validation->set_rules('frmSoruAciklamasi', 'Soru Açıklaması', 'trim|required|xss_clean');
		$this->form_validation->set_rules('frmSoruEtiketleri', 'Soru Etiketleri', 'trim|required|xss_clean');
	
		if ($this->form_validation->run() == FALSE) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => 'Kayıt Eklenemedi. <b><a href="'.base_url("admin/sss/soruekle").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		} else {
			
			$soru = $this->input->post('frmSoru', TRUE);
			$aciklama = ckeditor_html_clear($this->input->post('frmSoruAciklamasi', TRUE));
			$soruEtiketleri = $this->input->post('frmSoruEtiketleri', TRUE);
			$tarih = time();
			
			$insert = $this->db->insert('siksorulansorular', array('soru' => $soru, 'aciklama' => $aciklama, 'tarih' => $tarih));
			
			if ($insert) {
				$exp = explode(',', $soruEtiketleri);
				$soruID = $this->db->insert_id();
				
				foreach ($exp as $etiket) {
					$this->db->insert('etiketler', array('eklenti_id' => $soruID, 'tur' => 'sss', 'etiket' => $etiket));	
				}
				
				$_data['e'] = (object) array('durum' => 'ok', 'type' => '', 'mesaj' => 'Kayıt Eklendi. <b><a href="'.base_url("admin/sss").'"> Sorular </a></b>');
				$this->render('errorpage', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Eklenemedi. <b><a href="'.base_url("admin/sss/soruekle").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}		
			
		}	
		
		
	}
	
	public function soruduzelt(){
		$_soruID = $this->uri->segment(4);
	
		if (!is_numeric($_soruID) || empty($_soruID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Düzeltilecek Kayıt ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/sss").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_soru = $this->db->get_where('siksorulansorular', array('id' => $_soruID));
		
			if ($_soru->num_rows() > 0) {
				$_data['_soru'] = $_soru->row();
				
				$etiketler = $this->db->get_where('etiketler', array('eklenti_id' => $_soru->row()->id, 'tur' => 'sss'));
				
				if ($etiketler != FALSE ) :
					$_data['_etiketler'] = $etiketler;
				else:
					$_data['_etiketler'] = FALSE;
				endif;
				
				$this->js['nolink'] = 'jquery.tagsinput.min.js';
				$this->styles = array('jquery.tagsinput.css');
				
				
				$this->render('sss_soruduzelt', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/sss").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
			
		endif;
	}
	
	public function soruduzeltkaydet(){
		$_soruID = $this->uri->segment(4);
	
		if (!is_numeric($_soruID) || empty($_soruID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Düzeltilecek Kayıt ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/sss").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_soru = $this->db->get_where('siksorulansorular', array('id' => $_soruID));
		
			if ($_soru->num_rows() > 0) {
				
				$this->form_validation->set_rules('frmSoru', 'Soru', 'trim|required|xss_clean');
				$this->form_validation->set_rules('frmSoruAciklamasi', 'Soru Açıklaması', 'trim|required|xss_clean');
				$this->form_validation->set_rules('frmSoruEtiketleri', 'Soru Etiketleri', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE) {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => 'Kayıt Eklenemedi. <b><a href="'.base_url("admin/sss").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				} else {
						
					$soru = $this->input->post('frmSoru', TRUE);
					$aciklama = ckeditor_html_clear($this->input->post('frmSoruAciklamasi', TRUE));
					$soruEtiketleri = $this->input->post('frmSoruEtiketleri', TRUE);
					$tarih = time();
						
					$update = $this->db->update('siksorulansorular', array('soru' => $soru, 'aciklama' => $aciklama, 'tarih' => $tarih), array('id' => $_soruID));
						
					if ($update) {
						
						$delete = $this->db->delete('etiketler', array('eklenti_id' => $_soruID, 'tur' => 'sss'));
						
						$exp = explode(',', $soruEtiketleri);
						
						foreach ($exp as $etiket) {
							$this->db->insert('etiketler', array('eklenti_id' => $_soruID, 'tur' => 'sss', 'etiket' => $etiket));
						}
						
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Soru Düzeltild..! <b><a href="'.base_url("admin/sss").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Soru Düzeltilemedi..! <b><a href="'.base_url("admin/sss").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					}
						
				}				
				
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("AdminSSS").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
			
		endif;
	}
	
	public function sorusil(){
		$_soruID = $this->uri->segment(4);
	
		if (!is_numeric($_soruID) || empty($_soruID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek Kayıt ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/sss").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_soru = $this->db->get_where('siksorulansorular', array('id' => $_soruID));
		
			if ($_soru->num_rows() > 0) {
				
				$delete = $this->db->delete('siksorulansorular', array('id' => $_soruID));
				
				if ($delete) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("AdminSSS").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("AdminSSS").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				}
				
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("AdminSSS").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
			
		endif;
	}
}

/* End of File : sss.php */
/* Location : ./application/controllers/admin/sss.php */
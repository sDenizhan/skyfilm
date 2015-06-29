<?php
if (!defined('BASEPATH')) exit('Direk Erişim Yasaktır.');

class Mesajlar extends AdminController {

	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		$_mesajlar = $this->db->get("mesajlar");
		
		if ($_mesajlar->num_rows() > 0) {

			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
			
			$config["base_url"] = base_url("admin/mesajlar/index/");
			$config["total_rows"] = $_mesajlar->num_rows();
			$config["per_page"] = 25;
			$config["uri_segment"] = 4;
			
			include APPPATH.'/config/admin-pagination.php';
			
			$this->pagination->initialize($config);
			$_data['_pages'] = $this->pagination->create_links();
		
			$_data['_mesajlar'] = $this->db->get_where("mesajlar", array(), $config["per_page"], $_page);

			$this->render('mesajlar_index', $_data);

		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı.');
			$this->render('errorpage', $_data);	
		}
		
	}
	
	public function mesajoku(){
		$_mesajID = $this->uri->segment(4);
		
		if (empty($_mesajID) || !is_numeric($_mesajID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Mesaj ID Bilgisi Bulunamadı. <b><a href="'.base_url("admin/mesajlar").'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		} else {
			
			$_mesaj = $this->db->get_where('mesajlar', array('id' => $_mesajID));
			
			if ($_mesaj->num_rows() > 0) {
			
				$_data['_mesajlar'] = $_mesaj->row();
				$this->render('mesajlar_mesajoku', $_data);
				
				$_update = $this->db->update('mesajlar', array('yeni' => 'Hayir'), array('id' => $_mesajID));
				
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/mesajlar").'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			}
			
			
		}
		
	}
	
	public function mesajsil(){
		$_mesajID = $this->uri->segment(4);
		
		if (!is_numeric($_mesajID) || empty($_mesajID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Mesaj ID Bilgisi Bulunamadı. <b><a href="'.base_url("admin/mesajlar").'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$_mesaj = $this->db->get_where('mesajlar', array('id' => $_mesajID));
			
			if ($_mesaj->num_rows() > 0) :

				$_delete = $this->db->delete('mesajlar', array('id' => $_mesajID));
			
				if ($_delete > 0) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/mesajlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/mesajlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/mesajlar").'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
		
	}
	
	public function cevapgonder(){
		
		$this->form_validation->set_rules('frmGonderenAdi', 'Gönderen Adı', 'required');
		$this->form_validation->set_rules('frmAliciAdSoyad', 'Alıcı Adı ve Soyadı', 'required');
		$this->form_validation->set_rules('frmAliciEmail', 'Alıcının Email Adresi', 'required');
		$this->form_validation->set_rules('frmKonu', 'Konu', 'required');
		$this->form_validation->set_rules('frmMesaj', 'Mesaj', 'required');
		
		if ($this->form_validation->run() == FALSE ) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. $this->agent->referrer() .'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);	
		} else {
			
			$_gonderenAdi = $this->input->post('frmGonderenAdi');
			$_aliciAdSoyad = $this->input->post('frmAliciAdSoyad');
			$_aliciEmail = $this->input->post('frmAliciEmail');
			$_konu = $this->input->post('frmKonu');
			$_mesaj = $this->input->post('frmMesaj');	
			
			$_emailConf['mailtype'] = "text";
			$_emailConf['priority'] = 5;
			
			$this->load->library("email", $_emailConf);
			$this->email->clear(TRUE);
			$this->email->from('noreply@keyfisinema.net', $_aliciAdSoyad);
			$this->email->to($_aliciEmail);
			$this->email->subject($_konu);
			$this->email->message($_mesaj);
				
			if ($this->email->send() != FALSE ) {
				$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Mail Gönderildi. <b><a href="'. $this->agent->referrer() .'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);		
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Mail Gönderilemedi. <b><a href="'. $this->agent->referrer() .'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			}
		}
		
		
	}
	
}

/* End of file : AdminMesajlar.php */
/* Location : ./application/controllers/AdminMesajlar.php */
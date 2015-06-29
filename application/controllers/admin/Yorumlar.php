<?php
if (!defined('BASEPATH')) exit('No Direct Allow');

class Yorumlar extends AdminController {

	function __construct() {
		parent::__construct();
	}

	public function index(){
		$_yorumlar = $this->db->get("yorumlar");
		
		if ($_yorumlar->num_rows() > 0) {

			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
			
			$config["base_url"] = base_url("admin/yorumlar/index/");
			$config["total_rows"] = $_yorumlar->num_rows();
			$config["per_page"] = 25;
			$config["uri_segment"] = 4;
			
			include APPPATH.'/config/admin-pagination.php';
			
			$this->pagination->initialize($config);
			$_data['_pages'] = $this->pagination->create_links();
		
			$_data['_yorumlar'] = $this->db->get("yorumlar",  $config["per_page"], $_page);

			$this->render('yorumlar_index', $_data);

		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı.');
			$this->render('errorpage', $_data);	
		}
	}
	
	
	public function yorumsil() {
		$_yorumID = $this->uri->segment(4);
		
		if (!is_numeric($_yorumID) || empty($_yorumID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		else:
			$yorum = $this->db->get_where('yorumlar', array('id' => $_yorumID));
			
			if ($yorum->num_rows() > 0):
		
				$_delete = $this->db->delete('yorumlar', array("id" => $_yorumID));
			
				if ($_delete) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	}

	public function yorumoku(){
		$_yorumID = $this->uri->segment(4);
		
		if (empty($_yorumID) || !is_numeric($_yorumID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		} else {
				
			$yorum = $this->db->get_where('yorumlar', array('id' => $_yorumID));
		
			if ($yorum->num_rows() > 0) {
				$_data['_yorum'] = $yorum->row();
				
				$_film = $this->db->get_where('filmler', array('id' => $yorum->row()->film_id));
				
				$_data['_film'] = $_film != FALSE ? $_film->row() : FALSE;
				
				$this->render('yorumlar_yorumoku', $_data);		
			} else {
				$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
				$this->render('errorpage', $_data);
			}
				
				
		}
	}
	
	public function yorumonayla(){
		$_yorumID = $this->uri->segment(4);
		
		if (!is_numeric($_yorumID) || empty($_yorumID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		} else {
		
			$yorum = $this->db->get_where('yorumlar', array('id' => $_yorumID));
			
			if ($yorum->num_rows() > 0) {
				$_update = $this->db->update('yorumlar', array('onay' => 'Onayli'), array('id' => $_yorumID));
				if ($_update) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Yorum Onaylandı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Yorum Onaylanamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				}
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
				$this->render('errorpage', $_data);
			}
		
		
		}
	}
	
	public function yorumpasifle(){
		$_yorumID = $this->uri->segment(4);
		
		if (!is_numeric($_yorumID) || empty($_yorumID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		} else {
		
			$yorum = $this->db->get_where('yorumlar', array('id' => $_yorumID));
			
			if ($yorum->num_rows() > 0) {
				$_update = $this->db->update('yorumlar', array('onay' => 'Onaysiz'), array('id' => $_yorumID));
				if ($_update) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Yorum Pasifleştirildi...! <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Yorum Pasifleştirilemedi..! <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				}
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
				$this->render('errorpage', $_data);
			}
		
		
		}
	}
	
	public function yorumcevapla(){
		$_yorumID = $this->uri->segment(4);
		
		if (!is_numeric($_yorumID) || empty($_yorumID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		} else {
		
			$yorum = $this->db->get_where('yorumlar', array('id' => $_yorumID));
		
			if ($yorum->num_rows() > 0) {
				$_data['_yorum'] = $yorum->row();
				
				$_film = $this->db->get_where('filmler', array('id' => $yorum->row()->id));
				
				$_data['_film'] = $_film != FALSE ? $_film->row() : FALSE;
				
				$this->render('yorumlar_yorumcevapla', $_data);	
				
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
				$this->render('errorpage', $_data);
			}
		
		
		}
	}
	
	
	public function yorumcevaplakaydet(){
		$_yorumID = $this->uri->segment(4);
		
		if (!is_numeric($_yorumID) || empty($_yorumID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		} else {
		
			$_yorum = $this->db->get_where('yorumlar', array('id' => $_yorumID));
		
			if ($_yorum->num_rows() > 0) {
				
				$this->form_validation->set_rules('frmYorumCevap', 'Cevap', 'required');
			
				if ($this->form_validation->run() == FALSE) {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. $this->agent->referrer() .'">Geri Dönmek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_uyeID = uyebilgisi('id');
					$_filmID = $_yorum->row()->film_id;
					$_adSoyad =  uyebilgisi('adsoyad');
					$_email = uyebilgisi('email');
					$_tarih = time();
					$_cevap = $this->input->post('frmYorumCevap');
					
					$_insert = $this->db->insert('yorumlar', array('uye_id' => $_uyeID, 'film_id' => $_filmID, 'ad_soyad' => $_adSoyad, 'email' => $_email, 'tarih' => $_tarih, 'yorum' => $_cevap, 'onay' => 'Onayli', 'ana_yorum_id' => $_yorumID));
					
					if ($_insert) {
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' =>  'Yorum Cevaplandı..! <b><a href="'. $this->agent->referrer() .'">Geri Dönmek İçin Tıklayınız </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Yorum Cevaplanamadı..! <b><a href="'. $this->agent->referrer() .'">Geri Dönmek İçin Tıklayınız </a></b>');
						$this->render('errorpage', $_data);
					}
				}
				
				
		
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/yorumlar").'">Geri Dönmek İçin Tıklayınız </a></b>');
				$this->render('errorpage', $_data);
			}
		
		
		}
		
	}
	
}

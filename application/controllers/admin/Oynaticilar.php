<?php
if (!defined('BASEPATH')) exit('Hadi Ordan Bye Byee');

class Oynaticilar extends AdminController {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index(){
		
		$_oynaticilar = $this->db->get('oynaticilar');
		
		if ( $_oynaticilar->num_rows() > 0) {
			
			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}

			$config["base_url"] = base_url("admin/oynaticilar/index/");
			$config["total_rows"] = $_oynaticilar->num_rows();
			$config["per_page"] = 10;
			$config["uri_segment"] = 4;

			include APPPATH.'/config/admin-pagination.php';

			$this->pagination->initialize($config);
					
			$_data['_oynaticilar'] = $this->db->get("oynaticilar",  $config['per_page'], $_page);
			$_data['_pages'] = $this->pagination->create_links();
			
			$this->render('oynaticilar_index', $_data);
			
			
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/oynaticilar/ekle").'"> Oynatıcı Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}
		
	}
	
	
	public function ekle(){
		$this->render('oynaticilar_ekle');
	}
	
	public function eklekaydet(){

		$this->form_validation->set_rules('frmPlayerAdi', 'Oynatıcı Adı', 'trim|required');
		$this->form_validation->set_rules('frmPlayerKod', 'Oynatıcı Kodları', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) :
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'.base_url("admin/oynaticilar/ekle").'"> Oynatıcı Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_playerAdi = $this->input->post('frmPlayerAdi');
			$_playerKod = $this->input->post('frmPlayerKod');
			$_onlydb = $this->input->post('frmOnlyDB');
			
			if ($_onlydb == 'onlydb') {
				$_insert = $this->db->insert('oynaticilar', array('oynatici_adi' => $_playerAdi, 'oynatici_kodu' => $_playerKod));
				
				if ($_insert) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Oynatıcı Kaydedildi..! <b><a href="'.base_url("admin/oynaticilar/ekle").'"> Oynatıcı Eklemek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Oynatıcı Kaydedilemedi...! <b><a href="'.base_url("admin/oynaticilar/ekle").'"> Oynatıcı Eklemek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				}
			} else {
				if ( ! write_file('./others/players/'.seoURL($_playerAdi).'.php', $_playerKod, 'w+')) {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Oynatıcı Yazdırılamadı..! <b><a href="'.base_url("admin/oynaticilar/ekle").'"> Oynatıcı Eklemek İçin Tıklayınız </a></b>');
					$this->render('errorpage', $_data);
				} else {					
					$_insert = $this->db->insert('oynaticilar', array('oynatici_adi' => $_playerAdi, 'oynatici_kodu' => $_playerKod));
					
					if ($_insert) {
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Oynatıcı Kaydedildi..! <b><a href="'.base_url("admin/oynaticilar/ekle").'"> Oynatıcı Eklemek İçin Tıklayınız </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Oynatıcı Kaydedilemedi...! <b><a href="'.base_url("admin/oynaticilar/ekle").'"> Oynatıcı Eklemek İçin Tıklayınız </a></b>');
						$this->render('errorpage', $_data);
					}
				}
			}
		
		endif;
		
	}
	
	public function oynaticisil(){
		$_playerID = $this->uri->segment(4);
		
		if (!is_numeric($_playerID) || empty($_playerID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bilgisine Ulaşılamadı..! <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_file = $this->db->get_where('oynaticilar', array('id' => $_playerID));

			if ( $_file->num_rows() > 0):
			
				$_filename = $_file->row()->oynatici_adi;

				$_delete = $this->db->delete('oynaticilar', array("id" => $_playerID));
			
				if ($_delete) :
					@unlink('./others/players/'.$_filename.'.php');
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	}
	
	
	public function oynaticiduzelt(){
		$_playerID = $this->uri->segment(4);
		
		if (!is_numeric($_playerID) || empty($_playerID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bilgisine Ulaşılamadı..! <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_player = $this->db->get_where('oynaticilar', array('id' => $_playerID));
			
			if ($_player->num_rows() > 0 ) {
				$_data['_player'] = $_player;
				$this->render('oynaticilar_oynaticiduzelt', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
					
		endif;		
	}
	
	
	public function oynaticiduzeltkaydet() {
		$this->form_validation->set_rules('frmPlayerAdi', 'Oynatıcı Adı', 'trim|required');
		$this->form_validation->set_rules('frmPlayerKod', 'Oynatıcı Kodları', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) :
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_playerID = $this->uri->segment(4);
			$_playerAdi = $this->input->post('frmPlayerAdi');
			$_playerKod = $this->input->post('frmPlayerKod');			

			if ( ! write_file('./others/players/'.seoURL($_playerAdi).'.php', $_playerKod, 'w+')) {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Oynatıcı Yazdırılamadı. <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			} else {
				
				$_update = $this->db->update('oynaticilar', array('oynatici_adi' => $_playerAdi, 'oynatici_kodu' => $_playerKod), array('id' => $_playerID));
					
				if ($_update) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Oynatıcı Düzeltildi. <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Oynatıcı Düzeltilemedi. <b><a href="'.base_url("admin/oynaticilar").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				}
			}
					
		endif;
	} 
	
	
}
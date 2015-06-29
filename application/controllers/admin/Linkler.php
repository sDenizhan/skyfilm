<?php
if (!defined('BASEPATH')) exit('Direk Erişim Yasaktır.');

class Linkler extends AdminController {

	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		$linkler = $this->db->get_where("baglantilar");
		
		if ($linkler->num_rows() > 0) {

			$_page = $this->uri->segment(3);
			
			if (empty($_page))
			{
				$_page = 0;
			}
			
			$config["base_url"] = base_url("admin/linkler/index");
			$config["total_rows"] = $linkler->num_rows();
			$config["per_page"] = 10;
			$config["uri_segment"] = 4;
			
			include APPPATH.'/config/admin-pagination.php';
			
			$this->pagination->initialize($config);
			
			$_data['_pages'] = $this->pagination->create_links();
			$_data['_links'] = $this->db->get('baglantilar', $config['per_page'], $_page);
			
			$this->render('linkler_index', $_data);
			
		
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı.<a href="'. base_url('admin/linkler/linkekle') .'"> Bağlatı Ekle </a>');
			$this->render('errorpage', $_data);	
		}
		
	}
	
	
	public function linkekle(){
		$this->render('linkler_linkekle');
	}
	
	public function linkeklekaydet(){
		$this->form_validation->set_rules('frmBaglantiAdi', 'Bağlantı Adı', 'required');
		$this->form_validation->set_rules('frmBaglantiAdresi', 'Bağlanti Adresi', 'required');
		$this->form_validation->set_rules('frmBaglantiAciklamasi', 'Bağlanti Açıklaması', 'required');
		$this->form_validation->set_rules('frmBaglantiTuru', 'Bağlantı Türü', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			
			$baglantiAdi = $this->input->post('frmBaglantiAdi');
			$baglantiAdresi = $this->input->post('frmBaglantiAdresi');
			$baglantiAciklamasi = $this->input->post('frmBaglantiAciklamasi');
			$baglantiturleri = $this->input->post('frmBaglantiTuru');
			
			$baglantiturleri = implode(" ", $baglantiturleri);
			
			$insert = $this->db->insert('baglantilar', array('ad' => $baglantiAdi, 'url' => $baglantiAdresi, 'aciklama' => $baglantiAciklamasi, 'rel' => $baglantiturleri, 'tarih' => time(), 'hit' => '0'));
			
			if ($insert){
                $_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Eklendi.<a href="'. base_url('admin/linkler/linkekle') .'"> Bağlatı Ekle </a> | <a href="'. base_url('admin/linkler') .'"> Bağlatılar </a> ');
                $this->render('errorpage', $_data);
			} else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Eklenemedi.<a href="'. base_url('admin/linkler/linkekle') .'"> Geri Dön </a>');
                $this->render('errorpage', $_data);
			}
			
		} else {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '.<a href="'. base_url('admin/linkler/linkekle') .'"> Geri Dön </a>');
            $this->render('errorpage', $_data);
		}

	}
	
	
	public function linkduzeltkaydet(){
		$_baglantiID = $this->uri->segment(4);
	
		if (!is_numeric($_baglantiID) || empty($_baglantiID) ):
			$this->load->view('admin/ajax_error', array('_mesaj' => 'NoPost'));
		else:
			
			$_baglanti = $this->db->get_where('baglantilar', array('id' => $_baglantiID));

			if ( $_baglanti->num_rows() > 0):
				$this->form_validation->set_rules('frmBaglantiAdi', 'Bağlantı Adı', 'required');
				$this->form_validation->set_rules('frmBaglantiAdresi', 'Bağlanti Adresi', 'required');
				$this->form_validation->set_rules('frmBaglantiAciklamasi', 'Bağlanti Açıklaması', 'required');
			
				if ($this->form_validation->run() != FALSE) {
			
					$baglantiAdi = $this->input->post('frmBaglantiAdi');
					$baglantiAdresi = $this->input->post('frmBaglantiAdresi');
					$baglantiAciklamasi = $this->input->post('frmBaglantiAciklamasi');
					$baglantiturleri = $this->input->post('frmBaglantiTuru');
						
					$baglantiturleri = implode(" ", $baglantiturleri);
			
					$update = $this->db->update('baglantilar', array('ad' => $baglantiAdi, 'url' => $baglantiAdresi, 'aciklama' => $baglantiAciklamasi, 'rel' => $baglantiturleri, 'tarih' => time(), 'hit' => '0'), array('id' => $_baglantiID));
			
					if ($update){
                        $_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Güncellendi.<a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
                        $this->render('errorpage', $_data);
					} else {
                        $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Güncellenemedi.<a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
                        $this->render('errorpage', $_data);
					}
			
				} else {
                    $_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '.<a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
                    $this->render('errorpage', $_data);
				}
			else:
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı.<a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
                $this->render('errorpage', $_data);
			endif;
			
		endif;
	}
	
	public function linkduzelt(){
		$_baglantiID = $this->uri->segment(4);
		
		if (!is_numeric($_baglantiID) || empty($_baglantiID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="'.site_url("admin/linkler").'"> Geri Dön </a>');
			$this->render('errorpage', $_data);
		else:
			$_baglanti = $this->db->get_where('baglantilar', array('id' => $_baglantiID));
			
			if ( $_baglanti->num_rows() > 0):
				$data['link'] = (object) $_baglanti->row();
				$this->render('linkler_linkduzelt', $data);
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="'.site_url("admin/linkler").'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
			
		endif;
		
	}
	
	public function linksil(){
		$_baglantiID = $this->uri->segment(4);
		
		if (!is_numeric($_baglantiID) || empty($_baglantiID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek ID Bilgisine Ulaşılamadı. <a href="'.site_url("admin/linkler").'"> Geri Dön </a>');
			$this->render('errorpage', $_data);
		else:
			$_sil = $this->db->get_where('baglantilar', array('id' => $_baglantiID));
			
			if ($_sil->num_rows() > 0):

				$_delete = $this->db->delete('baglantilar', array('id' => $_baglantiID));
			
				if ($_delete) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Bağlantı Silindi. <a href="'.site_url("admin/linkler").'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Bağlantı Silinemedi. <a href="'.site_url("admin/linkler").'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="'.site_url("admin/linkler").'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
		
	}
	
	
}

/* End of file : AdminLinks.php */
/* Location : ./application/controllers/AdminLinks.php */
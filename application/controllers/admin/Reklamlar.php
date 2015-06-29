<?php
if (!defined('BASEPATH')) exit('No direct allow');

class Reklamlar extends AdminController {

	function __construct() {
		parent::__construct();
	}

	public function index(){
		$reklamlar = $this->db->get('reklamlar');
		
		if ($reklamlar->num_rows() > 0) {

			$_page = $this->uri->segment(4);
				
			if (empty($_page))
			{
				$_page = 0;
			}
				
			$config["base_url"] = base_url("admin/reklamlar/index/");
			$config["total_rows"] = $reklamlar->num_rows();
			$config["per_page"] = 25;
			$config["uri_segment"] = 4;
			
			include APPPATH.'/config/admin-pagination.php';
			
			$this->pagination->initialize($config);

			$_data['_reklamlar'] = $this->db->get('reklamlar', $config["per_page"], $_page);
			$_data['_pages'] = $this->pagination->create_links();
			$this->render('reklamlar_index', $_data);
			
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/reklamlar/reklamekle").'"> Reklam Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}
	}

    public function filitrele()
    {

        if ($this->input->get())
        {
            $aranan = $this->input->get('aranan');
            $id = $this->input->get('id');
            $siralama = $this->input->get('siralama');

            if (!empty($aranan))
            {
                $this->db->like('reklam_adi', $aranan)->or_like('reklam_metni', $aranan);
            }

            if (!empty($id))
            {
                $this->db->where('id', $id);
            }

            $filmler = $this->db->get('reklamlar');

            if ($filmler->num_rows() > 0 )
            {
                $_page = $this->uri->segment(4);

                if (empty($_page))
                {
                    $_page = 0;
                }

                $config["base_url"] = base_url('admin/reklamlar/filitrele/?aranan='. $aranan .'&id='. $id .'&siralama='. $siralama);
                $config["total_rows"] = $filmler->num_rows();
                $config["per_page"] = 25;
                $config["uri_segment"] = 4;
                $config["page_query_string"] = TRUE;

                include APPPATH.'/config/admin-pagination.php';

                $this->pagination->initialize($config);

                if (!empty($aranan))
                {
                    $this->db->like('reklam_adi', $aranan)->or_like('reklam_metni', $aranan);
                }
                if (!empty($id))
                {
                    $this->db->where('id = ', $id);
                }
                $this->db->order_by('id', $siralama);

                $reklamlar = $this->db->get('reklamlar', $config['per_page'], $_page);

                $_data['_reklamlar'] = $reklamlar;
                $_data['_pages'] = $this->pagination->create_links();

                $this->render('reklamlar_index', $_data);
            } else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Aradığınız Kriterlere Uygun Reklam Bulunamadı..! <b><a href="'.base_url("admin/reklamlar").'"> Reklamlar </a></b>');
                $this->render('errorpage', $_data);
            }

        }
        else
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'GET Bilgisi Alınamadı..! <b><a href="'.base_url("admin/filmler").'"> Filmler </a></b>');
            $this->render('errorpage', $_data);
        }
    }

	public function reklamekle(){
		$this->render('reklamlar_reklamekle');
	}
	
	public function reklamkaydet(){
		
		$this->form_validation->set_rules('frmReklamAdi', 'Reklam Adı', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		} else {
			$_reklamAdi = $this->input->post('frmReklamAdi');
			$_reklamKonumu = $this->input->post('frmReklamKonumu');
			$_reklamDurumu = $this->input->post('frmReklamDurumu');
			$_reklamTuru = $this->input->post('frmReklamTuru');
			//html
			$_reklamHTML = $this->input->post('frmHTMLKodlar');
			//metin
			$_reklamImageAdresi = $this->input->post('frmReklamImageAdresi');
			$_reklamMetni = $this->input->post('frmReklamMetni');
			$_reklamAdresi = $this->input->post('frmReklamAdresi');
			$_reklamTitle = $this->input->post('frmReklamAciklamasi');
			//zaman
			$_zamanAktif = $this->input->post('frmZaman');
			$_zamanBaslangic = $this->input->post('frmZamanBaslangic');
			$_zamanBitis = $this->input->post('frmZamanBitis');

			
						
			$_insert = $this->db->insert('reklamlar', array(
						'reklam_adi' => $_reklamAdi,
						'reklam_turu' => $_reklamTuru,
						'reklam_kodu' => $_reklamHTML,
						'reklam_konumu' => $_reklamKonumu,
						'hit' => 0,
						'tik' => 0,
						'reklam_resmi' => $_reklamImageAdresi,
						'reklam_metni' => $_reklamMetni,
						'reklam_url' => $_reklamAdresi,
						'durum' => $_reklamDurumu,
						'reklam_title' => $_reklamTitle, //yeni
						'zaman_aktif' => $_zamanAktif, //yeni
						'baslangic_tarihi' => $_zamanBaslangic,
						'bitis_tarihi' => $_zamanBitis
					));
		
			if ($_insert) {
				$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam Eklendi. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Reklam Eklenemedi. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
							
		}

	}
	
	
	public function reklamsil(){
		$_reklamID = $this->uri->segment(4);
	
		if (!is_numeric($_reklamID) || empty($_reklamID) ):
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam ID Bilgisine Ulaşılamadı..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$reklam = $this->db->get_where('reklamlar', array('id' => $_reklamID));
			
			if ($reklam->num_rows() > 0):
	
				$_delete = $this->db->delete('reklamlar', array('id' => $_reklamID));
				
				if ($_delete) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	
	}
	
	
	public function reklampasifle(){
		$_reklamID = $this->uri->segment(4);
	
		if (!is_numeric($_reklamID) || empty($_reklamID) ):
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam ID Bilgisine Ulaşılamadı..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$reklam = $this->db->get_where('reklamlar', array('id' => $_reklamID));
			
			if ($reklam->num_rows() > 0):
	
				$_reklam = $this->db->update('reklamlar', array('durum' => 'pasif'), array('id' => $_reklamID));
	
				if ($_reklam) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam Pasifleştirildi..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Reklam Pasifleştirilemedi..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	
	}
	
	public function reklamaktifle(){
		$_reklamID = $this->uri->segment(4);
	
		if (!is_numeric($_reklamID) || empty($_reklamID) ):
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam ID Bilgisine Ulaşılamadı..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$reklam = $this->db->get_where('reklamlar', array('id' => $_reklamID));
			
			if ($reklam->num_rows() > 0):
	
				$_reklam = $this->db->update('reklamlar', array('durum' => 'aktif'), array('id' => $_reklamID));
	
				if ($_reklam) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam Aktifleştirildi..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Reklam Aktifleştirilemedi..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	
	}
	
	
	
	public function reklamduzelt(){
		$_reklamID = $this->uri->segment(4);
	
		if (!is_numeric($_reklamID) || empty($_reklamID) ):
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam ID Bilgisine Ulaşılamadı..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$reklam = $this->db->get_where('reklamlar', array('id' => $_reklamID));
			
			if ($reklam->num_rows() > 0) {
				$_data['_reklam'] = $reklam->row();
				$this->render('reklamlar_reklamduzelt', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			}
		
		
		endif;
	}
	
	
	public function reklamduzeltkaydet(){
		
		$_reklamID = $this->uri->segment(4);
	
		if (!is_numeric($_reklamID) || empty($_reklamID) ):
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Reklam ID Bilgisine Ulaşılamadı..! <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			
			$this->form_validation->set_rules('frmReklamAdi', 'Reklam Adı', 'required');
			
			if ($this->form_validation->run() == FALSE) {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
				$this->render('errorpage', $_data);
			} else {
				$_reklamAdi = $this->input->post('frmReklamAdi');
				$_reklamKonumu = $this->input->post('frmReklamKonumu');
				$_reklamDurumu = $this->input->post('frmReklamDurumu');
				$_reklamTuru = $this->input->post('frmReklamTuru');
				//html
				$_reklamHTML = $this->input->post('frmHTMLKodlar');
				//metin
				$_reklamImageAdresi = $this->input->post('frmReklamImageAdresi');
				$_reklamMetni = $this->input->post('frmReklamMetni');
				$_reklamAdresi = $this->input->post('frmReklamAdresi');
				$_reklamTitle = $this->input->post('frmReklamAciklamasi');
				//zaman
				$_zamanAktif = $this->input->post('frmZaman');
				$_zamanBaslangic = $this->input->post('frmZamanBaslangic');
				$_zamanBitis = $this->input->post('frmZamanBitis');
			
					
			
				$_update = $this->db->update('reklamlar', array(
						'reklam_adi' => $_reklamAdi,
						'reklam_turu' => $_reklamTuru,
						'reklam_kodu' => $_reklamHTML,
						'reklam_konumu' => $_reklamKonumu,
						'reklam_resmi' => $_reklamImageAdresi,
						'reklam_metni' => $_reklamMetni,
						'reklam_url' => $_reklamAdresi,
						'durum' => $_reklamDurumu,
						'reklam_title' => $_reklamTitle, //yeni
						'zaman_aktif' => $_zamanAktif, //yeni
						'baslangic_tarihi' => $_zamanBaslangic,
						'bitis_tarihi' => $_zamanBitis
				), array('id' => $_reklamID));
			
				if ($_update) {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Düzeltildi. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Düzeltilemedi. <b><a href="'.base_url("admin/reklamlar").'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				}
					
			}
			
		endif;	
	}
		
}

/* End of File : AdminAds.php */
/* Location : ./application/controllers/AdminAds.php */

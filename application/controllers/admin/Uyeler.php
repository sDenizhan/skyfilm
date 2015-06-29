<?php
if (!defined('BASEPATH')) exit("Go Home Yanki !!");

class Uyeler extends AdminController {

	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$uyeler = $this->db->get("uyeler");
		
		if ($uyeler->num_rows() > 0) {
			
			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
			
			$config["base_url"] = base_url("admin/uyeler/index/");
			$config["total_rows"] = $uyeler->num_rows();
			$config["per_page"] = 25;
			$config["uri_segment"] = 4;
			
			include APPPATH.'/config/admin-pagination.php';
			
			$this->pagination->initialize($config);
			
			$_data['_uyeler'] = $this->db->get("uyeler", $config['per_page'], $_page);
			$_data['_pages'] = $this->pagination->create_links();
			
			$this->render('uyeler_index', $_data);
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı.');
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
                $this->db->like('kullanici_adi', $aranan)->or_like('adsoyad', $aranan);
            }

            if (!empty($id))
            {
                $this->db->where('id', $id);
            }

            $uyeler = $this->db->get('uyeler');

            if ($uyeler->num_rows() > 0 )
            {
                $_page = $this->uri->segment(4);

                if (empty($_page))
                {
                    $_page = 0;
                }

                $config["base_url"] = base_url('admin/uyeler/filitrele/?aranan='. $aranan .'&id='. $id .'&siralama='. $siralama);
                $config["total_rows"] = $uyeler->num_rows();
                $config["per_page"] = 25;
                $config["uri_segment"] = 4;
                $config["page_query_string"] = TRUE;

                include APPPATH.'/config/admin-pagination.php';

                $this->pagination->initialize($config);

                if (!empty($aranan))
                {
                    $this->db->like('kullanici_adi', $aranan)->or_like('adsoyad', $aranan);
                }
                if (!empty($id))
                {
                    $this->db->where('id = ', $id);
                }
                $this->db->order_by('id', $siralama);

                $uyelist = $this->db->get('uyeler', $config['per_page'], $_page);

                $_data['_uyeler'] = $uyelist;
                $_data['_pages'] = $this->pagination->create_links();

                $this->render('uyeler_index', $_data);
            } else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Aradığınız Kriterlere Uygun Üye Bulunamadı..! <b><a href="'.base_url("admin/uyeler").'"> Üyeler </a></b>');
                $this->render('errorpage', $_data);
            }

        }
        else
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'GET Bilgisi Alınamadı..! <b><a href="'.base_url("admin/uyeler").'"> Üyeler </a></b>');
            $this->render('errorpage', $_data);
        }
    }
	
	public function uyesil(){
		$_uyeID = $this->uri->segment(4);
		
		if (!is_numeric($_uyeID) || empty($_uyeID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek Uye ID Bilgisine Ulaşılamadı..! <b><a href="'. base_url('admin/uyeler').'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		} else {
				
			$uye = $this->db->get_where('uyeler', array('id' => $_uyeID));
				
			if ($uye->num_rows() > 0) {
				$_del = $this->db->delete('uyeler', array('id' => $_uyeID));
				if ($_del) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi...! <b><a href="'. base_url('admin/uyeler').'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi..!<a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				}
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı..!<a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			}
				
				
		}
	}
	
	public function uyeduzelt(){
		$_uyeID = $this->uri->segment(4);
	
		if (!is_numeric($_uyeID) || empty($_uyeID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek Uye ID Bilgisine Ulaşılamadı..! <b><a href="'. base_url('admin/uyeler').'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		} else {
	
			$uye = $this->db->get_where('uyeler', array('id' => $_uyeID));
	
			if ($uye->num_rows() > 0) {
				$_data['_uye'] = $uye->row();
				$this->render('uyeler_uyeduzelt', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı..!<a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			}
	
	
		}
	}
	
	public function uyeduzeltkaydet(){
		$_uyeID = $this->uri->segment(4);
		
		if (!is_numeric($_uyeID) || empty($_uyeID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Üye ID Bilgisine Ulaşılamadı..!<a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
			$this->render('errorpage', $_data);
		} else {
		
			$uye = $this->db->get_where('uyeler', array('id' => $_uyeID));
	
			if ($uye->num_rows() > 0) {

				$this->form_validation->set_rules('frmKullaniciAdi','Kullanıcı Adı','required|min_length[5]|trim');
				$this->form_validation->set_rules('frmEmailAdresi','Email Adresi','required|trim');
				$this->form_validation->set_rules('frmAdSoyad','Ad Soyad','required|trim');
				$this->form_validation->set_rules('frmCinsiyet','Cinsiyet','required|trim');
				$this->form_validation->set_rules('frmMeslek','Meslek','required|trim');
				$this->form_validation->set_rules('frmDogumTarihi','Doğum Tarihi','required|trim');
				$this->form_validation->set_rules('frmSehir','Şehir','required|trim');
				$this->form_validation->set_rules('frmUyelikDurumu','Üyelik Durumu','required|trim');
				
				if ($this->form_validation->run() == FALSE) {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				} else {
					$kullaniciAdi = $this->input->post('frmKullaniciAdi');
					$email = $this->input->post('frmEmailAdresi');
					$adSoyad = $this->input->post('frmAdSoyad'); 
					$cinsiyet = $this->input->post('frmCinsiyet');
					$meslek = $this->input->post('frmMeslek');
					$dogum = $this->input->post('frmDogumTarihi');
					$sehir = $this->input->post('frmSehir');
					$uyelikDurumu = $this->input->post('frmUyelikDurumu');
					$uyeSeviye = $this->input->post('frmUyeSeviye');

					$updateDizi = array(
										'kullanici_adi' => $kullaniciAdi,
										'email' => $email,
										'adsoyad' => $adSoyad,
										'cinsiyet' => $cinsiyet,
										'meslek' => $meslek,
										'dogumgunu' => $dogum,
										'sehir' => $sehir,
										'durum' => $uyelikDurumu,
										'uye_seviye' => $uyeSeviye
										);
										
					$_update = $this->db->update('uyeler', $updateDizi, array('id' => $_uyeID));
				
					if ($_update) {
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Üye Bilgileri Güncellendi..! <b><a href="'. base_url('admin/uyeler').'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Üye Bilgileri Güncellenemedi..! <a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
						$this->render('errorpage', $_data);
					}					
				}
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			}
		
		}
	}
	
	public function uyesifreduzeltkaydet()
	{
		$uyeid = $this->uri->segment(4);
		
		if (empty($uyeid) || !is_numeric($uyeid))
		{
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Üye ID Bilgisine Ulaşılamadı..!<a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
			$this->render('errorpage', $_data);
		}
		else
		{
			$uye = $this->db->get_where('uyeler', array('id' => $uyeid));
			
			if ($uye->num_rows() > 0)
			{
				$this->form_validation->set_rules('frmSifre','Şifre','required|trim|matches[frmSifreTekrar]');
				$this->form_validation->set_rules('frmSifreTekrar','Şifre Tekrarı','required|trim');
				
				if ($this->form_validation->run() == FALSE)
				{
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				}
				else
				{
					$sifre = $this->input->post('frmSifre');
					
					$_update = $this->db->update('uyeler',  array('sifre' => do_hash($sifre)), array('id' => $uyeid));
				
					if ($_update) {
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Üye Bilgileri Güncellendi..! <b><a href="'. base_url('admin/uyeler').'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Üye Bilgileri Güncellenemedi..! <a href="'. $this->agent->referrer() .'"> Geri Dön </a>');
						$this->render('errorpage', $_data);
					}	
				}
				
			}
			else
			{
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			}
			
		}
		
	}
	
	public function aktiflestir(){
		$_uyeID = $this->uri->segment(4);
		
		if (!is_numeric($_uyeID) || empty($_uyeID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Üye ID Bilgisine Ulaşılamadı..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
			$this->render('errorpage', $_data);
		} else {
		
			$uye = $this->db->get_where('uyeler', array('id' => $_uyeID));
		
			if ($uye->num_rows() > 0 ) {
				$_update = $this->db->update('uyeler', array('durum' => 'Aktif'), array('id' => $_uyeID));
				if ($_update) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kullanıcı Aktifleştirildi..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kullanıcı Aktifleştirilemedi..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				}
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			}
		}
	}
	
	public function pasiflestir(){
		$_uyeID = $this->uri->segment(4);
		
		if (!is_numeric($_uyeID) || empty($_uyeID)) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Üye ID Bilgisine Ulaşılamadı..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
			$this->render('errorpage', $_data);
		} else {
		
			$uye = $this->db->get_where('uyeler', array('id' => $_uyeID));
		
			if ($uye->num_rows() > 0 ) {
				$_update = $this->db->update('uyeler', array('durum' => 'Pasif'), array('id' => $_uyeID));
				if ($_update) {
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kullanıcı Pasifleştirildi..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kullanıcı Pasifleştirilemedi..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				}
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı..! <a href="'. base_url('admin/uyeler').'"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			}
		}
	}
}
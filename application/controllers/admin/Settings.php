<?php
if (!defined('BASEPATH')) exit('No direct allow');

class Settings extends AdminController {

	function __construct() {
		parent::__construct();
	}

    public function getLongTimeAccessToken()
    {
        $fb_exchange_token = $this->input->post('fb_exchange_token');
        $fb = $this->config->item('facebook');

        $this->load->library('curl');
        $response = $this->curl->getir('https://graph.facebook.com/oauth/access_token?client_secret='. $fb['app_secret'] .'&client_id='. $fb['app_id'] .'&grant_type=fb_exchange_token&fb_exchange_token='.$fb_exchange_token.'&redirect_uri='. base_url());

        parse_str($response, $access_token);

        if (array_key_exists('access_token', $access_token))
        {
            echo $access_token['access_token'];
        }
        else
        {
            echo 'Bir Hata Oluştu. Tekrar Deneyiniz..!';
        }

    }
	
	public function index(){
        $this->load->helper('directory');
		$data['_temalar'] = directory_map(APPPATH.'../temalar/site', 1);

		$this->render('ayarlar_index', $data);
	}

    public function genelayarlarkaydet()
    {

        $result = array();

        $kayitlar = array();
        $kayitlar[] = array('siteadi', $this->input->post('frmSiteAdi'), 'Site Adı Ayarı Güncellendi.', 'Site Adı Ayarı Güncellenemedi');
        $kayitlar[] = array('sitetheme', $this->input->post('frmTemalar'), 'Site Tema Ayarı Güncellendi.', 'Site Tema Ayarı Güncellenemedi');
        $kayitlar[] = array('index_turu', $this->input->post('frmIndexTuru'), 'Site Anasayfa Görünümü Güncellendi.', 'Site Anasayfa Görünümü Güncellenemedi');
        $kayitlar[] = array('header_html', $this->input->post('frmHeaderHTML'), 'Header Kodları Güncellendi.', 'Header Kodları Güncellenemedi');
        $kayitlar[] = array('footer_html', $this->input->post('frmFooterHTML'), 'Footer Kodları Güncellendi.', 'Footer Kodları Güncellenemedi');
        $kayitlar[] = array('anasayfa_kayit_sayisi', $this->input->post('frmAnasayfaFilmAdedi'), 'Anasayfada Gösterilecek Film Sayısı Güncellendi.', 'Anasayfada Gösterilecek Film Sayısı Güncellenemedi');
        $kayitlar[] = array('filmler_kayit_sayisi', $this->input->post('frmFilmKayitSayisi'), 'Filmler Sayfasında Gösterilecek Film Sayısı Güncellendi.', 'Filmler Sayfasında Gösterilecek Film Sayısı Güncellenemedi');
        $kayitlar[] = array('aktivasyonMaili', $this->input->post('frmAktivasyonMaili'), 'Aktivasyon Maili Ayarı Güncellendi.', 'Aktivasyon Maili Ayarı Güncellenemedi');
        $kayitlar[] = array('ailefilitresi', $this->input->post('frmAileFilitresi'), 'Aile Filitresi Güncellendi.', 'Aile Filitresi Güncellenemedi');

        foreach( $kayitlar as $r )
        {
            //ayar varsa güncellesin
            if ( false != ayar_getir($r[0]) )
            {
                if ( ayar_guncelle($r[0], $r[1]) )
                {
                    $result[] = $r[2];
                }
                else
                {
                    $result[] = $r[3];
                }

            }
            else
            {
                //ayar yoksa eklesin
                if ( ayar_ekle($r[0], $r[1]))
                {
                    $result[] = $r[2];
                }
                else
                {
                    $result[] = $r[3];
                }
            }
        }

        if (count($result) > 0 ) {
            array_push($result, '<b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
            $_data['e'] = (object) array('durum' => 'ok', 'type' => 'dizi', 'mesaj' => $result);
            $this->render('errorpage', $_data);
        }
        else
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıtlar Güncellenemedi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
            $this->render('errorpage', $_data);
        }


    }

    public function seo_ayarlari()
    {
        $this->render('ayarlar_seoayarlari');
    }

    public function yorum_ayarlari()
    {
        $this->render('ayarlar_yorumayarlari');
    }

    public function sosyalag_ayarlari()
    {
        $fb_config = $this->config->item('facebook');
        $data['_facebook_app_id'] = $fb_config['app_id'];
        $data['_facebook_app_secret'] = $fb_config['app_secret'];
        $data['_facebook_page_id'] = $fb_config['page_id'];
        $data['_facebook_page_name'] = $fb_config['page_name'];

        $this->render('ayarlar_sosyalagayarlari', $data);
    }

    public function cache_ayarlari()
    {
        $this->render('ayarlar_cacheayarlari');
    }

    public function yasaluyari_ayarlari()
    {
        $this->render('ayarlar_yasaluyari');
    }

    public function yasaluyarikaydet()
	{

		if (ayar_guncelle('yasal_uyari',  ckeditor_html_clear($this->input->post('frmYasalUyari', TRUE)))) {
	            $_data['e'] = (object) array('durum' => 'ok', 'type' => 'mesaj', 'mesaj' => 'Yasal Uyarı Güncellendi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
	            $this->render('errorpage', $_data);
		}
        else
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Yasal Uyarı Güncellenemedi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
            $this->render('errorpage', $_data);
        }

	}
	
	public function cachekaydet()
	{
		
		$result = array();
		
		if (ayar_guncelle('cache_status',  $this->input->post('frmCacheStatus', TRUE))) {
				array_push($result, 'Önbellek Ayarı Güncellendi..!');
		}
			
		if (ayar_guncelle('cache_time', $this->input->post('frmCacheTime', TRUE))) {
			array_push($result, 'Önbellek Süresi Güncellendi..!');
		}
		
		if (count($result) > 0 ) {
            array_push($result, '<b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'dizi', 'mesaj' => $result);
           		$this->render('errorpage', $_data);
		}
		else
		{
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıtlar Güncellenemedi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
         	$this->render('errorpage', $_data);
		}
		
	}
	
	
	
	
	public function sosyalagkaydet()
	{
		
		$result = array();
		
		if (ayar_guncelle('facebook_address',  $this->input->post('frmFacebookAdresi', TRUE))) {
				array_push($result, 'Facebook Adresi Güncellendi..!');
		}
			
		if (ayar_guncelle('twitter_address', $this->input->post('frmTwitterAdresi', TRUE))) {
			array_push($result, 'Twitter Adresi Güncellendi..!');
		}
			
		if (ayar_guncelle('youtube_address', $this->input->post('frmYoutubeAdresi'))) {
				array_push($result, 'Youtube Adresi Güncellendi..!');
		}
			
		if (ayar_guncelle('digg_address',  $this->input->post('frmDiggAdresi', TRUE))) {
				array_push($result, 'Digg Adresi Güncellendi..!');
		}
			
		if (ayar_guncelle('rss_address', $this->input->post('frmRSSAdresi', TRUE))) {
			array_push($result, 'RSS Adresi Güncellendi..!');
		}
			
		if (ayar_guncelle('sitemap_address', $this->input->post('frmSitemapAdresi'))) {
				array_push($result, 'Sitemap Adresi Güncellendi..!');
		}	
		
		if (count($result) > 0 ) {
            array_push($result, '<b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'dizi', 'mesaj' => $result);
           		$this->render('errorpage', $_data);
		}
		else
		{
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıtlar Güncellenemedi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
           		$this->render('errorpage', $_data);
		}
		
	}
	
	

	public function yorumayarkaydet()
	{
		
		$result = array();
		
		if (ayar_guncelle('yorumAcik',  $this->input->post('frmFilmYorum', TRUE))) {
				array_push($result, 'Filmlere Yorum Yapılma Ayarı Güncellendi..!');
		}
			
		if (ayar_guncelle('publicComment', $this->input->post('frmPublicComment', TRUE))) {
			array_push($result, 'Üye Olmayanların Yorum Yapma Ayarı Güncellendi..!');
		}
			
		if (ayar_guncelle('yorumOnay', $this->input->post('frmYorumOnay'))) {
				array_push($result, 'Yorum Onay Ayarı Güncellendi..!');
		}
				
		
		if (count($result) > 0 ) {
            array_push($result, '<b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'dizi', 'mesaj' => $result);
           		$this->render('errorpage', $_data);
		}
		else
		{
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıtlar Güncellenemedi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
           		$this->render('errorpage', $_data);
		}
		
	}


	public function seoayarkaydet()
	{
		
		$result = array();
		
		if (ayar_guncelle('sitetitle',  $this->input->post('frmSiteTitle', TRUE))) {
				array_push($result, 'Site Title Güncellendi..!');
		}
			
		if (ayar_guncelle('sitekeywords', $this->input->post('frmSiteKeywords', TRUE))) {
			array_push($result, 'Site Anahtar Kelimeleri Güncellendi..!');
		}
			
		if (ayar_guncelle('sitedescription', $this->input->post('frmSiteDescription'))) {
			array_push($result, 'Site Açıklaması Güncellendi..!');
		}
				
		
		if (count($result) > 0 ) {
            array_push($result, '<b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
			$_data['e'] = (object) array('durum' => 'ok', 'type' => 'dizi', 'mesaj' => $result);
           	$this->render('errorpage', $_data);
		}
		else
		{
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıtlar Güncellenemedi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
            $this->render('errorpage', $_data);
		}
		
	}

    public function facebookayarkaydet()
    {

        $result = array();

        if ($this->ayarlar->ayar_varmi('fb_paylasim') == FALSE)
        {
            if ($this->ayarlar->ayar_ekle('fb_paylasim', $this->input->post('fb_paylasim')))
            {
                $result[] = 'Facebook Paylaşım Ayarı Güncellendi';
            }
        }
        else
        {
            if ($this->ayarlar->ayar_guncelle('fb_paylasim', $this->input->post('fb_paylasim')))
            {
                $result[] = 'Facebook Paylaşım Ayarı Güncellendi';
            }
        }

        if ($this->ayarlar->ayar_varmi('facebook_access_token') == FALSE)
        {
            if ($this->ayarlar->ayar_ekle('facebook_access_token', $this->input->post('facebook_access_token')))
            {
                $result[] = 'Facebook Access Token Güncellendi';
            }
        }
        else
        {
            if ($this->ayarlar->ayar_guncelle('facebook_access_token', $this->input->post('facebook_access_token')))
            {
                $result[] = 'Facebook Access Token Güncellendi';
            }
        }

        if (count($result) > 0 ) {
            array_push($result, '<b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
            $_data['e'] = (object) array('durum' => 'ok', 'type' => 'dizi', 'mesaj' => $result);
            $this->render('errorpage', $_data);
        }
        else
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıtlar Güncellenemedi..! <b><a href="'.base_url("admin/settings").'">Geri Dön</a></b>');
            $this->render('errorpage', $_data);
        }

    }

}

/* End of File : ayarlar.php */
/* Location : ./application/controllers/admin/settings.php */
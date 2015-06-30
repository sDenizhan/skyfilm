<?php
if (!defined('BASEPATH')) exit('No direct allow');

class Kisiler extends AdminController {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
	
		$kisiler = $this->db->get("kisiler");
		
		if ($kisiler->num_rows() > 0) {
			
			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
			
			$config["base_url"] = base_url("admin/kisiler/index/");
			$config["total_rows"] = $kisiler->num_rows();
			$config["per_page"] = 15;
			$config["uri_segment"] = 4;

			include VIEWPATH.'dash/'. $this->getTheme() .'/views/config/pagination.php';
		
			$this->db->order_by('adi_soyadi', 'ASC');
			$_kisiler = $this->db->get('kisiler', $config['per_page'], $_page);

			$this->pagination->initialize($config);

			$_data['_pages'] = $this->pagination->create_links();
			$_data['_kisiler'] = $_kisiler->result();
			
			$this->render('kisiler_index', $_data);
			
		
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/kisiler/ekle").'"> Kişi Ekle </a></b>');
			$this->render('errorpage', $_data);	
		}
	}
	
	public function ekle(){
        $this->render('kisiler_ekle');
	}
	
	public function sil(){
		$kisi_id = $this->uri->segment(4);
		
		if (!is_numeric($kisi_id) || empty($kisi_id) ):
			redirect("admin/panel");
		else:
			$kisi = $this->db->get_where('kisiler', array('id' => $kisi_id));
			
			if ($kisi->num_rows() > 0):

				$_delete = $this->db->delete('kisiler', array("id" => $kisi_id));
				
				if ($_delete > 0) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <a href="' .base_url("admin/kisiler"). '"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <a href="' .base_url("admin/kisiler"). '"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/kisiler"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	}
	
	public function duzelt(){
		$kisi_id = $this->uri->segment(4);
		
		if (!is_numeric($kisi_id) || empty($kisi_id) ):
			redirect("admin/panel");
		else:
			$_kisi = $this->db->get_where('kisiler', array('id' => $kisi_id));
			if ($_kisi != FALSE):

                //kişiye ait bilgileri de gönderelim
                $bilgiler = $this->db->get_where('kisi_bilgileri', array('kisi_id' => $kisi_id));
                $_data['_bilgiler'] = ( $bilgiler->num_rows() > 0 ) ? $bilgiler->result() : false;

                $_data['_kisi'] = $_kisi->row();
                $this->render('kisiler_duzelt', $_data);

			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/kisiler"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
		
	}

    public function ajax_bilgi_kaydet()
    {
        $this->form_validation->set_rules('kisi_id', 'Kişi ID', 'required|trim|xss_clean');
        $this->form_validation->set_rules('baslik', 'Başlık', 'required|trim|xss_clean');
        $this->form_validation->set_rules('deger', 'Değer', 'required|trim|xss_clean');

        if ( $this->form_validation->run() != false ):

            $kisi_id = $this->input->post('kisi_id');
            $baslik = $this->input->post('baslik');
            $deger = $this->input->post('deger');

            $insert = $this->db->insert('kisi_bilgileri', array(
                'kisi_id' => $kisi_id,
                'baslik' => $baslik,
                'deger' => $deger
            ));

            if ( $insert )
            {
            	$bilgi_id = $this->db->insert_id();

                $data = json_encode( array('status' => 'ok', 'message' => 'Başlık Eklendi..!', 'id' => $bilgi_id) );
            }
            else
            {
                $data = json_encode( array('status' => 'error', 'message' => 'Başlık Eklenemedi..!') );
            }

        else:
            $data = json_encode( array('status' => 'error', 'message' => 'Tüm Forumu Doldurunuz..!') );
        endif;

        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function ajax_kisi_kaydet()
    {
        $kisi_adi = $this->input->post('kisi_adi');

        if ( empty($kisi_adi) )
        {
            $data = array('status' => 'error', 'message' => 'Kişi Adını Boş Bırakamazsınız..!');
        }
        else
        {
            $kisi = $this->db->get_where('kisiler', array('adi_soyadi' => $kisi_adi));

            if ( $kisi->num_rows() > 0 )
            {
                $data = array('status' => 'error', 'message' => 'Bu Kişi Daha Önceden Kaydedilmiş !!');
            }
            else
            {
                $insert = $this->db->insert('kisiler', array('adi_soyadi' => $kisi_adi));
                if ( $insert ) {

                    $kisi_id = $this->db->insert_id();
                    $kisi_data = array(
                        'kisi_id' => $kisi_id
                    );

                    $data = array('status' => 'ok', 'message' => 'Kişi Başarıyla Kaydedildi..!', 'data' => $kisi_data);
                }
                else
                {
                    $data = array('status' => 'error', 'message' => 'Kişi Kaydedilemedi.. Lütfen Tekrar Deneyiniz..!');
                }

            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function ajax_bilgi_sil()
    {
        $bilgi_id = $this->input->post('bilgi_id');

        if ( empty($bilgi_id) )
        {
            $data = array('status' => 'error', 'message' => 'Bilgi ID\'ye Erişelemedi..!');
        }
        else
        {
            $kisi = $this->db->get_where('kisi_bilgileri', array('id' => $bilgi_id));

            if ( $kisi->num_rows() > 0 )
            {
            	$delete = $this->db->delete('kisi_bilgileri', array('id' => $bilgi_id));

            	if ( $delete )
            	{
            		$data = array('status' => 'ok', 'message' => 'Kişi Bilgisi Silindi..!');
            	}
            	else
            	{
            		$data = array('status' => 'error', 'message' => 'Kişi Bilgisi Silinemedi..!');
            	}
                
            }
            else
            {
                $data = array('status' => 'error', 'message' => 'Kişi Bilgisine Erişelemedi..!');
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function ajax_kisi_guncelle()
    {
        $this->form_validation->set_rules('kisi_id', 'Kişi ID', 'required|trim|xss_clean');
        $this->form_validation->set_rules('resim_adresi', 'Resim', 'required|trim|xss_clean');
        $this->form_validation->set_rules('meslek', 'Meslek', 'required|trim|xss_clean');

        if ( $this->form_validation->run() != false ):

            $kisi_id = $this->input->post('kisi_id', true);
            $resim = $this->input->post('resim_adresi', true);
            $meslek = $this->input->post('meslek', true);
            $seo_title = $this->input->post('seo_title', true);
            $seo_keys = $this->input->post('seo_keys', true);
            $seo_desc = $this->input->post('seo_desc', true);

            $update = $this->db->update('kisiler', array(
                'resim' => $resim,
                'tur' => $meslek,
                'seo_title' => $seo_title,
                'seo_keys' => $seo_keys,
                'seo_desc' => $seo_desc
            ), array('id' => $kisi_id));

            if ( $update )
            {
                $data = json_encode( array('status' => 'ok', 'message' => 'Oyuncu Bilgileri Güncellendi..!') );
            }
            else
            {
                $data = json_encode( array('status' => 'error', 'message' => 'Oyuncu Bilgileri Güncellenemedi..!') );
            }

        else:
            $data = json_encode( array('status' => 'error', 'message' => 'Tüm Forumu Doldurunuz..!') );
        endif;

        $this->output->set_content_type('application/json')->set_output($data);
    }
	
	
}

?>
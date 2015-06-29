<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filmbotu extends AdminController {

    function __construct(){
        parent::__construct();
    }

    function index(){

        $film_adi = $this->uri->segment('4');

        if (!empty($film_adi))
        {
            $_data['film_adi'] = urldecode($film_adi);
        }
        else
        {
            $_data['film_adi'] = FALSE;
        }

        $bilgi_botlari = $this->db->get_where('botlar', array('kullanim_yeri' => 'bilgi', 'durum' => 'Aktif'));
        $part_botlari = $this->db->get_where('botlar', array('kullanim_yeri' => 'part', 'durum' => 'Aktif'));

        $_data['_bilgi'] = $bilgi_botlari->num_rows() > 0 ? $bilgi_botlari : FALSE;
        $_data['_part'] = $part_botlari->num_rows() > 0 ? $part_botlari : FALSE;

        $this->render('filmbotu_index', $_data);
    }

    private function _bot_codes($bot, $fonksiyon = 'filmara')
    {
        if (empty($bot))
        {
            return FALSE;
        }

        //dosya yolunu ayarladık
        $file = APPPATH.'../others/bots/'. $bot .'/'. $bot .'_'.$fonksiyon.'.php';
        //dosya içeriğini aldık
        $content = file_get_contents($file, 'r+');

        //kodların başında php ifadeleri temizleniyor...
        $content = ltrim($content, "<?php");
        $content = rtrim($content, "?>");
        $content = trim($content);

        //bilgiler return edildi
        return $content;
    }


    public function filmara()
    {
        $this->form_validation->set_rules('frmFilmAdi', 'Film Adı', 'required');
        //$this->form_validation->set_rules('frmAranacaSite', 'Aranacak Site', 'required');

        if ($this->form_validation->run() == FALSE) {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
            $this->render('errorpage', $_data);
        } else {

            $filmadi = $this->input->post('frmFilmAdi');
            $site = $this->input->post('frmAranacakSite');

            $this->load->library('Curl');

            //bot kodları çalıştı..
            $code = $this->_bot_codes($site, 'filmara');

            $_data = array();

            //tampon bellekleme başladı
            ob_start();

            //kodlar çalıştırıldı
            eval($code);

            //tampondaki bilgiler alındı
            $cikti = ob_get_contents();

            //tampon temizlendi
            ob_end_clean();

            $_data['_bot'] = $site;

            $this->render('filmbotu_filmsec', $_data);

        }

    }

    private function temp_delete()
    {
        $temp = directory_map('./others/temp');

        foreach($temp as $file)
        {
            if ($file != 'no_poster.jpg')
            {
                @unlink('./others/temp/'.$file);
            }
        }
    }

    public function filmicek()
    {

        $filmResmi = $this->input->post('filmResmi');
        $filmLinki = $this->input->post('filmLinki');
        $bot = $this->input->post('filmBotu');

        if (empty($filmLinki)) :
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Film Adresi Alınamadı. Tekrar Deneyiniz. <b><a href="'.base_url("admin/filmbotu").'"> Geri Dön </a></b>');
            $this->render('errorpage', $_data);
        else :

            // Curl Class Load
            $this->load->library('Curl');

            //bot kodları çalıştı..
            $code = $this->_bot_codes($bot, 'filmcek');

            $_bilgiler = new stdClass();

            //tampon bellekleme başladı
            ob_start();

            //kodlar çalıştırıldı
            eval($code);

            //tampondaki bilgiler alındı
            $cikti = ob_get_contents();

            //tampon temizlendi
            ob_end_clean();

            if (count((array) $_bilgiler) > 0)
            {
                $_data["_ustkat"] = $this->db->get_where('kategoriler', array("ust_kategori_id" => "0"));
                $_data["_altkat"] = $this->db->get_where('kategoriler', array("ust_kategori_id !=" => "0"));
                $_data['_bot'] = $_bilgiler;

                //load directory helper
                $this->load->helper('directory');

                $this->render('filmbotu_filmcek', $_data);

                $this->temp_delete();

            } else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Uzaktan Veri Alınamadı. <b><a href="'.base_url("admin/filmbotu").'"> Geri Dön </a></b>');
                $this->render('errorpage', $_data);
            }

        endif;

    }

	function partara()
	{
		$this->form_validation->set_rules('frmFilmAdi', 'Film Adı', 'required');
		
		if ($this->form_validation->run() == FALSE) {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
            $this->render('errorpage', $_data);
        } else {
			
			$filmkey = $this->input->post('frmFilmAdi', TRUE);
			$site = $this->input->post('frmAranacakSite', TRUE);

            //hataları tutacağımız dizi
            $hata = array();
			
			$this->load->library('Curl');

            //bot kodları çalıştı..
            $code = $this->_bot_codes($site, 'filmara');

            $bilgiler = new stdClass();

            //tampon bellekleme başladı
            ob_start();

            //kodlar çalıştırıldı
            eval($code);

            //tampondaki bilgiler alındı
            $cikti = ob_get_contents();

            //tampon temizlendi
            ob_end_clean();

            if (count($hata) > 0)
            {
                $hata[] = '<a href="'. $this->agent->referrer() .'">Geri Dön</a>';

                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'dizi', 'mesaj' => $hata);
                $this->render('errorpage', $_data);
            }
            else
            {
                $data['_filmBotu'] = $site;
                $data['kaynak'] = $site;
                $data['bilgiler'] = $bilgiler;

                $this->render('filmbotu_partfilmisec', $data);
            }

		
		}
		
	}

	function partcek(){
		
		$this->form_validation->set_rules('filmLinki', 'Film Adresi', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
			$this->render('errorpage', $_data);
		} else {
			
			$kaynak = $this->input->post('filmKaynak');
			$link = $this->input->post('filmLinki');
			$filmadi = $this->input->post('filmadi');
            $bot = $this->input->post('filmBotu');
			
			$this->load->library('curl');
			
			$partlar = array();

            //bot kodları çalıştı..
            $code = $this->_bot_codes($bot, 'filmcek');

            //tampon bellekleme başladı
            ob_start();

            //kodlar çalıştırıldı
            eval($code);

            //tampondaki bilgiler alındı
            $cikti = ob_get_contents();

            //tampon temizlendi
            ob_end_clean();

			$this->db->order_by('film_adi', 'ASC');
			$data['filmler'] = $this->db->get('filmler');
			$data['partlar'] = $partlar;
			$data['filmadi'] = $filmadi;
			
			$this->render('filmbotu_partsec', $data);

		}
		
	}

	function partkaydet()
	{
		
		$this->form_validation->set_rules('film', 'Film Adı', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
			$this->render('errorpage', $_data);
		}
		else 
		{
			
			$filmID = $this->input->post('film');
			$alternatif = $this->input->post('frmAlternatif');
			$partBaslik = $this->input->post('partbaslik');
			$partEmbed = $this->input->post('partembed');
			$ekle = $this->input->post('frmEkle');
			$width = $this->input->post('width');
			$height = $this->input->post('height');

			$get = $this->db->get_where('filmler', array('id' => $filmID));

			$kayit = 0;
			
			if ($get->num_rows() > 0)
			{
				
				foreach ($partBaslik as $k => $v)
				{
					if ($ekle[$k] == 'ekle')
					{
						$embed = $partEmbed[$k];
												
						if (!empty($height))
						{
							$embed = preg_replace('/height="(.*?)"/', 'height="'. $height .'"', $embed);
						}
						
						if (!empty($width))
						{
							$embed= preg_replace('/width="(.*?)"/', 'width="'. $width .'"', $embed);
						}

						$insert = $this->db->insert('partlar', array('film_id' => $filmID, 'baslik' => $partBaslik[$k], 'url' => $embed, 'player' => 'html', 'aciklama' => ayar_getir('siteadi').' İyi Seyirler Diler..!', 'alternatif' => $alternatif[$k]));
						
						if ($insert)
						{
							$kayit++;
						}
						
					}
					
				}
				
				if ($kayit <= 0)
				{
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'mesaj', 'mesaj' => 'Partlar Eklenemedi. <a href="'. base_url('admin/filmbotu') .'">Geri Dön</a>');
					$this->render('errorpage', $_data);
				}
				else 
				{
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'mesaj', 'mesaj' => 'Partlar Eklendi. <a href="'. base_url('admin/filmbotu') .'">Geri Dön</a>');
					$this->render('errorpage', $_data);
				}

			}
			else
			{
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'mesaj', 'mesaj' => 'Film Bulunamadı. <a href="'. base_url('admin/filmbotu') .'">Geri Dön</a>');
				$this->render('errorpage', $_data);
			}
			
			
		}
		
		
	}


} // class bitimi

/* End of file AdminFilmBotu.php */
/* Location: ./sdenizhan/controller/AdminFilmBotu.php */